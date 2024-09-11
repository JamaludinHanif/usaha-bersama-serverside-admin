@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection

@section('content')
    {{-- @dd($users) --}}
    {{-- tambah quotes --}}
    <div class="d-flex justify-content-end">
        <a href="#" data-toggle="modal" id="createButton" data-target="#insertModal"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="far fa-plus-square"></i> </span>
            <span class="text">New Quotes</span>
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
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Pemosting</th>
                            <th>Kategori</th>
                            <th>judul</th>
                            <th>Diposting pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Poster Name</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>posted on</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
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
                ajax: "{{ url('/admin/quotes/quotes-json') }}",
                columns: [{
                    data: 'username',
                    name: 'Nama Pemosting'
                }, {
                    data: 'category',
                    name: 'Kategori'
                }, {
                    data: 'title',
                    name: 'Judul'
                }, {
                    data: 'formatted_created_at',
                    name: 'Diposting Pada'
                }, {
                    data: 'aksi',
                    name: 'aksi'
                }]
            })

            function initializeSelect2User() {
                $('.input-user_id').select2({
                    dropdownParent: '#insertModal',
                    placeholder: 'Pilih User',
                    allowClear: true,
                    theme: 'classic'
                });
            }

            function initializeSelect2Category() {
                $('.input-category_id').select2({
                    dropdownParent: '#insertModal',
                    placeholder: 'Pilih Kategori',
                    allowClear: true,
                    theme: 'classic'
                });
            }

            // Inisialisasi awal saat halaman dimuat
            initializeSelect2User();
            initializeSelect2Category();

            function create() {
                $.get("{{ url('/admin/quotes/create-quotes') }}", {}, function(data, status) {
                    $("#page").html(data);
                    $('#insertModal').modal('show');
                    $('.modal-title').html('Buat Quotes');
                    initializeSelect2User(); // Inisialisasi Select2 setelah konten dimuat
                    initializeSelect2Category(); // Inisialisasi Select2 setelah konten dimuat
                });
            }

            // Tambahkan event listener untuk tombol create
            $('#createButton').on('click', function() {
                create();
            });


            $('body').on('click', '.tombol-edit', function() {
                var id = $(this).attr('data-id');
                console.log('tesss tombol edit', id);
                $.get("{{ url('/admin/quotes/quotes/') }}/" + id + "/edit", {}, function(data, status) {
                    $("#page").html(data);
                    $('#insertModal').modal('show');
                    $('.modal-title').html('Ubah Quotes')
                    initializeSelect2User();
                    initializeSelect2Category();
                })
                console.log('ini data id', id);
                $.ajax({
                    url: '/admin/quotes/quotes/' + id + '/edit',
                    type: 'GET',
                    success: function(response) {}
                })
            })
        });

        // Global setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $('body').on('click', '.tombol-tambah', function() {
            // loadingCreate.start();
            console.log($('#user_id').val());
            // Ladda.bind('button[type=submit]', {timeout: 10000});
            var loadingCreate = Ladda.create(document.querySelector('.tombol-tambah'));
            loadingCreate.start();
            $.ajax({
                url: '/admin/quotes/quotes',
                type: 'POST',
                data: {
                    user_id: $('#formCreate').find('[id="user_id"]').val(),
                    category_id: $('#formCreate').find('[id="category_id"]').val(),
                    title: $('#formCreate').find('[id="title"]').val(),
                    quote: $('#formCreate').find('[id="quote"]').val()
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
                    // console.log($('#user_id').val());
                    if (response.errors) {
                        // console.log(response.errors);
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "warning",
                            title: 'Tambah Data Gagal'
                        });
                        if (response.errors.user_id) {
                            $('.input-user_id').addClass('is-invalid')
                            $('.feedback-user_id').html(response.errors.user_id)
                        }
                        if (response.errors.category_id) {
                            $('.input-category_id').addClass('is-invalid')
                            $('.feedback-category_id').html(response.errors.category_id)
                        }
                        if (response.errors.title) {
                            $('.input-title').addClass('is-invalid')
                            $('.feedback-title').html(response.errors.title)
                        }
                        if (response.errors.quote) {
                            $('.input-quote').addClass('is-invalid')
                            $('.feedback-quote').html(response.errors.quote)
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

        $('body').on('click', '.tombol-simpan', function() {
            var id = $(this).attr('data-id');
            console.log('tesss tombol edit', id);
            var loadingCreate = Ladda.create(document.querySelector('.tombol-simpan'));
            loadingCreate.start();
            $.ajax({
                url: '/admin/quotes/quotes/' + id,
                type: 'PUT',
                data: {
                    user_id: $('#user_id').val(),
                    category_id: $('#category_id').val(),
                    title: $('#title').val(),
                    quote: $('#quote').val()
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
                            title: response.errors
                        });
                        if (response.errors.user_id) {
                            $('.input-user_id').addClass('is-invalid')
                            $('.feedback-user_id').html(response.errors.user_id)
                        }
                        if (response.errors.category_id) {
                            $('.input-category_id').addClass('is-invalid')
                            $('.feedback-category_id').html(response.errors.category_id)
                        }
                        if (response.errors.title) {
                            $('.input-title').addClass('is-invalid')
                            $('.feedback-title').html(response.errors.title)
                        }
                        if (response.errors.quote) {
                            $('.input-quote').addClass('is-invalid')
                            $('.feedback-quote').html(response.errors.quote)
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

        $('body').on('click', '.tombol-del', function() {
            // console.log('ttesss');
            if (confirm('Yakin mau hapus data ini') == true) {
                var id = $(this).attr('data-id');
                // console.log('ini data id', id);
                $.ajax({
                    url: '/admin/quotes/quotes/' + id,
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
                        } else {
                            Toast.fire({
                                icon: "warning",
                                title: response.error
                            });
                        }
                    }
                })
            }
        })
    </script>
@endsection
