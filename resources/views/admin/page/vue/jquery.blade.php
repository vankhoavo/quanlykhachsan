@extends('admin.share.master')
@section('title')
   Ôn Lại JQuery
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Test Dữ Liệu
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Mã Phòng</th>
                                <th class="text-center">Đơn Giá</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="align-middle">1</th>
                                <td class="align-middle">AAA</td>
                                <td class="align-middle">AAA</td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-danger">Tạm Tắt</button>
                                    <button class="btn btn-warning">Hiển Thị</button>
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-info">Cập Nhật</button>
                                    <button class="btn btn-danger">Hủy Bỏ</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            loadData();
            function loadData()
            {
                axios
                    .get('/data')
                    .then((res) => {
                        var html = '';
                        $.each(res.data.data, function(k, v) {
                            html += '<tr>';
                            html += '<th class="align-middle">' + (k + 1) + '</th>';
                            html += '<td class="align-middle">'+ v.ma_phong +'</td>';
                            html += '<td class="align-middle">'+ v.gia_mac_dinh +'</td>';
                            html += '<td class="align-middle text-center">';
                            if(v.tinh_trang == 1) {
                                html += '<button class="btn btn-warning">Hiển Thị</button>';
                            } else {
                                html += '<button class="btn btn-danger">Tạm Tắt</button>';
                            }
                            html += '</td>';
                            html += '<td class="align-middle text-center">';
                            html += '<button class="btn btn-info">Cập Nhật</button>';
                            html += '<button class="btn btn-danger">Hủy Bỏ</button>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        $("#table tbody").html(html);
                    });
            }
        });
    </script>
@endsection
