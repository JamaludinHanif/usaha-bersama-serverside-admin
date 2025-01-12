@extends('layouts.buyer')

@section('content')
    <div class="bg-white pb-14 pt-5">
        <div class="mx-auto max-w-2xl my-4 lg:my-10 px-4 sm:px-6 lg:px-0">
            <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>

            <form class="mt-10 lg:mt-15">
                <div aria-labelledby="cart-heading">
                    <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                    <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                        @forelse ($items as $item)
                            <li class="flex py-6">
                                <div class="shrink-0">
                                    <img src="{{ $item->product->image }}"
                                        alt="{{ $item->product->name }}"
                                        class="size-24 rounded-md object-cover sm:size-32">
                                </div>

                                <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                    <div>
                                        <div class="flex justify-between">
                                            <h4 class="text-sm w-10/12">
                                                <a href="#"
                                                    class="font-medium text-gray-700 hover:text-gray-800 line-clamp-2">{{ $item->product->name }}</a>
                                            </h4>
                                            {{-- <p class="ml-4 text-sm font-medium text-gray-900 lg:w-1/5 text-right">{{ $item->product->priceFormatted() }}</p> --}}
                                            <div class="">
                                                <div class="grid grid-cols-1">
                                                    <select id="quantity-{{ $item->product->id }}" name="quantity"
                                                        aria-label="Quantity" data-product-id="{{ $item->product->id }}"
                                                        class="item-quantity col-start-1 row-start-1 w-full appearance-none rounded-md bg-white lg:py-2 pl-1 pr-1 lg:pl-3 lg:pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                                        @for ($i = 1; $i <= 9; $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $i == $item->quantity ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <svg class="pointer-events-none hidden lg:block col-start-1 row-start-1 ml-1 size-3 lg:size-5 self-center justify-self-end text-gray-500"
                                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"
                                                        data-slot="icon">
                                                        <path fill-rule="evenodd"
                                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $item->product->category }}
                                        </p>
                                        <p class="item-price mt-1 text-sm text-gray-900 font-semibold">
                                            {{ $item->product->priceFormatted() }}
                                        </p>
                                    </div>

                                    <div class="mt-4 flex flex-1 items-end justify-between">
                                        <p class="flex items-center space-x-2 text-sm text-gray-700">
                                            <svg class="size-5 shrink-0 text-green-500" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd"
                                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>Stok ada</span>
                                        </p>
                                        <div class="ml-4">
                                            <button type="button" data-id="{{ $item->id }}"
                                                class="delete-from-cart text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="grid min-h-full place-items-center bg-white my-20 px-6 lg:px-8">
                                <div class="text-center">
                                    <p class="text-base font-semibold text-indigo-600">404</p>
                                    <h1
                                        class="mt-4 text-balance text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                        Keranjang Kamu Kosong</h1>
                                    <div class="mt-10 flex items-center justify-center gap-x-6">
                                        <a href="{{ route('buyer.index') }}"
                                            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold hover:text-white text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Lihat
                                            Dan
                                            Cari Produk</a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </ul>
                </div>

                <!-- Order summary -->
                @if ($items->isNotEmpty())
                    <div aria-labelledby="summary-heading"
                        class="mt-14 lg:mt-16 py-0 px-0 lg:py-5 lg:px-6 lg:border lg:rounded lg:shadow">
                        <div>
                            <dl class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-base font-medium text-gray-900">Subtotal</dt>
                                    <dd class="ml-4 text-base lg:text-lg font-semibold text-gray-900"> <span
                                            id="cart-total">Rp
                                            0</span></dd>
                                </div>
                            </dl>
                            <p class="mt-1 text-sm w-2/3 text-gray-500">*Ongkir dan pajak akan dihitung saat checkout.</p>
                        </div>

                        <div class="mt-10">
                            <a href="{{ route('buyer.buy.now')}}" class="w-full block text-center rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Checkout</a>
                        </div>

                        <div class="mt-6 text-center text-sm">
                            <p>
                                atau
                                <a href="{{ route('buyer.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Continue Shopping
                                    <span aria-hidden="true"> &rarr;</span>
                                </a>
                            </p>
                        </div>
                    </div>
                @else
                @endif
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateCartTotal() {
            let total = 0;

            $('li').each(function() {
                let priceText = $(this).find('.item-price').text();
                // Ubah harga ke format angka: hapus 'Rp.', koma sebagai pemisah ribuan, dan titik desimal
                let price = parseFloat(priceText.replace(/Rp\.|\./g, '').replace(/,/g,
                    '')); // Ambil jumlah item (pastikan elemen select memiliki kelas 'item-quantity')
                let quantity = parseInt($(this).find('.item-quantity').val());

                // Tambahkan harga item ke total
                if (!isNaN(price) && !isNaN(quantity)) {
                    total += price * quantity;
                }
            });

            $('#cart-total').text(`Rp ${total.toLocaleString('id-ID')}`);
        }

        // Panggil fungsi saat halaman dimuat
        $(document).ready(function() {
            updateCartTotal();
        });

        // fungsi jika jumlah item berubah
        $(document).on('change', '.item-quantity', function() {
            updateCartTotal();

            let quantity = parseInt($(this).val(), 10);
            let productId = $(this).data('product-id');

            ajaxSetup();
            $.ajax({
                    url: `{{ route('buyer.cart.updateQuantity') }}`,
                    method: 'post',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                    },
                })
                .done(response => {
                    // alertTailwind('Berhasil!', response.success, 'success', 3000);
                })
                .fail(error => {
                    if (error.responseJSON) {
                        const errorMessage = error.responseJSON.message || error.responseJSON.details;
                        alertTailwind('Gagal!', errorMessage, 'error', 3000);
                        if (error.responseJSON.errors) {
                            const validationErrors = Object.values(error.responseJSON.errors)
                                .map(errArray => errArray.join('<br>'))
                                .join('<br>');
                            alertTailwind('Pesan Validasi!', validationErrors, 'warning', 3000);
                        }
                    } else {
                        alertTailwind('Error!', 'An unexpected error occurred. Please try again.', 'error',
                            3000);
                    }
                });
        });

        // hapus produk
        $(function() {
            const $deleteFromCart = $('.delete-from-cart');
            $deleteFromCart.on('click', function(e) {
                e.preventDefault();
                let cartId = $(this).data('id');
                let listItem = $(this).closest('li');

                ajaxSetup();
                $.ajax({
                        url: `{{ route('buyer.cart.remove', ['id' => '__cartId__']) }}`.replace(
                            '__cartId__', cartId),
                        method: 'DELETE',
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
                        if ($('li').length === 2) {
                            location.reload();
                        } else {
                            listItem.remove();
                        }
                        updateCartTotal();
                        updateCartBadge(response.cartCount);
                    })
                    .fail(error => {
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
            });
        });
    </script>
@endsection
