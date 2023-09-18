<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhong;
use App\Models\ChiTietPhongSuDung;
use App\Models\HoaDon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HoaDonController extends Controller
{
    public function viewDonDatHang()
    {
        return view('admin.page.don_hang.index');
    }

    public function getDataDonDatHang()
    {
        // Đơn đặt hàng là những đơn chưa phân phòng hoặc chưa cọc hoặc chưa thanh toán
        $data = HoaDon::where('is_don_hang', 0)->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function createChiTietPhong(Request $request)
    {
        // 1. Lấy thông của hóa đơn
        $hoaDon = HoaDon::where('id', $request->id_hd)->where('xep_phong', 0)->first();
        if($hoaDon) {
            foreach($request->footList as $key => $value) {
                if($value['sl'] != $hoaDon->so_phong_dat) {
                    return response()->json([
                        'status'    => false,
                        'message'   => 'Số lượng phòng bạn chọn không đủ cho đơn hàng!',
                    ]);
                }
            }

            // Qua tới đây là đủ số lượng rồi!
            foreach($request->footList as $key => $value) {
                $day = Carbon::createFromFormat("Y-m-d", $hoaDon->ngay_bat_dau)->addDays($key);
                foreach($value['phong'] as $k => $v) {
                    ChiTietPhongSuDung::create([
                        'id_hoa_don'    =>      $hoaDon->id,
                        'id_phong'      =>      $v,
                        'ngay_su_dung'  =>      $day,
                    ]);
                }
            }

            $hoaDon->xep_phong = 1;
            $hoaDon->save();

            return response()->json([
                'status'    => true,
                'message'   => 'Đã xếp phòng thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Đơn hàng không tồn tại trong hệ thống hoặc đã xử lý rồi!',
            ]);
        }
    }
}
