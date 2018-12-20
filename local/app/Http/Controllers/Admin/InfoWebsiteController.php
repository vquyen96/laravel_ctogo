<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InfoWebsiteController extends Controller
{
    function index(){
//        $data = [
//            'hotline' => '0888.790.111',
//            'link_facebook' => '',
//            'link_youtobe' => '',
//            'link_instagram' => '',
//            'link_google' => '',
//            'link_twitter' => '',
//            'link_appstore' => '',
//            'link_googleplay' => ''
//        ];
//
//        dd(json_encode($data));

        $website_info = DB::table('configs')->where('name','website-info')->first();

        $website_info->value = json_decode($website_info->value);

        $website_info->user_updated = DB::table('admins')->where('id',$website_info->user_updated)->first();

        $data = [
            'website_info' => $website_info
        ];

        return view('admin.website_info.index',$data);
    }

    function update_info(Request $request){
        $req = $request->get('info');
        $data = [
            'user_updated' => Auth::guard('admin')->user()->id,
            'updated_at' => time(),
            'value' => json_encode($req)
        ];

        if (DB::table('configs')->where('name','website-info')->update($data)){
            return back()->with('success',"Cập nhật thành công");
        }else {
            return back()->with('error','Cập nhật không thành công');
        }
    }
}
