<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    function index(Request $request){
        $req = $request->all();

        $query = DB::table('guest_users');

        if(isset($req['search'])){
            $query = $query->where('email','like',"%".$req['search'].'%')
                            ->orWhere('name','like',"%".$req['search'].'%')
                            ->orWhere('phone',$req['search']);
        }

        $list_guest = $query->orderByDesc('id')->paginate(15);

        $data = [
            'list_guest' => $list_guest
        ];

        return view('admin.guest.list',$data);
    }

    function update_status($id){
        $guest = User::find($id);
        $guest->status == 2 ? $guest->status = 1 : $guest->status = 2;
        $guest->save();

        return json_encode([
            'guest' => $guest->toJson()
        ]);
    }

    function delete_guest($id){
        if(DB::table('guest_users')->delete($id)){
            return redirect()->route('list_guest')->with('success','Xóa thành công');
        }else {
            return redirect()->route('list_guest')->with('error','Xóa không thành công');
        }
    }


    function detail_guest(){
        return view('admin.guest.profile');
    }
}
