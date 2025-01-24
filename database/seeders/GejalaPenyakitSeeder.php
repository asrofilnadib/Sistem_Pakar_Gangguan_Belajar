<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GejalaPenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Disleksia (P001)
            [
                'penyakit_id' => 1,
                'gejala_id' => 1,
                'value_cf' => -0.6,
            ],
            [
                'penyakit_id' => 1,
                'gejala_id' => 2,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 1,
                'gejala_id' => 3,
                'value_cf' => -0.6,
            ],
            [
                'penyakit_id' => 1,
                'gejala_id' => 4,
                'value_cf' => -0.2,
            ],
            [
                'penyakit_id' => 1,
                'gejala_id' => 5,
                'value_cf' => -0.2,
            ],
            [
                'penyakit_id' => 1,
                'gejala_id' => 7,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 1,
                'gejala_id' => 21,
                'value_cf' => 0.2,
            ],

            // Disgrafia (P002)
            [
                'penyakit_id' => 2,
                'gejala_id' => 3,
                'value_cf' => -0.6,
            ],
            [
                'penyakit_id' => 2,
                'gejala_id' => 6,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 2,
                'gejala_id' => 7,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 2,
                'gejala_id' => 8,
                'value_cf' => 0.4,
            ],
            [
                'penyakit_id' => 2,
                'gejala_id' => 9,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 2,
                'gejala_id' => 10,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 2,
                'gejala_id' => 19,
                'value_cf' => -0.6,
            ],

            // Diskalkulia (P003)
            [
                'penyakit_id' => 3,
                'gejala_id' => 5,
                'value_cf' => -0.2,
            ],
            [
                'penyakit_id' => 3,
                'gejala_id' => 11,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 3,
                'gejala_id' => 12,
                'value_cf' => 0.4,
            ],
            [
                'penyakit_id' => 3,
                'gejala_id' => 13,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 3,
                'gejala_id' => 14,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 3,
                'gejala_id' => 15,
                'value_cf' => 0.4,
            ],

            // Dispraksia (P004)
            [
                'penyakit_id' => 4,
                'gejala_id' => 7,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 4,
                'gejala_id' => 16,
                'value_cf' => -0.2,
            ],
            [
                'penyakit_id' => 4,
                'gejala_id' => 17,
                'value_cf' => -0.2,
            ],
            [
                'penyakit_id' => 4,
                'gejala_id' => 18,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 4,
                'gejala_id' => 19,
                'value_cf' => -0.6,
            ],
            [
                'penyakit_id' => 4,
                'gejala_id' => 20,
                'value_cf' => -0.2,
            ],
            [
                'penyakit_id' => 4,
                'gejala_id' => 22,
                'value_cf' => 0.2,
            ],

            // Attention Deficit Hyperactivity Disorder (ADHD) (P005)
            [
                'penyakit_id' => 5,
                'gejala_id' => 8,
                'value_cf' => 0.4,
            ],
            [
                'penyakit_id' => 5,
                'gejala_id' => 18,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 5,
                'gejala_id' => 21,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 5,
                'gejala_id' => 22,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 5,
                'gejala_id' => 23,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 5,
                'gejala_id' => 24,
                'value_cf' => 0.2,
            ],
            [
                'penyakit_id' => 5,
                'gejala_id' => 25,
                'value_cf' => 0.2,
            ],
        ];

        DB::table('gejala_penyakit')->insert($data);
    }
}
