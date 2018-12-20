<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class AccountController extends Controller
{

    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        $data['admins'] = $this->admin->paginate(10);
        return view('admin.mod.list', $data);
    }

    public function store(Request $rq)
    {
        $this->admin->handleStore($rq);
        return back();
    }

    public function delete($id)
    {
        $admin = $this->admin->findOrFail($id);

        if( !$admin->isSuperAccount() ) {
            // dd($admin);
            $admin->delete();
            return back();
        }else{
            return back()->with('error','Tài khoản này không được xóa !');
        }
    }

    public function updatePermission(Request $rq, $id)
    {
        $admin = $this->admin->findOrFail($id);

        if( !$admin->isSuperAccount() ) {

            $admin->handleStore($rq);
            return back()->with('success', 'Tài khoản ' . $admin->email . ' đã được cấp quyền lại');
        }else{
            return back()->with('error','Tài khoản này không được sửa quyền !');
        }
    }

    public function resetPassword($id)
    {
        $admin = $this->admin->findOrFail($id);

        if( !$admin->isSuperAccount() ) {
            $admin->handleResetPassword();
            return back()->with('success', 'Mật khẩu của ' . $admin->email . ' đã được reset !');
        }else{
            return back()->with('error','Tài khoản này không được reset mật khẩu !');
        }
    }
}