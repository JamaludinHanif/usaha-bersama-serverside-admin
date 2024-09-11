<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-left {
            display: flex;
            flex-direction: row;
        }

        .header-left img {
            width: 60px;
        }

        .header-left .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }

        .header-left .tagline {
            font-size: 12px;
            color: #555;
        }

        .header-right {
            text-align: right;
        }

        .header-right .invoice-title {
            font-size: 28px;
            font-weight: bold;
        }

        .details {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .details-left {
            font-size: 14px;
        }

        .details-right {
            font-size: 14px;
            text-align: right;
        }

        .table-container {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .totals {
            text-align: right;
            margin-top: 20px;
        }

        .totals div {
            margin-bottom: 10px;
        }

        .payment-method {
            margin-top: 30px;
            font-size: 14px;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            text-align: center;
        }

        .footer img {
            width: 15px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }

        .signature span {
            display: inline-block;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="header">
            <div class="header-left" style="display: flex;">
                <img src="https://adiva.co.id/storage/website/logo_website.png" width="50" alt="Company Logo">
                <div class="">
                    <div class="company-name">Borcelle</div>
                    <div class="tagline">Meet All Your Needs</div>
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
            </div>
        </div>

        <div class="details">
            <div class="details-left">
                <p><strong>Invoice to:</strong><br> Daniel Gallego<br>123 Anywhere St.,<br>Any City, ST 12345</p>
            </div>
            <div class="details-right">
                <p><strong>Invoice#</strong> 52131<br><strong>Date</strong> 01 / 02 / 2023</p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A4 Paper (75gr/m2)</td>
                        <td>10</td>
                        <td>$20</td>
                        <td>$200</td>
                    </tr>
                    <tr>
                        <td>Pencil (12ea/box)</td>
                        <td>5</td>
                        <td>$15</td>
                        <td>$75</td>
                    </tr>
                    <tr>
                        <td>Ruler</td>
                        <td>2</td>
                        <td>$5</td>
                        <td>$10</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="totals">
            <div><strong>Subtotal:</strong> $285</div>
            <div><strong>Tax (0%):</strong> $0</div>
            <div><strong>Total:</strong> $285</div>
        </div>

        <div class="payment-method">
            <p><strong>PAYMENT METHOD</strong><br>Rimberio Bank<br>Account Name: Alfredo Torres<br>Account No.: 0123
                4567 8901<br>Pay by: 23 June 2023</p>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p><img src="https://via.placeholder.com/15" alt="Phone"> 123-456-7890 <img
                    src="https://via.placeholder.com/15" alt="Address"> 123 Anywhere St., Any City</p>
        </div>

        <div class="signature">
            <span>Authorized Signed</span>
        </div>
    </div>

</body>

</html>



@extends('layouts.app')
@section('style')
    <style>
        /* * {
                                                    border: 1px solid black;
                                                } */
    </style>
@endsection
@section('title')
    tess
@endsection
@section('content')
    <a href="/pdf/generate-pdf-users-data" class="btn btn-primary">Download PDF</a>
    <div class="" style="height: 20px"></div>

    <a href="/excel/export-users" class="btn btn-primary">Export Excel</a>
    <div class="" style="height: 20px"></div>

    <a href="/excel/download-template-users" class="btn btn-primary">Download template Excel</a>
    <div class="" style="height: 20px"></div>

    <form action="/excel/import-users" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" />
        <button type="submit">Import</button>
    </form>

    {{-- <canvas id="myChart" width="400" height="200"></canvas> --}}

    <div class="" style="height: 100px"></div>

    <!-- tombol untuk menggenerate nim -->
    <form action="{{ route('code.generate') }}" method="POST">
        @csrf
        <button type="submit">Generate Code</button>
    </form>

    <div class="" style="height: 50px"></div>

    <a href="/checkout-v1" id="coBtn" class="btn tombol-co ladda-button btn-primary">Checkout</a>
    <div class="" style="height: 20px"></div>

    <div class="" style="height: 50px"></div>

    @if (session('code'))
        <p>Generated Code: <strong>{{ session('code') }}</strong></p>
    @endif

    <div class="" style="height: 100px"></div>

    <p style="text-align: center">
    <h4 style="text-align: center">Peringkat Kehadiran (karyawan/guru) & murid</h4>
    <h4 style="text-align: center" class="mb-5">Tahun ajaran 2024/2025</h4>
    </p>
    <!-- Progress rank -->
    <div class="d-flex justify-content-evenly">
        <div class="card mb-4" style="width: 40%">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Peringkat Kehadiran Student</h6>
            </div>

            <div class="ranking-student"></div>
        </div>

        <div class="card mb-4" style="width: 40%">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Peringkat Kehadiran Employe</h6>
            </div>

            <div class="ranking-employe"></div>

        </div>
    </div>

    <div class="" style="height: 100px"></div>
@endsection
@section('scripts')
    {{-- <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie', // tipe chart: 'line', 'bar', 'pie', dll.
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Data Example',
                    data: [12, 25, 12, 5, 2, 3, 7],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script> --}}

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Data Example',
                    data: [12, 25, 12, 5, 2, 3, 7],
                    backgroundColor: [
                        '#FF5753',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // $('#coBtn').click(function() {
            //     var loadingCo = Ladda.create(document.querySelector('.tombol-co'));

            //     // Memulai loading animation
            //     loadingCo.start();

            //     // Menunggu event "beforeunload" ketika halaman berubah
            //     $(window).on('beforeunload', function() {
            //         loadingCo.stop(); // Hentikan loading ketika halaman sudah mulai dialihkan
            //     });

            //     // Redirect ke halaman /checkout-v1
            //     window.location.href = '/checkout-v1';

            //     //     loadingCo.start();
            //     //     window.location.href = `/checkout-v1`;

            //     //     setTimeout(() => {
            //     //         loadingCo.stop();
            //     //     }, 3000);

            // });

            // Inisialisasi loading button

            $('#coBtn').click(function(e) {
                var loadingPdf = Ladda.create(document.querySelector('.tombol-co'));
                // Prevent default action (jangan langsung beralih halaman)
                loadingPdf.start();
                    window.location.href = `/checkout-v1`;

                    setTimeout(() => {
                        loadingPdf.stop();
                    }, 10000);
            });


            $.ajax({
                url: '{{ url('/ranking-json') }}', // URL dari route untuk mengambil data
                method: 'GET',
                success: function(response) {
                    var dataHtmlStudent = '';
                    var dataHtmlEmploye = '';
                    $.each(response, function(index, item) {
                        if (item.type == 1) {
                            let bgColor = 'gray'; // Default untuk ranking 4 sampai 10
                            if (item.ranking == 1) {
                                bgColor = '#FFD700'; // Emas
                            } else if (item.ranking == 2) {
                                bgColor = '#C0C0C0'; // Perak
                            } else if (item.ranking == 3) {
                                bgColor = '#CD7F32'; // Perunggu
                            }
                            dataHtmlStudent += `
                        <div class="card-body d-flex flex-row ranking-container" style="width: 100%">
                            <div style="width: 10%; margin-right: 10px">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div style="height: 45px; background-color: ${bgColor}; color: white; padding: 10px; border-radius: 5px">
                                        <p>#${item.ranking}</p>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 20%; margin-right: 10px">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="${item.image}" width="75" alt="">
                                </div>
                            </div>
                            <div style="width: 70%">
                                <div class="mb-1">${item.name}</div>
                                <div class="mb-1">${item.role}</div>
                                <div class="progress mb-1">
                                    <div class="progress-bar" role="progressbar" style="width: ${item.persentase}%" aria-valuenow="${item.persentase}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div>${item.point} Poin</div>
                            </div>
                        </div>`
                        } else {
                            let bgColor = 'gray'; // Default untuk ranking 4 sampai 10
                            if (item.ranking == 1) {
                                bgColor = '#FFD700'; // Emas
                            } else if (item.ranking == 2) {
                                bgColor = '#C0C0C0'; // Perak

                            } else if (item.ranking == 3) {
                                bgColor = '#CD7F32'; // Perunggu
                            }
                            dataHtmlEmploye += `
                        <div class="card-body d-flex flex-row ranking-container" style="width: 100%">
                            <div style="width: 10%; margin-right: 10px">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div style="height: 45px; background-color: ${bgColor}; color: white; padding: 10px; border-radius: 5px">
                                        <p>#${item.ranking}</p>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 20%; margin-right: 10px">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="${item.image}" width="75" alt="">
                                </div>
                            </div>
                            <div style="width: 70%">
                                <div class="mb-1">${item.name}</div>
                                <div class="mb-1">${item.role}</div>
                                <div class="progress mb-1">
                                    <div class="progress-bar" role="progressbar" style="width: ${item.persentase}%" aria-valuenow="${item.persentase}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div>${item.point} Poin</div>
                            </div>
                        </div>`
                        }
                    });

                    // Tampilkan data di container yang sesuai
                    $('.ranking-student').html(dataHtmlStudent);
                    $('.ranking-employe').html(dataHtmlEmploye);
                },
                error: function() {
                    $('.ranking-student').html('<p>Gagal mengambil data.</p>');
                }
            });
        });
    </script>
@endsection
