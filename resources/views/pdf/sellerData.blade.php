<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-primary {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }

        .button-info {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    {{-- <h1>Laporan Data User</h1> --}}
    <div class="">
        <img src="{{ public_path('kop-surat-2.png') }}" style="width: 100%" alt="">
    </div>
    <h3 style="text-align: right">{{ $title }}</h3>
    <div class="" style="height: 30px"></div>
    <p>Tanggal: {{ $date }}</p>
    <div class="" style="height: 30px"></div>
    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center;">Nama</th>
                <th style="text-align: center">Nama Toko</th>
                <th style="text-align: center">Status</th>
                <th style="text-align: center">Profit</th>
                <th style="text-align: center">Nomor Hp</th>
                <th style="text-align: center">Email</th>
                <th style="text-align: center">Alamat/Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sellers as $index => $seller)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}.</td>
                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->shop_name }}</td>
                    <td
                        style="@if ($seller->status == 'Tutup') background-color: #f0ad4e; color: white;
                    @elseif ($seller->status == 'Buka') background-color: #5cb85c; color: white;
                    @else
                    background-color: #d9534f; color: white; @endif font-weight: bold; text-align: center;">
                        {{ $seller->status }}
                    </td>
                    <td style="text-align: center">{{ $seller->profit }} %</td>
                    <td>{{ $seller->no_hp }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->location }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
