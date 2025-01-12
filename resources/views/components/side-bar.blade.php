<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="https://i.pinimg.com/236x/88/ef/45/88ef4583aa9e81b18d6baa9ebf3e5486.jpg" alt="..."
                        class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a>
                        <span>
                            {{ session('userData')->username }}
                            <span class="user-level">{{ session('userData')->role }}</span>
                        </span>
                    </a>
                </div>
            </div>
            <ul class="nav nav-primary" id="menu-nav">
                <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="/admin/dashboard">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- users --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">USERS</h4>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" aria-expanded="false" href="#users">
                        <i class="fas fa-users"></i>
                        <p>Pengguna</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="users">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.index') }}">
                                    <span class="sub-item">Kelola Pengguna</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.log') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.log') }}">
                                    <span class="sub-item">Log Aktivitas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- products --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">PRODUCTS</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.product.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.product.index') }}">
                        <i class="fas fa-box"></i>
                        <p>Kelola Produk</p>
                    </a>
                </li>
                {{-- Transaction --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">TRANSACTION</h4>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" aria-expanded="false" href="#transaction">
                        <i class="fas fa-money-check-alt"></i>
                        <p>Transaksi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="transaction">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.transactions.index') }}">
                                    <span class="sub-item">Kelola Transaksi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Seller --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">SELLERS</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.seller.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.seller.index') }}">
                        <i class="fas fa-user-shield"></i>
                        <p>Penjual</p>
                    </a>
                </li>
                {{-- recycle bin --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">RESTORE</h4>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" aria-expanded="false" href="#restore">
                        <i class="fas fa-recycle"></i>
                        <p>Restore</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="restore">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/recycle/users') ? 'active' : '' }}">
                                <a href="/admin/recycle/users">
                                    <span class="sub-item">Users</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/recycle/products') ? 'active' : '' }}">
                                <a href="/admin/recycle/products">
                                    <span class="sub-item">Produk</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                        <span class="badge badge-success">4</span>
                    </a>
                </li> --}}
                <li class="mx-4 mt-2">
                    <a href="{{ route('auth.logout') }}" class="btn btn-primary btn-block"><span
                            class="btn-label mr-2"> <i class="fas fa-sign-out-alt"></i>
                        </span>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
