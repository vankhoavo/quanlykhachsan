<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Phong;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $slide = explode(',', Config::orderByDESC('id')->first()->slide);
        $loaiPhong  = Phong::where('tinh_trang', 1)->get();
        view()->share('slide', $slide);
        view()->share('loaiPhong', $loaiPhong);
    }
}
