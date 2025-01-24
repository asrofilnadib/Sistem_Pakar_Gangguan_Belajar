<?php

namespace Database\Seeders;

use App\Models\Penyakit;
use Illuminate\Database\Seeder;

class CreatePenyakitSeeder extends Seeder
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
                'nama' => 'Disleksia',
                'kode' => 'P001',
                'solusi' => 'Membantu anak melalui terapi membaca fonetik, dukungan teknologi seperti text-to-speech, serta bimbingan guru berpengalaman. Deteksi dini dan aktivitas membaca rutin sejak kecil akan membangun fondasi keterampilan membaca yang lebih baik.'
            ],
            [
                'nama' => 'Disgrafia',
                'kode' => 'P002',
                'solusi' => 'Mengembangkan keterampilan motorik halus melalui terapi menulis, penggunaan alat tulis ergonomis, dan teknologi seperti keyboard. Rangsang kemampuan menulis dengan permainan kreatif dan latihan sejak dini.'
            ],
            [
                'nama' => 'Diskalkulia',
                'kode' => 'P003',
                'solusi' => 'Mengatasi kesulitan matematika dengan pendekatan visual dan alat bantu hitung seperti sempoa, serta bimbingan khusus yang praktis. Permainan angka sederhana sejak kecil akan menanamkan logika matematika yang lebih kuat.'
            ],
            [
                'nama' => 'Dispraksia',
                'kode' => 'P004',
                'solusi' => 'Meningkatkan koordinasi tubuh melalui terapi okupasi, latihan fisik seperti berenang atau senam, serta dukungan alat bantu. Stimulasi motorik dini dengan permainan koordinasi akan membantu anak berkembang lebih percaya diri.'
            ],
            [
                'nama' => 'Attention Deficit Hyperactivity Disorder',
                'kode' => 'P005',
                'solusi' => 'Membantu anak fokus melalui terapi perilaku, manajemen waktu yang terstruktur, serta aktivitas fisik dan relaksasi seperti yoga. Menciptakan rutinitas yang konsisten dan membatasi paparan gadget berlebihan dapat membantu menjaga keseimbangan perilaku dan energi.'
            ]
        ];

        Penyakit::insert($data);
    }
}
