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
            <ul class="nav nav-primary">
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
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="users">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/users/users') ? 'active' : '' }}">
                                <a href="/admin/users/users">
                                    <span class="sub-item">Kelola User</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/users/log-activities') ? 'active' : '' }}">
                                <a href="/admin/users/log-activities">
                                    <span class="sub-item">Log-Aktifitas</span>
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
                <li class="nav-item">
                    <a data-toggle="collapse" aria-expanded="false" href="#products">
                        <i class="fas fa-box"></i>
                        <p>Produk</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="products">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/products/products') ? 'active' : '' }}">
                                <a href="/admin/products/products">
                                    <span class="sub-item">Kelola Produk</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
                <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                        <span class="badge badge-success">4</span>
                    </a>
                </li>
                <li class="mx-4 mt-2">
                    <a href="https://usaha-bersama.hanifdev.my.id" class="btn btn-primary btn-block"><span
                            class="btn-label mr-2"> <i class="fa fa-heart"></i>
                        </span>Usaha Bersama</a>
                </li>
            </ul>
        </div>
    </div>
</div>
