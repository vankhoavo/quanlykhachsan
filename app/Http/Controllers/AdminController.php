<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $data = Admin::get();

        return view('admin.page.tai_khoan.index', compact('data'));
    }

    public function store(CreateAdminRequest $request)
    {
        $data               = $request->all();
        $data['password']   = bcrypt($request->password);

        Admin::create($data);
        toastr()->success('Đã thêm mới tài khoản thành công!');

        return redirect()->back();
    }

    public function viewLogin()
    {
        return view('admin.page.login');
    }

    public function actionLogin(LoginAdminRequest $request)
    {
        $check = Auth::guard('admin')->attempt([
            'email'     => $request->email,
            'password'  => $request->password,
        ]);

        if($check) {
            return redirect('/admin/phong');
        } else {
            return redirect('/admin/login');
        }
    }

    public function viewFaceBook()
    {
        return view('facebook');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        toastr()->success("Đã Logout Thành Công!");

        return redirect('/admin/login');
    }
}
