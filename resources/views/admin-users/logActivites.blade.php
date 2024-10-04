@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <h1 class="h5 mb-3 text-gray-800">Filter berdasarkan periode tanggal :</h1>
    <!-- Input untuk filter tanggal -->
    <div class="row d-flex align-items-end">
        <form action="" id="formFilter">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Dari tanggal : </label>
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
            <h6 class="m-0 font-weight-bold text-primary">Semua User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTableLog" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nama Pengguna</th>
                            <th>Peran Sebagai</th>
                            <th>Aktivitas</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Activity</th>
                            <th>Time</th>
                        </tr>
                    </tfoot>
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
