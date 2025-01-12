@extends('layouts.seller')
@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-2xl px-4 pb-24 pt-10 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Checkout</h2>

            <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16" id="formCheckout">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Pilih Toko Pembelian</h2>
                    <div class="mt-4">
                        <div class="overflow-y-auto border rounded-xl">
                            <div
                                class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black/5 transition-all">
                                <div class="grid grid-cols-1">
                                    <input type="text"
                                        class="col-start-1 row-start-1 h-12 w-full pl-11 pr-4 text-sm text-gray-900 outline-none placeholder:text-gray-400 placeholder:text-sm"
                                        placeholder="Cari Nama Toko atau Lokasi Toko..." id="search-box" role="combobox"
                                        aria-expanded="false" aria-controls="options">
                                    <input type="hidden" name="seller_id" id="seller-id">
                                    <svg class="pointer-events-none col-start-1 row-start-1 ml-4 size-5 self-center text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <ul class="max-h-96 transform-gpu scroll-py-3 overflow-y-auto p-3 hidden"
                                    id="search-results" role="listbox">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order summary -->
                <div class="mt-8 pt-2 border-t border-gray-200 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">Detail Pembelian</h2>
                    <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach ($products as $index => $product)
                                <li class="flex px-4 py-6 sm:px-6">
                                    <input type="hidden" name="data[{{ $index }}][product_id]"
                                        value="{{ $product->id }}">
                                    <div class="shrink-0">
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-20 rounded-md">
                                    </div>

                                    <div class="ml-6 flex flex-1 flex-col">
                                        <div class="">
                                            <h4 class="text-sm">
                                                <a href="#"
                                                    class="font-medium text-gray-700 hover:text-gray-800 line-clamp-2 lg:line-clamp-3">{{ $product->name }}</a>
                                            </h4>
                                        </div>

                                        <div class="flex flex-1 items-end justify-between pt-2">
                                            <p class="item-price mt-1 text-sm font-medium text-gray-900">
                                                {{ $product->priceFormatted() }}</p>

                                            <div class="ml-4">
                                                <div class="grid grid-cols-1">
                                                    <select id="quantity" name="data[{{ $index }}][quantity]"
                                                        aria-label="Quantity"
                                                        class="item-quantity col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"
                                                        data-slot="icon">
                                                        <path fill-rule="evenodd"
                                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <!-- More products... -->
                        </ul>
                        <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $product->priceFormatted() }}</dd>
                            </div>
                            {{-- <div class="flex items-center justify-between">
                            <dt class="text-sm">Ongkir</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp. 22.000</dd>
                        </div> --}}
                            {{-- <div class="flex items-center justify-between">
                            <dt class="text-sm"> PPN (12%)</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp. 4.000</dd>
                        </div> --}}
                            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                <dt class="text-base font-medium">Total</dt>
                                <dd class="text-base font-medium text-gray-900" id="total-amount"></dd>
                            </div>
                        </dl>

                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <button type="submit"
                                class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Konfirmasi
                                Pesanan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
