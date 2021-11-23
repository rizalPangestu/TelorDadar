<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\PG;

class soalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $questions = [
            [
                'id_matkul' => 1,
                'id_dosen' => 2,
                'soal_pg' => 'Apakah sifat dari proyek?',
                'kunci_pg' => 'A',
                'pil_a' => 'Sementara',
                'pil_b' => 'tidak langsung',
                'pil_c' => 'Permanen',
                'pil_d' => 'Langsung',
                'pil_e' => 'Cepat',
                'soal_gambar' => null,
                'gambar_pil_a' => null,
                'gambar_pil_b' => null,
                'gambar_pil_c' => null,
                'gambar_pil_d' => null,
                'gambar_pil_e' => null,
            ],
            [
                'id_matkul' => 1,
                'id_dosen' => 2,
                'soal_pg' => 'Sekelompok proyek terkait dikelola secara terkoordinasi untuk memperoleh manfaat dan kontrol yang tidak tersedia dari mengelolanya secara individual disebut',
                'kunci_pg' => 'B',
                'pil_a' => 'Software',
                'pil_b' => 'Proyek',
                'pil_c' => 'Program',
                'pil_d' => 'Portopolio',
                'pil_e' => 'Hardware',
                'soal_gambar' => null,
                'gambar_pil_a' => null,
                'gambar_pil_b' => null,
                'gambar_pil_c' => null,
                'gambar_pil_d' => null,
                'gambar_pil_e' => null,
            ],
            [
                'id_matkul' => 1,
                'id_dosen' => 2,
                'soal_pg' => ' Hal-hal yang harus dimiliki seorang manajer proyek, kecuali?',
                'kunci_pg' => 'C',
                'pil_a' => 'Memberikan Kepercayaan',
                'pil_b' => 'Mampu membuat keputusan',
                'pil_c' => 'Menimbulkan Konflik',
                'pil_d' => 'Menjadi penengar yang baik',
                'pil_e' => 'Menjadi petinju yang baik',
                'soal_gambar' => null,
                'gambar_pil_a' => null,
                'gambar_pil_b' => null,
                'gambar_pil_c' => null,
                'gambar_pil_d' => null,
                'gambar_pil_e' => null,
            ],
            [
                'id_matkul' => 1,
                'id_dosen' => 2,
                'soal_pg' => ' upaya sementara yang dilakukan untuk menciptakan produk, layanan, atau hasil yang unik disebut sebagai?',
                'kunci_pg' => 'D',
                'pil_a' => 'Teknik',
                'pil_b' => 'Program',
                'pil_c' => 'Tools',
                'pil_d' => 'Proyek',
                'pil_e' => 'Hoki',
                'soal_gambar' => null,
                'gambar_pil_a' => null,
                'gambar_pil_b' => null,
                'gambar_pil_c' => null,
                'gambar_pil_d' => null,
                'gambar_pil_e' => null,
            ],
            [
                'id_matkul' => 1,
                'id_dosen' => 2,
                'soal_pg' => 'Manakah yang bukan termasuk keuntungan dari manajemen proyek?',
                'kunci_pg' => 'E',
                'pil_a' => 'Meningkatkan Produktivitas',
                'pil_b' => 'Meningkatkan bakuhantam',
                'pil_c' => 'Meningkatkan kerjasama',
                'pil_d' => 'Memperbanyak Anak',
                'pil_e' => 'Memperbanyak biaya',
                'soal_gambar' => null,
                'gambar_pil_a' => null,
                'gambar_pil_b' => null,
                'gambar_pil_c' => null,
                'gambar_pil_d' => null,
                'gambar_pil_e' => null,
            ]
        ];

        foreach($questions as $question){
            PG::create($question);
        }
    }
}
