<?php

namespace App\Http\Controllers\Pub;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

	public function getLogin(){
		return view('public.login');
	}

	public function postLogin(Request $request){
		$user = [
			'email' => $request->email,
			'password' => $request->password
		];

		$url = Session::get('url');

		if( Auth::attempt($user) ){
		    if(Auth::user()->status == User::NON_ACTIVE){
                Auth::logout();
                Session::flush();
                return back()->with('error','Tài khoản chưa được kích hoạt, vui lòng liên hệ nhà quản trị');
            }
		    if(isset($url)){
                return redirect($url);
            }
            return redirect('');
		}else{
			return back()->with('error','Không thể đăng nhập');
		}
	}

	public function getLogout(){
		if( Auth::check() ){
			Auth::logout();
		}	
		return redirect('login');
	}
}
