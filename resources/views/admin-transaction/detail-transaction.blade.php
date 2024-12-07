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
        <a href="/admin/transaction/transaction" style="color: white">History Transaksi</a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow" style="color: white"></i>
    </li>
    <li class="nav-item">
        <a href="#" style="color: white">Detail Transaksi</a>
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="card c">
        <div class="card body">
            User
        </div>
    </div>
    <div class="card">
        <div class="card body">
            Barang yang dibeli
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- <script>
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
    </script> --}}
@endsection
