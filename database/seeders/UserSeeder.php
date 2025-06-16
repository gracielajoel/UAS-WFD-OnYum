<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin1',
            'email' => 'admin@gmail.com',
            'phone_number' => '089123516112',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()               
                ]);
        // User::factory()->count(1)->create();
    }
}
