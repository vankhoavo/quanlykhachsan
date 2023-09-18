@extends('admin.share.master')
@section('title')
   Bài Mới VueJS
@endsection
@section('content')
    <div id="app" class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Thêm Mới Khu Vực
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Mã Khu Vực</label>
                        <input v-model="add.ma_khu" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tên Khu Vực</label>
                        <input v-model="add.ten_khu" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Mô Tả Khu Vực</label>
                        <textarea v-model="add.mo_ta" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tình Trạng</label>
                        <select v-model="add.tinh_trang" class="form-control">
                            <option value="1">Đang Mở</option>
                            <option value="0">Đang Đóng</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button v-on:click="themMoi()" type="button" class="btn btn-primary">Thêm Mới</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Test Dữ Liệu
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Mã Khu</th>
                                <th class="text-center">Tên Khu</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, key) in list_phong">
                                <th class="align-middle">@{{ key + 1 }}</th>
                                <td class="align-middle">@{{ value.ma_khu }}</td>
                                <td class="align-middle">@{{ value.ten_khu }}</td>
                                <td class="align-middle text-center">
                                    <button v-if="value.tinh_trang == 0" class="btn btn-danger">Tạm Tắt</button>
                                    <button v-else class="btn btn-warning">Hiển Thị</button>
                                </td>
                                <td class="align-middle text-center">
                                    <button v-on:click="edit = value" class="btn btn-info" data-toggle="modal" data-target="#editModal">Cập Nhật</button>
                                    <button class="btn btn-danger">Hủy Bỏ</button>
                                </td>
                            </tr>
                        </tbody>
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Modal title</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Mã Khu Vực</label>
                                        <input v-model="edit.ma_khu" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Tên Khu Vực</label>
                                        <input v-model="edit.ten_khu" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Mô Tả Khu Vực</label>
                                        <textarea v-model="edit.mo_ta" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tình Trạng</label>
                                        <select v-model="edit.tinh_trang" class="form-control">
                                            <option value="1">Đang Mở</option>
                                            <option value="0">Đang Đóng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="button" v-on:click="capNhat()"  class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el      :   "#app",
            data    :   {
                list_phong  :   [],
                add         :   {},
                edit        :   {},
            },
            created()   {
                this.loadData();
            },
            methods :   {
                loadData()  {
                    axios
                        .get('/admin/khu-vuc/data')
                        .then((res) => {
                            this.list_phong = res.data.data;
                        });
                },
                themMoi()   {
                    axios
                        .post('/admin/khu-vuc/index', this.add)
                        .then((res) => {
                            if(res.data.status == true) {
                                toastr.success("Đã thêm mới khu vực thành công!");
                                this.loadData();
                            }
                        })
                        .catch((res) => {
                            var errors = res.response.data.errors;
                            $.each(errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
            },
        });
    </script>
@endsection
