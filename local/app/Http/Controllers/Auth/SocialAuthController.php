<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use \Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $data = Socialite::driver($social)->stateless()->user();
        if($social == 'facebook'){
            $avatar = isset($data->avatar) ? $data->avatar : '';
            $data = $data->user;
            $user = User::where('social_id',$data['id'])->orWhere('email',$data['email'])->first();

            if(!$user){
                $user = new User();
                $user->password = isset($data['email']) ? bcrypt($data['email']) : bcrypt($data['id'].'@social.com');
                $user->social_id = $data['id'];
                $user->social_type = 1;

            }
            $user->avatar = $avatar;
            $user->name = $data['name'];
            $user->email = isset($data['email']) ? $data['email'] : $data['id'].'@social.com';

        }else if ($social == 'google'){
            $email = $data['emails'][0]['value'];
            $name = $data['displayName'];

            $user = User::where('social_id',$data['id'])->orWhere('email',$email)->first();

            if(!$user){
                $user = new User();
                $user->password = bcrypt($email);
                $user->social_id = $data['id'];
                $user->social_type = 2;

            }
            $user->avatar = isset($data->avatar) ? $data->avatar : '';
            $user->name = $name;
            $user->email = $email;
        }else {
            return redirect()->to('/login');
        }

        $user->save();

        if($user->status == User::NON_ACTIVE){
            Auth::logout();
            Session::flush();
            return redirect()->route('login')->with('error','Tài khoản chưa được kích hoạt, vui lòng liên hệ nhà quản trị');
        }

        auth()->login($user);

        $url = Session::get('url');

        return redirect()->to($url);
    }
}
