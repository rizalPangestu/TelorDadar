<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Str;
use App\Models\Dosen;

class dosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $lecturer = [
            [
                'nama_dosen' => 'Mia Kamiyani',
                'nidn' => rand(100000, 999999),
                'password' => Hash::make('password'),
                'prodi' => 'teknik informatika',
                'role' => 'dosen',
                'api_token' =>  Hash::make(Str::random(60))
            ],
            [
                'nama_dosen' => 'Arry Avorizano',
                'nidn' => rand(100000, 999999),
                'password' => Hash::make('password'),
                'prodi' => 'teknik Informatika',
                'role' => 'dosen',
                'api_token' =>  Hash::make(Str::random(60))
            ],
            [
                'nama_dosen' => 'Ahmad Rizal',
                'nidn' => rand(100000, 999999),
                'password' => Hash::make('password'),
                'prodi' => 'teknik Informatika',
                'role' => 'dosen',
                'api_token' =>  Hash::make(Str::random(60))
            ],
            [
                'nama_dosen' => 'Nunik',
                'nidn' => rand(100000, 999999),
                'password' => Hash::make('password'),
                'prodi' => 'teknik Informatika',
                'role' => 'dosen',
                'api_token' =>  Hash::make(Str::random(60))
            ]
        ];

        foreach($lecturer as $dosen){
            Dosen::create($dosen);
        }
    }
}
