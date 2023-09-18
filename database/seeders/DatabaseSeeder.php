<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(KhuVucSeeder::class);
        $this->call(PhongSeeder::class);
        $this->call(ChiTietPhongSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
