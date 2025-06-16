<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('roles')->insert([
                    "name" => "Admin",
                    "description" => "Bertanggung jawab mengelola reservasi dan data pelanggan serta memastikan komunikasi dan pelayanan pelanggan berjalan lancar.",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),                
                ]);
            DB::table('roles')->insert([
                    "name" => "Customer",
                    "description" => "Pelanggan yang melakukan reservasi dan menerima layanan dari restoran.",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),                
                ]);
        
    }
}
