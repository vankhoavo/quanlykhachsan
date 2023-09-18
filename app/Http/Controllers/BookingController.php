<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerBookingRequest;
use App\Jobs\sendMailJob;
use App\Models\ChiTietPhong;
use App\Models\HoaDon;
use App\Models\Phong;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function processBooking(CustomerBookingRequest $request)
    {
        $data = $request->all();
        $phong = Phong::where('id', $data['booking-roomtype'])->first();
        $data['booking-from']   = Carbon::createFromFormat('d-m-Y', Str::substr($data['booking-date'], 0, 10))->format('Y-m-d');
        $data['booking-to']     = Carbon::createFromFormat('d-m-Y', Str::substr($data['booking-date'], 13))->format('Y-m-d');
        $data['booking-room']   = intval(ceil($data['booking-adults'] / $phong->so_khach));

        $check = true;
        if($data['booking-room'] < 1) {
            $check = false;
            toastr()->error('Số phòng đặt không hợp lệ');
        }
        if($data['booking-from'] < date('Y-m-d')) {
            $check = false;
            toastr()->error('Ngày đặt phải lớn hơn hoặc bằng ngày hiện tại');
        }
        if($data['booking-from'] > $data['booking-to']) {
            $check = false;
            toastr()->error('Ngày rời đi phải lớn hơn hoặc bằng ngày đến');
        }

        if($check == false) {
            return redirect('/');
        } else {
            // Chổ này tạo hóa đơn
            $this->taoHoaDon($data);
            toastr()->success('Đơn đặt hàng của bạn đã thành công!');
            return redirect('/');
        }
    }

    public function taoHoaDon($data)
    {
        DB::beginTransaction();
        try {
            $ngay_bd    = Carbon::parse($data['booking-from']);
            $ngay_kt    = Carbon::parse($data['booking-to']);
            $so_ngay    = $ngay_kt->diffInDays($ngay_bd);

            $phong      = Phong::where('id', $data['booking-roomtype'])->first();
            $tong_tien  = $phong->gia_mac_dinh * $so_ngay * $data['booking-room'];

            $hoaDon     =  HoaDon::create([
                'ho_va_ten'         =>  $data['booking-name'],
                'email'             =>  $data['booking-email'],
                'ngay_bat_dau'      =>  $data['booking-from'],
                'ngay_ket_thuc'     =>  $data['booking-to'],
                'so_phong_dat'      =>  $data['booking-room'],
                'loai_phong_dat'    =>  $data['booking-roomtype'],
                'tong_tien'         =>  $tong_tien,
            ]);

            $so_hoa_don = $hoaDon->id * 1 + 10000;

            $data['ho_va_ten']                  =   $data['booking-name'];
            $data['tu_ngay']                    =   Carbon::parse($data['booking-from'])->format('d/m/Y');
            $data['den_ngay']                   =   Carbon::parse($data['booking-to'])->format('d/m/Y');
            $data['so_khach']                   =   $data['booking-adults'] . ' người lớn ' . $data['booking-children'] . ' trẻ em';
            $data['so_phong_dat']               =   $data['booking-room'];
            $data['loai_phong_dat']             =   $phong->ma_phong;
            $data['tong_tien_thanh_toan']       =   number_format($tong_tien, 0) . ' đ';
            $data['tien_dat_coc']               =   number_format($tong_tien * 0.3, 0) . ' đ';
            $data['noi_dung_chuyen_khoan']      =   'HD' . $so_hoa_don;

            sendMailJob::dispatch($data['booking-email'], 'Xác Nhận Đặt Phòng', $data, 'mail.order');
            Log::info("Đã thực hiện chức năng booking thành công!");

            DB::commit();
        } catch(Exception $e) {
            Log::error("Có lỗi " . $e);
            DB::rollBack();
        }
    }

    public function transactionBooking()
    {
        $now = Carbon::now()->format('d/m/Y');
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);
        echo 'đang chạy code..... <br>';
        $response = $client->post('http://103.137.185.207:9899/api/vcb/transactions',
                    [
                        'body' => json_encode(
                            [
                                'begin'           => $now,
                                'end'             => $now,
                                'username'        => '0982834671',
                                'password'        => 'Anhvu.372002',
                            ]
                    )]
                );

        $result = json_decode($response->getBody()->getContents(), true);

        if($result["success"] == true) {
            $list = $result["transactions"];
            foreach($list as $key => $value) {
                $tran = Transaction::where('reference', $value['Reference'])->first();
                if(!$tran && $value['CD'] == '+') {
                    $str = $value['Description'];
                    $hd  = strpos($str, 'HD') ? Str::substr($str, 2 + strpos($str, 'HD')) : '';
                    Transaction::create([
                        'reference'         => $value['Reference'],
                        'amount'            => $value['Amount'],
                        'description'       => $value['Description'],
                        'content'           => $hd,
                    ]);

                    if(strlen($hd) > 4) {
                        // hd = 10009
                        $id = $hd - 10000;
                        $hoaDon = HoaDon::where('id', $id)->first();
                        if($hoaDon) {
                            $tien_can_dat_coc = $hoaDon->tong_tien * 0.3;
                            if($tien_can_dat_coc <= $value['Amount']) {
                                $hoaDon->tien_coc   = $value['Amount'];
                                $hoaDon->thanh_toan = 1;
                                $hoaDon->save();
                            }
                        }
                    }
                }
            }
        }
    }
}
