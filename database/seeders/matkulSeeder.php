<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Matkul;

class matkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $courses = [
            [
                'nama_matkul' => 'Implementasi Proyek',
                'id_dosen' => 2,
                'kelas' => '6A',
                'prodi' => 'teknik informatika'
            ],
            [
                'nama_matkul' => 'Data Mining',
                'id_dosen' => 4,
                'kelas' => '5A',
                'prodi' => 'teknik informatika'
            ],
            [
                'nama_matkul' => 'Sistem Informasi',
                'id_dosen' => 3,
                'kelas' => '4A',
                'prodi' => 'teknik informatika'
            ],
        ];

        foreach($courses as $course){
            Matkul::create($course);
        }
    }
}
