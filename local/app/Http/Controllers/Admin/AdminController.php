<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminController extends Controller
{

    public function __construct() {
        $this->middleware('admin',['except' => 'getLogout']);
    }
    public function getIndex()
    {
        return "Day la trang admin sau khi da dang nhap, neu chua dang nhap thi se khong duoc phep vao day.";
    }
    public function getLogout() {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
