<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten');
            $table->string('email');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->integer('so_phong_dat');
            $table->integer('loai_phong_dat');
            $table->integer('tong_tien')->default(0);
            $table->integer('thanh_toan')->default(0)->comment('Chưa Thanh Toán/Đã Thanh Toán');
            $table->integer('xep_phong')->default(0)->comment('Chưa Lock/Lock Phòng');
            $table->integer('tien_coc')->default(0)->comment('0 hoặc số tiền đã cọc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoa_dons');
    }
};
