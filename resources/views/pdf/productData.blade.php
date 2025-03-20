<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Product</title>
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
        <img src="{{ public_path('kop-surat-v2.jpg') }}" style="width: 100%" alt="">
    </div>
    <h3 style="text-align: right">{{ $title }}</h3>
    <div class="" style="height: 30px"></div>
    <p>Tanggal: {{ $date }}</p>
    <div class="" style="height: 30px"></div>
    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center;width: 30%">Nama</th>
                <th style="text-align: center">Harga</th>
                <th style="text-align: center">Satuan</th>
                <th style="text-align: center">Stok</th>
                <th style="text-align: center">Kategory</th>
                <th style="text-align: center">Gambar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}.</td>
                    <td>{{ $product->name }}</td>
                    <td>Rp. {{ number_format($product->price ?? 0, 0, ',', '.') }}</td>
                    <td
                        style="@if ($product->unit == 'pack') background-color: #ffad46; color: white;
                    @elseif ($product->unit == 'dos') background-color: #31ce36; color: white;
                    @elseif ($product->unit == 'pcs') background-color: #007bff; color: white;
                    @else
                    background-color: #f25961; color: white; @endif font-weight: bold; text-align: center;">
                        {{ $product->unit }}
                    </td>
                    <td style="text-align: center">{{ $product->stock }}</td>
                    <td
                        style="@if ($product->category == 'pembersih') background-color: #f25961; color: white;
                        @elseif ($product->category == 'makanan') background-color: #31ce36; color: white;
                        @elseif ($product->category == 'minuman') background-color: #007bff; color: white;
                        @else
                        background-color: gray; color: white; @endif font-weight: bold; text-align: center">
                        {{ $product->category }}
                    </td>
                    <td>
                        <div class="" style="">
                            <img src="{{ $product->image }}" style="margin-left: 5px" width="50" alt="">
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
