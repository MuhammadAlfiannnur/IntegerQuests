<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvaluasiSoal;

class EvaluasiSoalSeeder extends Seeder
{
    public function run()
    {
        $soals = [
            [
                'pertanyaan' => 'Seekor burung sedang terbang pada ketinggian 3.5 meter di atas permukaan laut, sementara seekor ikan berenang pada kedalaman -4 meter di bawah permukaan laut. Di dekat mereka, seekor kura-kura berenang perlahan pada kedalaman 2/3 meter, dan seekor katak melompat-lompat di atas batu yang tingginya 0.75 meter dari permukaan air. Yang termasuk bilangan bulat adalah...',
                'opsi_a' => '3.5',
                'opsi_b' => '-4',
                'opsi_c' => '2/3',
                'opsi_d' => '0.75',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => '"Seekor burung terbang pada ketinggian 5 meter di atas permukaan laut, sedangkan ikan tersebut berenang pada kedalaman 3 meter di bawah permukaan laut" yang termasuk bilangan bulat positif pada kalimat di atas adalah...',
                'opsi_a' => '5',
                'opsi_b' => '-5',
                'opsi_c' => '3',
                'opsi_d' => '-3',
                'jawaban_benar' => 'a'
            ],
            [
                'pertanyaan' => 'Berdasarkan kalimat dibawah yang bukan merupakan bilangan bulat adalah...',
                'opsi_a' => 'Seorang anak menaiki tangga hingga mencapai anak tangga ke 5.',
                'opsi_b' => 'Seorang siswa belum menabung sehingga jumlah tabungannya adalah 0.',
                'opsi_c' => 'Suhu di dalam kulkas turun menjadi -2 derajat Celsius.',
                'opsi_d' => 'Ibu menuangkan setengah liter (1/2 liter) susu ke dalam gelas.',
                'jawaban_benar' => 'd'
            ],
            [
                'pertanyaan' => 'Urutan bilangan bulat dari yang terkecil ke terbesar adalah...',
                'opsi_a' => '-4, -1, 2, 0',
                'opsi_b' => '-3, -1, 0, 2',
                'opsi_c' => '0, 1, -1, 2',
                'opsi_d' => '3, -2, 0, 1',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Berapa banyak bilangan bulat yang terdapat dari -3 sampai 3?',
                'opsi_a' => '6',
                'opsi_b' => '7',
                'opsi_c' => '8',
                'opsi_d' => '9',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Perbandingan yang tepat untuk Bilangan -7 dengan -3 adalah...',
                'opsi_a' => 'Lebih besar',
                'opsi_b' => 'Lebih kecil',
                'opsi_c' => 'Sama dengan',
                'opsi_d' => 'Tidak dapat dibandingkan',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Urutan bilangan -5, 2, -3, 0 dari yang terbesar ke terkecil adalah...',
                'opsi_a' => '-5, -3, 0, 2',
                'opsi_b' => '2, 0, -3, -5',
                'opsi_c' => '0, 2, -5, -3',
                'opsi_d' => '3, -5, 2, 0',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Yang lebih kecil dari -2 adalah...',
                'opsi_a' => '-1',
                'opsi_b' => '0',
                'opsi_c' => '2',
                'opsi_d' => '-3',
                'jawaban_benar' => 'd'
            ],
            [
                'pertanyaan' => 'Bilangan 0 adalah...',
                'opsi_a' => 'Lebih besar dari semua bilangan bulat negatif',
                'opsi_b' => 'Lebih kecil dari semua bilangan bulat positif',
                'opsi_c' => 'Sama dengan bilangan bulat positif',
                'opsi_d' => 'a dan b benar',
                'jawaban_benar' => 'd'
            ],
            [
                'pertanyaan' => 'Bilangan yang lebih besar dari 8 adalah...',
                'opsi_a' => '-10',
                'opsi_b' => '9',
                'opsi_c' => '-7',
                'opsi_d' => '-11',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Hasil operasi dari (-7) + 5 adalah...',
                'opsi_a' => '-12',
                'opsi_b' => '-2',
                'opsi_c' => '2',
                'opsi_d' => '12',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Hasil operasi dari 6 - (-4) adalah...',
                'opsi_a' => '2',
                'opsi_b' => '10',
                'opsi_c' => '-10',
                'opsi_d' => '24',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Hasil operasi dari (-3) x (-2) adalah...',
                'opsi_a' => '-6',
                'opsi_b' => '6',
                'opsi_c' => '-1',
                'opsi_d' => '1',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Hasil dari operasi 12 ÷ (-3) adalah...',
                'opsi_a' => '4',
                'opsi_b' => '-4',
                'opsi_c' => '9',
                'opsi_d' => '-9',
                'jawaban_benar' => 'b'
            ],
            [
                'pertanyaan' => 'Hasil operasi dari (-8) + (-5) adalah...',
                'opsi_a' => '-13',
                'opsi_b' => '13',
                'opsi_c' => '-3',
                'opsi_d' => '3',
                'jawaban_benar' => 'a'
            ],
            [
                'pertanyaan' => 'KPK dari 6 dan 8 adalah...',
                'opsi_a' => '12',
                'opsi_b' => '18',
                'opsi_c' => '24',
                'opsi_d' => '48',
                'jawaban_benar' => 'c'
            ],
            [
                'pertanyaan' => 'FPB dari 15 dan 25 adalah...',
                'opsi_a' => '5',
                'opsi_b' => '10',
                'opsi_c' => '15',
                'opsi_d' => '25',
                'jawaban_benar' => 'a'
            ],
            [
                'pertanyaan' => 'Bilangan yang merupakan faktor dari 18 adalah...',
                'opsi_a' => '1, 2, 3, 6, 9, 18',
                'opsi_b' => '1, 2, 4, 8, 18',
                'opsi_c' => '2, 3, 6, 12',
                'opsi_d' => '3, 6, 9, 18',
                'jawaban_benar' => 'a'
            ],
            [
                'pertanyaan' => 'Bilangan yang merupakan kelipatan dari 7 adalah...',
                'opsi_a' => '7, 14, 21, 28',
                'opsi_b' => '7, 15, 21, 28',
                'opsi_c' => '7, 14, 22, 28',
                'opsi_d' => '7, 14, 21, 30',
                'jawaban_benar' => 'a'
            ],
            [
                'pertanyaan' => 'FPB dari 36 dan 60 adalah...',
                'opsi_a' => '6',
                'opsi_b' => '9',
                'opsi_c' => '12',
                'opsi_d' => '18',
                'jawaban_benar' => 'c'
            ]
        ];

        foreach ($soals as $soal) {
            EvaluasiSoal::create($soal);
        }
    }
}