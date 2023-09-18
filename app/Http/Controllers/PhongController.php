<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckIdPhongRequest;
use App\Http\Requests\CreatePhongRequest;
use App\Http\Requests\UpdatePhongRequest;
use App\Models\KhuVuc;
use App\Models\Phong;
use Illuminate\Http\Request;

class PhongController extends Controller
{
    public function index()
    {
        $khuVuc = KhuVuc::all();

        return view('admin.page.phong.index', compact('khuVuc'));
    }

    public function getData()
    {
        $data = Phong::join('khu_vucs', 'phongs.khu_vuc_id', 'khu_vucs.id')
                     ->select('phongs.*', 'khu_vucs.ten_khu')
                     ->get(); // Trả về array

        return response()->json([
            'data'    => $data,
        ]);
    }

    public function viewListRoom()
    {
        $data = Phong::where('tinh_trang', 1)->get();

        return view('client.page.list_room', compact('data'));
    }

    public function store(CreatePhongRequest $request)
    {
        $phong = Phong::create([
            'ma_phong'      =>  $request->ma_phong,
            'gia_mac_dinh'  =>  $request->gia_mac_dinh,
            'mo_ta_phong'   =>  $request->mo_ta_phong,
            'tinh_trang'    =>  $request->tinh_trang,
            'hinh_anh'      =>  $request->hinh_anh,
            'khu_vuc_id'    =>  $request->khu_vuc_id,
            'so_khach'      =>  $request->so_khach,
        ]);

        broadcast(new \App\Events\event_phong(1));

        return response()->json([
            'status'    => true,
        ]);
    }

    public function destroy(CheckIdPhongRequest $request)
    {
        // Phong:where('id', $request->id)->first();
        Phong::find($request->id)->delete();

        return response()->json([
            'status'    => true,
        ]);
    }

    public function edit(CheckIdPhongRequest $request)
    {
        $data = Phong::find($request->id);

        return response()->json([
            'data'    => $data,
        ]);
    }

    public function update(UpdatePhongRequest $request)
    {
        $phong = Phong::find($request->id);
        $phong->ma_phong     = $request->ma_phong;
        $phong->gia_mac_dinh = $request->gia_mac_dinh;
        $phong->mo_ta_phong  = $request->mo_ta_phong;
        $phong->tinh_trang   = $request->tinh_trang;
        $phong->hinh_anh     = $request->hinh_anh;
        $phong->khu_vuc_id   = $request->khu_vuc_id;
        $phong->so_khach     = $request->so_khach;

        $phong->save();

        return response()->json(['status' => true]);
    }

    public function viewDetailRoom($id)
    {
        $data = Phong::where('id', $id)->first();
        $list = Phong::where('tinh_trang', 1)->take(3)->get();

        if($data) {
            return view('client.page.detail_room', compact('data', 'list'));
        } else {
            toastr()->error('Liên kết không tồn tại!');
            return redirect('/');
        }
    }

    public function changeStatus($id)
    {
        $phong = Phong::find($id);

        if ($phong) {
            $phong->tinh_trang = !$phong->tinh_trang;
            $phong->save();

            return response()->json([
                'status'    => true,
            ]);
        }
    }
}
