<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class CreateRuleSeeder extends Seeder
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
                'kode_penyakit' => 'P001', // Rule 1 - Disleksia
                'G001' => true,
                'G002' => true,
                'G003' => true,
                'G004' => true,
                'G005' => true,
                'G007' => true,
                'G021' => true,
            ],
            [
                'kode_penyakit' => 'P002', // Rule 2 - Disgrafia
                'G003' => true,
                'G006' => true,
                'G007' => true,
                'G008' => true,
                'G009' => true,
                'G010' => true,
                'G019' => true,
            ],
            [
                'kode_penyakit' => 'P003', // Rule 3 - Diskalkulia
                'G005' => true,
                'G011' => true,
                'G012' => true,
                'G013' => true,
                'G014' => true,
                'G015' => true,
            ],
            [
                'kode_penyakit' => 'P004', // Rule 4 - Dispraksia
                'G007' => true,
                'G016' => true,
                'G017' => true,
                'G018' => true,
                'G019' => true,
                'G020' => true,
                'G022' => true,
            ],
            [
                'kode_penyakit' => 'P005', // Rule 5 - Attention Deficit Hyperactivity Disorder (ADHD)
                'G008' => true,
                'G018' => true,
                'G021' => true,
                'G022' => true,
                'G023' => true,
                'G024' => true,
                'G025' => true,
            ],
        ];

        foreach ($data as $row) {
            Rule::create($row);
        }
    }
}
