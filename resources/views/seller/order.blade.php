@extends('layouts.seller')
@section('content')
    <div class="my-5 mb-80">
        <h3 class="text-lg font-semibold text-gray-900 px-4 py-2">Pesanan yang belum di konfirmasi</h3>
        <ul role="list" class="divide-y divide-gray-100 px-4">
            @forelse (\App\Models\Transaction::where('seller_id', session('userData')->id)->where('status', 'pending')->with(['user', 'seller', 'items.product'])->orderBy('created_at', 'desc')->get() as $index => $transaction)
                <li class="flex items-center justify-between gap-x-6 py-5">
                    <div class="min-w-0">
                        <div class="flex items-start gap-x-3">
                            <p class="text-sm/6 font-semibold text-gray-900">{{ $transaction->user->username }}</p>
                            <span
                                class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                {{ $transaction->status === 'success' ? 'bg-green-400/10 text-green-400 ring-green-400/30' : '' }}
                                {{ $transaction->status === 'pending' ? 'bg-yellow-400/10 text-yellow-400 ring-yellow-400/30' : '' }}
                                {{ $transaction->status === 'failed' ? 'bg-red-400/10 text-red-400 ring-red-400/30' : '' }}">
                                {{ $transaction->status }}
                            </span>
                        </div>
                        <div class="mt-2 flex items-center gap-x-2 text-xs">
                            <p class="font-bold">{{ $transaction->priceFormatted() }}</p>
                            {{-- <svg viewBox="0 0 2 2" class="size-0.5 fill-current">
                                <circle cx="1" cy="1" r="1" />
                            </svg> --}}
                        </div>
                        <p class="whitespace-nowrap mt-2 text-xs/5 text-gray-500"><time
                            datetime="{{ $transaction->created_at }}"> Dipesan pada {{ $transaction->created_at->translatedFormat('d F Y , H:i') }}</time>
                    </p>
                    </div>
                    <div class="flex flex-none items-center gap-x-4">
                        <a href="{{ route('seller.detail.order', $transaction->code_invoice) }}"
                            class=" rounded-md bg-blue-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-blue-300 sm:block">Konfirmasi</a>
                    </div>
                </li>
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
            {{-- <li class="flex items-center justify-between gap-x-6 py-5">
                <div class="min-w-0">
                    <div class="flex items-start gap-x-3">
                        <p class="text-sm/6 font-semibold text-gray-900">New benefits plan</p>
                        <p
                            class="mt-0.5 whitespace-nowrap rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                            In progress</p>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
                        <p class="whitespace-nowrap">Due on <time datetime="2023-05-05T00:00Z">May 5, 2023</time></p>
                        <svg viewBox="0 0 2 2" class="size-0.5 fill-current">
                            <circle cx="1" cy="1" r="1" />
                        </svg>
                        <p class="truncate">Created by Leslie Alexander</p>
                    </div>
                </div>
            </li>
            <li class="flex items-center justify-between gap-x-6 py-5">
                <div class="min-w-0">
                    <div class="flex items-start gap-x-3">
                        <p class="text-sm/6 font-semibold text-gray-900">Onboarding emails</p>
                        <p
                            class="mt-0.5 whitespace-nowrap rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                            In progress</p>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
                        <p class="whitespace-nowrap">Due on <time datetime="2023-05-25T00:00Z">May 25, 2023</time></p>
                        <svg viewBox="0 0 2 2" class="size-0.5 fill-current">
                            <circle cx="1" cy="1" r="1" />
                        </svg>
                        <p class="truncate">Created by Courtney Henry</p>
                    </div>
                </div>
            </li>
            <li class="flex items-center justify-between gap-x-6 py-5">
                <div class="min-w-0">
                    <div class="flex items-start gap-x-3">
                        <p class="text-sm/6 font-semibold text-gray-900">iOS app</p>
                        <p
                            class="mt-0.5 whitespace-nowrap rounded-md bg-gray-50 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                            In progress</p>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
                        <p class="whitespace-nowrap">Due on <time datetime="2023-06-07T00:00Z">June 7, 2023</time></p>
                        <svg viewBox="0 0 2 2" class="size-0.5 fill-current">
                            <circle cx="1" cy="1" r="1" />
                        </svg>
                        <p class="truncate">Created by Leonard Krasner</p>
                    </div>
                </div>
            </li>
            <li class="flex items-center justify-between gap-x-6 py-5">
                <div class="min-w-0">
                    <div class="flex items-start gap-x-3">
                        <p class="text-sm/6 font-semibold text-gray-900">Marketing site redesign</p>
                        <p
                            class="mt-0.5 whitespace-nowrap rounded-md bg-yellow-50 px-1.5 py-0.5 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                            Archived</p>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
                        <p class="whitespace-nowrap">Due on <time datetime="2023-06-10T00:00Z">June 10, 2023</time></p>
                        <svg viewBox="0 0 2 2" class="size-0.5 fill-current">
                            <circle cx="1" cy="1" r="1" />
                        </svg>
                        <p class="truncate">Created by Courtney Henry</p>
                    </div>
                </div>
            </li> --}}
        </ul>
    </div>
@endsection
@section('script')
@endsection
