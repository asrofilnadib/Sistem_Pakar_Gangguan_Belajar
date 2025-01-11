<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:riwayat-list', ['only' => ['index']]);
    $this->middleware('permission:riwayat-show', ['only' => ['show']]);
  }

  public function index()
  {
    if (auth()->user()->hasRole('Admin')) {
      $riwayat = Riwayat::with('penyakit')
        ->latest()
        ->paginate(10);
    } else {
      $riwayat = auth()->user()
        ->riwayats()
        ->with('penyakit')
        ->latest()
        ->paginate(10);
    }

    return view('admin.riwayat.index', compact('riwayat'));
  }

/*public function show(Riwayat $riwayat)
  {
    $this->authorize('show', $riwayat);

    $diagnosa_tertinggi = null;
    $solusi = null;

    if ($riwayat->hasil_diagnosa) {
      $hasil_diagnosa = unserialize($riwayat->hasil_diagnosa);
      $diagnosa_tertinggi = collect($hasil_diagnosa)->sortByDesc('hasil_cf')->first();
    }

    if ($riwayat->cf_max) {
      $cf_max = unserialize($riwayat->cf_max);
      $kode_penyakit = substr($cf_max[1], strpos($cf_max[1], '(') + 1, -1);
      $penyakit = Penyakit::where('kode', $kode_penyakit)->first();

      if ($penyakit) {
        $solusi = [
          'nama' => $penyakit->nama,
          'kode' => $penyakit->kode,
          'penyebab' => $penyakit->penyebab,
        ];
      }
    }

    return view('admin.riwayat.show', compact('diagnosa_tertinggi', 'riwayat', 'solusi'));
  }*/

  public function show(Riwayat $riwayat)
  {
    $this->authorize('show', $riwayat);

    // Deserialisasi data diagnosa dari riwayat
    $data_diagnosa = unserialize($riwayat->hasil_diagnosa);
    $gejala_terpilih = \unserialize($riwayat->cf_max);

    // Ambil diagnosa tertinggi
    $diagnosa_tertinggi = array_reduce($data_diagnosa, function ($carry, $item) {
      return ($carry === null || $item['hasil_cf'] > $carry['hasil_cf']) ? $item : $carry;
    });

    $penyebab = null;
    if ($diagnosa_tertinggi) {
      $penyakit = \App\Models\Penyakit::where('kode',$diagnosa_tertinggi['kode_penyakit'])->first();
      $penyebab = $penyakit ? $penyakit->penyebab : null;
    }

    // Siapkan data gejala dengan CF Combine
    /*$gejala_cf_data = [];
    if ($diagnosa_tertinggi && isset($diagnosa_tertinggi['gejala'])) {
      $cf_combine = null;
      foreach ($diagnosa_tertinggi['gejala'] as $key => $gejala) {
        if ($key == 0) {
          $cf_combine = $gejala['cf_total']; // Nilai CF pertama
          $gejala_cf_data[] = [
            'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
            'cf1' => $cf_combine,
            'cf2' => null,
            'cf_combine' => $cf_combine,
          ];
        } else {
          $cf2 = $gejala['cf_total'];
          $cf_combine = $cf_combine + $cf2 * (1 - abs($cf_combine)); // Hitung CF Combine

          $gejala_cf_data[] = [
            'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
            'cf1' => $cf_combine,
            'cf2' => $cf2,
            'cf_combine' => $cf_combine,
          ];
        }
      }
    }*/
    $gejala_cf_data = [];
    if ($diagnosa_tertinggi && isset($diagnosa_tertinggi['gejala'])) {
      $cf_combine = null;
      foreach ($diagnosa_tertinggi['gejala'] as $key => $gejala) {
        if ($key == 0) {
          // Gejala pertama: cf_combine adalah cf_total dari gejala pertama
          $cf_combine = $gejala['cf_total'];
          $gejala_cf_data[] = [
            'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
            'cf1' => $cf_combine,
            'cf2' => null,
            'cf_combine' => $cf_combine,
          ];
        } else {
          // Gejala berikutnya: gunakan hasil cf_combine sebelumnya sebagai cf1
          $cf2 = $gejala['cf_total'];
          $cf_combine = $cf_combine + ($cf2 * (1 - abs($cf_combine)));

          $gejala_cf_data[] = [
            'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
            'cf1' => $cf_combine, // Gunakan hasil kombinasi terakhir sebagai cf1
            'cf2' => $cf2,
            'cf_combine' => $cf_combine,
          ];
        }
      }
    }


//    \dd($data_diagnosa, $diagnosa_tertinggi, $gejala_cf_data);

    return view('admin.riwayat.show', compact('riwayat', 'diagnosa_tertinggi', 'gejala_cf_data', 'penyebab'));
  }

}
