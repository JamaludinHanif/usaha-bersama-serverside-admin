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
        <a href="/admin/resycle/users" style="color: white">Restore</a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow" style="color: white"></i>
    </li>
    <li class="nav-item">
        <a href="/admin/resycle/users" style="color: white">User</a>
    </li>
</ul>
@endsection
@section('content')
    {{-- filter --}}
    <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
        <form action="" id="formFilter">
            <p class="h5 mb-2 text-gray-800">Filter berdasarkan role :</p>
            <select name="roleSelected" id="roleSelected" class="form-control" aria-label="Default select example" required>
                <option value="" selected>All Role</option>
                <option value="admin">
                    Admin</option>
                <option value="user">
                    User</option>
            </select>
        </form>
    </div>


    <div class="" style="height: 60px"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua User Yang Terhapus</h6>
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
                            <th style="background-color: #007bff; color: white;">Dihapus Pada</th>
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
                    url: `{{ url('/admin/recycle/users-json') }}`,
                    data: function(d) {
                        let roleSelected = $('#roleSelected').val();
                        if (roleSelected) {
                            d.role = roleSelected; // Kirim role ke server
                        } else {
                            d.role = null; // Jika tidak ada role terpilih
                        }
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
                    data: 'formatted_deleted_at',
                    name: 'Dihapus pada'
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

        // Global setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        // function restrore
        $('body').on('click', '.tombol-restore', function() {
            Swal.fire({
                title: "Apakah kmu yakin?",
                text: "Data akan di Restore/Recycle (diaktifkan kembali)",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Restore"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr('data-id');
                    console.log('ini data id', id);
                    $.ajax({
                        url: '/admin/recycle/users/' + id + '/restore',
                        type: 'GET',
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

        // function delete
        $('body').on('click', '.tombol-del', function() {
            Swal.fire({
                title: "Apakah kmu yakin?",
                text: "Data akan dihapus untuk selama nya",
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
                        url: '/admin/recycle/users/' + id + '/destroy',
                        type: 'GET',
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
