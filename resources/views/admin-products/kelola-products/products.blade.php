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
            <a href="/admin/products/products" style="color: white">Produk</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="/admin/products/products" style="color: white">Kelola Produk</a>
        </li>
    </ul>
@endsection
@section('content')
    {{-- filter --}}
    <div class="d-flex" style="width: 50%">
        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan kategori:</p>
            <select name="categorySelected" id="categorySelected" class="form-control" aria-label="Default select example"
                required>
                <option value="" selected>Semua Kategori</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="pembersih">Pembersih</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan satuan:</p>
            <select name="unitSelected" id="unitSelected" class="form-control" aria-label="Default select example" required>
                <option value="" selected>Semua Satuan</option>
                <option value="pcs">Pcs</option>
                <option value="pack">Pack</option>
                <option value="dos">Dos</option>
                <option value="1/4">1/4 kg</option>
            </select>
        </div>

    </div>

    {{-- tambah products --}}
    <div class="d-flex justify-content-end">
        <a href="#" data-toggle="modal" id="createButton" data-target="#insertModal"
            class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="far fa-plus-square"></i> </span>
            <span class="text" style="color: white">Produk Baru</span>
        </a>
    </div>

    <div class="" style="height: 35px"></div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="" style="display: flex;justify-content: space-between;align-items: center">
                <h6 class="m-0 font-weight-bold text-primary">Semua Produk</h6>
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
                        <a href="#" id="modalImport" class="btn btn-round btn-success" style="color: white">Import
                            Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTableProducts" width="100%" cellspacing="0">
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

            $('#myTableProducts').DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: {
                    url: '/api/products/products-json',
                    data: function(d) {
                        let categorySelected = $('#categorySelected').val();
                        d.category = categorySelected ? categorySelected : null;

                        let unitSelected = $('#unitSelected').val();
                        d.unit = unitSelected ? unitSelected : null;
                    },
                },
                columns: [{
                    data: 'name',
                    name: 'Nama'
                }, {
                    data: 'formatted_amount',
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

            // filter
            $('#categorySelected').change(function(e) {
                e.preventDefault();
                $('#myTableProducts').DataTable().ajax.reload();
            });

            $('#unitSelected').change(function(e) {
                e.preventDefault();
                $('#myTableProducts').DataTable().ajax.reload();
            });

            // export pdf
            $('#exportPdf').click(function() {
                var loadingPdf = Ladda.create(document.querySelector('.export-pdf'));
                let unitSelected = $('#unitSelected').val();
                let categorySelected = $('#categorySelected').val();
                Swal.fire({
                    title: "Ingin mendownload PDF?",
                    text: `kamu memilih download untuk ${!unitSelected ? 'Semua User' : unitSelected} `,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Download!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadingPdf.start();
                        window.location.href =
                            `/admin/pdf/product?unit=${unitSelected}&category=${categorySelected}`;
                        // window.location.href = `{{ route('pdf.transaction') }}`;

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
                window.location.href = '{{ route('excel.export.product') }}';

                setTimeout(() => {
                    loadingExcel.stop();
                }, 3000);
            });

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
                $.get("{{ url('/admin/products/create-products') }}", {}, function(data, status) {
                    $("#page").html(data);
                    $('#insertModal').modal('show');
                    $('.modal-title').html('Tambah Produk');
                    initializeSelect2User(); // Inisialisasi Select2 setelah konten dimuat
                    initializeSelect2Category(); // Inisialisasi Select2 setelah konten dimuat
                });
            }

            // modal import data
            $('#modalImport').on('click', function() {
                $.get("{{ route('modal.import.product') }}", {}, function(data, status) {
                    $("#page").html(data);
                    $('#insertModal').modal('show');
                    $('.modal-title').html('Import Produk');
                })
            })

            // import data by excel
            $('body').on('click', '.import-btn', function(e) {
                e.preventDefault(); // Mencegah form submit standar

                var loadingCreate = Ladda.create(document.querySelector('.import-btn'));
                let formData = new FormData($('#importForm')[0]);
                loadingCreate.start();

                $.ajax({
                    url: "{{ route('excel.import.product') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
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
                                title: 'Import Data Gagal'
                            });
                        } else {
                            loadingCreate.stop();
                            Toast.fire({
                                icon: "success",
                                title: response.message
                            });
                            $('#myTableProducts').DataTable().ajax.reload();
                            $('.close').click();
                        }
                    },
                    error: function(xhr, status, error) {
                        loadingCreate.stop();
                        console.error(xhr.responseText);
                        Toast.fire({
                            icon: "error",
                            title: response.message
                        });
                    }
                });
            });

            // Tambahkan event listener untuk tombol create
            $('#createButton').on('click', function() {
                create();
            });

            $('body').on('click', '.tombol-edit', function() {
                var id = $(this).attr('data-id');
                console.log('tesss tombol edit', id);
                $.get("{{ url('/admin/products/products/') }}/" + id + "/edit", {}, function(data, status) {
                    $("#page").html(data);
                    $('#insertModal').modal('show');
                    $('.modal-title').html('Ubah Produk')
                    initializeSelect2User();
                    initializeSelect2Category();
                })
                console.log('ini data id', id);
                $.ajax({
                    url: '/admin/products/products/' + id + '/edit',
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
                url: '/api/products/products',
                type: 'POST',
                data: {
                    name: $('#formCreate').find('[id="name"]').val(),
                    price: $('#formCreate').find('[id="price"]').val(),
                    category: $('#formCreate').find('[id="category"]').val(),
                    unit: $('#formCreate').find('[id="unit"]').val(),
                    stock: $('#formCreate').find('[id="stock"]').val(),
                    image: $('#formCreate').find('[id="image"]').val(),
                    admin_id: "{{ session('userData')->id }}",
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
                    // console.log($('#name').val());
                    if (response.errors) {
                        // console.log(response.errors);
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
                        if (response.errors.price) {
                            $('.input-price').addClass('is-invalid')
                            $('.feedback-price').html(response.errors.price)
                        } else {
                            $('.input-price').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-price').html('');
                        }
                        if (response.errors.category) {
                            $('.input-category').addClass('is-invalid')
                            $('.feedback-category').html(response.errors.category)
                        } else {
                            $('.input-category').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-category').html('');
                        }
                        if (response.errors.image) {
                            $('.input-image').addClass('is-invalid')
                            $('.feedback-image').html(response.errors.image)
                        } else {
                            $('.input-image').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-image').html('');
                        }
                        if (response.errors.unit) {
                            $('.input-unit').addClass('is-invalid')
                            $('.feedback-unit').html(response.errors.unit)
                        } else {
                            $('.input-unit').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-unit').html('');
                        }
                        if (response.errors.stock) {
                            $('.input-stock').addClass('is-invalid')
                            $('.feedback-stock').html(response.errors.stock)
                        } else {
                            $('.input-stock').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-stock').html('');
                        }
                    } else {
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "success",
                            title: response.success
                        });
                        $('#myTableProducts').DataTable().ajax.reload();
                        $('.close').click();
                    }
                }

            })
        })

        $('body').on('click', '.tombol-simpan', function() {
            var id = $(this).attr('data-id');
            console.log('tesss tombol edit123', id);
            var loadingCreate = Ladda.create(document.querySelector('.tombol-simpan'));
            loadingCreate.start();
            $.ajax({
                url: '/api/products/products/' + id,
                type: 'PUT',
                data: {
                    name: $('#name').val(),
                    price: $('#price').val(),
                    stock: $('#stock').val(),
                    category: $('#category').val(),
                    unit: $('#unit').val(),
                    image: $('#image').val(),
                    admin_id: "{{ session('userData')->id }}",
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
                        // console.log(response.errors);
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "warning",
                            title: 'Ubah Data Gagal'
                        });
                        if (response.errors.name) {
                            $('.input-name').addClass('is-invalid')
                            $('.feedback-name').html(response.errors.name)
                        } else {
                            $('.input-name').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-name').html('');
                        }
                        if (response.errors.price) {
                            $('.input-price').addClass('is-invalid')
                            $('.feedback-price').html(response.errors.price)
                        } else {
                            $('.input-price').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-price').html('');
                        }
                        if (response.errors.category) {
                            $('.input-category').addClass('is-invalid')
                            $('.feedback-category').html(response.errors.category)
                        } else {
                            $('.input-category').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-category').html('');
                        }
                        if (response.errors.image) {
                            $('.input-image').addClass('is-invalid')
                            $('.feedback-image').html(response.errors.image)
                        } else {
                            $('.input-image').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-image').html('');
                        }
                        if (response.errors.unit) {
                            $('.input-unit').addClass('is-invalid')
                            $('.feedback-unit').html(response.errors.unit)
                        } else {
                            $('.input-unit').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-unit').html('');
                        }
                        if (response.errors.stock) {
                            $('.input-stock').addClass('is-invalid')
                            $('.feedback-stock').html(response.errors.stock)
                        } else {
                            $('.input-stock').removeClass('is-invalid').addClass('is-valid');
                            $('.feedback-stock').html('');
                        }
                    } else {
                        loadingCreate.stop();
                        Toast.fire({
                            icon: "success",
                            title: response.success
                        });
                        $('#myTableProducts').DataTable().ajax.reload();
                        $('.close').click();
                    }
                }
            })
        })

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
                    // console.log('ini data id', id);
                    $.ajax({
                        url: '/api/products/products/' + id,
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
                                $('#myTableProducts').DataTable().ajax.reload();
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
        })
    </script>
@endsection
