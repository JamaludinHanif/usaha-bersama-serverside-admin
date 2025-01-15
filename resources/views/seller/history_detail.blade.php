@extends('layouts.seller')
@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-2xl px-4 pb-10 pt-5 sm:px-6 lg:max-w-7xl lg:px-8">
            <!-- Detail Produk -->
            <div class="lg:mt-0">
                <h2 class="text-lg font-medium text-gray-900">Pesanan #{{ $datas->code_invoice }}</h2>
                <div class="flex justify-between items-center text-xs my-2 font-medium text-gray-500">Dikonfirm tanggal
                    {{ $datas->updated_at->translatedFormat('d F Y , H:i') }} <span
                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                    {{ $datas->status === 'success' ? 'bg-green-400/10 text-green-400 ring-green-400/30' : '' }}
                    {{ $datas->status === 'pending' ? 'bg-yellow-400/10 text-yellow-400 ring-yellow-400/30' : '' }}
                    {{ $datas->status === 'failed' ? 'bg-red-400/10 text-red-400 ring-red-400/30' : '' }}">
                    {{ $datas->status }}
                </span></div>
                <div class="mt-4">
                    <div
                        class="group flex cursor-pointer hover:opacity-75 select-none rounded-xl p-3 border rounded-sm shadow">
                        <div class="">
                            <img class="flex size-10 flex-none object-cover items-center justify-center rounded-lg"
                                src="{{ asset('user-avatar.jpg') }}">
                        </div>
                        <div class="ml-4 flex-auto">
                            <p class="text-sm font-medium text-gray-700">{{ $datas->user->username ?? 'Pengguna tidak ditemukan' }}</p>
                            <p class="text-xs text-gray-500 line-clamp-1">{{ $datas->user->name ?? 'Pengguna tidak ditemukan' }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 rounded-lg border border-gray-200 bg-white shadow-sm">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach ($datas->items as $index => $data)
                            <li class="flex px-4 py-6 sm:px-6">
                                <div class="shrink-0">
                                    <img src="{{ $data->product->image }}" alt="{{ $data->product->name }}"
                                        class="w-20 rounded-md">
                                </div>

                                <div class="ml-6 flex flex-1 flex-col">
                                    <div class="">
                                        <h4 class="text-sm">
                                            <a href="#"
                                                class="font-medium text-gray-700 hover:text-gray-800 line-clamp-2 lg:line-clamp-3">{{ $data->product->name }}</a>
                                        </h4>
                                    </div>

                                    <div class="flex flex-1 items-center justify-between pt-2">
                                        <p class="item-price mt-1 text-sm font-medium text-gray-900">
                                            {{ $data->product->priceFormatted() }}</p>

                                        <div class="ml-4">
                                            <div class="grid grid-cols-1">
                                                <p class="mt-1 text-sm font-medium text-gray-900">
                                                    {{ $data->quantity }} {{ $data->product->unit }}
                                                </p>
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
                            <dt class="text-base font-medium">Total</dt>
                            <dd class="text-base font-medium text-gray-900" id="total-amount">
                                {{ $datas->priceFormatted() }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="mt-10 justify-center items-center">
                    <div class="mt-10">
                        <button type="submit" data-id="{{ $datas->id }}"
                            class="downloadInvoice w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Download
                            Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
