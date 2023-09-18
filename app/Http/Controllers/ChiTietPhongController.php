<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckIdChiTietPhongRequest;
use App\Http\Requests\CreateChiTietPhongRequest;
use App\Http\Requests\UpdateChiTietPhongRequest;
use App\Models\ChiTietPhong;
use App\Models\ChiTietPhongSuDung;
use App\Models\HoaDon;
use App\Models\Phong;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChiTietPhongController extends Controller
{
    public function index()
    {
        $phong = Phong::get();

        return view('admin.page.chi_tiet_phong.index', compact('phong'));
    }

    public function store(CreateChiTietPhongRequest $request)
    {
        $data  = $request->all();
        ChiTietPhong::create($data);

        return response()->json([
            'status'    => true,
        ]);
    }

    public function getData()
    {
        $duLieu = ChiTietPhong::join('phongs', 'chi_tiet_phongs.id_phong', 'phongs.id')
                             ->select('chi_tiet_phongs.*', 'phongs.ma_phong')
                             ->orderBy('phongs.ma_phong')
                             ->get();

        return response()->json([
            'data'    => $duLieu,
        ]);
    }

    public function changeStatus(CheckIdChiTietPhongRequest $request)
    {
        $chiTietPhong = ChiTietPhong::where('id', $request->id)->first();

        $chiTietPhong->is_open = !$chiTietPhong->is_open;
        $chiTietPhong->save();

        return response()->json([
            'status'    => true,
        ]);
    }

    public function destroy(CheckIdChiTietPhongRequest $request)
    {
        ChiTietPhong::where('id', $request->id)->first()->delete();

        return response()->json([
            'status'    => true,
        ]);
    }

    public function edit(CheckIdChiTietPhongRequest $request)
    {
        $duLieu = ChiTietPhong::where('id', $request->id)->first();

        return response()->json([
            'data'    => $duLieu,
        ]);
    }

    public function update(UpdateChiTietPhongRequest $request)
    {
        $checkMaPhong       = ChiTietPhong::where('id_phong', $request->id_phong)
                                          ->where('id', '<>', $request->id)
                                          ->get();
        foreach($checkMaPhong as $key => $value) {
            if($request->id_phong == $value->id_phong) {
                return response()->json([
                    'status'    => false,
                ]);
            }
        }

        $chiTietPhong = ChiTietPhong::where('id', $request->id)->first();
        $data     = $request->all();
        $chiTietPhong->update($data);

        return response()->json([
            'status'    => true,
        ]);
    }

    public function getListPhong(Request $request)
    {
        $hoaDon = HoaDon::where('id', $request->id)->first();

        $data = ChiTietPhong::where('is_open', 1)
                            ->where('id_phong', $hoaDon->loai_phong_dat)
                            ->select('id', 'ten_phong')
                            ->get();
        foreach($data as $key => $value) {
            $begin = Carbon::createFromFormat("Y-m-d", $request->ngay_bat_dau);
            $end   = Carbon::createFromFormat("Y-m-d", $request->ngay_ket_thuc);
            $str = '';

            while($begin <= $end) {
                //Kiểm tra xem với ngày $begin và id phòng = $value->id có người đặt chưa?
                $check = ChiTietPhongSuDung::where('id_phong', $value->id)
                                           ->whereDate('ngay_su_dung', $begin)
                                           ->first();
                if($check) {
                    $str = $str . '0,';
                } else {
                    $str = $str . '1,';
                }
                $begin->addDay(1);
            };
            $str = Str::substr($str, 0, strlen($str) - 1);
            $value->x = $str;
        }

        $listDate  = '';
        $begin = Carbon::createFromFormat("Y-m-d", $request->ngay_bat_dau);
        $end   = Carbon::createFromFormat("Y-m-d", $request->ngay_ket_thuc);
        while($begin <= $end) {
            $listDate = $listDate . $begin->format('d/m/Y') . ',';
            $begin->addDay(1);
        };
        $listDate = Str::substr($listDate, 0, strlen($listDate) - 1);

        $footList = [];
        for($i = 0; $i < count(explode(",", $listDate)); $i++) {
            // $footList[$i] = 0;
            $footList[$i] = (object) array('sl' => 0, 'phong' => []);
        }

        return response()->json([
            'data'      => $data,
            'listDate'  => $listDate,
            'footList'  => $footList,
        ]);
    }
}
