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
        Schema::create('chi_tiet_phong_su_dungs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoa_don');
            $table->integer('id_phong');
            $table->date('ngay_su_dung');
            $table->string('ho_ten_khach_hang')->nullable();
            $table->string('so_dien_thoai_khach_hang')->nullable();
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
        Schema::dropIfExists('chi_tiet_phong_su_dungs');
    }
};
