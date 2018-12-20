<?php

namespace App\Http\Controllers\Admin;

use Validator;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use App\Http\Requests\AdminLoginRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getLogin()
    {
//        dd(bcrypt('123456'));
        return view('admin.auth.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        $user = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $this->checkUserBot($user);
        if ( Auth::guard('admin')->attempt($user) ) {
            return redirect('admin');
        } else {
            return back()->with('error','Không thể đăng nhập');
        }
    }

    public function getLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin');
    }
}
