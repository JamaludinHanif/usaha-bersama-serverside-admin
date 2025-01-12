@extends('layouts.seller')
@section('content')
    <div class="p-3">
        <h3 class="text-base font-semibold text-gray-900">Hallo{{ session('userData')->name }}</h3>
        <div>
            <div class="mt-2 grid grid-cols-1">
                <select id="status" name="status"
                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    <option {{ $data->status == 'Buka' ? 'selected' : '' }} value="Buka">Buka</option>
                    <option {{ $data->status == 'Tutup' ? 'selected' : '' }} value="Tutup">Tutup</option>
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                    viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd"
                        d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>


        <dl class="my-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            {{-- total pesanan hari ini --}}
            <div class="relative overflow-hidden rounded-lg bg-white border px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute rounded-md bg-indigo-500 p-3">
                        <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Total pesanan *hari ini</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-xl font-semibold text-gray-900">
                        {{ \App\Models\Transaction::where('seller_id', session('userData')->id)->whereDate('created_at', now())->count() }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('seller.order') }}"
                                class="font-medium text-indigo-600 hover:text-indigo-500">Lihat Semua</a>
                        </div>
                    </div>
                </dd>
            </div>
            {{-- total pesanan --}}
            <div class="relative overflow-hidden rounded-lg bg-white border px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute rounded-md bg-sky-500 p-3">
                        <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                        </svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Total transaksi terselesaikan</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-xl font-semibold text-gray-900">
                        {{ \App\Models\Transaction::where('seller_id', session('userData')->id)->where('status', 'success')->count() }}
                    </p>
                    {{-- <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
                        <svg class="size-5 shrink-0 self-center text-red-500" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M10 3a.75.75 0 0 1 .75.75v10.638l3.96-4.158a.75.75 0 1 1 1.08 1.04l-5.25 5.5a.75.75 0 0 1-1.08 0l-5.25-5.5a.75.75 0 1 1 1.08-1.04l3.96 4.158V3.75A.75.75 0 0 1 10 3Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only"> Decreased by </span>
                    </p> --}}
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        <svg class="size-5 shrink-0 self-center text-green-500" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only"> Increased by </span>
                        {{ \App\Models\Transaction::where('seller_id', session('userData')->id)->where('status', 'success')->whereDate('created_at', now())->count() }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('seller.order') }}"
                                class="font-medium text-indigo-600 hover:text-indigo-500">Lihat Semua</a>
                        </div>
                    </div>
                </dd>
            </div>
            {{-- total pendapatan hari ini --}}
            <div class="relative overflow-hidden rounded-lg bg-white border px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute rounded-md bg-orange-500 p-3">
                        <p class="size-6 text-xl text-center block font-bold text-white">$</p>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Total pendapatan *hari ini</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-xl font-semibold text-gray-900">
                        {{ 'Rp ' .number_format(\App\Models\Transaction::where('seller_id', session('userData')->id)->where('status', 'success')->whereDate('created_at', now())->sum('amount'),0,',','.') }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('seller.order') }}"
                                class="font-medium text-indigo-600 hover:text-indigo-500">Lihat Semua</a>
                        </div>
                    </div>
                </dd>
            </div>
            {{-- total pendapatan --}}
            <div class="relative overflow-hidden rounded-lg bg-white border px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute rounded-md bg-green-500 p-3">
                        <p class="size-6 text-xl text-center block font-bold text-white">$</p>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Total pendapatan</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-xl font-semibold text-gray-900">
                        {{ 'Rp ' .number_format(\App\Models\Transaction::where('seller_id', session('userData')->id)->where('status', 'success')->sum('amount'),0,',','.') }}
                    </p>
                    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                        <svg class="size-5 shrink-0 self-center text-green-500" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only"> Increased by </span>
                        {{ 'Rp ' .number_format(\App\Models\Transaction::where('seller_id', session('userData')->id)->where('status', 'success')->whereDate('created_at', now())->sum('amount'),0,',','.') }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('seller.order') }}"
                                class="font-medium text-indigo-600 hover:text-indigo-500">Lihat Semua</a>
                        </div>
                    </div>
                </dd>
            </div>
        </dl>
    </div>
@endsection
@section('script')
<script>
    $(document).on('change', '#status', function() {
        const formData = {
            status: $(this).val() // Ambil nilai dari select
        };

        ajaxSetup();

        $.ajax({
            url: `{{ route('seller.change.status') }}`, // Endpoint server
            method: 'POST', // Gunakan POST untuk mengubah status
            data: formData, // Kirim data sebagai objek
            dataType: 'json'
        })
        .done(response => {
            // Tampilkan pesan sukses
            alertTailwind('Berhasil!', response.message, 'success');

            // Reload halaman setelah 1.5 detik
            setTimeout(() => {
                location.href = `{{ route('seller.index') }}`;
            }, 1500);
        })
        .fail(error => {
            // Tangani validasi atau error lainnya
            if (error.responseJSON) {
                if (error.responseJSON.errors) {
                    const validationErrors = Object.values(error.responseJSON.errors)
                        .map(errArray => errArray.join('<br>'))
                        .join('<br>');
                    alertTailwind('Pesan Validasi!', validationErrors, 'warning');
                } else {
                    const errorMessage = error.responseJSON.message || error.responseJSON.details;
                    alertTailwind('Gagal!', errorMessage, 'error');
                }
            } else {
                alertTailwind('Error!', 'An unexpected error occurred. Please try again.', 'error');
            }
        });
    });
</script>

@endsection
