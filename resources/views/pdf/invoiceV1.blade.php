<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            color: #999;
        }

        .container {
            /* max-width: 600px; */
            margin: 0 auto;
            padding: 20px;
        }

        /*
        .header h1 {
            font-size: 24px;
            margin: 0;
        } */

        .invoice-info {
            margin-bottom: 40px;
        }

        .invoice-info div {
            /* margin-bottom: 10px; */
        }

        .invoice-info span {
            display: inline-block;
            margin-right: 20px;
            /* width: 120px; */
            /* font-weight: bold; */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
        }

        .table2 td {
            padding-right: 30px;
        }

        .judulInvoice {
            text-align: right;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            margin-bottom: 50px
        }

        .total h3 {
            margin: 0;
            font-size: 18px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>


<body>
    <div class="container">
        {{-- @dd($data['noInvoice']) --}}
        @php
            // Mengambil data dari $data123
            // $itemsList = $data['data']; // ambil data yang diperlukan
        @endphp
        <table style="width: 100%;">
            <tr>
                <td>
                    <div>
                        <img src="https://jamaludinhanif.github.io/portofolio-hanif/dist/img/logo%20by%20tegar.png" width="50" alt="Company Logo">
                        <br>
                        Jamal Industri
                    </div>
                </td>
                <td style="text-align: right;">
                    <div>
                        <h1>INVOICE</h1>
                    </div>
                </td>
            </tr>
        </table>

        <div class="" style="height: 30px;"></div>

        <table class="table2">
            <tr>
                <td>
                    Nama Pembeli
                </td>
                <td>
                    : {{ $name ?? 'Pembeli yng terhormat' }}
                </td>
            </tr>
            <tr>
                <td>
                    Kode Invoice
                </td>
                <td>
                    : {{ $noInvoice ?? 'no_invoice' }}
                </td>
            </tr>
            <tr>
                <td>
                    Tanggal
                </td>
                <td>
                    : {{ now()->format('d-F-Y') }}
                </td>
            </tr>
        </table>

        {{-- <p>{{ $data->title }}</p> --}}

        <div class="" style="height: 30px;"></div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kuantitas</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['data']['data'] as $items)
                    <tr>
                        <td>{{ $items['value']['name'] ?? $items['value']['product']['name'] }}</td>
                        <td>{{ $items['quantity'] ?? 0 }}</td>
                        <td>Rp. {{ number_format($items['value']['price'] ?? $items['value']['product']['price'], 0, ',', '.') }}</td>
                        <td>Rp.
                            {{ number_format(($items['value']['price'] ?? $items['value']['product']['price']) * ($items['quantity'] ?? 1), 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <h3>Subtotal: Rp. {{ number_format($data['data']['totalPrice'] ?? 0, 0, ',', '.') }}</h3>
            <h3>Tax (0%): Rp. 0</h3>
            <h3>Total: Rp. {{ number_format($data['data']['totalPrice'] ?? 0, 0, ',', '.') }}</h3>
        </div>

        <div class="" style="height: 30px"></div>

        <div class="">
            <h4>Check My Sosial Media</h4>
            <p></p>
            <p>Instagram : @_ha_nif</p>
            <p>No. Hp : 0851-6131-0017</p>
            <p>Email : newhanif743@gmail.com</p>
        </div>

        <div class="footer">
            <p>Terima kasih atas Transaksi anda 🙏🙏</p>
            <p>-- Salam Hangat Hanif --</p>
            <p>Desa Cikaso, Kec. KramatMulya, Kab. Kuningan</p>
        </div>
    </div>
</body>

</html>
