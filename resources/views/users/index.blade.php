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
            <a href="{{ route('admin.users.index') }}" style="color: white">Kelola Pengguna</a>
        </li>
    </ul>
@endsection

@section('content')
    {{-- filter --}}
    <div style="width: 300px" class="col-sm-6 mb-3 mb-sm-0">
        <form action="" id="formFilter">
            <p class="h5 mb-2 text-gray-800">Filter berdasarkan role :</p>
            <select class="form-control" name="roleSelected" id="roleSelected" required>
                <option value="" selected>Semua Role</option>
                <option value="admin">
                    Admin</option>
                <option value="buyer">
                    Pembeli</option>
            </select>
        </form>
    </div>

    <div class="" style="height: 35px"></div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalCreate">
            <i class="fa fa-plus"></i> Tambah
        </button>
    </div>

    <div class="" style="height: 35px"></div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="" style="display: flex;justify-content: space-between;align-items: center">
                <h6 class="m-0 font-weight-bold text-primary">Semua Pengguna</h6>
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
                            <th style="background-color: #007bff; color: white;">Email</th>
                            <th style="background-color: #007bff; color: white;">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modalCreate" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCreate">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-plus"></i> Tambah
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {!! Template::requiredBanner() !!}

                        <div class="form-group">
                            <label> Nama {!! Template::required() !!} </label>
                            <input type="text" name="name" placeholder="Nama" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Username {!! Template::required() !!} </label>
                            <input type="text" name="username" placeholder="Username" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Email {!! Template::required() !!} </label>
                            <input type="text" name="email" placeholder="Email" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Nomor Handphone {!! Template::required() !!} </label>
                            <input type="number" name="no_hp" placeholder="Nomor Handphone" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Role {!! Template::required() !!} </label>
                            <select name="role" class="form-control" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="admin"> Admin </option>
                                <option value="buyer"> Pembeli </option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Password {!! Template::required() !!} </label>
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <input type="hidden" name="is_verify" value="yes">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpdate" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formUpdate">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-pencil-alt"></i> Edit
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {!! Template::requiredBanner() !!}

                        <div class="form-group">
                            <label> Nama {!! Template::required() !!} </label>
                            <input type="text" name="name" placeholder="Nama" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Username {!! Template::required() !!} </label>
                            <input type="text" name="username" placeholder="Username" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Email {!! Template::required() !!} </label>
                            <input type="text" name="email" placeholder="Email" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Nomor Handphone {!! Template::required() !!} </label>
                            <input type="number" name="no_hp" placeholder="Nomor Handphone" class="form-control" required>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Role {!! Template::required() !!} </label>
                            <select name="role" class="form-control" required>
                                <option value="admin"> Admin </option>
                                <option value="buyer"> Pembeli </option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input type="password" name="password" placeholder="Isi Kolom Ini Jika Ingin Ganti Password"
                                class="form-control">
                            <span class="invalid-feedback"></span>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {

            const $modalCreate = $('#modalCreate');
            const $modalUpdate = $('#modalUpdate');
            const $formCreate = $('#formCreate');
            const $formUpdate = $('#formUpdate');
            const $roleFilter = $('#roleSelected');
            const $formCreateSubmitBtn = $formCreate.find(`[type="submit"]`).ladda();
            const $formUpdateSubmitBtn = $formUpdate.find(`[type="submit"]`).ladda();

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.users.index') }}",
                    data: function(d) {
                        let roleSelected = $roleFilter.val();
                        if (roleSelected) {
                            d.role = roleSelected;
                        } else {
                            d.role = null;
                        }
                    }
                },
                columns: [{
                        data: "name",
                        name: 'name'
                    },
                    {
                        data: "username",
                        name: 'username'
                    },
                    {
                        data: "roleFormatted",
                        name: 'roleFormatted'
                    },
                    {
                        data: "email",
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ],
                drawCallback: settings => {
                    renderedEvent();
                }
            })

            const reloadDT = () => {
                $('#dataTable').DataTable().ajax.reload();
            }

            $roleFilter.on('change', function() {
                reloadDT();
            });

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
                                    console.log(error);
                                    ajaxErrorHandling(error);
                                })
                        })
                    })
                })

                $.each($('.edit'), (i, editBtn) => {
                    $(editBtn).off('click')
                    $(editBtn).on('click', function() {
                        let {
                            editHref,
                            getHref
                        } = $(this).data();
                        $.get({
                                url: getHref,
                                dataType: 'json'
                            })
                            .done(response => {
                                let {
                                    user
                                } = response;
                                clearInvalid();
                                $modalUpdate.modal('show')
                                $formUpdate.attr('action', editHref)
                                $formUpdate.find(`[name="name"]`).val(user.name);
                                $formUpdate.find(`[name="username"]`).val(user.username);
                                $formUpdate.find(`[name="email"]`).val(user.email);
                                $formUpdate.find(`[name="no_hp"]`).val(user.no_hp);
                                $formUpdate.find(`[name="role"]`).val(user.role);

                                formSubmit(
                                    $modalUpdate,
                                    $formUpdate,
                                    $formUpdateSubmitBtn,
                                    editHref,
                                    'put'
                                );
                            })
                            .fail(error => {
                                ajaxErrorHandling(error);
                            })
                    })
                })
            }

            $modalCreate.on('shown.bs.modal', function() {
                $formCreate.find(`[name="name"]`).focus();
            })

            $modalUpdate.on('shown.bs.modal', function() {
                $formUpdate.find(`[name="name"]`).focus();
            })

            const clearFormCreate = () => {
                $formCreate[0].reset();
            }

            const formSubmit = ($modal, $form, $submit, $href, $method, addedAction = null) => {
                $form.off('submit')
                $form.on('submit', function(e) {
                    e.preventDefault();
                    clearInvalid();

                    let formData = $(this).serialize();
                    $submit.ladda('start');

                    ajaxSetup();
                    $.ajax({
                            url: $href,
                            method: $method,
                            data: formData,
                            dataType: 'json'
                        })
                        .done(response => {
                            let {
                                message
                            } = response;
                            successNotification('Berhasil', message)
                            reloadDT();
                            $submit.ladda('stop');
                            $modal.modal('hide');

                            if (addedAction) {
                                addedAction();
                            }
                        })
                        .fail(error => {
                            $submit.ladda('stop');
                            ajaxErrorHandling(error, $form);
                        })
                })
            }

            formSubmit(
                $modalCreate,
                $formCreate,
                $formCreateSubmitBtn,
                `{{ route('admin.users.store') }}`,
                'post',
                () => {
                    clearFormCreate();
                }
            );

            $('#exportPdf').click(function() {
                var loadingPdf = Ladda.create(document.querySelector('.export-pdf'));
                let roleSelected = $('#roleSelected').val();
                Swal.fire({
                    title: "Ingin menExport PDF?",
                    text: `kamu memilih Export untuk role ${!roleSelected ? 'Semua User' : roleSelected} `,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Export!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadingPdf.start();
                        window.location.href = `/admin/pdf/user?role=${roleSelected}`;

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
                    window.location.href = '{{ route('excel.export.user') }}';
                })

                setTimeout(() => {
                    loadingExcel.stop();
                }, 5000);
            });

        })
    </script>
@endsection
