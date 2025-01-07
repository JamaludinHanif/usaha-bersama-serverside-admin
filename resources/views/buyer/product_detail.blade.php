@extends('layouts.buyer')
@section('style')
@endsection
@section('content')
    <main id="main">
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 mt-5 lg:mt-10 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8 my-5 lg:my-10">
                    <!-- Image -->
                    <div class="flex flex-col-reverse">
                        <!-- Image -->
                        <div class="mx-auto mt-6 hidden w-full max-w-2xl sm:block lg:max-w-none">
                            <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                                <button id="tabs-1-tab-1"
                                    class="relative flex h-24 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium uppercase text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring focus:ring-indigo-500/50 focus:ring-offset-4"
                                    aria-controls="tabs-1-panel-1" role="tab" type="button">
                                    <span class="sr-only">Angled view</span>
                                    <span class="absolute inset-0 overflow-hidden rounded-md">
                                        <img src="{{ $product->image }}" alt=""
                                            class="size-full object-cover">
                                    </span>
                                    <!-- Selected: "ring-indigo-500", Not Selected: "ring-transparent" -->
                                    <span
                                        class="pointer-events-none absolute inset-0 rounded-md ring-2 ring-transparent ring-offset-2"
                                        aria-hidden="true"></span>
                                </button>

                                <!-- More images... -->
                            </div>
                        </div>

                        <div>
                            <!-- Tab panel, show/hide based on tab state. -->
                            <div id="tabs-1-panel-1" aria-labelledby="tabs-1-tab-1" role="tabpanel" tabindex="0">
                                <img src="{{ $product->image }}"
                                    alt="Angled front view with bag zipped and handles upright."
                                    class="aspect-square w-full object-cover sm:rounded-lg">
                            </div>

                            <!-- More images... -->
                        </div>
                    </div>

                    <!-- Product info -->
                    <div class="mt-10 sm:mt-16 sm:px-0 lg:mt-0">
                        <h1 class="lg:text-2xl text-lg font-semibold tracking-tight text-gray-900">
                            {{ $product->name }}</h1>
                        <div class="mt-3">
                            <span
                                class="inline-flex items-center rounded-md bg-indigo-400/10 px-2 py-1 text-xs font-medium text-indigo-400 ring-1 ring-inset ring-indigo-400/30">{{ $product->category }}</span>
                            <span
                                class="inline-flex items-center rounded-md bg-green-400/10 px-2 py-1 text-xs font-medium text-green-400 ring-1 ring-inset ring-green-400/30">{{ $product->unit }}</span>
                        </div>

                        <div class="mt-3">
                            <h2 class="sr-only">Product information</h2>
                            <p class="lg:text-xl text-base font-bold tracking-tight text-gray-900">
                                {{ $product->priceFormatted() }}</p>
                        </div>

                        <div class="mt-3">
                            <div class="lg:flex">
                                <button type="button" id="add-to-cart"
                                    class="flex w-full lg:w-4/12 mr-5 mb-3 lg:mb-0 text-xs items-center justify-center rounded-md border border-transparent bg-yellow-500 px-3 py-2 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                                    <li class="fas fa-shopping-cart mr-1"></li> Tambahkan Ke
                                    Keranjang
                                </button>
                                <div class="w-full lg:w-4/12">
                                    <a href="{{ route('buyer.buy.now',['product'=>$product->slug]) }}"
                                        class="flex w-full text-xs items-center justify-center rounded-md border border-transparent bg-indigo-600 hover:text-white px-3 py-2 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                                        <li class="fas fa-shopping-bag mr-1"></li> Beli Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div aria-labelledby="details-heading" class="mt-3">
                            <h2 id="details-heading" class="sr-only">Additional details</h2>

                            <div class="divide-y divide-gray-200 border-t">
                                <div>
                                    <h3>
                                        <button type="button"
                                            class="group relative flex w-full items-center justify-between py-6 text-left detail-produk"
                                            aria-controls="disclosure-1" aria-expanded="false">
                                            <span class="text-sm font-medium text-gray-900">Deskripsi</span>
                                            <span class="ml-6 flex items-center">
                                                <svg class="hidden size-6 text-gray-400 group-hover:text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                                <svg class="block size-6 text-indigo-400 group-hover:text-indigo-500"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pb-6 block" id="disclosure-1">
                                        <div class="post-content overflow-y-auto max-h-64 text-sm text-gray-700">
                                            {!! $product->description !!}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h3>
                                        <button type="button"
                                            class="group relative flex w-full items-center justify-between py-6 text-left detail-produk"
                                            aria-controls="disclosure-2" aria-expanded="false">
                                            <span class="text-sm font-medium text-gray-900">Spesifikasi</span>
                                            <span class="ml-6 flex items-center">
                                                <svg class="hidden size-6 text-gray-400 group-hover:text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                                <svg class="block size-6 text-indigo-400 group-hover:text-indigo-500"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pb-6 block" id="disclosure-2">
                                        <ul role="list"
                                            class="list-disc space-y-1 pl-5 text-sm text-gray-700 marker:text-gray-300">
                                            <li class="pl-2">Kategori : <span
                                                    class="font-semibold">{{ $product->category }}</span></li>
                                            <li class="pl-2">Satuan : <span
                                                    class="font-semibold">{{ $product->unit }}</span></li>
                                            <li class="pl-2">Berat : <span
                                                    class="font-semibold">{{ $product->weight }}</span> Gram</li>
                                            <li class="pl-2">Panjang : <span
                                                    class="font-semibold">{{ $product->length }}</span> Cm</li>
                                            <li class="pl-2">Tinggi : <span
                                                    class="font-semibold">{{ $product->height }}</span> Cm</li>
                                            <li class="pl-2">Lebar : <span
                                                    class="font-semibold">{{ $product->width }}</span> Cm</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('script')
    <script src="{{ url('js/jquery.min.js') }}"></script>
    <script src="{{ url('vendors/photoswipe/PhotoSwipe/photoswipe.min.js') }}"></script>
    <script src="{{ url('vendors/photoswipe/PhotoSwipe/photoswipe-ui-default.min.js') }}"></script>
    <script src="{{ url('vendors/photoswipe/jqPhotoSwipe.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $(".image").jqPhotoSwipe({
                galleryOpen: function(gallery) {
                    gallery.toggleDesktopZoom();
                }
            });
        })
    </script>
    <script>
        // untuk deskripsi dan spesifikasi
        $(document).ready(function() {
            // // Handle button click
            $('.detail-produk').on('click', function() {
                var $button = $(this);
                var targetId = $button.attr('aria-controls');
                var $target = $('#' + targetId);

                // Toggle aria-expanded attribute
                var isExpanded = $button.attr('aria-expanded') === 'true';
                $button.attr('aria-expanded', !isExpanded);

                // Toggle visibility of the target content
                $target.slideToggle();

                // Toggle icons visibility
                $button.find('svg').toggleClass('hidden block');
            });
        });
    </script>
    <script>
        // tambahkan ke keranjang
        $(function() {

            const $addToCart = $('#add-to-cart');
            const originalBtnText = $addToCart.html(); // Simpan teks asli tombol

            $addToCart.on('click', function(e) {
                e.preventDefault();
                @if (session('userData'))

                    $addToCart.prop('disabled', true).text(
                        'Menambahkan Ke Keranjang...');

                    ajaxSetup();
                    $.ajax({
                            url: `{{ route('buyer.cart.store') }}`,
                            method: 'post',
                            data: {
                                product_id: {{ $product->id }},
                                quantity: 1,
                            }
                        })
                        .done(response => {
                            if (response.success) {
                                alertTailwind('Berhasil!',
                                    response.success, 'success', 3000
                                );
                            } else {
                                alertTailwind('Info!',
                                    response.info, 'info', 3000
                                );
                            }
                            updateCartBadge(response.cartCount);
                            $addToCart.prop('disabled', false).html(originalBtnText);
                        })
                        .fail(error => {
                            $addToCart.prop('disabled', false).html(originalBtnText);
                            if (error.responseJSON) {
                                const errorMessage = error.responseJSON.message || error.responseJSON
                                    .details;
                                alertTailwind('Gagal!', errorMessage, 'error', 3000);
                                if (error.responseJSON.errors) {
                                    const validationErrors = Object.values(error.responseJSON.errors)
                                        .map(errArray => errArray.join('<br>'))
                                        .join('<br>');
                                    alertTailwind('Pesan Validasi!', validationErrors, 'warning', 3000);
                                }
                            } else {
                                alertTailwind('Error!',
                                    'An unexpected error occurred. Please try again.',
                                    'error', 3000);
                            }
                        });
                @else
                    alertTailwind('Peringatan!',
                        'Aktifitas tidak dapat dilanjutkan, silahkan login terlebih dahulu', 'warning',
                        3000
                    );
                @endif

            });

        });
    </script>
@endsection
