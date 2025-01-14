<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use App\Models\{Gejala, Penyakit, Rule, Riwayat};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:diagnosa', ['only' => ['index']]);
    $this->middleware('permission:diagnosa-create', ['only' => ['diagnosa']]);
  }

  public function index()
  {
    $gejala = Gejala::all();

    return view('admin.diagnosa', compact('gejala'));
  }

  public function tingkat_keyakinan($keyakinan)
  {
    switch ($keyakinan) {
      case 0.2:
        return 'Tidak';
        break;
      case 0.5:
        return 'Mungkin';
        break;
      case 1:
        return 'Ya';
        break;
    }
  }

  public function kalkulasi_cf($data)
  {
    $data_penyakit = [];
    $gejala_terpilih = [];

    // Iterasi input gejala dari pengguna
    foreach ($data['diagnosa'] as $input) {
      if (!empty($input)) {
        $opts = explode('+', $input); // Memisahkan ID gejala dan cf_user
        $gejala = Gejala::with('penyakits')->find($opts[0]);

        foreach ($gejala->penyakits as $penyakit) {
          // Hitung CF Total menggunakan rumus baru
          $cf_total = $penyakit->pivot->value_cf + ($opts[1] * (1 - abs($penyakit->pivot->value_cf)));

          // Simpan data penyakit dan gejala terkait
          if (empty($data_penyakit[$penyakit->id])) {
            $data_penyakit[$penyakit->id] = [$penyakit, [$gejala, $cf_total]];
          } else {
            array_push($data_penyakit[$penyakit->id], [$gejala, $cf_total]);
          }

          // Simpan data gejala yang dipilih
          if (empty($gejala_terpilih[$gejala->id])) {
            $gejala_terpilih[$gejala->id] = [
              'nama' => $gejala->nama,
              'kode' => $gejala->kode,
              'cf_user' => $opts[1],
              'keyakinan' => $this->tingkat_keyakinan($opts[1])
            ];
          }
        }
      }
    }

    $hasil_diagnosa = [];
    $cf_max = null;

    // Proses kombinasi CF untuk setiap penyakit
    foreach ($data_penyakit as $final) {
      if (count($final) < 3) {
        continue; // Jika gejala kurang dari 2, lewati
      }

      $cf_combine = null;

      foreach ($final as $key => $value) {
        if ($key == 0) {
          continue; // Abaikan elemen pertama karena itu adalah informasi penyakit
        }

        if ($key == 1) {
          $cf_combine = $final[$key][1]; // Nilai CF pertama
        } else {
          $cf2 = $final[$key][1]; // Nilai CF gejala berikutnya
          $cf_combine = $cf_combine + $cf2 * (1 - abs($cf_combine)); // Kombinasi CF
        }

        // Jika elemen terakhir, simpan hasil CF max
        if (count($final) - 1 == $key) {
          if ($cf_max == null) {
            $cf_max = [$cf_combine, "{$final[0]->nama} ({$final[0]->kode})"];
          } else {
            $cf_max = ($cf_combine > $cf_max[0])
              ? [$cf_combine, "{$final[0]->nama} ({$final[0]->kode})"]
              : $cf_max;
          }

          $hasil_diagnosa[$final[0]->id]['hasil_cf'] = $cf_combine;
        }

        // Simpan detail gejala untuk penyakit
        if (empty($hasil_diagnosa[$final[0]->id])) {
          $hasil_diagnosa[$final[0]->id] = [
            'nama_penyakit' => $final[0]->nama,
            'kode_penyakit' => $final[0]->kode,
            'gejala' => [
              [
                'nama' => $final[$key][0]->nama,
                'kode' => $final[$key][0]->kode,
                'cf_total' => $final[$key][1]
              ]
            ]
          ];
        } else {
          array_push($hasil_diagnosa[$final[0]->id]['gejala'], [
            'nama' => $final[$key][0]->nama,
            'kode' => $final[$key][0]->kode,
            'cf_total' => $final[$key][1]
          ]);
        }
      }
    }

    return [
      'hasil_diagnosa' => $hasil_diagnosa,
      'gejala_terpilih' => $gejala_terpilih,
      'cf_max' => $cf_max
    ];
  }



  public function diagnosa(Request $request)
  {
    $name = auth()->user()->name;

    if (auth()->user()->hasRole('Admin')) {
      $request->validate(['nama' => 'required|string|max:100']);
      $name = $request->nama;
    }

    $data = $request->all();

    $result = $this->kalkulasi_cf($data);

    if ($result['cf_max'] == null) {
      return back()->withErrors(['Terjadi sebuah kesalahan']);
    }

    $riwayat = Riwayat::create([
      'nama' => $name,
      'hasil_diagnosa' => serialize($result['hasil_diagnosa']),
      'cf_max' => serialize($result['cf_max']),
      'gejala_terpilih' => serialize($result['gejala_terpilih']),
      'user_id' => auth()->id()
    ]);

    $path = public_path('storage/downloads');

    if (!File::isDirectory($path)) {
      File::makeDirectory($path, 0777, true, true);
    }

    $file_pdf = 'Diagnosa-'.$name.'-'.time().'.pdf';

    PDF::loadView('pdf.riwayat', ['id' => $riwayat->id])
      ->save($path."/".$file_pdf);

    $riwayat->update(['file_pdf' => $file_pdf]);

    return redirect()->to(route('admin.riwayat', $riwayat->id));
  }
}
