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
        <a href="/admin/users/users" style="color: white">Users</a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow" style="color: white"></i>
    </li>
    <li class="nav-item">
        <a href="/admin/users/users" style="color: white">Log Aktifitas</a>
    </li>
</ul>
@endsection
@section('content')
    {{-- filter --}}

    <div style="width: 300px" class="mb-3 mb-sm-0]">
        <form action="" id="formFilter">
            <p class="h5 mb-2 text-gray-800">Filter berdasarkan tanggal :</p>
            <div class="form-group">
                <label for="start_date" class="form-label">Dari tanggal : </label>
                <input type="date" id="date" name="date" class="form-control datepicker" placeholder="Pilih Tanggal">
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
            <h6 class="m-0 font-weight-bold text-primary">Semua Aktifitas Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTableLog" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="background-color: #007bff; color: white;">Nama</th>
                            <th style="background-color: #007bff; color: white;">Nama Pengguna</th>
                            <th style="background-color: #007bff; color: white;">Peran Sebagai</th>
                            <th style="background-color: #007bff; color: white;">Aktivitas</th>
                            <th style="background-color: #007bff; color: white;">Waktu</th>
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
            var table = $('#myTableLog').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ url('/api/users/log-activities-json') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'activity',
                        name: 'activity',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'formatted_created_at',
                        name: 'formatted_created_at'
                    }
                ],
                preDrawCallback: function(settings) {
                    let date = $('#formFilter').find('[name="date"]').val();
                    let class_id = $('#formFilter').find('[name="class_id"]').val();

                    settings.ajax =
                        `{{ url('/api/users/log-activities-json') }}?date=${date}&class_id=${class_id}`;
                }
            });

            // function untuk filter
            $('#formFilter').find('[name="date"]').change(function(e) {
                e.preventDefault();
                $('#myTableLog').DataTable().ajax.reload();
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
