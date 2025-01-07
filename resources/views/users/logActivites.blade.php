@extends('layouts.app')
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
            <a href="#" style="color: white">Pengguna</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.log') }}" style="color: white">Log Aktivitas</a>
        </li>
    </ul>
@endsection
@section('content')
    {{-- filter --}}
    <div class="d-flex" style="width: 50%">
        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan role:</p>
            <select name="roleSelected" id="roleSelected" class="form-control" aria-label="Default select example" required>
                <option value="" selected>Semua Role</option>
                <option value="admin">Admin</option>
                <option value="buyer">Pembeli</option>
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

    <div class="" style="height: 35px"></div>
    <!-- DataTables  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="" style="display: flex;justify-content: space-between;align-items: center">
                <h6 class="m-0 font-weight-bold text-primary">Semua Aktivitas</h6>
                <div class="" style="display: flex;justify-content: end;">
                    <div class="">
                        <button id="exportPdf" class="btn btn-round btn-primary export-pdf ladda-button"
                            style="color: white">Export PDF</button>
                    </div>
                    <div class="ml-5">
                        <button id="exportExcel" class="btn btn-round btn-warning export-excel ladda-button"
                            style="color: white">Export
                            Excel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
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
            const $roleFilter = $('#roleSelected');
            const $dateFilter = $('#formFilter').find('[name="date"]')

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.users.log') }}",
                    data: function(d) {
                        d.date = $dateFilter.val();
                        d.role = $roleFilter.val();
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'roleFormatted',
                        name: 'roleFormatted'
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
            })

            const reloadDT = () => {
                $('#dataTable').DataTable().ajax.reload();
            }

            $roleFilter.on('change', function() {
                reloadDT();
            });

            $dateFilter.on('change', function() {
                reloadDT();
            });

            $('#exportPdf').click(function() {
                var loadingPdf = Ladda.create(document.querySelector('.export-pdf'));
                let date = $('#formFilter').find('[name="date"]').val();
                let roleSelected = $('#roleSelected').val();
                Swal.fire({
                    title: "Ingin mendownload PDF?",
                    text: `kamu memilih download untuk tanggal ${date} `,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Download!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadingPdf.start();
                        window.location.href =
                            `{{ route('pdf.log') }}?date=${date}&role=${roleSelected}`;

                        setTimeout(() => {
                            loadingPdf.stop();
                        }, 5000);
                    } else {
                        loadingPdf.stop();
                    }
                });
            });

            // function download excel
            $('#exportExcel').click(function() {
                var loadingExcel = Ladda.create(document.querySelector('.export-excel'));
                confirmation('Kamu ingin melakukan export excel ?', function() {
                    loadingExcel.start();
                    window.location.href = '{{ route('excel.export.log-activity') }}';
                })

                setTimeout(() => {
                    loadingExcel.stop();
                }, 5000);
            });

        });
    </script>
@endsection
