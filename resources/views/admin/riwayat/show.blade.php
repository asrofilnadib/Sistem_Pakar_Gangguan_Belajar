{{--@dd($solusi)--}}
<x-app-layout>
  <x-slot name="title">Hasil diagnosa</x-slot>

  @if(session()->has('success'))
    <x-alert type="success" message="{{ session()->get('success') }}"/>
  @endif
  <x-card title="Berikut hasil diagnosa penyakit">
    <p class="mb-4">
      <i class="fas fa-user mr-1"></i> {{ $riwayat->nama }} <i
        class="fas fa-calendar ml-4 mr-1"></i> {{ $riwayat->created_at->format('d M Y, H:m:s') }}
    </p>

    {{--<table class="table table-hover border">
      <thead class="thead-light">
        <tr>
          <th>Gejala yang kamu alami saat ini</th>
          <th>Tingkat keyakinan</th>
          <th>CF User</th>
        </tr>
      </thead>
      <tbody>
        @foreach(unserialize($riwayat->gejala_terpilih) as $gejala)
        <tr>
          <td>{{ $gejala['kode'] }} - {{ $gejala['nama'] }}</td>
          <td>{{ $gejala['keyakinan'] }}</td>
          <td>{{ $gejala['cf_user'] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>--}}

    @if($diagnosa_tertinggi)
      <div class="card card-body p-0 mt-5 border" style="box-shadow: none !important;">
        <div class="card-header bg-primary text-white p-2">
          <h6 class="font-weight-bold">Tabel perhitungan penyakit: {{ $diagnosa_tertinggi['nama_penyakit'] }}
            ({{ $diagnosa_tertinggi['kode_penyakit'] }})</h6>
        </div>
        {{--<table class="table table-hover">
          <thead class="thead-light">
          <tr>
            <th>Gejala</th>
            <th>CF User</th>
            <th>CF Expert</th>
            <th>CF (H, E)</th>
          </tr>
          </thead>
          <tbody>
          @foreach($diagnosa_tertinggi['gejala'] as $gejala)
            <tr>
              <td>{{ $gejala['kode'] }} - {{ $gejala['nama'] }}</td>
              <td>{{ $gejala['cf_user'] }}</td>
              <td>{{ $gejala['cf_role'] }}</td>
              <td>{{ $gejala['hasil_perkalian'] }}</td>
            </tr>
          @endforeach
          </tbody>
          <tfoot class="font-weight-bold">
          <tr>
            <td scope="row">Nilai CF</td>
            <td><span class="text-danger">{{ number_format($diagnosa_tertinggi['hasil_cf'], 3) }}</span></td>
          </tr>
          </tfoot>
        </table>--}}
        <table class="table table-hover border">
          <thead class="thead-light">
          <tr>
            <th>Nama Gejala</th>
            <th>CF1</th>
            <th>CF2</th>
            <th>CF Combine</th>
          </tr>
          </thead>
          <tbody>
          @foreach($gejala_cf_data as $gejala)
            <tr>
              <td>{{ $gejala['nama_gejala'] }}</td>
              <td>{{ number_format($gejala['cf1'], 3) }}</td>
              <td>{{ $gejala['cf2'] !== null ? number_format($gejala['cf2'], 3) : '-' }}</td>
              <td>{{ number_format($gejala['cf_combine'], 3) }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
        @endif
      </div>

      <div class="mt-5">
        @if($solusi)
          <div class="alert alert-success">
            <h5 class="font-weight-bold">Kesimpulan</h5>
            <p>Berdasarkan dari gejala yang kamu pilih atau alami juga berdasarkan Role/Basis aturan yang sudah ditentukan
              oleh seorang pakar penyakit, maka perhitungan Algoritma Certainty Factor mengambil nilai CF yang paling
              tinggi yakni <b>{{ number_format(unserialize($riwayat->cf_max)[0], 3) }}
                ({{ number_format(unserialize($riwayat->cf_max)[0], 3) * 100 }}%)</b> yaitu
              <b>{{ $diagnosa_tertinggi['nama_penyakit'] }} ({{ $diagnosa_tertinggi['kode_penyakit'] }})</b>.</p>
            <p><b>Penyebab:</b> {{ $solusi }}</p>
{{--            <p><b>Solusi:</b> {{ $solusi['solusi'] }}</p>--}}
          </div>
          <div class="mt-3 text-center">
            <a href="{{ asset("storage/downloads/$riwayat->file_pdf") }}" target="_blank" class="btn btn-primary mr-1">
              <i class="fas fa-print mr-1"></i> Print
            </a>
            <a href="{{ route('admin.diagnosa') }}" class="btn btn-warning mr-1">
              <i class="fas fa-redo mr-1"></i> Diagnosa ulang
            </a>
          </div>
        @else
          <p class="text-center mt-5">Tidak ada solusi yang ditemukan untuk hasil diagnosa ini.</p>
        @endif
      </div>

  </x-card>
</x-app-layout>
