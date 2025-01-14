<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hasil Diagnosa</title>
    <link href="{{ public_path('dist/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-section img {
            height: 80px;
        }
        .header-section .school-name {
            font-size: 20px;
            font-weight: bold;
        }
        .footer-section {
            margin-top: 50px;
            text-align: right;
        }
        .signature-section {
            text-align: right;
            margin-top: 50px;
        }
        .signature-section .signature-line {
            margin: 40px 0 10px;
            border-top: 1px solid #000;
            width: 200px;
        }
    </style>
</head>
<body>
@php
  $riwayat = App\Models\Riwayat::find($id);
  $data_diagnosa = unserialize($riwayat->hasil_diagnosa);
  $cf_max = unserialize($riwayat->cf_max);
  $diagnosa_tertinggi = $data_diagnosa[$cf_max[1]] ?? null;
  $gejala_cf_data = [];
  if ($diagnosa_tertinggi) {
      $cf_combine = null;
      foreach ($diagnosa_tertinggi['gejala'] as $key => $gejala) {
          if ($key == 0) {
              $cf_combine = $gejala['cf_total'];
              $gejala_cf_data[] = [
                  'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
                  'cf1' => $cf_combine,
                  'cf2' => null,
                  'cf_combine' => $cf_combine
              ];
          } else {
              $cf2 = $gejala['cf_total'];
              $cf_combine = $cf_combine + ($cf2 * (1 - abs($cf_combine)));
              $gejala_cf_data[] = [
                  'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
                  'cf1' => $cf_combine,
                  'cf2' => $cf2,
                  'cf_combine' => $cf_combine
              ];
          }
      }
  }
@endphp

<div class="header-section">
    <div class="school-name">SMP ISLAM PLUS AS SYARIFIYYAH</div>
    <img src="{{ public_path('path_to_logo/logo.png') }}" alt="Logo Sekolah">
</div>

<p class="mb-4">
	<b>Nama :</b> {{ $riwayat->nama }}
</p>
<p class="mb-4">
	<b>Tanggal :</b> {{ $riwayat->created_at->format('d M Y, H:m:s A') }}
</p>

@if($diagnosa_tertinggi)
  <div class="card card-body shadow-none p-0 mt-5 border">
    <div class="card-header bg-primary text-white p-2">
      <h6 class="font-weight-bold">Penyakit: {{ $diagnosa_tertinggi['nama_penyakit'] }} ({{ $diagnosa_tertinggi['kode_penyakit'] }})</h6>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
      <tr>
        <th>Nama Gejala</th>
        <th>CF1 (User)</th>
        <th>CF2 (Expert)</th>
        <th>CF Combine</th>
      </tr>
      </thead>
      <tbody>
      @foreach($gejala_cf_data as $gejala)
        <tr>
          <td>{{ $gejala['nama_gejala'] }}</td>
          <td>{{ $gejala['cf1'] !== null ? number_format($gejala['cf1'], 3) : '-' }}</td>
          <td>{{ $gejala['cf2'] !== null ? number_format($gejala['cf2'], 3) : '-' }}</td>
          <td>{{ number_format($gejala['cf_combine'], 3) }}</td>
        </tr>
      @endforeach
      </tbody>
      <tfoot class="font-weight-bold">
      <tr>
        <td colspan="3" class="text-right">Nilai CF Total</td>
        <td><span class="text-danger">{{ number_format($diagnosa_tertinggi['hasil_cf'], 3) }}</span></td>
      </tr>
      </tfoot>
    </table>
  </div>
  <div class="mt-5">
    <div class="alert alert-success">
      <h5 class="font-weight-bold">Kesimpulan</h5>
      <p>Berdasarkan gejala yang kamu pilih atau alami dan aturan yang telah ditentukan oleh pakar, diagnosa tertinggi memiliki nilai CF <b>{{ number_format($diagnosa_tertinggi['hasil_cf'], 3) }}
          ({{ number_format($diagnosa_tertinggi['hasil_cf'] * 100, 2) }}%)</b> untuk penyakit
        <b>{{ $diagnosa_tertinggi['nama_penyakit'] }} ({{ $diagnosa_tertinggi['kode_penyakit'] }})</b>.</p>
    </div>
  </div>
@else
  <p class="text-center mt-5">Tidak ada diagnosa yang ditemukan.</p>
@endif

<div class="footer-section">
    <p><b>Jakarta, {{ now()->isoFormat('dddd, D MMMM YYYY') }}</b></p>
</div>

<div class="signature-section">
    <p><b>Kepala Sekolah</b></p>
    <div class="signature-line-right"></div>
    <p><b>Nama Kepala Sekolah</b></p>
    <p><b>NIDN: XXXXXXXX</b></p>
</div>
</body>
</html>
