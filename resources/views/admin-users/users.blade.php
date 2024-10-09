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
                <option value="user">
                    User</option>
            </select>
        </form>
    </div>

    <div class="" style="height: 35px"></div>

    <div class="d-flex justify-content-between">

        {{-- download pdf --}}
        {{-- <a href="/generate-pdf" id="generatePdfBtn" class="btn btn-primary">Download PDF</a> --}}
        <a href="#" id="generatePdfBtn" class="btn btn-primary tombol-pdf ladda-button">Download PDF</a>

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
            <h6 class="m-0 font-weight-bold text-primary">Semua User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="background-color: #007bff; color: white;">Nama</th>
                            <th style="background-color: #007bff; color: white;">Nama Pengguna</th>
                            <th style="background-color: #007bff; color: white;">Peran Sebagai</th>
                            <th style="background-color: #007bff; color: white;">Email</th>
                            <th style="background-color: #007bff; color: white;">Gambar</th>
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
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: {
                    url: `{{ url('/api/users/users-json') }}`,
                    data: function(d) {
                        let roleSelected = $('#roleSelected').val();
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
                    data: 'role',
                    name: 'Peran Sebagai'
                }, {
                    data: 'email',
                    name: 'Email'
                }, {
                    data: 'imageUser',
                    name: 'Image'
                }, {
                    data: 'action',
                    name: 'Aksi'
                }],
            })
        })

        $('#formFilter').find('[name="roleSelected"]').change(function(e) {
            e.preventDefault();
            // console.log('Role changed:', $(this).val()); // Log perubahan
            $('#myTableUsers').DataTable().ajax.reload();
        });

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

        // $('#role').change(function(e) {
        //     e.preventDefault();
        //     console.log('Role changed:', $(this).val()); // Log perubahan
        //     $('#myTable').DataTable().ajax.reload();
        // });

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
            formData.append('role', $('#formEdit').find('[id="role"]').val());
            formData.append('email', $('#formEdit').find('[id="email"]').val());
            formData.append('password', $('#formEdit').find('[id="password"]').val());

            var fileInput = $('#formEdit').find('[id="image"]')[0].files[0];
            if (fileInput) {
                formData.append('image', fileInput);
            }

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
                    // console.log($('#user_id').val());
                    if (response.errors) {
                        console.log(response.errors);
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "warning",
                            title: 'Tambah Data Gagal'
                        });
                        // validasi pesan error
                        if (response.errors.name) {
                            $('.input-name').addClass('is-invalid')
                            $('.feedback-name').html(response.errors.name)
                        } else {
                            $('.input-name').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-name').html('');
                        }
                        if (response.errors.username) {
                            $('.input-username').addClass('is-invalid')
                            $('.feedback-username').html(response.errors.username)
                        } else {
                            $('.input-username').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-username').html('');
                        }
                        if (response.errors.role) {
                            $('.input-role').addClass('is-invalid')
                            $('.feedback-role').html(response.errors.role)
                        } else {
                            $('.input-role').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-role').html('');
                        }
                        if (response.errors.image) {
                            $('.input-image').addClass('is-invalid')
                            $('.feedback-image').html(response.errors.image)
                        } else {
                            $('.input-image').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-image').html('');
                        }
                        if (response.errors.email) {
                            $('.input-email').addClass('is-invalid')
                            $('.feedback-email').html(response.errors.email)
                        } else {
                            $('.input-email').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-email').html('');
                        }
                        if (response.errors.password) {
                            $('.input-password').addClass('is-invalid')
                            $('.feedback-password').html(response.errors.password)
                        } else {
                            $('.input-password').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-password').html('');
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
            formData.append('image', $('#formCreate').find('[id="image"]')[0].files[0]);
            formData.append('email', $('#formCreate').find('[id="email"]').val());
            formData.append('password', $('#formCreate').find('[id="password"]').val());

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
                        // validasi pesan error
                        if (response.errors.name) {
                            $('.input-name').addClass('is-invalid')
                            $('.feedback-name').html(response.errors.name)
                        } else {
                            $('.input-name').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-name').html('');
                        }
                        if (response.errors.username) {
                            $('.input-username').addClass('is-invalid')
                            $('.feedback-username').html(response.errors.username)
                        } else {
                            $('.input-username').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-username').html('');
                        }
                        if (response.errors.role) {
                            $('.input-role').addClass('is-invalid')
                            $('.feedback-role').html(response.errors.role)
                        } else {
                            $('.input-role').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-role').html('');
                        }
                        if (response.errors.image) {
                            $('.input-image').addClass('is-invalid')
                            $('.feedback-image').html(response.errors.image)
                        } else {
                            $('.input-image').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-image').html('');
                        }
                        if (response.errors.email) {
                            $('.input-email').addClass('is-invalid')
                            $('.feedback-email').html(response.errors.email)
                        } else {
                            $('.input-email').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-email').html('');
                        }
                        if (response.errors.password) {
                            $('.input-password').addClass('is-invalid')
                            $('.feedback-password').html(response.errors.password)
                        } else {
                            $('.input-password').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-password').html('');
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
