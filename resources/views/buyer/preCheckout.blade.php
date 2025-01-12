@extends('layouts.buyer')

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


                    {{-- <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div>
                                <label for="first-name" class="block text-sm/6 font-medium text-gray-700">First name</label>
                                <div class="mt-2">
                                    <input type="text" id="first-name" name="first-name" autocomplete="given-name"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div>
                                <label for="last-name" class="block text-sm/6 font-medium text-gray-700">Last name</label>
                                <div class="mt-2">
                                    <input type="text" id="last-name" name="last-name" autocomplete="family-name"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="company" class="block text-sm/6 font-medium text-gray-700">Company</label>
                                <div class="mt-2">
                                    <input type="text" name="company" id="company"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm/6 font-medium text-gray-700">Address</label>
                                <div class="mt-2">
                                    <input type="text" name="address" id="address" autocomplete="street-address"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="apartment" class="block text-sm/6 font-medium text-gray-700">Apartment, suite,
                                    etc.</label>
                                <div class="mt-2">
                                    <input type="text" name="apartment" id="apartment"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div>
                                <label for="city" class="block text-sm/6 font-medium text-gray-700">City</label>
                                <div class="mt-2">
                                    <input type="text" name="city" id="city" autocomplete="address-level2"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div>
                                <label for="country" class="block text-sm/6 font-medium text-gray-700">Country</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="country" name="country" autocomplete="country-name"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        <option>United States</option>
                                        <option>Canada</option>
                                        <option>Mexico</option>
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <label for="region" class="block text-sm/6 font-medium text-gray-700">State /
                                    Province</label>
                                <div class="mt-2">
                                    <input type="text" name="region" id="region" autocomplete="address-level1"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div>
                                <label for="postal-code" class="block text-sm/6 font-medium text-gray-700">Postal
                                    code</label>
                                <div class="mt-2">
                                    <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm/6 font-medium text-gray-700">Phone</label>
                                <div class="mt-2">
                                    <input type="text" name="phone" id="phone" autocomplete="tel"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- metode pengiriman --}}
                    {{-- <div class="mt-10 border-t border-gray-200 pt-10">
                        <fieldset>
                            <legend class="text-lg font-medium text-gray-900">Metode Pengiriman</legend>
                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <label aria-label="Standard" aria-description="4–10 business days for $5.00"
                                    class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                    <input type="radio" name="delivery-method" value="Standard" class="sr-only">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm lg:text-base font-semibold text-gray-900">Si Sepat
                                                Reguler</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">Estimasi 4-5
                                                hari</span>
                                            <span class="mt-6 text-sm lg:text-base font-semibold text-gray-900">Rp.
                                                20.000</span>
                                        </span>
                                    </span>
                                    <svg class="size-5 text-indigo-600 hidden" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="pointer-events-none absolute -inset-px rounded-lg border-2"
                                        aria-hidden="true"></span>
                                </label>
                                <label aria-label="Express" aria-description="2–5 business days for $16.00"
                                    class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                    <input type="radio" name="delivery-method" value="Express" class="sr-only">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm lg:text-base font-semibold text-gray-900">J&E
                                                Express</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">Estimasi 2–5
                                                hari</span>
                                            <span class="mt-6 text-sm lg:text-base font-semibold text-gray-900">Rp.
                                                22.500</span>
                                        </span>
                                    </span>
                                    <svg class="size-5 text-indigo-600 hidden" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="pointer-events-none absolute -inset-px rounded-lg border-2"
                                        aria-hidden="true"></span>
                                </label>
                            </div>
                        </fieldset>
                    </div> --}}

                    <!-- Payment 2 -->
                    {{-- <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Payment</h2>

                        <fieldset class="mt-4">
                            <legend class="sr-only">Payment type</legend>
                            <div class="space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                                <div class="flex items-center">
                                    <input id="credit-card" name="payment-type" type="radio" checked
                                        class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden [&:not(:checked)]:before:hidden">
                                    <label for="credit-card" class="ml-3 block text-sm/6 font-medium text-gray-700">Credit
                                        card</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="paypal" name="payment-type" type="radio"
                                        class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden [&:not(:checked)]:before:hidden">
                                    <label for="paypal"
                                        class="ml-3 block text-sm/6 font-medium text-gray-700">PayPal</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="etransfer" name="payment-type" type="radio"
                                        class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden [&:not(:checked)]:before:hidden">
                                    <label for="etransfer"
                                        class="ml-3 block text-sm/6 font-medium text-gray-700">eTransfer</label>
                                </div>
                            </div>
                        </fieldset>

                        <div class="mt-6 grid grid-cols-4 gap-x-4 gap-y-6">
                            <div class="col-span-4">
                                <label for="card-number" class="block text-sm/6 font-medium text-gray-700">Card
                                    number</label>
                                <div class="mt-2">
                                    <input type="text" id="card-number" name="card-number" autocomplete="cc-number"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div class="col-span-4">
                                <label for="name-on-card" class="block text-sm/6 font-medium text-gray-700">Name on
                                    card</label>
                                <div class="mt-2">
                                    <input type="text" id="name-on-card" name="name-on-card" autocomplete="cc-name"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div class="col-span-3">
                                <label for="expiration-date" class="block text-sm/6 font-medium text-gray-700">Expiration
                                    date (MM/YY)</label>
                                <div class="mt-2">
                                    <input type="text" name="expiration-date" id="expiration-date"
                                        autocomplete="cc-exp"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div>
                                <label for="cvc" class="block text-sm/6 font-medium text-gray-700">CVC</label>
                                <div class="mt-2">
                                    <input type="text" name="cvc" id="cvc" autocomplete="csc"
                                        class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
{{-- @dd($datas) --}}
                <!-- Order summary -->
                <div class="mt-8 pt-2 border-t border-gray-200 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">Detail Pembelian</h2>
                    <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach ($datas as $index => $data)
                                <li class="flex px-4 py-6 sm:px-6">
                                    <input type="hidden" name="data[{{ $index }}][product_id]"
                                        value="{{ $data['product']->id }}">
                                    <div class="shrink-0">
                                        <img src="{{ $data['product']->image }}" alt="{{ $data['product']->name }}"
                                            class="w-20 rounded-md">
                                    </div>

                                    <div class="ml-6 flex flex-1 flex-col">
                                        <div class="">
                                            <h4 class="text-sm">
                                                <a href="#"
                                                    class="font-medium text-gray-700 hover:text-gray-800 line-clamp-2 lg:line-clamp-3">{{ $data['product']->name }}</a>
                                            </h4>
                                        </div>

                                        <div class="flex flex-1 items-end justify-between pt-2">
                                            <p class="item-price mt-1 text-sm font-medium text-gray-900">
                                                {{ $data['product']->priceFormatted() }}</p>

                                            <div class="ml-4">
                                                <div class="grid grid-cols-1">
                                                    <select id="quantity" name="data[{{ $index }}][quantity]"
                                                        aria-label="Quantity"
                                                        class="item-quantity col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $data['quantity'] == $i ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
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
                                <dd class="text-sm font-medium text-gray-900">{{ $data['product']->priceFormatted() }}</dd>
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

@section('script')
    <script>
        $(document).ready(function() {
            const $labels = $('label[aria-label]');

            // Fungsi untuk menghapus kelas aktif dan sembunyikan SVG centang
            function resetLabels() {
                $labels.removeClass('border-indigo-500 ring-2 ring-indigo-500');
                $labels.find('svg').addClass('hidden'); // Sembunyikan SVG
            }

            // Event listener untuk setiap input radio di dalam label
            $labels.on('click', function() {
                resetLabels();
                $(this).addClass('border-indigo-500 ring-2 ring-indigo-500');
                $(this).find('svg').removeClass('hidden'); // Tampilkan SVG centang
            });

            let selectedShop = null;

            $('#search-box').on('keyup', function() {
                const query = $(this).val().trim();
                const searchResults = $('#search-results');

                if (!query) {
                    searchResults.html('').hide();
                    return; // Keluar dari fungsi jika input kosong
                }

                searchResults.show();

                $.ajax({
                    url: '{{ route('buyer.seller.search') }}',
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#search-results').html('');
                        const baseUrlImg = '{{ url('storage/image/seller/') }}';
                        if (data.length > 0) {
                            data.forEach(seller => {
                                $('#search-results').append(`
                                    <li class="group flex cursor-pointer hover:opacity-75 select-none rounded-xl p-3"
                                        role="option" data-shop='${JSON.stringify(seller)}'>
                                        <div
                                            class="">
                                            <img class="flex size-10 flex-none object-cover items-center justify-center rounded-lg" src="${baseUrlImg}/${seller.image}">
                                        </div>
                                        <div class="ml-4 flex-auto">
                                            <p class="text-sm font-medium text-gray-700">${seller.shop_name}</p>
                                            <p class="text-xs text-gray-500 line-clamp-1">${seller.location}</p>
                                        </div>
                                    </li>
                                `);
                            });

                        } else {
                            $('#search-results').html(
                                `<div class="px-5 py-5 text-center text-sm">
                                    <svg class="mx-auto size-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    <p class="mt-4 font-semibold text-gray-900">No results found</p>
                                    <p class="mt-2 text-gray-500">Cari nama toko lain atau lokasi yang kamu tuju</p>
                                </div>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $(document).on('click', '#search-results li', function() {
                const sellerData = $(this).data('shop');
                selectedShop = sellerData;
                $('#search-box').val(sellerData.shop_name);
                $('#seller-id').val(sellerData.id);
                $('#search-results').hide();
            });
        });

        // counting total
        function updateTotal() {
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

            $('#total-amount').text(`Rp ${total.toLocaleString('id-ID')}`);
        }

        // Panggil fungsi saat halaman dimuat
        $(document).ready(function() {
            updateTotal();
        });

        // fungsi jika jumlah item berubah
        $(document).on('change', '.item-quantity', function() {
            updateTotal();
        })


        // checkout
        $(function() {

            const $formCheckout = $('#formCheckout');
            const $formCheckoutSubmitBtn = $formCheckout.find(`[type="submit"]`);
            const originalBtnText = $formCheckoutSubmitBtn.text(); // Simpan teks asli tombol

            $formCheckout.on('submit', function(e) {
                e.preventDefault();
                $('.message-error').html('');

                const formData = $(this).serialize();
                $formCheckoutSubmitBtn.prop('disabled', true).text(
                    'Loading...'); // Ubah teks tombol dan disable

                ajaxSetup();
                $.ajax({
                        url: `{{ route('buyer.checkout') }}`,
                        method: 'post',
                        data: formData,
                        dataType: 'json'
                    })
                    .done(response => {
                        alertTailwind('Berhasil!',
                            response.message, 'success'
                        );
                        $formCheckoutSubmitBtn.prop('disabled', false).text(
                            originalBtnText);
                        setTimeout(() => {
                            location.href = `{{ route('buyer.history') }}`;
                        }, 1500)
                    })
                    .fail(error => {
                        $formCheckoutSubmitBtn.prop('disabled', false).text(
                            originalBtnText);
                        if (error.responseJSON) {
                            if (error.responseJSON.errors) {
                                const validationErrors = Object.values(error.responseJSON.errors)
                                    .map(errArray => errArray.join('<br>'))
                                    .join('<br>');
                                alertTailwind('Pesan Validasi!', validationErrors, 'warning');
                            } else {
                                const errorMessage = error.responseJSON.message || error.responseJSON
                                    .details;
                                alertTailwind('Gagal!', errorMessage, 'error');
                            }
                        } else {
                            alertTailwind('Error!', 'An unexpected error occurred. Please try again.',
                                'error');
                        }
                    });
            });
        });
    </script>
    </script>
@endsection
