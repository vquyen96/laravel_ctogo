<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomeStay;
use App\Models\BedRoom;
use App\Models\Book;
class CheckController extends Controller
{
    //
	public function getAjaxCheck(Request $request){
		$homestay_id = Homestay::find($request->homestay_id)->homestay_id;
		$bedrooms = BedRoom::where('bedroom_homestay_id',$homestay_id)->get();
		
		$arr = [];
		foreach($bedrooms as $bedroom){
			$a = Book::where('book_bedroom_id',$bedroom->bedroom_id)
					    ->where(function ($query) use ($request){
							$query->where(function ($query) use ($request){
										$query->where('book_from', '<=', implode('/',array_reverse(explode('/',$request->end))) );
										$query->where('book_from', '>=', implode('/',array_reverse(explode('/',$request->start))) );
							});
							$query->orWhere(function ($query) use ($request) {
								       $query->where('book_to', '<=', implode('/',array_reverse(explode('/',$request->end))) );
								       $query->where('book_to', '>=', implode('/',array_reverse(explode('/',$request->start))) );
							});
							$query->orWhere(function ($query) use ($request) {
								       $query->where('book_from', '<=', implode('/',array_reverse(explode('/',$request->start))) );
								       $query->where('book_to', '>=', implode('/',array_reverse(explode('/',$request->end))) );
							});
						})
						->get();

			if( count($a) == 0 && ($bedroom->bedroom_slot >= $request->slot) ){
				$arr[] = $bedroom->bedroom_id;
			}

    	}
    	return $arr;
	}
}
