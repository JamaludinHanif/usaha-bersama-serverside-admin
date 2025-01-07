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
            <a href="{{ route('admin.product.index') }}" style="color: white">Kelola Produk</a>
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

    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-icon-split">
            <i class="fa fa-plus"></i> Tambah
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
                        <button id="exportPdf" class="btn btn-round btn-primary export-pdf ladda-button"
                            style="color: white">Export PDF</button>
                    </div>
                    <div class="ml-5">
                        <button id="exportExcel" class="btn btn-round btn-warning export-excel ladda-button"
                            style="color: white">Export
                            Excel</button>
                    </div>
                    <div class="ml-5">
                        <button data-toggle="modal" data-target="#modalImport" class="btn btn-round btn-success"
                            style="color: white">Import
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
    <div class="modal fade" id="modalImport" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="importForm" enctype="multipart/form-data" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-plus"></i> Import
                        </h5>
                        <button type="button" class="closeModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! Template::requiredBanner() !!}
                        <div class="">
                            <div class="">
                                <ul>
                                    <li>Download template file excel <a title="Download Template Excel" style="color: blue"
                                            href="{{ route('download.template.product') }}">Disini</a>
                                    </li>
                                    <li>Silahkan isi dengan format yang sesuai template diatas</li>
                                    <li>Setelah di isi, silahkan uploadkan file excel di bawah </li>
                                    <li>File yang didukung : xls, xlsx</li>
                                </ul>
                            </div>
                            <div class="" style="height: 20px"></div>
                            <div class="ml-2 mr-2" style="padding: 10px">
                                <div style="font-weight: bold;margin-bottom: 1px">File {!! Template::required() !!} :</div>
                                <input type="file" name="file" id="file" class="form-control"
                                    accept=".xlsx, .xls, .csv">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Tutup
                        </button>
                        <button type="submit" id="importButton" class="btn btn-primary ladda-button import-btn">
                            <i class="fas fa-save mr-1"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            const renderedEvent = () => {
                $.each($('.delete'), (i, deleteBtn) => {
                    $(deleteBtn).off('click')
                    $(deleteBtn).on('click', function() {
                        let {
                            deleteMessage,
                            deleteHref
                        } = $(this).data();
                        confirmation(deleteMessage, function() {
                            ajaxSetup()
                            $.ajax({
                                    url: deleteHref,
                                    method: 'delete',
                                    dataType: 'json'
                                })
                                .done(response => {
                                    let {
                                        message
                                    } = response
                                    successNotification('Berhasil', message)
                                    reloadDT();
                                })
                                .fail(error => {
                                    ajaxErrorHandling(error);
                                })
                        })
                    })
                })
            }

            $('#dataTable').DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.product.index') }}",
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
                    data: 'thumbnail',
                    name: 'Gambar'
                }, {
                    data: 'action',
                    name: 'Aksi'
                }],
                drawCallback: settings => {
                    renderedEvent();
                },
            })

            const reloadDT = () => {
                $('#dataTable').DataTable().ajax.reload();
            }

            // filter
            $('#categorySelected').change(function(e) {
                reloadDT();
            });

            $('#unitSelected').change(function(e) {
                reloadDT();
            });

            // export pdf
            $('#exportPdf').click(function() {
                var loadingPdf = Ladda.create(document.querySelector('.export-pdf'));
                let unitSelected = $('#unitSelected').val();
                let categorySelected = $('#categorySelected').val();
                Swal.fire({
                    title: "Ingin mengExport PDF?",
                    text: `kamu memilih Export untuk ${!categorySelected ? 'Semua Kategori' : categorySelected} `,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Export!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadingPdf.start();
                        window.location.href =
                            `/admin/pdf/product?unit=${unitSelected}&category=${categorySelected}`;
                        setTimeout(() => {
                            loadingPdf.stop();
                        }, 5000);
                    } else {
                        loadingPdf.stop();
                    }
                });

            });

            // function Export excel
            $('#exportExcel').click(function() {
                var loadingExcel = Ladda.create(document.querySelector('.export-excel'));
                confirmation('Kamu ingin melakukan export excel ?', function() {
                    loadingExcel.start();
                    window.location.href = '{{ route('excel.export.product') }}';
                })

                setTimeout(() => {
                    loadingExcel.stop();
                }, 5000);
            });

            // import data by excel
            $('body').on('click', '.import-btn', function(e) {
                e.preventDefault();

                var loadingCreate = Ladda.create(document.querySelector('.import-btn'));
                let formData = new FormData($('#importForm')[0]);
                loadingCreate.start();

                ajaxSetup()
                $.ajax({
                    url: "{{ route('excel.import.product') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.errors) {
                            loadingCreate.stop();
                            errorNotification('Peringatan!', response.errors);
                        } else {
                            loadingCreate.stop();
                            successNotification('Berhasil', response.success)
                            reloadDT();
                            $('#importForm')[0].reset();
                            $('.closeModal').click();
                        }
                    },
                    error: function(xhr, status, error) {
                        loadingCreate.stop();
                        console.error(xhr.responseText);
                        errorNotification('Import Data Gagal', xhr.responseJSON.message || xhr
                            .responseJSON
                            .details)
                    }
                });
            });
        });
    </script>
@endsection
