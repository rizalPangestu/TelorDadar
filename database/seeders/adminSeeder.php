<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Str;
use App\Models\Dosen;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // 'nama_dosen' => 'required',
		// 			'password' => 'required|min:6',
		// 			'prodi' => 'required',
        Dosen::firstOrCreate(
            [
                'nama_dosen' => 'admin',
                'nidn' => 999999,
                'password' => Hash::make('password'),
                'prodi' => 'teknik',
                'role' => 'admin',
                'api_token' =>  Hash::make(Str::random(60))
            ]
            );
    }
}
