@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('title2')
    {{ $title2 }}
@endsection
@section('breadcrumbs')
    <ul class="breadcrumbs" style="color: white">
        <li class="nav-home">
            <a href="/admin/dashboard">
                <i class="flaticon-home" style="color: white;font-weight: bold"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
    </ul>
@endsection
@section('content')
    <div class="mt--5">
        <div class="row mt--2">
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Total Data</div>
                        <div class="card-category">Data ini di hitung per hari ini, dan di kalkulasikan per 100</div>
                        <div class="d-flex flex-wrap justify-content-around pb-2 pt-4 mt-4">
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-1"></div>
                                <h6 class="fw-bold mt-3 mb-0">Users</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-2"></div>
                                <h6 class="fw-bold mt-3 mb-0">Produk</h6>
                            </div>
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-3"></div>
                                <h6 class="fw-bold mt-3 mb-0">Transaksi</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
        <div class="row row-card-no-pd">
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
                                    <h4 class="card-title">{{ 'Rp ' .number_format(\App\Models\Transaction::where('status', 'success')->whereDate('created_at', now())->sum('amount'),0,',','.') }}
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
                                    <h4 class="card-title">{{ \App\Models\Transaction::whereDate('created_at', now())->count() }}
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
                                    <h4 class="card-title">{{ 'Rp ' .number_format(\App\Models\Transaction::where('status', 'success')->sum('amount'),0,',','.') }}
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
                                    <h4 class="card-title">{{ \App\Models\Transaction::where('status', 'success')->count() }}</h4>
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
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Catatan / Notes</div>
                            <div class="card-tools">
                                <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab"
                                    role="tablist">
                                    <li class="nav-item">
                                        <div data-id="{{ session('userData')->id }}"
                                            class="btn btn-warning btn-circle btn-sm modal-notes">
                                            Buat Catatan <i class="fas fa-edit ml-2"></i> </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="max-height: 400px;overflow-y: auto">
                        <ol class="activity-feed" id="notesList">
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Top Kasir</div>
                    </div>
                    <div class="card-body" style="height: 400px;overflow-y: auto">
                        @foreach ($topSellers as $index => $topSeller)
                            <div class="d-flex">
                                <div class="d-flex ml-auto align-items-center mr-3">
                                    <h4 class="fw-bold">{{ $index + 1 }}.</h4>
                                </div>
                                <div class="avatar">
                                    <img src="{{ $topSeller->seller->imageLink() }}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                                <div class="flex-1 pt-1 ml-2">
                                    <h5 class="fw-bold mb-1">{{ $topSeller->seller->shop_name }}</h5>
                                    <small
                                        class="text-muted">{{ \Illuminate\Support\Str::limit($topSeller->seller->name, 20, '...') }}</small>
                                </div>
                                <div class="d-flex ml-auto align-items-center">
                                    <h4 class="text-info fw-bold">Rp.
                                        {{ number_format($topSeller->total_sales ?? 0, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                            <div class="separator-dashed"></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Top Pembeli</div>
                    </div>
                    <div class="card-body" style="height: 400px;overflow-y: auto">
                        @foreach ($topBuyers as $index => $topBuyer)
                            <div class="d-flex">
                                <div class="d-flex ml-auto align-items-center mr-3">
                                    <h4 class="fw-bold">{{ $index + 1 }}.</h4>
                                </div>
                                <div class="avatar">
                                    <img src="{{ asset('user-avatar.jpg') }}"
                                        alt="..." class="avatar-img rounded-circle">
                                </div>
                                <div class="flex-1 pt-1 ml-2">
                                    <h5 class="fw-bold mb-1">{{ $topBuyer->user->username ?? 'Pengguna tidak ditemukan' }}</h5>
                                    <small
                                        class="text-muted">{{ \Illuminate\Support\Str::limit($topBuyer->user->name ?? 'Pengguna tidak ditemukan', 20, '...') }}</small>
                                </div>
                                <div class="d-flex ml-auto align-items-center">
                                    <h4 class="text-info fw-bold">Rp.
                                        {{ number_format($topBuyer->total_sales ?? 0, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                            <div class="separator-dashed"></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Top Produk</div>
                    </div>
                    <div class="card-body" style="height: 400px;overflow-y: auto">
                        @foreach ($topSellingProducts as $index => $topSellingProduct)
                            @php
                                $colors = '#007bff';
                                if ($index == 0) {
                                    $colors = '#ffd700';
                                } elseif ($index == 1) {
                                    $colors = '#C0C0C0';
                                } elseif ($index == 2) {
                                    $colors = '#CE8946';
                                } else {
                                    $color = '#007bff';
                                }
                            @endphp
                            <div class="">
                                <div class="d-flex align-content-center">
                                    <div class="d-flex ml-auto align-items-center mr-3">
                                        <h4 class="fw-bold">{{ $index + 1 }}.</h4>
                                    </div>
                                    <div class="avatar">
                                        <img src="{{ $topSellingProduct['products']->image }}" alt="..."
                                            class="avatar-img rounded-circle">
                                    </div>
                                    <div class="flex-1 pt-1 ml-2">
                                        <h6 class="fw-bold mb-1">Total Terjual : <span class="fw-extrabold"
                                                style="font-size: 15px">{{ $topSellingProduct['total_quantity'] }}
                                                {{ $topSellingProduct['products']->unit }}</span></h6>
                                        <small
                                            class="">{{ \Illuminate\Support\Str::limit($topSellingProduct['products']->name, 35, '...') }}</small>
                                    </div>
                                </div>
                                <div class="separator-dashed"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="" id="page"></div>
                </div>
                {{-- <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/auth/logout">Logout</a>
                </div> --}}
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
        // circle chart
        var userCount = {{ $jumlahUser }};
        var productCount = {{ $jumlahProduk }};
        var transactionCount = {{ $jumlahTransaksi }};

        Circles.create({
            id: 'circles-1',
            radius: 45,
            value: userCount,
            maxValue: 100,
            width: 7,
            text: userCount,
            colors: ['#f1f1f1', '#FF9E27'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })

        Circles.create({
            id: 'circles-2',
            radius: 45,
            value: productCount,
            maxValue: 100,
            width: 7,
            text: productCount,
            colors: ['#f1f1f1', '#2BB930'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })

        Circles.create({
            id: 'circles-3',
            radius: 45,
            value: transactionCount,
            maxValue: 100,
            width: 7,
            text: function(value) {
                return value === 0 ? '0' : value;
            },
            colors: ['#f1f1f1', '#F25961'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })
        // end circle chart

        // chart weekly income
        $.ajax({
            url: "{{ route('chart.weekly.income') }}",
            method: 'GET',
            success: function(data) {
                // Render chart setelah mendapatkan data
                weeklyIncome(data);
            },
            error: function(error) {
                console.error('Error fetching weekly income data:', error);
            }
        });

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
        $.ajax({
            url: "{{ route('chart.stats.transaction') }}",
            method: 'GET',
            success: function(data) {
                statsTransaction(data);
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });

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
                        data: data.success
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

        // start send whatsapp
        $('.modal-whatsapp').on('click', function() {
            var id = $(this).attr('data-id');
            $.get(`/admin/modal-whatsapp/${id}`, {}, function(data, status) {
                $("#page").html(data);
                $('#insertModal').modal('show');
                $('.modal-title').html('Send Message');
            })
        })

        $('body').on('click', '.tombol-send', function() {
            // e.preventDefault();
            const noHp = $(this).attr('data-id');
            const message = $('#formSend').find('[id="message"]').val();

            var loadingCreate = Ladda.create(document.querySelector('.tombol-send'));
            loadingCreate.start();
            $.ajax({
                url: "{{ route('send.message') }}",
                method: 'POST',
                data: {
                    noHp: noHp,
                    message: message,
                },
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    loadingCreate.stop();
                    Toast.fire({
                        icon: "success",
                        title: response.status
                    });
                    $('.close').click();
                }
            });
        });


        // start notes
        $('.modal-notes').on('click', function() {
            var id = $(this).attr('data-id');
            console.log('ini user id', id);
            $.get(`/admin/notes/modal-create/${id}`, {}, function(data, status) {
                $("#page").html(data);
                $('#insertModal').modal('show');
                $('.modal-title').html('Buat Catatan');
            })
        })

        fetchNotes();

        function fetchNotes() {
            $.get("{{ route('get.notes') }}", function(data) {
                let notesHtml = '';
                $.each(data, function(index, note) {
                    const colorClasses = [
                        'feed-item-primary',
                        'feed-item-success',
                        'feed-item-warning',
                        'feed-item-danger',
                        'feed-item-info',
                        'feed-item-secondary'
                    ];
                    const randomColorClass = colorClasses[Math.floor(Math.random() * colorClasses.length)];
                    notesHtml += `<li class="feed-item ${randomColorClass}">
                                <time class="date" datetime="${note.created_at}">${note.formatted_created_at}</time>
                                <div class="fw-bold">${note.user.username}<span class="text ml-2 text-primary">"${note.note}"</span></div>
                            </li>`;
                });
                $('#notesList').html(notesHtml);
            });
        }

        $('body').on('click', '.tombol-add-note', function() {
            // e.preventDefault();
            const userId = $(this).attr('data-id');
            const content = $('#formNote').find('[id="notes"]').val();

            var loadingCreate = Ladda.create(document.querySelector('.tombol-add-note'));
            loadingCreate.start();
            $.ajax({
                url: "{{ route('store.notes') }}",
                method: 'POST',
                data: {
                    user_id: userId,
                    note: content,
                },
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    // $('#noteForm')[0].reset();
                    // $('#noteId').val('');
                    loadingCreate.stop();
                    Toast.fire({
                        icon: "success",
                        title: response.success
                    });
                    fetchNotes();
                    $('.close').click();
                }
            });
        });
    </script>
@endsection
