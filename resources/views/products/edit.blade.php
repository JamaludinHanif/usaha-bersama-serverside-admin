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
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="#" style="color: white">Ubah Produk</a>
        </li>
    </ul>
@endsection
@section('content')
    <form id="form">
        @method('PUT')
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
                                    <p> Nama Produk {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Masukan Nama Produk"
                                        value="{{ $product->name }}" required>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Kategori Produk -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Kategori Produk {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <select class="form-control" name="category" required>
                                        <option value="makanan" {{ $product->category == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                        <option value="minuman" {{ $product->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                        <option value="pembersih" {{ $product->category == 'pembersih' ? 'selected' : '' }}>Pembersih</option>
                                        <option value="lainnya" {{ $product->category == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Satuan Produk -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Satuan Produk {!! Template::required() !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <select class="form-control" name="unit" required>
                                        <option value="pcs" {{ $product->unit == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                        <option value="pack" {{ $product->unit == 'pack' ? 'selected' : '' }}>Pack</option>
                                        <option value="dos" {{ $product->unit == 'dos' ? 'selected' : '' }}>Dos</option>
                                        <option value="1/4" {{ $product->unit == '1/4' ? 'selected' : '' }}>1/4 kg</option>
                                    </select>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Harga {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Rp </span>
                                        </div>
                                        <input type="number" name="price" class="form-control" placeholder="*contoh: 4000"
                                            value="{{ $product->price }}" required>
                                    </div>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Stok {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="stock" class="form-control" placeholder="Stok"
                                        value="{{ $product->stock }}" required>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Berat (gram) -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Berat (gram) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="weight" class="form-control" placeholder="Masukan Berat (gram) *contoh: 10"
                                        value="{{ $product->weight }}">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Panjang -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Panjang (cm) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="length" class="form-control" placeholder="Masukan Panjang (cm) *contoh: 10"
                                        value="{{ $product->length }}">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Lebar -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Lebar (cm) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="width" class="form-control" placeholder="Masukan Lebar (cm) *contoh: 10"
                                        value="{{ $product->width }}">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Tinggi -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Tinggi (cm) </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="number" name="height" class="form-control" placeholder="Masukan Tinggi (cm) *contoh: 10"
                                        value="{{ $product->height }}">
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Deskripsi / Konten -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Deskripsi / Konten </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <textarea id="tiny" name="description">{!! $product->description !!}</textarea>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Foto Utama Produk -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Foto Utama Produk </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <img src="{{ $product->image ?? '#' }}" style="max-width: 300px; height: auto; {{ $product->image ? '' : 'display: none;' }} "
                                        class="image-preview mb-2">
                                    <input type="text" name="image" value="{{ $product->image }}" class="form-control image-url-input"
                                        placeholder="Masukan URL Gambar Produk" required>
                                    <small class="invalid-feedback"></small>
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p> Slug / SEO {!! Template::required() !!} </p>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input type="text" name="slug" class="form-control" placeholder="Slug / SEO"
                                        value="{{ $product->slug }}" required>
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
                clearInvalid();
                $form.find(`[name="title"]`).focus();
            }

            $form.on('submit', function(e) {
                e.preventDefault();
                clearInvalid();

                let formData = new FormData(this);
                formData.set('description', $form.find(`[name="description"]`).val());
                $submitBtn.ladda('start')

                ajaxSetup();
                $.ajax({
                        url: `{{ route('admin.product.update', $product->id) }}`,
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

            previewImageFromUrl('.image-url-input', '.image-preview');

            $form.find(`[name="id_product_type"]`).select2({
                'placeholder': '- Pilih Jenis Produk -'
            })

            $form.find(`[name="id_brand"]`).select2({
                'placeholder': '- Pilih Brand -'
            })

            $form.find(`[name="id_product_type"]`).val(`{{ $product->id_product_type }}`).trigger('change')
            $form.find(`[name="id_brand"]`).val(`{{ $product->id_brand }}`).trigger('change')
            $form.find(`[name="is_published"]`).val(`{{ $product->is_published }}`).trigger('change')

            resetForm();

        })
    </script>
@endsection
