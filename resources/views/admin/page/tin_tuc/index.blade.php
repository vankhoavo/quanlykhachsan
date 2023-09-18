@extends('admin.share.master')
@section('title')
    Quản Lý Tin Tức
@endsection
@section('content')
    <div id="app" class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Thêm Mới Bài Viết
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Tiêu Đề</label>
                        <input v-model="add.tieu_de" v-on:keyup="toSlug(add.tieu_de)" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Slug Tin Tức</label>
                        <input v-model="add.slug" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Mô Tả</label>
                        <textarea v-model="add.mo_ta" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội Dung</label>
                        <textarea id="noi_dung" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình Ảnh</label>
                        <div class="input-group">
                            <input id="hinh_anh" class="form-control" type="text" name="filepath">
                            <span class="input-group-prepend">
                              <a id="lfm" data-input="hinh_anh" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                              </a>
                            </span>
                        </div>
                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    </div>
                    <div class="form-group">
                        <label>Hiển Thị</label>
                        <select v-model="add.is_open" class="form-control">
                            <option value="1">Đăng Bài</option>
                            <option value="0">Bản Nháp</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" v-on:click="themMoiTinTuc()">Thêm Mới Tin</button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Danh Sách Tin Tức
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tiêu Đề</th>
                                <th class="text-center">Mô Tả Ngắn</th>
                                <th class="text-center">Hình Ảnh</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, key) in list">
                                <th>@{{ key + 1 }}</th>
                                <td>@{{ value.tieu_de }}</td>
                                <td>@{{ value.mo_ta }}</td>
                                <td class="text-center">
                                    <img v-bind:src="value.hinh_anh" class="img-thumbnail" style="height: 150px">
                                </td>
                                <td class="text-center text-nowrap">
                                    <button v-on:click="changeOpen(value)" v-if="value.is_open == 1" class="btn btn-primary">Hiển Thị</button>
                                    <button v-on:click="changeOpen(value)" v-else class="btn btn-warning">Bản Nháp</button>
                                </td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-info" v-on:click="click_edit(value)" data-toggle="modal" data-target="#editModal">Cập Nhật</button>
                                    <button class="btn btn-danger" v-on:click="dele = value" data-toggle="modal" data-target="#deleteModal">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Tiêu Đề</label>
                                        <input v-model="edit.tieu_de" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Slug Tin Tức</label>
                                        <input v-model="edit.slug" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Mô Tả</label>
                                        <textarea v-model="edit.mo_ta" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Nội Dung</label>
                                        <textarea id="edit_noi_dung" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Hình Ảnh</label>
                                        <div class="input-group">
                                            <input id="edit_hinh_anh" class="form-control" type="text" name="filepath">
                                            <span class="input-group-prepend">
                                              <a id="lfm" data-input="edit_hinh_anh" data-preview="edit_holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                              </a>
                                            </span>
                                        </div>
                                        <div id="edit_holder" style="margin-top:15px;max-height:100px;">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Hiển Thị</label>
                                        <select v-model="edit.is_open" class="form-control">
                                            <option value="1">Đăng Bài</option>
                                            <option value="0">Bản Nháp</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="button" v-on:click="capNhatTinTuc()" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn có chắc chắn muốn xóa bài viết: @{{ dele.tieu_de }}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="button" v-on:click="xoaTinTuc()" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                                </div>
                              </div>
                            </div>
                        </div>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el  :   '#app',
            data:   {
                add :   {
                    slug     : '',
                },
                list:   [],
                edit:   {},
                dele:   {},
            },
            created() {
                this.loadData();
            },
            methods : {
                click_edit(value) {
                    this.edit = value;
                    CKEDITOR.instances.edit_noi_dung.setData(value.noi_dung);
                    $("#edit_hinh_anh").val(value.hinh_anh);
                    $("#edit_holder").html('<img src="' + value.hinh_anh +'" style="max-height:100px;">');
                },
                themMoiTinTuc() {
                    this.add.noi_dung = CKEDITOR.instances.noi_dung.getData();
                    this.add.hinh_anh = $("#hinh_anh").val();
                    axios
                        .post('/admin/tin-tuc/create', this.add)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success("Đã thêm mới thành công!");
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
                loadData() {
                    axios
                        .get('/admin/tin-tuc/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                changeOpen(payload) {
                    axios
                        .post('/admin/tin-tuc/change-status', payload)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success("Đã Thay Đổi Trạng Thái!");
                                this.loadData();
                            } else {
                                toastr.error("Thông tin không chính xác!");
                            }
                        })
                        .catch((res) => {
                            var errors = res.response.data.errors;
                            $.each(errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                capNhatTinTuc() {
                    this.edit.noi_dung = CKEDITOR.instances.edit_noi_dung.getData();
                    this.edit.hinh_anh = $("#edit_hinh_anh").val();
                    axios
                        .post('/admin/tin-tuc/update', this.edit)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success("Đã cập nhật thành công!");
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
                xoaTinTuc() {
                    axios
                        .post('/admin/tin-tuc/delete', this.dele)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success("Đã xóa thành công!");
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
                toSlug(str) {
                    str = str.toLowerCase();
                    str = str
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '');
                    str = str.replace(/[đĐ]/g, 'd');
                    str = str.replace(/([^0-9a-z-\s])/g, '');
                    str = str.replace(/(\s+)/g, '-');
                    str = str.replace(/-+/g, '-');
                    str = str.replace(/^-+|-+$/g, '');
                    this.add.slug = str;
                },
            },
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('noi_dung');
        CKEDITOR.replace('edit_noi_dung');
    </script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image', { prefix: '/laravel-filemanager' });
    </script>
@endsection
