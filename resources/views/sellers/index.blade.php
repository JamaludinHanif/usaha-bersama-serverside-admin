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
            <a href="{{ route('admin.seller.index') }}" style="color: white">Kelola Penjual</a>
        </li>
    </ul>
@endsection
@section('content')
    {{-- filter --}}
    <div class="d-flex" style="width: 50%">
        <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
            <p class="h6 mb-2 text-gray-800">Filter berdasarkan status :</p>
            <select name="statusSelected" id="statusSelected" class="form-control" aria-label="Default select example" required>
                <option value="" selected>Semua status</option>
                <option value="Buka">Buka</option>
                <option value="Tutup">Tutup</option>
                <option value="Blokir">Di Blokir</option>
            </select>
        </div>

        <!-- Input untuk filter tanggal -->
        <div class="col-sm-6 mb-3 mb-sm-0" style="width: 300px">
            <form action="" id="formFilter">
                <div class="">
                    <p class="h6 mb-2 text-gray-800">Filter berdasarkan tanggal dibuat :</p>
                    <input type="date" id="date" name="date" class="form-control datepicker" placeholder="">
                </div>
            </form>
        </div>
    </div>

    {{-- tambah products --}}
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.seller.create') }}" class="btn btn-primary btn-icon-split">
            <i class="fa fa-plus"></i> Tambah
        </a>
    </div>

    <div class="" style="height: 35px"></div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="" style="display: flex;justify-content: space-between;align-items: center">
                <h6 class="m-0 font-weight-bold text-primary">Semua Penjual</h6>
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
                            <th style="background-color: #007bff; color: white; text-align: center;">Nama Toko</th>
                            <th style="background-color: #007bff; color: white; text-align: center;">Nomor Hp</th>
                            <th style="background-color: #007bff; color: white; text-align: center;">Email</th>
                            <th style="background-color: #007bff; color: white; text-align: center;">Status</th>
                            <th style="background-color: #007bff; color: white; text-align: center;">Logo</th>
                            <th style="background-color: #007bff; color: white; text-align: center;">Aksi</th>
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
                                    <li>Download template file excel <a title="Download Template Excel"
                                            style="color: blue" href="{{ route('download.template.product') }}">Disini</a>
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

            const $statusFilter = $('#statusSelected');
            const $dateFilter = $('#formFilter').find('[name="date"]')

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
                    url: "{{ route('admin.seller.index') }}",
                    data: function(d) {
                        d.status = $statusFilter.val();
                        d.date = $dateFilter.val();
                    }
                },
                columns: [{
                    data: 'shop_name',
                    name: 'Nama Toko'
                }, {
                    data: 'no_hp',
                    name: 'Nomor Hp'
                }, {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'status',
                    name: 'Status'
                }, {
                    data: 'image',
                    name: 'Logo'
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

            $statusFilter.on('change', function() {
                reloadDT();
            });

            $dateFilter.on('change', function() {
                reloadDT();
            });

            // export pdf
            $('#exportPdf').click(function() {
                var loadingPdf = Ladda.create(document.querySelector('.export-pdf'));
                Swal.fire({
                    title: "Ingin mengExport PDF?",
                    text: `kamu memilih Export untuk ${!$statusFilter.val() ? 'Semua Status' : $statusFilter.val()} `,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Export!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadingPdf.start();
                        window.location.href =
                            `/admin/pdf/seller?date=${$dateFilter.val()}&status=${$statusFilter.val()}`;
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
                    window.location.href = '{{ route('excel.export.seller') }}';
                })

                setTimeout(() => {
                    loadingExcel.stop();
                }, 5000);
            });

        });
    </script>
@endsection
