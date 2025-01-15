@extends('layouts.buyer')

@section('content')

    <body class="bg-white">
        <div class="max-w-7xl mx-auto">
            {{-- header --}}
            <div class="rounded-lg shadow overflow-hidden">
                <div class="relative">
                    <img alt="Mountain landscape with a cloudy sky" class="w-full h-64 object-cover" height="400"
                        src="https://storage.googleapis.com/a1aa/image/Yx6LzL6ZliJlKZ9jBzO1kOhiqWYZye8vb92uvmkfRMzuIu5TA.jpg"
                        width="1200" />
                    <button class="absolute top-4 right-4 bg-black text-white px-4 py-2 rounded-full flex items-center">
                        <i class="fas fa-camera mr-2">
                        </i>
                        Edit Cover
                    </button>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2">
                        <img alt="Profile picture of a person" class="w-24 h-24 rounded-full border-4" height="100"
                            src="{{ asset('user-avatar.jpg') }}" width="100" />
                    </div>
                </div>
                <div class="text-center mt-16 mb-5">
                    <h1 class="text-2xl font-semibold mb-5">
                        {{ session('userData')->name }}
                    </h1>
                    <h1 class="text-sm lg:text-base text-gray-500 mb-5">
                        {{ session('userData')->email }}
                    </h1>
                </div>

                {{-- nav --}}
                <div class="">
                    <div
                        class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-8 py-4 px-4 text-sm md:text-base font-semibold">
                        <!-- Ganti Password -->
                        <button type="button" data-target="#content-password"
                            class="hidden md:inline-block nav-desktop border-b-4 text-indigo-600 border-indigo-600 pb-1 md:pb-0.5">
                            Ganti Password
                        </button>
                        <button type="button" data-target="#content-password"
                            class="md:hidden nav-mobile text-white bg-indigo-600 flex justify-center items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold shadow-sm">
                            Ganti Password
                            <i class="fas fa-edit ml-0.5"></i>
                        </button>

                        <!-- Riwayat Pembelian -->
                        <button type="button" data-target="#content-history"
                            class="hidden md:inline-block nav-desktop border-b-4 pb-1 md:pb-0.5">
                            Riwayat Pembelian
                        </button>
                        <button type="button" data-target="#content-history"
                            class="md:hidden nav-mobile text-white bg-gray-600 flex justify-center items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold shadow-sm">
                            Riwayat Pembelian
                            <i class="fas fa-history ml-0.5"></i>
                        </button>

                        <!-- Kritik Dan Saran -->
                        <button type="button" data-target="#content-feedback"
                            class="hidden md:inline-block nav-desktop border-b-4 pb-1 md:pb-0.5">
                            Kritik Dan Saran
                        </button>
                        <button type="button" data-target="#content-feedback"
                            class="md:hidden nav-mobile text-white bg-gray-600 flex justify-center items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold shadow-sm">
                            Kritik Dan Saran
                            <i class="fas fa-thumbs-up ml-0.5"></i>
                        </button>
                    </div>

                </div>
            </div>
            <!-- Konten -->
            <div class="">

                {{-- ganti password --}}
                <div id="content-password" class="content rounded-md mt-4">
                    <div class="bg-white">
                        <div class="mx-auto max-w-xl px-4 py-10 sm:px-6">
                            <div class="max-w-xl">
                                <h1 id="your-orders-heading" class="text-xl font-bold tracking-tight text-gray-900">Ganti
                                    Password</h1>
                            </div>

                            <form id="formChangePassword">
                                <div class="mt-5 grid grid-cols-1 relative">
                                    <input type="password" name="password" id="password"
                                        class="block w-full rounded-md bg-white py-3 pl-10 pr-3 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:pl-9 text-sm lg:text-base"
                                        placeholder="Masukkan Password Baru Anda">
                                    <i
                                        class="fas fa-edit pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 size-5"></i>
                                </div>
                                <div class="flex justify-center mt-5 lg:mt-11 mb-16">
                                    <button type="submit"
                                        class="rounded-md m-auto bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Ganti Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- riwayat pembelian --}}
                <div id="content-history" class="hidden content rounded-md mt-4">
                    <div class="bg-white">
                        <div class="max-w-7xl mx-auto">
                            {{-- riwayat pembelian --}}
                            <div class="rounded-md">
                                <div class="bg-white">
                                    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
                                        <div class="max-w-xl">
                                            <h1 id="your-orders-heading"
                                                class="text-xl font-bold tracking-tight text-gray-900">
                                                {{ $title }}</h1>
                                        </div>

                                        <div class="mt-8 space-y-16 lg:mt-10">
                                            {{-- @dd(
                                                \App\Models\Transaction::where('user_id', session('userData')->id)->with(['user', 'seller', 'items.product'])->orderBy('created_at', 'asc')->get()
                                            ) --}}
                                            @forelse (\App\Models\Transaction::where('user_id', session('userData')->id)->with(['user', 'seller', 'items.product'])->orderBy('created_at', 'desc')->get() as $index => $transaction)
                                                <div aria-labelledby="">
                                                    <div
                                                        class="space-y-1 md:flex md:items-baseline md:space-x-4 md:space-y-0">
                                                        <div class="flex justify-between items-center">
                                                            <h2 id=""
                                                                class="text-lg font-medium text-gray-900 md:shrink-0">
                                                                #{{ $transaction->code_invoice }}</h2>
                                                            <span
                                                                class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                                                    {{ $transaction->status === 'success' ? 'bg-green-400/10 text-green-400 ring-green-400/30' : '' }}
                                                                    {{ $transaction->status === 'pending' ? 'bg-yellow-400/10 text-yellow-400 ring-yellow-400/30' : '' }}
                                                                    {{ $transaction->status === 'failed' ? 'bg-red-400/10 text-red-400 ring-red-400/30' : '' }}">
                                                                {{ $transaction->status }}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="space-y-5 sm:flex sm:items-baseline sm:justify-between sm:space-y-0 md:min-w-0 md:flex-1">
                                                            <p class="text-xs font-medium text-gray-500">
                                                                Dibeli Pada Tanggal
                                                                {{ $transaction->created_at->translatedFormat('d F Y, H:i') }}
                                                            </p>
                                                            <div class="flex text-sm font-medium">
                                                                <a href="{{ route('buyer.detail.order', $transaction->code_invoice) }}"
                                                                    class="text-indigo-600 hover:text-indigo-500">Detail
                                                                    Pembelian</a>
                                                                <div
                                                                    class="ml-4 border-l border-gray-200 pl-4 sm:ml-6 sm:pl-6">
                                                                    <a href="#" data-id="{{ $transaction->id }}"
                                                                        class="downloadInvoice text-indigo-600 hover:text-indigo-500">Download
                                                                        Invoice</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="-mb-3 flow-root divide-y divide-gray-200 ">
                                                        @foreach ($transaction->items->take(2) as $item)
                                                            <div class="py-6 border-b sm:flex">
                                                                <div
                                                                    class="flex space-x-4 sm:min-w-0 sm:flex-1 sm:space-x-6 lg:space-x-8">
                                                                    <img src="{{ $item->product->image }}"
                                                                        alt="Brass puzzle in the shape of a jack with overlapping rounded posts."
                                                                        class="size-20 flex-none rounded-md object-cover sm:size-48">
                                                                    <div class="min-w-0 flex-1 pt-1.5 sm:pt-0">
                                                                        <h3
                                                                            class="text-sm font-medium text-gray-900 line-clamp-1">
                                                                            {{ $item->product->name }}
                                                                        </h3>
                                                                        <p class="truncate text-sm text-gray-500">
                                                                            {{ $item->quantity }} x buah
                                                                        </p>
                                                                        <p class="mt-1 font-medium text-gray-900">
                                                                            {{ $item->product->priceFormatted() }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <!-- More products... -->
                                                    </div>
                                                    @if (count($transaction->items) > 2)
                                                        <div class="text-center mt-3">
                                                            <a href="{{ route('buyer.detail.order', $transaction->code_invoice) }}"
                                                                class="text-sm text-gray-500 hover:text-gray-700">
                                                                Produk Lainnya
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @empty
                                                <div
                                                    class="grid min-h-full place-items-center bg-white my-20 px-6 lg:px-8">
                                                    <div class="text-center">
                                                        <p class="text-base font-semibold text-indigo-600">404</p>
                                                        <h1
                                                            class="mt-4 text-balance text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                                            {{ $title }} Kamu Kosong</h1>
                                                        <div class="mt-10 flex items-center justify-center gap-x-6">
                                                            <a href="{{ route('buyer.index') }}"
                                                                class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold hover:text-white text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Lihat
                                                                Dan
                                                                Cari Produk</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- feedback --}}
                <div id="content-feedback" class="hidden content rounded-md mt-4">
                    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
                        <div class="text-center">
                            <p class="text-base font-semibold text-indigo-600">404</p>
                            <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
                                Page not found</h1>
                            <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Sorry, we couldn’t
                                find the page you’re looking for.</p>
                            <div class="mt-10 flex items-center justify-center gap-x-6">
                                <a href="{{ url('/') }}"
                                    class="rounded-md bg-indigo-600 hover:text-white px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go
                                    back home</a>
                                <a href="#" class="text-sm font-semibold text-gray-900">Contact support <span
                                        aria-hidden="true">&rarr;</span></a>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengatur warna aktif dan tidak aktif
            function setActive(button) {
                // Hapus kelas aktif dari semua tombol desktop dan mobile
                $('.nav-desktop').removeClass('text-indigo-600 border-indigo-600').addClass('text-gray-600');
                $('.nav-mobile').removeClass('bg-indigo-600').addClass('bg-gray-600');

                // Tambahkan kelas aktif ke tombol yang diklik
                $(button).hasClass('nav-desktop') ?
                    $(button).addClass('text-indigo-600 border-indigo-600').removeClass('text-gray-600') :
                    $(button).addClass('bg-indigo-600').removeClass('bg-gray-600');
            }

            $('button[data-target]').click(function() {
                // Sembunyikan semua konten terlebih dahulu
                $('.content').hide();

                // Tampilkan konten yang sesuai dengan tombol yang diklik
                let target = $(this).data('target');
                $(target).show();

                // Atur tombol aktif
                setActive(this);
            });
        });

        $(function() {

            const $formChangePassword = $('#formChangePassword');
            const $formChangePasswordSubmitBtn = $('#formChangePassword').find(`[type="submit"]`);
            const originalBtnText = $formChangePasswordSubmitBtn.text();

            $formChangePassword.on('submit', function(e) {
                e.preventDefault();
                $('.message-error').html('')

                const formData = $(this).serialize();
                $formChangePasswordSubmitBtn.prop('disabled', true).text(
                    'Loading...');

                ajaxSetup();
                $.ajax({
                        url: `{{ route('buyer.changePassword') }}`,
                        method: 'post',
                        data: formData,
                        dataType: 'json'
                    })
                    .done(response => {
                        alertTailwind('Berhasil!', response.success, 'success', 3000);
                        $formChangePasswordSubmitBtn.prop('disabled', false).text(
                            originalBtnText);
                    })
                    .fail(error => {
                        $formChangePasswordSubmitBtn.prop('disabled', false).text(
                            originalBtnText);
                        if (error.responseJSON) {
                            if (error.responseJSON.errors) {
                                const validationErrors = Object.values(error.responseJSON.errors)
                                    .map(errArray => errArray.join(
                                        '<br>'))
                                    .join('<br>');
                                alertTailwind('Pesan Validasi!', validationErrors, 'warning', 3000);
                            } else {
                                const errorMessage = error.responseJSON.message || error.responseJSON
                                    .details; //detailsnya nanti harus diganti jadi error
                                alertTailwind('Gagal!', errorMessage, 'error', 3000);
                            }
                        } else {
                            alertTailwind('Error!', 'An unexpected error occurred. Please try again.',
                                'error');
                        }
                    })
            })

        })
    </script>
@endsection
