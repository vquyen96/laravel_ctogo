<?php

namespace App\Http\Middleware\Permission;

use Closure;
use Auth;
use App\Models\Admin;

class CheckSuperAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( (Auth::guard('admin')->user()->permiss ?? '') == Admin::ADMIN_PERMISSION ){
            return $next($request);
        }else{
            return redirect('admin')->with('error','Bạn không có quyền truy cập');
        }
    }
}
