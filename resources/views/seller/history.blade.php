@extends('layouts.seller')
@section('content')

    <body class="bg-white">
        <div class="max-w-7xl mx-auto mb-80">
            {{-- riwayat pembelian --}}
            <div class="rounded-md">
                <div class="bg-white">
                    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
                        <div class="max-w-xl">
                            <h1 id="your-orders-heading" class="text-xl font-bold tracking-tight text-gray-900">
                                {{ $title }}</h1>
                        </div>

                        <div class="mt-8 space-y-16 lg:mt-10">
                            {{-- @dd(
                                \App\Models\Transaction::where('user_id', session('userData')->id)->with(['user', 'seller', 'items.product'])->orderBy('created_at', 'asc')->get()
                            ) --}}
                            @forelse (\App\Models\Transaction::where('seller_id', session('userData')->id)->whereIn('status', ['success', 'failed'])->with(['user', 'seller', 'items.product'])->orderBy('updated_at', 'desc')->get() as $index => $transaction)
                                <div aria-labelledby="">
                                    <div class="space-y-1 md:flex md:items-baseline md:space-x-4 md:space-y-0">
                                        <div class="flex justify-between items-center">
                                            <h2 id="" class="text-lg font-medium text-gray-900 md:shrink-0">
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
                                                Dikonfirm Tanggal {{ $transaction->updated_at->translatedFormat('d F Y, H:i') }}
                                            </p>
                                            <div class="flex text-sm font-medium">
                                                <a href="{{ route('seller.order.detail', $transaction->code_invoice) }}"
                                                    class="text-indigo-600 hover:text-indigo-500">Detail
                                                    Pembelian</a>
                                                <div class="ml-4 border-l border-gray-200 pl-4 sm:ml-6 sm:pl-6">
                                                    <a href="#" id="" data-id="{{ $transaction->id }}" class="downloadInvoice text-indigo-600 hover:text-indigo-500">Download
                                                        Invoice</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="-mb-3 flow-root divide-y divide-gray-200 ">
                                        @foreach ($transaction->items->take(2) as $item)
                                            <div class="py-6 border-b sm:flex">
                                                <div class="flex space-x-4 sm:min-w-0 sm:flex-1 sm:space-x-6 lg:space-x-8">
                                                    <img src="{{ $item->product->image }}"
                                                        alt="Brass puzzle in the shape of a jack with overlapping rounded posts."
                                                        class="size-20 flex-none rounded-md object-cover sm:size-48">
                                                    <div class="min-w-0 flex-1 pt-1.5 sm:pt-0">
                                                        <h3 class="text-sm font-medium text-gray-900 line-clamp-1">
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
                                            <a href="{{ route('seller.order.detail', $transaction->code_invoice) }}" class="text-sm text-gray-500 hover:text-gray-700">
                                                Produk Lainnya
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="grid min-h-full place-items-center bg-white my- px-6 lg:px-8">
                                    <div class="text-center">
                                        <p class="text-base font-semibold text-indigo-600">404</p>
                                        <h1
                                            class="mt-4 text-balance text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                                            {{ $title }} Kamu Kosong</h1>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </body>
@endsection
