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
            <a href="{{ route('admin.seller.index') }}" style="color: white">Kelola Penjual</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.seller.create') }}" style="color: white">Edit Penjual</a>
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
						<!-- Nama -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Nama {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <input type="text" value="{{ $seller->name }}" name="name" class="form-control" placeholder="Nama Penjual"
                                    required>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Nama Toko -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Nama Toko {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <input type="text" value="{{ $seller->shop_name }}" name="shop_name" class="form-control" placeholder="Nama Toko"
                                    required>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Email {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <input type="email" value="{{ $seller->email }}" name="email" class="form-control" placeholder="Email Penjual"
                                    required>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Nomor Hp -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Nomor Hp {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <input type="number" value="{{ $seller->no_hp }}" name="no_hp" class="form-control"
                                    placeholder="*contoh 62851613xxx" required>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Profit -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Profit/Laba {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" value="{{ $seller->profit }}" name="profit" class="form-control" placeholder="*contoh 3"
                                        required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> % </span>
                                    </div>
                                </div>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Password {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <input type="text" value="{{ $seller->password }}" name="password" class="form-control"
                                    placeholder="Masukan Password Penjual" required>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Status {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <select class="form-control" name="status" required>
                                    <option value="Buka" {{ $seller->status == 'Buka' ? 'selected' : '' }}>Buka</option>
                                    <option value="Tutup" {{ $seller->status == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                                    <option value="Blokir" {{ $seller->status == 'Blokir' ? 'selected' : '' }}>Blokir</option>
                                </select>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Lokasi/Alamat -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Lokasi/Alamat {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <textarea name="location" rows="7" cols="70" class="p-2" placeholder="Masukan alamat toko dengan lengkap" required>{{ $seller->location }}</textarea>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Gambar / Logo Toko -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Gambar / Logo Toko {!! Template::required() !!} </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <img src="#" style="max-width: 300px; height: auto; display: none;"
                                    class="image-preview mb-2">
                                <input type="file" name="image" class="form-control" accept="image/*" multiple
                                    data-allow-reorder="true" data-max-file-size="5MB" data-max-file="4">
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>
					</div>

                    <div class="card-footer row">
                        <div class="mr-3">
                            <a href="javascript:history.back()" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left mr-2"></i> Kembali</a>
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

<script>

	$(function(){

		$form = $('#form');
		$submitBtn = $form.find(`[type="submit"]`).ladda();

		const resetForm = () => {
			clearInvalid();
			$form.find(`[name="name"]`).focus();
		}

		$form.on('submit', function(e){
			e.preventDefault();
			clearInvalid();

			let formData = new FormData(this);
			formData.set('location', $form.find(`[name="location"]`).val());
			$submitBtn.ladda('start')

			ajaxSetup();
			$.ajax({
				url: `{{ route('admin.seller.update', $seller->id) }}`,
				method: 'post',
				dataType: 'json',
				data: formData,
				contentType : false,
				processData : false,
			})
			.done(response => {
				let { message } = response;
				successNotification('Berhasil', message)
				setTimeout(() => {
					window.location.href = `{{ route('admin.seller.index') }}`
				}, 1000)
			})
			.fail(error => {
				$submitBtn.ladda('stop')
				ajaxErrorHandling(error, $form)
			})
		})

		previewImageAfterChange({
			fieldSelector: `[name="image"]`,
			previewSelector: `.image-preview`,
			defaultSource: `{{ $seller->imageLink() }}`
		})

		resetForm();

	})

</script>
@endsection
