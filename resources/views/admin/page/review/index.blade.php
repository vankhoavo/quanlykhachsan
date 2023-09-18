@extends('admin.share.master')
@section('title')
    Quản Lý Review
@endsection
@section('content')
    <div id="app">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        Thêm Mới Review
                    </div>
                    <div class="card-body">
                        <form id="form_create">
                            <div class="form-group">
                                <label>Tên Khách Hàng</label>
                                <input type="text" v-model="payload.name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Thành Phố</label>
                                <input type="text" v-model="payload.city" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Số Sao</label>
                                <input type="number" v-model="payload.rate" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nội Dung</label>
                                <textarea v-model="payload.content" name="content" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <div class="input-group">
                                    <input id="avatar" class="form-control" type="text" name="filepath">
                                    <span class="input-group-prepend">
                                      <a data-input="avatar" data-preview="holder" class="btn btn-primary lfm">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                </div>
                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                            </div>
                            <div class="form-group text-right">
                                <button type="button" v-on:click="themMoiReview()" class="btn btn-primary">Thêm Mới Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        Danh Sách Review
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="listPhong">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Tên Khách Hàng</th>
                                        <th class="text-center">Địa Chỉ</th>
                                        <th class="text-center">Số Sao</th>
                                        <th class="text-center">Nội Dung</th>
                                        <th class="text-center">Hình Ảnh</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(value, key) in list_review">
                                        <tr>
                                            <th class="text-center align-middle">@{{ key * 1 + 1 }}</th>
                                            <td class="align-middle">@{{ value.name }}</td>
                                            <td class="align-middle">@{{ value.city }}</td>
                                            <td class="align-middle">@{{ value.rate }}</td>
                                            <td class="align-middle" v-html="value.content"></td>
                                            <td class="align-middle">
                                                <img v-bind:src="value.avatar" style="height: 100px" alt="">
                                            </td>
                                            <td class="text-center align-middle text-nowrap">
                                                <button class="btn btn-info mr-1 edit" data-toggle="modal" data-target="#editModal" v-on:click="click_edit(value)">Cập Nhật</button>
                                                <button class="btn btn-danger" v-on:click="del = value" data-toggle="modal" data-target="#deleteModal">Xóa Phòng</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    <form id="form_create">
                        <div class="form-group">
                            <label>Tên Khách Hàng</label>
                            <input type="text" v-model="edit.name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Thành Phố</label>
                            <input type="text" v-model="edit.city" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Số Sao</label>
                            <input type="number" v-model="edit.rate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nội Dung</label>
                            <textarea id="edit_content" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Hình Ảnh</label>
                            <div class="input-group">
                                <input id="edit_avatar" class="form-control" type="text" name="filepath">
                                <span class="input-group-prepend">
                                  <a data-input="avatar" data-preview="edit_holder" class="btn btn-primary lfm">
                                    <i class="fa fa-picture-o"></i> Choose
                                  </a>
                                </span>
                            </div>
                            <div id="edit_holder" style="margin-top:15px;max-height:100px;"></div>
                        </div>
                        <div class="form-group text-right">
                            <button type="button" v-on:click="capNhatReview()" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                </div>
              </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Xóa Review</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Bạn có chắc chắn muốn xóa Review này ?
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" v-on:click="xoaReview()" class="btn btn-danger" data-dismiss="modal">Xóa</button>
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
                payload     : {},
                list_review : [],
                edit        : {},
                del         : {},
            },
            created() {
                this.loadData();
            },
            methods : {
                click_edit(value) {
                    this.edit = value;
                    CKEDITOR.instances.edit_content.setData(value.content);
                    $("#edit_avatar").val(value.avatar);
                    $("#edit_holder").html('<img src="' + value.avatar +'" style="max-height:100px;">');
                },
                themMoiReview() {
                    this.payload.content = CKEDITOR.instances.content.getData();
                    this.payload.avatar = $("#avatar").val();
                    axios
                        .post('/admin/review', this.payload)
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
                        .get('/admin/review/data')
                        .then((res) => {
                           this.list_review = res.data.data;
                        })
                },

                capNhatReview() {
                    console.log(1);
                    this.edit.content = CKEDITOR.instances.edit_content.getData();
                    this.edit.avatar = $("#edit_avatar").val();
                    axios
                        .post('/admin/review/update', this.edit)
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

                xoaReview() {
                    axios
                        .post('/admin/review/delete', this.del)
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
            },
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
        CKEDITOR.replace('edit_content');
    </script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('.lfm').filemanager('image', { prefix: '/laravel-filemanager' });
    </script>
@endsection
