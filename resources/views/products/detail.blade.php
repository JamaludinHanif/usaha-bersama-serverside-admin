@extends('layouts.app')
@section('styles')
    <style>
        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 100px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }
    </style>
@endsection
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
            <a href="#" style="color: white">{{ $product->slug }}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Produk -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Nama Produk </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                : {{ $product->name }}
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>
                        <!-- Kategori Produk -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Kategori Produk </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                : {{ $product->category }}
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Satuan -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Satuan </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                : {{ $product->unit }}
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Harga </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    </div>
                                    : {{ $product->priceFormatted() }}
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
                                : {{ $product->stock }}
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
                                : {{ $product->weight }}
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
                                : {{ $product->length }}
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
                                : {{ $product->width }}
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
                                : {{ $product->height }}
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Deskripsi / Konten -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Deskripsi / Konten </p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="" style="overflow-y: scroll; height: 200px; border: 1.5px solid #ccc;border-radius: 5px;padding: 10px">
                                    {!! $product->description !!}
                                </div>
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                        <!-- Foto Utama Produk -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <p class="mb-0"> Foto Utama Produk</p>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <img src="{{ $product->image }}" style="max-width: 300px; height: auto;" class="thumbnail">
                                <small class="invalid-feedback"></small>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer">
                    <div class="">
                        <a href="javascript:history.back()" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
