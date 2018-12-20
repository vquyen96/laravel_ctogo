<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomeStay;
use DB;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function getSearch(Request $request){
        $search_data = [
            'start' => $request->start,
            'end' => $request->end,
            'slot' => $request->slot,
        ];

        Session::put('search_data',$search_data);

    	$string = '%'.implode( '%',explode( ',',str_replace(' ','%', $request->location ) ) ).'%';
    	$data['homestays'] = HomeStay::with(['bedroom','homestayimage'])
                                    ->where('homestay_active',HomeStay::ACTIVE)
    								->where('homestay_location','like',$string)
    								->whereHas('bedroom',function($query) use ($request){
                                        if($request->slot){
                                            $query->where('bedroom_slot','>=',$request->slot);
                                        }
    								});

        if( $request->homestay_type ){
            $data['homestays'] = $data['homestays']->whereIn('homestay_type',$request->homestay_type);
        }                                
    	if( $request->start && $request->end ){
            $data['homestays'] 
            = $data['homestays']->whereDoesntHave('bedroom.book',function($query) use ($request)
                                    {
                                        $query->where('book_from','<=',implode('/',array_reverse(explode('/',$request->end))));
                                        $query->where('book_to','>=',implode('/',array_reverse(explode('/',$request->start))));
                                    });
        }

    	$data['homestays'] = $data['homestays']->paginate(10);

    	return view('public.search-result',$data);
    }

    public function getAjaxSearch(Request $request){
        $string = '%'.implode( '%',explode( ',',str_replace(' ','%', $request->location ) ) ).'%';
        $data['homestays'] = HomeStay::with(['bedroom','homestayimage'])
                                    ->where('homestay_active',HomeStay::ACTIVE)
                                    ->where('homestay_location','like',$string)
                                    ->whereHas('bedroom',function($query) use ($request){
                                        if($request->slot){
                                            $query->where('bedroom_slot','>=',$request->slot);
                                        }
                                    });
        if( $request->homestay_type ){
            $data['homestays'] = $data['homestays']->whereIn('homestay_type',$request->homestay_type);
        }                            

        if( $request->start && $request->end ){
            $data['homestays'] = $data['homestays']->whereDoesntHave('bedroom.book',function($query) use ($request){
                                            $query->where('book_from','<=',implode('/',array_reverse(explode('/',$request->end))));
                                            $query->where('book_to','>=',implode('/',array_reverse(explode('/',$request->start))));
                                    });
        }
        // price filter
        if($request->price_from && $request->price_to){
            $data['homestays'] = $data['homestays']->whereHas('bedroom',function($query) use ($request){
                                                            $float_price_from = (float)preg_replace('/[^0-9]/', '', $request->price_from);
                                                            $float_price_to = (float)preg_replace('/[^0-9]/', '', $request->price_to);
                                                            $query->whereBetween('bedroom_price',[$float_price_from, $float_price_to]);
                                                    });
        }
           
        //number of bedrooms filter
        if($request->number_of_bedroom){
            $data['homestays'] = $data['homestays']->has('bedroom','>=',$request->number_of_bedroom);
        }

        //facility filter
        if($request->facility){
            $arr = [];
            foreach ($data['homestays']->get() as $homestay) {
                if(!array_diff($request->facility ?? [], explode(',',$homestay->homestay_facility) )){
                    $arr[] = $homestay->homestay_id;
                }
            }
            $data['homestays'] = $data['homestays']->whereIn('homestay_id',$arr);
        }

        // bedroom_facility filter
        if($request->bedroom_facility){
            $arr = [];
            foreach ($data['homestays']->get() as $homestay) {
                $i = false;
                foreach($homestay->bedroom as $bedroom){
                    if(!array_diff($request->bedroom_facility ?? [], explode(',',$bedroom->bedroom_facility) )){
                        $i = true;
                    }  
                }
                if($i){
                    $arr[] = $homestay->homestay_id;
                }
            }
            $data['homestays'] = $data['homestays']->whereIn('homestay_id',$arr);
        }

        $data['homestays'] = $data['homestays']->paginate(6);

        return view('public.search-ajax',$data);
    }
}