<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeStay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class HomestayController extends Controller
{
    function index(Request $request){
        $req = $request->all();

        $query = HomeStay::with('user');

        if(isset($req['search'])){
            $query = $query->where('homestay_name','like',"%".$req['search'].'%')
                            ->orWhere('homestay_about','like',"%".$req['search'].'%');
        }

        $list_homestay = $query->orderByDesc('homestay_id')->paginate(15);

        $data = [
            'list_homestay' => $list_homestay
        ];

        return view('admin.homestay.list',$data);
    }

    function list_non_active(Request $request){
        $req = $request->all();

        $query = HomeStay::with('user');

        if(isset($req['search'])){
            $query = $query->where('homestay_name','like',"%".$req['search'].'%')
                ->orWhere('homestay_about','like',"%".$req['search'].'%');
        }

        $list_homestay = $query->where('homestay_active',HomeStay::NON_ACTIVE)->orderByDesc('homestay_id')->paginate(15);

        $data = [
            'list_homestay' => $list_homestay
        ];

        return view('admin.homestay.list_non_active',$data);
    }


    function update_status($id){
        $homestay = Homestay::find($id);
        $homestay->homestay_active == 2 ? $homestay->homestay_active = 1 : $homestay->homestay_active = 2;
        $homestay->save();

        return json_encode([
            'homestay' => $homestay->toJson()
        ]);
    }

    function delete_homestay($id){
        if(Homestay::find($id)->delete()){
            return back()->with('success','Xóa thành công');
        }else {
            return back()->with('error','Xóa không thành công');
        }
    }

    function sort_homestay(Request $request){
        $list_homestay = Homestay::with('user')->where('home',Homestay::ACTIVE)->orderBy('sort')->paginate(30);

        $data = [
            'list_homestay' => $list_homestay
        ];

        return view('admin.homestay.sort_homestay',$data);
    }

    function delete_homestay_hot($id){
        if(DB::table('homestay')->where('homestay_id',$id)->update(['home' => Homestay::NON_ACTIVE])){
            return redirect()->route('sort_homestay')->with('success','Xóa thành công');
        }else {
            return redirect()->route('sort_homestay')->with('error','Xóa không thành công');
        }
    }

    function update_sort_homestay(Request $request){
        $req = $request->get('homestay');
        foreach ($req as $key=>$value){
            DB::table('homestay')->where('homestay_id',$key)->update(['sort'=>$value]);
        }
        return back()->with('success',"Sắp xếp thành công");
    }

    function view_detail($id){
        $homestay = Homestay::with('user')->with('bedroom')->with('homestayimage')->where('homestay_id',$id)->first();

        $data = [
            'homestay' => $homestay
        ];

        $view = View::make('admin.homestay.detail',$data)->render();

        return json_encode([
            'view' => $view
        ]);
    }
}
