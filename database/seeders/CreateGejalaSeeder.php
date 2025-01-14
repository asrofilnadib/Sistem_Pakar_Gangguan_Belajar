<?php

namespace Database\Seeders;

use App\Models\Gejala;
use Illuminate\Database\Seeder;

class CreateGejalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Kesulitan membaca kata-kata panjang',
                'kode' => 'G001'
            ],
            [
                'nama' => 'Membaca huruf atau kata secara terbalik',
                'kode' => 'G002'
            ],
            [
                'nama' => 'Bingung membedakan huruf yang mirip',
                'kode' => 'G003'
            ],
            [
                'nama' => 'Sulit mengingat urutan huruf dalam alfabet',
                'kode' => 'G004'
            ],
            [
                'nama' => 'Sulit memahami isi bacaan',
                'kode' => 'G005'
            ],
            [
                'nama' => 'Sulit Membaca Tulisan Tangan',
                'kode' => 'G006'
            ],
            [
                'nama' => 'Ukuran atau Bentuk Tulisan Tidak Konsisten',
                'kode' => 'G007'
            ],
            [
                'nama' => 'Kesulitan Menulis dengan Kecepatan yang Sama',
                'kode' => 'G008'
            ],
            [
                'nama' => 'Melewatkan atau Salah Menulis Huruf',
                'kode' => 'G009'
            ],
            [
                'nama' => 'Tidak Nyaman Saat Menulis Lama',
                'kode' => 'G010'
            ],
            [
                'nama' => 'Kesulitan Menghitung Penjumlahan atau Pengurangan',
                'kode' => 'G011'
            ],
            [
                'nama' => 'Sulit Memahami Pecahan atau Pembagian',
                'kode' => 'G012'
            ],
            [
                'nama' => 'Sulit Mengingat Tabel Perkalian',
                'kode' => 'G013'
            ],
            [
                'nama' => 'Bingung Menulis Angka Besar',
                'kode' => 'G014'
            ],
            [
                'nama' => 'Sulit Mengikuti Langkah-Langkah Soal Matematika',
                'kode' => 'G015'
            ],
            [
                'nama' => 'Kesulitan  Memegang Barang Stabil',
                'kode' => 'G016'
            ],
            [
                'nama' => 'Kesulitan dengan Koordinasi Tubuh',
                'kode' => 'G017'
            ],
            [
                'nama' => 'Gerakan Lambat atau Kurang Seimbang',
                'kode' => 'G018'
            ],
            [
                'nama' => 'Sulit Melakukan Hal Kecil',
                'kode' => 'G019'
            ],
            [
                'nama' => 'Kesulitan Menggambar di Dalam Garis',
                'kode' => 'G020'
            ],
            [
                'nama' => 'Sulit Berkonsentrasi Lama',
                'kode' => 'G021'
            ],
            [
                'nama' => 'Sering Lupa Membawa Perlengkapan Sekolah',
                'kode' => 'G022'
            ],
            [
                'nama' => 'Tidak Bisa Duduk Diam Lama',
                'kode' => 'G023'
            ],
            [
                'nama' => 'Sering Bertindak Tanpa Berpikir',
                'kode' => 'G024'
            ],
            [
                'nama' => 'Mudah Terganggu Hal-Hal Kecil',
                'kode' => 'G025'
            ]
        ];

        Gejala::insert($data);
    }
}
