<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left; /* Rata kiri */
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #66BA6A; /* Warna hijau muda untuk header */
        }
        .footer-section {
            text-align: right;
            margin-top: 50px;
            padding-right: 50px;
        }
        .header-section {
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            text-align: center;
            margin-bottom: 20px; /* Jarak antara kop surat dan tabel */
        }

        white-text{
            color:white
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="header-section">
        <img src="{{ base_path('resources/views/pdf/Logo Sekolah.png') }}" style="height: 80px; margin-bottom: 10px;">
        <div>
            <h3 style="margin: 0; font-weight: bold; font-size: 26px; color: black;">YAYASAN ISLAM ASY SYARIFIYYAH BOJONGGEDE</h3>
            <h4 style="margin: 5px 0; font-weight: normal; font-size: 22px; color: black;">SMP ISLAM PLUS ASY SYARIFIYYAH</h4>
            <p style="margin: 5px 0; font-size: 16px; color: black;">Jln. Alternatif Pemda Kp. Pulo, Desa Kedung Waringin Kec. Bojonggede Kab. Bogor</p>
        </div>
    </div>

    <h3>Data Pengguna</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th class="white-text">Username</th>
                <th class="white-text">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td class="white-text">{{ $user->username }}</td>
                    <td class="white-text">
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                                <label>{{ $v }}</label>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="footer-section">
        <p class="black-text" style="margin: 0;">
            {{ session('user_location', 'Jakarta') }}, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </p>
        <p class="black-text" style="margin: 10px 0;">Kepala Sekolah</p>
        <div style="height: 80px;"></div> <!-- Ruang kosong untuk tanda tangan -->
        <p class="black-text" style="margin: 0;">Abdul Latip S.Hi</p>
    </div>
</body>
</html>