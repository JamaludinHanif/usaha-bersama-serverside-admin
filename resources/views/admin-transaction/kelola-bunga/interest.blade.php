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
        <a href="/admin/transaction/interest" style="color: white">Transaksi</a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow" style="color: white"></i>
    </li>
    <li class="nav-item">
        <a href="/admin/transaction/interest" style="color: white">Kelola Bunga</a>
    </li>
</ul>
@endsection

@section('content')

    <div class="d-flex justify-content-between">
        {{-- tambah bunga --}}
        <a href="#" data-toggle="modal" id="createButton" data-target="#insertModal"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="far fa-plus-square"></i> </span>
            <span class="text" style="color: white">Tambah Bunga</span>
        </a>
    </div>

    <div class="" style="height: 35px"></div>

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Bunga</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="background-color: #007bff; color: white;">No</th>
                            <th style="background-color: #007bff; color: white;">Nama</th>
                            <th style="background-color: #007bff; color: white;">Bunga</th>
                            <th style="background-color: #007bff; color: white;">Jumlah Hari</th>
                            <th style="background-color: #007bff; color: white;">Satuan Tanggal</th>
                            <th style="background-color: #007bff; color: white;">Aksi</th>
                        </tr>
                    </thead>
                </table>
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: {
                    url: `{{ url('/api/transactions/interest-json') }}`,
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'no'
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'bunga',
                    name: 'bunga'
                }, {
                    data: 'formatted_amount_day',
                    name: 'formatted_amount_day'
                }, {
                    data: 'unit_date_formatted',
                    name: 'unit_date_formatted'
                }, {
                    data: 'action',
                    name: 'action'
                }],
            })
        })

        $('#generatePdfBtn').click(function() {
            var loadingPdf = Ladda.create(document.querySelector('.tombol-pdf'));
            let roleSelected = $('#roleSelected').val();
            Swal.fire({
                title: "Ingin mendownload PDF?",
                text: `kamu memilih download untuk ${!roleSelected ? 'Semua User' : roleSelected} `,
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Download!"
            }).then((result) => {
                if (result.isConfirmed) {
                    loadingPdf.start();
                    window.location.href = `/pdf/generate-pdf-users-data?role=${roleSelected}`;

                    setTimeout(() => {
                        loadingPdf.stop();
                    }, 3000);
                } else {
                    loadingPdf.stop();
                }
            });

        });

        function create() {
            $.get("{{ url('/admin/transaction/create-interest') }}", {}, function(data, status) {
                $("#page").html(data);
                $('#insertModal').modal('show');
                $('.modal-title').html('Tambah Bunga');
            })
        }

        // Tambahkan event listener untuk tombol create
        $('#createButton').on('click', function() {
            create();
        });

        // Global setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $('body').on('click', '.tombol-tambah', function() {
            var loadingCreate = Ladda.create(document.querySelector('.tombol-tambah'));
            loadingCreate.start();
            $.ajax({
                url: '/api/transactions/interest',
                type: 'POST',
                data: {
                    name: $('#formCreate').find('[id="name"]').val(),
                    interest: $('#formCreate').find('[id="interest"]').val(),
                    amount_day: $('#formCreate').find('[id="amount_day"]').val(),
                    unit_date: $('#formCreate').find('[id="unit_date"]').val(),
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
                    if (response.errors) {
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "warning",
                            title: 'Tambah Data Gagal'
                        });
                        if (response.errors.name) {
                            $('.input-name').addClass('is-invalid')
                            $('.feedback-name').html(response.errors.name)
                        } else {
                            $('.input-name').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-name').html('');
                        }
                        if (response.errors.interest) {
                            $('.input-interest').addClass('is-invalid')
                            $('.feedback-interest').html(response.errors.interest)
                        } else {
                            $('.input-interest').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-interest').html('');
                        }
                        if (response.errors.amount_day) {
                            $('.input-amount_day').addClass('is-invalid')
                            $('.feedback-amount_day').html(response.errors.amount_day)
                        } else {
                            $('.input-amount_day').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-amount_day').html('');
                        }
                        if (response.errors.unit_date) {
                            $('.input-unit_date').addClass('is-invalid')
                            $('.feedback-unit_date').html(response.errors.unit_date)
                        } else {
                            $('.input-unit_date').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-unit_date').html('');
                        }
                    } else {
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "success",
                            title: response.success
                        });
                        $('#myTable').DataTable().ajax.reload();
                        $('.close').click();
                    }
                }

            })
        })

        // function delete
        $('body').on('click', '.tombol-del', function() {
            Swal.fire({
                title: "Apakah kmu yakin?",
                text: "Data yang sudah dihapus dapat dikembalikan jika kmu mau",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr('data-id');
                    console.log('ini data id', id);
                    $.ajax({
                        url: '/api/transactions/interest/' + id,
                        type: 'DELETE',
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
                            if (response.success) {
                                Toast.fire({
                                    icon: "success",
                                    title: response.success
                                });
                                $('#myTable').DataTable().ajax.reload();
                            }
                        },
                        error: function(xhr, status, error) {
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
                            // alert("Error: " + error);
                            // console.log(xhr.responseJSON.error);
                            Toast.fire({
                                icon: "warning",
                                title: xhr.responseJSON.error
                            });
                        },
                    })
                }
            });
        })
    </script>
@endsection
