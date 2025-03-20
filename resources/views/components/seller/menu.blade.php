<nav class="sticky top-0 z-50 bg-white shadow border-b-2">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="-ml-2 mr-2 flex items-center md:hidden">
                    <!-- Mobile menu button -->
                    <button type="button"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg class="block open-btn-nav size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg class="hidden close-btn-nav size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center">
                    <img class="h-8 w-auto mr-2" src="{{ asset('logo-company.png') }}" alt="Usaha Bersama">
                    <a href="{{ url('/') }}" class="text-sm lg:text-2xl font-semibold">Usaha Bersama | Akun Penjual</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="hidden md:ml-3 md:flex md:inline md:space-x-7">
                    <a href="#"
                        class="inline-flex items-center border-b-4 px-1 pt-1 text-lg font-semibold transition-all duration-300 ease-in-out {{ request()->url() == url('/') ? 'hover:text-indigo-700 border-indigo-700 text-indigo-700' : 'border-transparent hover:border-indigo-700 hover:text-indigo-700' }}">
                        Beranda
                    </a>
                    <a href="#"
                        class="inline-flex items-center border-b-4 px-1 pt-1 text-lg font-semibold transition-all duration-300 ease-in-out {{ request()->url() == url('/') ? 'hover:text-indigo-700 border-indigo-700 text-indigo-700' : 'border-transparent hover:border-indigo-700 hover:text-indigo-700' }}">
                        Riwayat Penjualan
                    </a>
                </div>
            </div>
            <div class="flex items-center">

                @if (session('userData'))
                    <div class="hidden md:ml-4 md:flex md:shrink-0 md:items-center">
                        {{-- <a href="{{ route('buyer.cart.index') }}"
                            class="relative rounded-full bg-white p-3 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 group">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View cart</span>
                            <i class="fas fa-shopping-cart"></i>
                            <span
                                class="cart-badge absolute top-0 right-0 block h-4 w-4 flex items-center justify-center rounded-full bg-red-500 text-white text-xs leading-5 text-center">
                                {{ App\Models\Cart::where('user_id', session('userData')->id )->count() }}
                            </span>
                        </a> --}}
                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button"
                                    class="relative flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="size-8 rounded-full border" src="{{ asset('user-avatar.jpg') }}"
                                        alt="{{ session('userData')->name }}">
                                    <span
                                        class="absolute right-0 top-0 block size-3 rounded-full bg-green-400 ring-2 ring-white"></span>
                                </button>
                            </div>

                            <div id="profil-dropdown"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none hidden"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-gray-100 outline-none", Not Active: "" -->
                                <a href="#{{-- route('buyer.profile.index') --}}" class="block px-4 py-2 text-sm text-gray-700"
                                    role="menuitem" tabindex="-1" id="user-menu-item-0">My Profile</a>
                                {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Settings</a> --}}
                                <a href="{{ route('seller.logout') }}" class="block px-4 py-2 text-sm text-gray-700"
                                    role="menuitem" tabindex="-1" id="user-menu-item-2">Logout</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="shrink-0">
                        <a href="{{ route('buyer.login.view') }}"
                            class="relative inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-3 py-2 text-base font-semibold text-white shadow-sm hover:bg-indigo-500 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Login</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="transition-all duration-300 transform opacity-0 scale-95 hidden shadow-lg" id="mobile-menu">
        <div class="space-y-1 pb-3 pt-2">
            <!-- Link Beranda -->
            <a
                href="{{ route('seller.index') }}"
                class="block border-l-4 py-2 pl-3 pr-4 text-base font-semibold sm:pl-5 sm:pr-6
                {{ request()->url() == route('seller.index') ? 'bg-indigo-50 border-indigo-500 font-bold text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }}">
                Beranda
            </a>

            <a
                href="{{ route('seller.order') }}"
                class="block border-l-4 py-2 pl-3 pr-4 text-base font-semibold sm:pl-5 sm:pr-6
                {{ request()->url() == route('seller.order') ? 'bg-indigo-50 border-indigo-500 font-bold text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }}">
                Pesanan
            </a>

            <a
                href="{{ route('seller.history') }}"
                class="block border-l-4 py-2 pl-3 pr-4 text-base font-semibold sm:pl-5 sm:pr-6
                {{ request()->url() == route('seller.history') ? 'bg-indigo-50 border-indigo-500 font-bold text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }}">
                Riwayat Pesanan
            </a>

            <a
                href="{{ route('seller.cashier') }}"
                class="block border-l-4 py-2 pl-3 pr-4 text-base font-semibold sm:pl-5 sm:pr-6
                {{ request()->url() == route('seller.cashier') ? 'bg-indigo-50 border-indigo-500 font-bold text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }}">
                Kasir
            </a>

            {{-- <a
                href="#"
                class="relative block border-l-4 py-2 pl-3 pr-4 text-base font-semibold sm:pl-5 sm:pr-6
                {{ request()->url() == url('/') ? 'bg-indigo-50 border-indigo-500 font-bold text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }}">
                Pembelian
                <span
                    class="absolute top-1/2 right-5 transform -translate-y-1/2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-white text-xs leading-5">
                    0
                </span>
            </a> --}}
        </div>


        @if (session('userData'))
            <div class="border-t border-gray-200 pb-3 pt-4">
                <div class="flex items-center px-4 sm:px-6">
                    <div class="shrink-0">
                        <img class="size-10 rounded-full" src="{{ url('storage/image/seller/' . session('userData')->image) }}" alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ session('userData')->shop_name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ session('userData')->email }}</div>
                    </div>
                    <a href="#"
                        class="on-going relative ml-auto shrink-0 rounded-full bg-white p-3 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute -inset-1.5"></span>
                        <li class="far fa-bell"></li>
                        <span
                            class="cart-badge absolute top-0 right-0 block h-4 w-4 flex items-center justify-center rounded-full bg-red-500 text-white text-xs leading-5 text-center">
                            {{-- {{ App\Models\Cart::where('user_id', session('userData')->id)->count() }} --}}
                            0
                        </span>
                    </a>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="#{{-- route('seller.profile') --}}"
                        class="on-going block px-4 pt-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800 sm:px-6">
                        Profil Ku</a>
                    {{-- <a href="#"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800 sm:px-6">Settings</a> --}}
                    <a href="{{ route('seller.logout') }}"
                        class="block px-4 pb-1 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800 sm:px-6">
                        Logout</a>
                </div>
            </div>
        @endif
    </div>
</nav>
