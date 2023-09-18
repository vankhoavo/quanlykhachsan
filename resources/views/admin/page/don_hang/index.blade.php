@extends('admin.share.master')
@section('title')
    Quản Lý Đơn Đặt Hàng
@endsection
@section('content')
<div id="app" class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Thời Gian</th>
                            <th class="text-center">Số Phòng</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, key) in list">
                            <th class="text-center align-middle">@{{ key + 1 }}</th>
                            <td class="text-center align-middle text-nowrap">@{{ formatDate(value.ngay_bat_dau) }} - @{{ formatDate(value.ngay_ket_thuc) }}</td>
                            <td class="text-center align-middle">@{{ value.so_phong_dat }}</td>
                            <td class="text-center align-middle text-nowrap">
                                <template v-if="value.xep_phong == 0">
                                    <button class="btn btn-primary" v-on:click="getListPhong(value)">Chưa Xếp</button>
                                </template>
                                <template v-else>
                                    <button class="btn btn-success">Đã Xếp</button>
                                </template>
                                <button class="btn btn-danger">Hủy</button>
                                <button class="btn btn-warning">Xem</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Danh Sách Phòng Có Thể Chọn
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tên Phòng</th>
                            <th class="text-center" v-for="(v1, k1) in listDate.split(',')">
                                @{{ v1 }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, key) in phong">
                            <th class="text-center">
                                @{{ key + 1 }}
                            </th>
                            <td class="text-center">@{{ value.ten_phong }}</td>
                            <template v-for="(v, k) in value.x.split(',')" >
                                <td v-if="v == 1" class="text-center">
                                    <input type="checkbox" v-on:click="process(value.id, k, $event)">
                                </td>
                                <td v-else class="bg-danger">

                                </td>
                            </template>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="2">Tổng</th>
                            <th class="text-center" v-for="(v2, k2) in footList">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary" v-on:click="create()">Tạo Lịch Phòng</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        new Vue({
            el      :   '#app',
            data    :   {
                list    :   [],
                phong   :   [],
                listDate:   '',
                footList:   [],
                id_hd   :   '',
            },
            created() {
                this.loadDonHang();
            },
            methods :   {
                create() {
                    var payload = {
                        'id_hd'     :   this.id_hd,
                        'footList'  :   this.footList,
                    };
                    axios
                        .post('/admin/hoa-don/don-dat-hang/create', payload)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            var errors = res.response.data.errors;
                            $.each(errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                loadDonHang() {
                    axios
                        .get('/admin/hoa-don/don-dat-hang/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                formatDate(date) {
                    return moment(date).format('DD/MM/YYYY');
                },
                getListPhong(payload) {
                    this.id_hd  = payload.id;
                    console.log(this.id_hd);
                    axios
                        .post('/admin/chi-tiet-phong/getListPhong', payload)
                        .then((res) => {
                            this.phong = res.data.data;
                            this.listDate = res.data.listDate;
                            this.footList = res.data.footList;
                        });
                },
                process(id, k, $event) {
                    const checked = $event.target.checked;
                    if(checked) {
                        this.footList[k].sl++;
                        this.footList[k].phong.push(id);
                    } else {
                        this.footList[k].sl--;
                        for(var i in this.footList[k].phong){
                            if(this.footList[k].phong[i]==id){
                                this.footList[k].phong.splice(i,1);
                                break;
                            }
                        }
                    }
                },
            },
        });
    </script>
@endsection
