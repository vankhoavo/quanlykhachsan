@extends('admin.share.master')
@section('title')
    Quản Lý Tài Khoản Admin
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Thêm Mới Tài Khoản Admin
                </div>
                <div class="card-body">
                    @if($errors->any())
                        @foreach ($errors->all() as $key => $value)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Error {{ $key + 1 }}:</strong> {{ $value }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach
                    @endif
                    <form action="/admin/tai-khoan/create" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Họ Và Tên</label>
                            <input name="ho_va_ten" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Số Điện Thoại</label>
                            <input name="so_dien_thoai" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mật Khẩu</label>
                            <input name="password" type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nhập Lại Mật Khẩu</label>
                            <input name="ag_password" type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Loại Admin</label>
                            <select name="is_master" class="form-control">
                                <option value="0">Admin Bình Thường</option>
                                <option value="1">Admin Trùm</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm Mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Danh Sách Tài Khoản
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Họ Và Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Số Điện Thoại</th>
                                <th class="text-center">Loại Tài Khoản</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                            <tr>
                                <th class="text-center align-middle">{{ $key + 1 }}</th>
                                <td class="align-middle">{{ $value->ho_va_ten }}</td>
                                <td class="align-middle">{{ $value->email }}</td>
                                <td class="align-middle">{{ $value->so_dien_thoai }}</td>
                                <td class="align-middle text-center">
                                    @if($value->is_master == 1)
                                        <button class="btn btn-warning">Admin Trùm</button>
                                    @else
                                        <button class="btn btn-primary">Admin Thường</button>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-info">Cập Nhật</button>
                                    <button class="btn btn-danger">Xóa Tài Khoản</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
