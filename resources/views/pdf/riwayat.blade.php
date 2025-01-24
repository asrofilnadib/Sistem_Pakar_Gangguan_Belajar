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
  $gejala_cf_data = [];

  // Menggunakan $cf_max[0] sebagai key numerik untuk mengakses $data_diagnosa
  $key_diagnosa = (int) $cf_max[0]; // Konversi ke integer jika perlu
  if (array_key_exists($key_diagnosa, $data_diagnosa)) {
    $diagnosa_tertinggi = $data_diagnosa[$key_diagnosa];
    $cf_combine = null;
    if (!empty($diagnosa_tertinggi['gejala'])) {
    $cf_combine = null;  // Inisialisasi cf_combine
    foreach ($diagnosa_tertinggi['gejala'] as $key => $gejala) {
      // Pastikan cf_total ada untuk setiap gejala
      if (!isset($gejala['cf_total']) || $gejala['cf_total'] === null) {
      //dd('CF total tidak ada untuk gejala', $gejala);
      }
      $cf2 = $gejala['cf_total'];
      // Proses perhitungan untuk gejala pertama
      if ($key == 0) {
      $cf_combine = $cf2;
      $gejala_cf_data[] = [
        'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
        'cf1' => $cf_combine,
        'cf2' => null,
        'cf_combine' => $cf_combine
      ];
      } else {
      // Rumus untuk menggabungkan CF
      $cf_combine = $cf_combine + ($cf2 * (1 - abs($cf_combine)));

      $gejala_cf_data[] = [
        'nama_gejala' => "{$gejala['kode']} - {$gejala['nama']}",
        'cf1' => $cf_combine,
        'cf2' => $cf2,
        'cf_combine' => $cf_combine
      ];
      }
    }
    } else {
    dd('Gejala tidak ditemukan', $diagnosa_tertinggi);
    }
  } else {
    dd('Key tidak ditemukan di data_diagnosa', $key_diagnosa, $data_diagnosa);
  }




  $currentDate = \Carbon\Carbon::now();
  $dayOfWeek = $currentDate->format('l'); // Menampilkan nama hari (misalnya Senin, Selasa, dll)
  $date = $currentDate->format('d'); // Tanggal
  $month = $currentDate->format('F'); // Bulan dalam format teks (misalnya Januari, Februari, dll)
  $year = $currentDate->format('Y'); // Tahun
@endphp
  {{--
  {{ ($diagnosa_tertinggi['gejala']) }} --}}
 

<div class="header-section" style="border-bottom: 2px solid black; padding-bottom: 10px; display: flex; align-items: center; justify-content: center; text-align: left;">
  <!-- Logo di kiri -->
  <img src="{{ base_path('resources/views/pdf/Logo Sekolah.png') }}" style="height: 80px; margin-right: 20px;">
  
  <!-- Teks Header -->
  <div>
    <h3 style="margin: 0; font-weight: bold; font-size: 26px; text-align: center;">YAYASAN ISLAM ASY SYARIFIYYAH BOJONGGEDE</h3>
    <h4 style="margin: 5px 0; font-weight: normal; font-size: 22px; text-align: center;">SMP ISLAM PLUS ASY SYARIFIYYAH</h4>
    <p style="margin: 5px 0; font-size: 16px; text-align: center;">Sekretariat: Jln. Alternatif Pemda Kp. Pulo Rt04/01 Desa Kedung Waringin Kec. Bojonggede Kab. Bogor</p>
    <p style="margin: 5px 0; font-size: 16px; text-align: center;">Prop. Jawa Barat Indonesia Kode Pos. 16922 Telp. 081380012001 / 08951325740236</p>
  </div>
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
      <h6 class="font-weight-bold">Penyakit: {{ $diagnosa_tertinggi['nama_penyakit'] }}
        ({{ $diagnosa_tertinggi['kode_penyakit'] }})</h6>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th>Nama Gejala</th>
          <th>CF Combine</th>
          <th>CF Total</th>
          <th>Nilai CF Akhir</th>
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
      <p>Berdasarkan gejala yang kamu pilih atau alami dan aturan yang telah ditentukan oleh pakar, diagnosa tertinggi
        memiliki nilai CF <b>{{ number_format($diagnosa_tertinggi['hasil_cf'], 3) }}
          ({{ number_format($diagnosa_tertinggi['hasil_cf'] * 100, 2) }}%)</b> untuk penyakit
        <b>{{ $diagnosa_tertinggi['nama_penyakit'] }} ({{ $diagnosa_tertinggi['kode_penyakit'] }})</b>.
      </p>
    </div>
  </div>
  @else
  <p class="text-center mt-5">Tidak ada diagnosa yang ditemukan.</p>
  @endif
  <div class="footer-section" style="text-align: right; margin-top: 50px; padding-right: 50px;">
  <p style="margin: 0;">
    {{ session('user_location', 'Jakarta') }}, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
  </p>
  <p style="margin: 10px 0;">Kepala Sekolah</p>
  <div style="height: 80px;"></div> <!-- Ruang kosong untuk tanda tangan -->
  <p style="margin: 0;">Abdul Latip S.Hi</p>
</div>




</body>

</html>