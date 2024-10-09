@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('style')
    <style>
        .breadcrumb {
            list-style: none;
            display: flex;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .breadcrumb li {
            /* margin-right: 10px; */
        }

        .breadcrumb li a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb li a:hover {
            text-decoration: none;
        }

        .breadcrumb li::after {
            content: '';
            /* margin-left: 10px; */
        }

        .breadcrumb li:last-child::after {
            content: '';
        }
    </style>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb">
        {{ Breadcrumbs::render('transactions') }}
    </div>
@endsection

@section('content')
    <h1 class="h5 mb-3 text-gray-800">Filter berdasarkan tanggal :</h1>
    <!-- Input untuk filter tanggal -->
    <div class="row d-flex align-items-end">
        <form action="" id="formFilter">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Tanggal : </label>
                <input type="date" id="date" name="date" class="form-control" placeholder="Start Date">
            </div>
        </form>
    </div>
    {{-- download pdf --}}
    <div class="" style="height: 35px"></div>
    <div class="">
        <a href="#" id="generatePdfBtn" class="btn btn-primary">Download PDF</a>
    </div>
    <div class="" style="height: 35px"></div>
    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="background-color: #007bff; color: white;">Kode Invoice</th>
                            <th style="background-color: #007bff; color: white;">Nama Pengguna</th>
                            <th style="background-color: #007bff; color: white;">Total Pembelian</th>
                            <th style="background-color: #007bff; color: white;">Waktu</th>
                            <th style="background-color: #007bff; color: white;">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ url('/api/transactions/transactions-json') }}",
                columns: [{
                        data: 'kode_invoice',
                        name: 'kode_invoice'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'formatted_amount',
                        name: 'formatted_amount'
                    },
                    {
                        data: 'formatted_created_at',
                        name: 'formatted_created_at',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                preDrawCallback: function(settings) {
                    let date = $('#formFilter').find('[name="date"]').val();
                    let class_id = $('#formFilter').find('[name="class_id"]').val();

                    settings.ajax =
                        `{{ url('/api/transactions/transactions-json') }}?date=${date}&class_id=${class_id}`;
                }
            });

            // function untuk filter
            $('#formFilter').find('[name="date"]').change(function(e) {
                e.preventDefault();
                $('#myTable').DataTable().ajax.reload();
            });

            // function download pdf
            $('#generatePdfBtn').click(function() {
                let date = $('#date').val();
                alert(date)
                window.location.href = `/pdf/generate-pdf-logs-data?date=${date}`;
            });

        });
    </script>
@endsection
