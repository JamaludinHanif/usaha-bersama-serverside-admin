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
            <a href="/admin/users/users" style="color: white">Kelola Users</a>
        </li>
    </ul>
@endsection

@section('content')
    {{-- filter --}}

    <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
        <form action="" id="formFilter">
            <p class="h5 mb-2 text-gray-800">Filter berdasarkan role :</p>
            <select class="form-control" name="roleSelected" id="roleSelected" required>
                <option value="" selected>All Role</option>
                <option value="admin">
                    Admin</option>
                <option value="kasir">
                    Kasir</option>
                <option value="user">
                    User</option>
            </select>
        </form>
    </div>

    <div class="" style="height: 35px"></div>

    <div class="d-flex justify-content-end">
        {{-- tambah user --}}
        <a href="#" data-toggle="modal" id="createButton" data-target="#insertModal"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="far fa-plus-square"></i> </span>
            <span class="text" style="color: white">Tambah User</span>
        </a>
    </div>

    <div class="" style="height: 35px"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="" style="display: flex;justify-content: space-between;align-items: center">
                <h6 class="m-0 font-weight-bold text-primary">Semua User</h6>
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
                    <div class="ml-5">
                        <a href="#" id="importExcel" class="btn btn-round btn-success" style="color: white">Import
                            Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="background-color: #007bff; color: white;">Nama</th>
                            <th style="background-color: #007bff; color: white;">Nama Pengguna</th>
                            <th style="background-color: #007bff; color: white;">Limit Hutang</th>
                            <th style="background-color: #007bff; color: white;">Peran Sebagai</th>
                            <th style="background-color: #007bff; color: white;">Email</th>
                            <th style="background-color: #007bff; color: white;">No Hp</th>
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
                    url: `{{ url('/api/users/users-json') }}`,
                    data: function(d) {
                        let roleSelected = $('#roleSelected').val();
                        console.log('role', roleSelected)
                        if (roleSelected) {
                            d.role = roleSelected; // Kirim role ke server
                        } else {
                            d.role = null; // Jika tidak ada role terpilih
                        }
                        console.log(d);
                    }
                },
                columns: [{
                    data: 'name',
                    name: 'Nama'
                }, {
                    data: 'username',
                    name: 'Nama Pengguna'
                }, {
                    data: 'formattedLimit',
                    name: 'formattedLimit'
                }, {
                    data: 'role',
                    name: 'Peran Sebagai'
                }, {
                    data: 'email',
                    name: 'Email'
                }, {
                    data: 'formatted_noHp',
                    name: 'formatted_noHp'
                }, {
                    data: 'action',
                    name: 'Aksi'
                }],
            })
        })

        $('#formFilter').find('[name="roleSelected"]').change(function(e) {
            e.preventDefault();
            // console.log('Role changed:', $(this).val()); // Log perubahan
            $('#myTable').DataTable().ajax.reload();
        });

        $('#exportPdf').click(function() {
            var loadingPdf = Ladda.create(document.querySelector('.export-pdf'));
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
                    window.location.href = `/admin/pdf/user?role=${roleSelected}`;

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
            window.location.href = '{{ route('excel.export.user') }}';

            setTimeout(() => {
                loadingExcel.stop();
            }, 3000);
        });

        function create() {
            $.get("{{ url('/admin/users/create') }}", {}, function(data, status) {
                $("#page").html(data);
                $('#insertModal').modal('show');
                $('.modal-title').html('Buat User');
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

        // function click edit
        $('body').on('click', '.tombol-edit', function() {
            var id = $(this).attr('data-id');
            $.get("{{ url('/admin/users/users/') }}/" + id + "/edit", {}, function(data, status) {
                $("#page").html(data);
                $('#insertModal').modal('show');
                $('.modal-title').html('Edit User');
            })
        })

        $('body').on('click', '.tombol-simpan', function(e) {
            e.preventDefault(); // Mencegah form submit secara default

            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', $('#formEdit').find('[id="name"]').val());
            formData.append('username', $('#formEdit').find('[id="username"]').val());
            formData.append('debt_limit', $('#formEdit').find('[id="debt_limit"]').val());
            formData.append('role', $('#formEdit').find('[id="role"]').val());
            formData.append('email', $('#formEdit').find('[id="email"]').val());
            formData.append('no_hp', $('#formEdit').find('[id="no_hp"]').val());
            formData.append('password', $('#formEdit').find('[id="password"]').val());
            formData.append('admin_id', "{{ session('userData')->id }}");

            var id = $(this).attr('data-id');
            console.log('tesss tombol edit', id);
            var loadingCreate = Ladda.create(document.querySelector('.tombol-simpan'));
            loadingCreate.start();
            $.ajax({
                url: '/api/users/users/' + id,
                type: 'POST',
                data: formData,
                contentType: false, // Penting: agar data dikirim sebagai multipart/form-data
                processData: false,
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
                        console.log(response.errors);
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "warning",
                            title: 'Tambah Data Gagal'
                        });

                        // Daftar input dan feedback yang ingin divalidasi
                        const fields = ['name', 'username', 'role', 'debt_limit', 'no_hp', 'email',
                            'password'
                        ];

                        fields.forEach(field => {
                            if (response.errors[field]) {
                                $(`.input-${field}`).addClass('is-invalid');
                                $(`.feedback-${field}`).html(response.errors[field]);
                            } else {
                                $(`.input-${field}`).removeClass('is-invalid').addClass(
                                    'is-valid');
                                $(`.feedback-${field}`).html('');
                            }
                        });
                    } else {
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "success",
                            title: response.success
                        });
                        $('#myTable').DataTable().ajax.reload();
                        $('.close').click();
                    }
                },
                error: function(xhr, status, error) {
                    // Tampilkan notifikasi error jika gagal
                    alert("Error: " + xhr.responseJSON.error);
                    loadingCreate.stop();
                },
                complete: function() {
                    // Sembunyikan spinner dan enable kembali tombol
                    loadingCreate.stop();
                }
            })
        })

        // function tambah user
        $('body').on('click', '.tombol-tambah', function(e) {
            e.preventDefault(); // Mencegah form submit secara default

            var formData = new FormData();
            formData.append('name', $('#formCreate').find('[id="name"]').val());
            formData.append('username', $('#formCreate').find('[id="username"]').val());
            formData.append('role', $('#formCreate').find('[id="roles"]').val());
            formData.append('debt_limit', $('#formCreate').find('[id="debt_limit"]').val());
            formData.append('email', $('#formCreate').find('[id="email"]').val());
            formData.append('no_hp', $('#formCreate').find('[id="no_hp"]').val());
            formData.append('password', $('#formCreate').find('[id="password"]').val());
            formData.append('admin_id', "{{ session('userData')->id }}");

            console.log(formData);
            var loadingCreate = Ladda.create(document.querySelector('.tombol-tambah'));
            loadingCreate.start();
            $.ajax({
                url: '/api/users/users',
                type: 'POST',
                data: formData,
                contentType: false, // Penting: agar data dikirim sebagai multipart/form-data
                processData: false,
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
                    // console.log($('#user_id').val());
                    if (response.errors) {
                        console.log(response.errors);
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "warning",
                            title: 'Tambah Data Gagal'
                        });

                        // Daftar input dan feedback yang ingin divalidasi
                        const fields = ['name', 'username', 'role', 'debt_limit', 'no_hp', 'email',
                            'password'
                        ];

                        fields.forEach(field => {
                            if (response.errors[field]) {
                                $(`.input-${field}`).addClass('is-invalid');
                                $(`.feedback-${field}`).html(response.errors[field]);
                            } else {
                                $(`.input-${field}`).removeClass('is-invalid').addClass(
                                    'is-valid');
                                $(`.feedback-${field}`).html('');
                            }
                        });
                    } else {
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "success",
                            title: response.success
                        });
                        $('#myTable').DataTable().ajax.reload();
                        $('.close').click();
                    }

                },
                error: function(xhr, status, error) {
                    // Tampilkan notifikasi error jika gagal
                    alert("Error: " + xhr.responseJSON.error);
                },
                complete: function() {
                    // Sembunyikan spinner dan enable kembali tombol
                    loadingCreate.stop();
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
                        url: '/api/users/users/' + id,
                        type: 'DELETE',
                        data: {
                            admin_id: "{{ session('userData')->id }}"
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
