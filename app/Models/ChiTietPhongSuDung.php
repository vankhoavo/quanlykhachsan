<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhongSuDung extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_phong_su_dungs';

    protected $fillable = [
        'id_hoa_don',
        'id_phong',
        'ngay_su_dung',
        'ho_ten_khach_hang',
        'so_dien_thoai_khach_hang',
    ];
}
