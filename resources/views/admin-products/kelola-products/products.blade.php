@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <div id="loading-spinner"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255,255,255,0.8); z-index: 9999; text-align: center;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    {{-- filter --}}
    <div class="d-flex" style="width: 50%">
        {{-- <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <form action="" id="formFilter">
                <p class="h6 mb-2 text-gray-800">Filter berdasarkan kategory :</p>
                <select name="categorySelected" id="categorySelected" class="form-select" aria-label="Default select example"
                    required>
                    <option value="" selected>Semua Kategori</option>
                    <option value="makanan">
                        Makanan</option>
                    <option value="minuman">
                        Minuman</option>
                    <option value="pembersih">
                        Pembersih</option>
                </select>
            </form>
        </div>
        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <form action="" id="formFilter">
                <p class="h6 mb-2 text-gray-800">Filter berdasarkan satuan :</p>
                <select name="unitSelected" id="unitSelected" class="form-select" aria-label="Default select example"
                    required>
                    <option value="" selected>Semua satuan</option>
                    <option value="pcs">
                        Pcs</option>
                    <option value="pak">
                        Pak</option>
                    <option value="dos">
                        Dos</option>
                </select>
            </form>
        </div> --}}
        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan kategori:</p>
            <select name="categorySelected" id="categorySelected" class="form-select" aria-label="Default select example"
                required>
                <option value="" selected>Semua Kategori</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="pembersih">Pembersih</option>
            </select>
        </div>

        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan satuan:</p>
            <select name="unitSelected" id="unitSelected" class="form-select" aria-label="Default select example" required>
                <option value="" selected>Semua Satuan</option>
                <option value="pcs">Pcs</option>
                <option value="pak">Pak</option>
                <option value="dos">Dos</option>
            </select>
        </div>

    </div>

    {{-- tambah quotes --}}
    <div class="d-flex justify-content-end">
        <a href="#" data-toggle="modal" id="createButton" data-target="#insertModal"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="far fa-plus-square"></i> </span>
            <span class="text">Produk Baru</span>
        </a>
    </div>

    <div class="" style="height: 35px"></div>

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="background-color: #007bff; color: white;">Nama</th>
                            <th style="background-color: #007bff; color: white;">Harga</th>
                            <th style="background-color: #007bff; color: white;">Satuan</th>
                            <th style="background-color: #007bff; color: white;">Stok</th>
                            <th style="background-color: #007bff; color: white;">Kategori</th>
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
                    url: `{{ url('/admin/products/products-json') }}`,
                    data: function(d) {
                        let categorySelected = $('#categorySelected').val();
                        if (categorySelected) {
                            d.category = categorySelected;
                        } else {
                            d.category = null;
                        }
                        let unitSelected = $('#unitSelected').val();
                        if (unitSelected) {
                            d.unit = unitSelected;
                        } else {
                            d.unit = null;
                        }
                    }
                },
                columns: [{
                    data: 'name',
                    name: 'Nama'
                }, {
                    data: 'price',
                    name: 'Harga'
                }, {
                    data: 'unit',
                    name: 'Satuan'
                }, {
                    data: 'stock',
                    name: 'Stok'
                }, {
                    data: 'category',
                    name: 'Kategori'
                }, {
                    data: 'image',
                    name: 'Gambar'
                }, {
                    data: 'action',
                    name: 'Aksi'
                }]
            })

            // loading
            $(document).on('click', 'a', function(e) {
                var href = $(this).attr('href');

                if (href && href !== "#" && href.indexOf('#') === -1) {
                    $('#loading-spinner').show();
                }
            });

            $(window).on('load', function() {
                $('#loading-spinner').hide();
            });

            // filter
            $('#categorySelected').change(function(e) {
                e.preventDefault();
                $('#myTable').DataTable().ajax.reload();
            });

            $('#unitSelected').change(function(e) {
                e.preventDefault();
                $('#myTable').DataTable().ajax.reload();
            });
            // $('#formFilter').find('[name="categorySelected"]').change(function(e) {
            //     e.preventDefault();
            //     // console.log('Role changed:', $(this).val()); // Log perubahan
            //     $('#myTable').DataTable().ajax.reload();
            // });

            // $('#formFilter').find('[name="unitSelected"]').change(function(e) {
            //     e.preventDefault();
            //     // console.log('Role changed:', $(this).val()); // Log perubahan
            //     $('#myTable').DataTable().ajax.reload();
            // });

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
