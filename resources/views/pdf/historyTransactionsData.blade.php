<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Transaksi</title>
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
        {{-- <img src="{{ asset('kop-surat.png') }}" style="width: 100%" alt=""> --}}
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
                <th style="width: 15%;text-align: center">Kode Invoice</th>
                <th style="width: 15%;text-align: center">Pembeli</th>
                <th style="text-align: center">Status</th>
                <th style="text-align: center">Total Pembelian</th>
                <th style="text-align: center">Penjual</th>
                <th style="text-align: center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $index => $transaction)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}.</td>
                    <td>{{ $transaction->code_invoice }}</td>
                    <td>{{ $transaction->user->username ?? 'Pengguna tidak ditemukan' }}</td>
                    <td
                        style="@if ($transaction->status == 'pending') background-color: #ffad46; color: white;
                    @elseif ($transaction->status == 'success') background-color: #31ce36; color: white;
                    @else
                    background-color: #f25961; color: white; @endif font-weight: bold; text-align: center;">
                        {{ $transaction->status }}
                    </td>
                    <td>Rp. {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $transaction->seller->shop_name ?? 'Penjual tidak ditemukan' }}</td>
                    <td>{{ $transaction->created_at->translatedFormat('d-F-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
