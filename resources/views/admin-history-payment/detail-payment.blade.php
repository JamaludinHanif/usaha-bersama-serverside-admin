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
            <a href="/admin/transaction/transaction" style="color: white">Transaksi</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="/admin/transaction/transaction" style="color: white">Riwayat Pembayaran</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="#" style="color: white">Detail Pembayaran</a>
        </li>
    </ul>
@endsection

@section('content')
    @php
        $totalHutang =
            $datas->transaction->total_amount + ($datas->transaction->total_amount * $datas->interest->interest) / 100;
    @endphp
    {{-- @dd($datas) --}}
    <div class="container my-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Detail Transaksi</h4>
            </div>
            <div class="card-body text">
                <!-- Informasi Transaksi -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>
                                    <span class="mx-2">ID Transaksi</span>
                                </td>
                                <td>: <span class="fw-bold mx-1">#{{ $datas->transaction->kode_invoice }}</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="mx-2">Tanggal</span>
                                </td>
                                <td>: <span class="fw-bold mx-1">{{ $datas->created_at->format('d-m-Y (H:i:s)') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Type</span></td>
                                <td>: <span
                                        class="badge text-white fw-bold mx-1 {{ $datas->type == 'paylater' ? 'bg-warning' : ($datas->type == 'cash' || $datas->type == 'tunai' ? 'bg-success' : 'bg-info') }}">
                                        {{ $datas->type }}
                                    </span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Kode Pembayaran</span></td>
                                <td>: <span class="fw-bold mx-1">{{ $datas->code }}</span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Dikonfirmasi oleh</span></td>
                                <td>: <span class="fw-bold mx-1">{{ $datas->cashier->name ?? 'belum dikonfirmasi' }}
                                        ({{ $datas->cashier->role ?? '-' }})</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td><span class="mx-2">Nama Pelanggan</span></td>
                                <td>: <span class="fw-bold mx-1">{{ $datas->user->name }}</span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Status</span></td>
                                <td>: <span
                                        class="badge text-white fw-bold mx-1 {{ $datas->status == 'pending' ? 'bg-warning' : ($datas->status == 'success' ? 'bg-success' : 'bg-danger') }}">
                                        {{ $datas->status }}
                                    </span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Invoice/Nota</span></td>
                                <td>: <span class="fw-bold mx-1"><a
                                            href="{{ url('/api/export-invoice') .
                                                '?' .
                                                http_build_query([
                                                    'userId' => session('userData')->id,
                                                    'payment_id' => $datas->id,
                                                    'type' => 'I',
                                                ]) }}">
                                            Download Invoice
                                        </a>
                                    </span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Detail Transaksi</span></td>
                                <td>: <span class="badge text-white fw-bold mx-1 bg-primary"><a
                                            href="{{ route('transaction.detail', $datas->transaction->id) }}"
                                            style="color: white">Klik ini</a></span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Sisa Hutang</span></td>
                                <td>: <span class="fw-bold mx-1">Rp.
                                        {{ number_format($totalHutang - $datas->amount, 0, ',', '.') }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($datas->type !== 'paylater')
                    <p class="fw-bold my-5" style="text-align: center;font-size: 1.5rem">
                        Total Pembayaran : Rp. {{ number_format($datas->amount, 0, ',', '.') }}
                    </p>
                @else
                    <p class="fw-bold my-5" style="text-align: center;font-size: 1.5rem">
                        Total Tagihan : Rp.
                        {{ number_format($totalHutang, 0, ',', '.') }}
                    </p>
                @endif
                {{-- @endif --}}

                <!-- Tombol Aksi -->
                <div class="" style="margin-top: 50px">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
