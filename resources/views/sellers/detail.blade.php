@extends('layouts.app')
@section('styles')
    <style>
        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 100px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }
    </style>
@endsection
@section('title')
    {{ $title }}
@endsection
@section('breadcrumbs')
    <ul class="breadcrumbs" style="color: white">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="flaticon-home" style="color: white"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.seller.index') }}" style="color: white">Kelola Penjual</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="#" style="color: white">{{ $seller->shop_name }}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="mt--5">
        <div class="row mt--2 row-card-no-pd">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-graph text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Pendapatan hari ini</p>
                                    <h4 class="card-title">
                                        {{ 'Rp ' .number_format(\App\Models\Transaction::where('seller_id', $seller->id)->where('status', 'success')->whereDate('created_at', now())->sum('amount'),0,',','.') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="far fa-calendar-check text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Transaksi hari ini</p>
                                    <h4 class="card-title">
                                        {{ \App\Models\Transaction::where('seller_id', $seller->id)->whereDate('created_at', now())->count() }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Total pendapatan</p>
                                    <h4 class="card-title">
                                        {{ 'Rp ' .number_format(\App\Models\Transaction::where('seller_id', $seller->id)->where('status', 'success')->sum('amount'),0,',','.') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="far fa-check-square text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Transaksi selesai</p>
                                    <h4 class="card-title">
                                        {{ \App\Models\Transaction::where('seller_id', $seller->id)->where('status', 'success')->count() }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Transaction Statistics</div>
                            <div class="card-tools">
                                <a href="{{ route('excel.export.transaction') }}"
                                    class="btn btn-info btn-border btn-round btn-sm mr-2">
                                    <span class="btn-label">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    Export Excel
                                </a>
                                <a href="{{ route('pdf.transaction') }}" class="btn btn-info btn-border btn-round btn-sm">
                                    <span class="btn-label">
                                        <i class="fa fa-print"></i>
                                    </span>
                                    Print
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                            <canvas id="statisticsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Total pendapatan minggu ini</div>
                        <div class="col-md-12">
                            <div id="chart-container">
                                <canvas id="totalIncomeChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2 d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column justify-content-center mt-2">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="fw-extrabold ml-4 text-success">Rp.
                                            {{ number_format($weeklyIncomeBersih ?? 0, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="d-flex align-items-center">
                                    <div class="d-inline-block bg-success"
                                        style="height: 10px; width: 10px; margin-right: 5px;"></div>
                                    <div>Pendapatan minggu ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="fw-bold h3">Detail Data Penjual</div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Nama Toko -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Nama Toko </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    : {{ $seller->shop_name }}
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>
                            <!-- Nama Penjual -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Nama Penjual </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    : {{ $seller->name }}
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Email </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    : {{ $seller->email }}
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Nomor Hp -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Nomor Hp </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    : <a href="https://wa.me/{{ $seller->no_hp }}">{{ $seller->no_hp }}</a>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Status </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    : <span
                                        class="badge text-white fw-bold mx-1 {{ $seller->status == 'Buka' ? 'bg-success' : ($seller->status == 'Tutup' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $seller->status }}
                                    </span>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Passsword -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Passsword </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    : {{ $seller->password }}
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Dibuat Pada -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Dibuat Pada Tanggal </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    : {{ $seller->created_at->translatedFormat('d F Y , H:i') }}
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Alamat / Lokasi -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Alamat / Lokasi </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <div class=""
                                        style="overflow-y: scroll; height: 200px; border: 1.5px solid #ccc;border-radius: 5px;padding: 10px">
                                        {!! $seller->location !!}
                                    </div>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Logo Toko  -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Logo Toko </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <img src="{{ $seller->imageLink() }}" style="max-width: 300px; height: auto;"
                                        class="thumbnail">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="">
                            <a href="javascript:history.back()" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left mr-2"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function formatRupiah(angka) {
            return 'Rp. ' + angka?.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // chart weekly income
        var dataWeekly = @json($weeklyIncome);

        weeklyIncome(dataWeekly);

        function weeklyIncome(data) {
            var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

            var mytotalIncomeChart = new Chart(totalIncomeChart, {
                type: 'bar',
                data: {
                    labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
                    datasets: [{
                        label: "Total Income",
                        backgroundColor: '#31ce36',
                        borderColor: 'rgb(23, 125, 255)',
                        data: data,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                let value = tooltipItem.yLabel || tooltipItem.raw;
                                return 'Total Income: ' + formatRupiah(value);
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                display: false //this will remove only the label
                            },
                            gridLines: {
                                drawBorder: false,
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display: false
                            }
                        }]
                    },
                }
            });
        }
        // end chart weekly income

        $('#lineChart').sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#ffa534',
            fillColor: 'rgba(255, 165, 52, .14)'
        });

        // chart transaksi
        var dataMonthly = @json($monthlyIncome);

        statsTransaction(dataMonthly);

        function statsTransaction(data) {
            var ctx = document.getElementById('statisticsChart').getContext('2d');
            var statisticsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Pendapatan Perbulan",
                        borderColor: "#f25961",
                        pointBorderColor: "#FFF",
                        pointBackgroundColor: "#f25961",
                        pointBorderWidth: 2,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        pointRadius: 4,
                        backgroundColor: 'transparent',
                        fill: true,
                        borderWidth: 2,
                        data: data
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'top',
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode: "nearest",
                        intersect: 0,
                        position: "nearest",
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                let value = tooltipItem.yLabel || tooltipItem.raw;
                                return 'Total Income: ' + formatRupiah(value);
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 15,
                            right: 15,
                            top: 15,
                            bottom: 15
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(value) {
                                    // Format nilai di sumbu Y menjadi Rupiah
                                    return formatRupiah(value);
                                }
                            }
                        }],
                        // x: {
                        //     ticks: {
                        //         callback: function(value) {
                        //             // Format nilai pada sumbu X jika dibutuhkan (opsional)
                        //             return formatRupiah(value); // Tetap tampilkan teks tanpa perubahan
                        //         }
                        //     }
                        // }
                    }
                }
            });
        }
        // end chart transaksi
    </script>
@endsection
