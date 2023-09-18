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
        Schema::table('hoa_dons', function (Blueprint $table) {
            $table->integer('is_don_hang')->default(0)->comment('0: Đơn đặt hàng, 1: Đơn hàng, 2: Đã hoàn thành');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hoa_dons', function (Blueprint $table) {
            //
        });
    }
};
