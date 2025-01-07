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
            <a href="{{ route('admin.product.index') }}" style="color: white">Kelola Produk</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.product.create') }}" style="color: white">Tambah Produk</a>
        </li>
    </ul>
@endsection
@section('content')
    <form id="form">
        <div class="row">

            <div class="col-lg-12 mb-3">
                {!! Template::requiredBanner() !!}
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Nama Produk -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Nama Produk {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Masukan Nama Produk" required>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Kategory Produk -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Kategory Produk {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <select class="form-control" name="category" required>
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        <option value="makanan">Makanan</option>
                                        <option value="minuman">Minuman</option>
                                        <option value="pembersih">Pembersih</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Satuan -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Satuan Produk {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <select class="form-control" name="unit" required>
                                        <option value="" disabled selected>Pilih Satuan</option>
                                        <option value="pcs">Pcs</option>
                                        <option value="pack">Pack</option>
                                        <option value="dos">Dos</option>
                                        <option value="1/4">1/4 kg</option>
                                    </select>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Harga Produk {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Rp </span>
                                        </div>
                                        <input type="number" name="price" class="form-control" placeholder="*contoh: 4000" required>
                                    </div>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Stok </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="stock" class="form-control" placeholder="Masukan Stok">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Berat (gram) -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Berat (gram) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="weight" class="form-control" placeholder="Masukan Berat (gram) *contoh: 10">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Panjang -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Panjang (cm) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="length" class="form-control" placeholder="Masukan Panjang (cm) *contoh: 10">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Lebar -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Lebar (cm) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="width" class="form-control" placeholder="Masukan Lebar (cm) *contoh: 10">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Tinggi -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Tinggi (cm) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="height" class="form-control" placeholder="Masukan Tinggi (cm) *contoh: 10">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Deskripsi Produk -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Deskripsi Produk </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <textarea id="tiny" name="description"></textarea>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Foto Utama Produk -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mb-0"> Foto Utama Produk {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <img src="#" style="max-width: 300px; height: auto; display: none;"
                                        class="image-preview mb-2">
                                    <input type="text" name="image" class="form-control image-url-input"
                                        placeholder="Masukan URL Gambar Produk" required>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer row">
                            <div class="mr-3">
                                <a href="javascript:history.back()" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Simpan
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('atlantis/assets/js/plugin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/plugin/tinymce/jquery.tinymce.min.js') }}"></script>

    <script>
        $(function() {

            $form = $('#form');
            $submitBtn = $form.find(`[type="submit"]`).ladda();

            const resetForm = () => {
                $form[0].reset()
                clearInvalid();
                $form.find(`[name="name"]`).focus();
                $('.thumbnail-preview').hide();
                $('.thumbnail-preview').attr('src', '#')
                $form.find(`[name="id_product_type"]`).val('').trigger('change')
                $form.find(`[name="id_brand"]`).val('').trigger('change')
            }

            $form.on('submit', function(e) {
                e.preventDefault();
                clearInvalid();

                let formData = new FormData(this);
                formData.set('description', $form.find(`[name="description"]`).val());
                $submitBtn.ladda('start')

                ajaxSetup();
                $.ajax({
                        url: `{{ route('admin.product.store') }}`,
                        method: 'post',
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                    })
                    .done(response => {
                        let {
                            message
                        } = response;
                        successNotification('Berhasil', message)
                        setTimeout(() => {
                            window.location.href = `{{ route('admin.product.index') }}`
                        }, 1000)
                    })
                    .fail(error => {
                        $submitBtn.ladda('stop')
                        ajaxErrorHandling(error, $form)
                    })
            })

            $form.find('textarea#tiny').tinymce({
                height: 400,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image media code | preview removeformat help',
                images_upload_url: `{{ url('api/uploads/image') }}`,
            });

            // previewImageAfterChange({
            //     fieldSelector: `[name="image"]`,
            //     previewSelector: `.image-preview`,
            // })

            previewImageFromUrl('.image-url-input', '.image-preview')

            $form.find(`[name="id_product_type"]`).select2({
                'placeholder': '- Pilih Jenis Produk -',
                'allowClear': true,
            })

            $form.find(`[name="id_brand"]`).select2({
                'placeholder': '- Pilih Brand -',
                'allowClear': true,
            })

            resetForm();

        })
    </script>
@endsection
