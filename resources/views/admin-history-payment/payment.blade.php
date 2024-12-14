@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('breadcrumbs')
    <ul class="breadcrumbs" style="color: white">
        <li class="nav-home">
            <a href="/admin/dashboard">
                <i class="flaticon-home" style="color: white"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="/admin/transaction/transaction" style="color: white">Transaksi</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="/admin/transaction/transaction" style="color: white">Riwayat Pembayaran</a>
        </li>
    </ul>
@endsection

@section('content')
    {{-- filter --}}
    <div class="d-flex" style="width: 50%">
        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan status:</p>
            <select name="statusSelected" id="statusSelected" class="form-control" aria-label="Default select example"
                required>
                <option value="" selected>Semua Status</option>
                <option value="pending">Pending</option>
                <option value="success">Success</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan tipe:</p>
            <select name="typeSelected" id="typeSelected" class="form-control" aria-label="Default select example" required>
                <option value="" selected>Semua Tipe</option>
                <option value="cash">Cash</option>
                <option value="paylater">Paylater</option>
                <option value="payment bill">Pembayaran Tagihan</option>
            </select>
        </div>

        <!-- Input untuk filter tanggal -->
        <div class="col-sm-6 mb-3 mb-sm-0" style="width: 300px">
            <form action="" id="formFilter">
                <div class="">
                    <p class="h6 mb-2 text-gray-800">Filter berdasarkan tanggal:</p>
                    <input type="date" id="date" name="date" class="form-control datepicker" placeholder="">
                </div>
            </form>
        </div>
    </div>
    {{-- export import session --}}
    <div class="" style="height: 35px"></div>
    <div class="" style="height: 35px"></div>
    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="" style="display: flex;justify-content: space-between;align-items: center">
                <h6 class="m-0 font-weight-bold text-primary">Semua Transaksi</h6>
                <div class="" style="display: flex;justify-content: end;">
                    <div class="">
                        <a href="#" id="exportPdf" class="btn btn-round btn-primary export-pdf ladda-button"
                            style="color: white">Export PDF</a>
                    </div>
                    <div class="ml-5">
                        <a href="#" id="exportExcel" class="btn btn-round btn-warning export-excel ladda-button"
                            style="color: white">Export
                            Excel</a>
                    </div>
                    {{-- <div class="ml-5">
                        <a href="#" id="importExcel" class="btn btn-round btn-success" style="color: white">Import Excel</a>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="background-color: #007bff; color: white;">Nama Pengguna</th>
                            <th style="background-color: #007bff; color: white;">Kasir</th>
                            <th style="background-color: #007bff; color: white;">Status</th>
                            <th style="background-color: #007bff; color: white;">Total Pembayaran</th>
                            <th style="background-color: #007bff; color: white;">Tipe</th>
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
                ajax: {
                    url: "{{ route('index.payments.json') }}",
                },
                columns: [
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'cashier',
                        name: 'cashier'
                    },
                    {
                        data: 'status_formatted',
                        name: 'status_formatted'
                    },
                    {
                        data: 'formatted_amount',
                        name: 'formatted_amount'
                    },
                    {
                        data: 'type_formatted',
                        name: 'type_formatted'
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
                    let statusSelected = $('#statusSelected').val();
                    let typeSelected = $('#typeSelected').val();
                    let class_id = $('#formFilter').find('[name="class_id"]').val();

                    settings.ajax =
                        `{{ route('index.payments.json') }}?date=${date}&class_id=${class_id}&status=${statusSelected}&type=${typeSelected}`;
                }
            });

            // function untuk filter
            $('#formFilter').find('[name="date"]').change(function(e) {
                e.preventDefault();
                $('#myTable').DataTable().ajax.reload();
            });

            $('#statusSelected').change(function(e) {
                e.preventDefault();
                $('#myTable').DataTable().ajax.reload();
            });

            $('#typeSelected').change(function(e) {
                e.preventDefault();
                $('#myTable').DataTable().ajax.reload();
            });

            // function export pdf
            $('#exportPdf').click(function() {
                var loadingPdf = Ladda.create(document.querySelector('.export-pdf'));
                let date = $('#formFilter').find('[name="date"]').val();
                let statusSelected = $('#statusSelected').val();
                let typeSelected = $('#typeSelected').val();
                Swal.fire({
                    title: "Ingin mendownload PDF?",
                    text: `kamu memilih download untuk ${!statusSelected ? 'Semua User' : statusSelected} `,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Download!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadingPdf.start();
                        window.location.href =
                            `/admin/pdf/payment?status=${statusSelected}&type=${typeSelected}&date=${date}`;
                        // window.location.href = `{{ route('pdf.transaction') }}`;

                        setTimeout(() => {
                            loadingPdf.stop();
                        }, 3000);
                    } else {
                        loadingPdf.stop();
                    }
                });

            });

            // function download excel
            $('#exportExcel').click(function() {
                var loadingExcel = Ladda.create(document.querySelector('.export-excel'));
                loadingExcel.start();
                window.location.href = '{{ route('excel.export.payment') }}';

                setTimeout(() => {
                    loadingExcel.stop();
                }, 3000);
            });

        });
    </script>
@endsection
