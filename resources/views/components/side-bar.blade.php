<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-face-grin-squint-tears"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin {{ session('userData')->username }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        USERS
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Users</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kelola User :</h6>
                <a class="collapse-item {{ Request::is('admin/users/users') ? 'active' : '' }}"
                    href="/admin/users/users">Users</a>
                <a class="collapse-item {{ Request::is('admin/users/users-v2') ? 'active' : '' }}"
                    href="/admin/users/users-v2">Users V2</a>
                <a class="collapse-item {{ Request::is('admin/users/log-activities') ? 'active' : '' }}"
                    href="/admin/users/log-activities">Log Activities</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    {{-- quote --}}

    <!-- Heading -->
    <div class="sidebar-heading">
        PRODUCTS
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            {{-- <i class="fas fa-recycle"></i> --}}
            <span>Master Products</span>
        </a>
        @php
            $routeproducts = "Request::is('admin/products";
            $routeUsers = "Request::is('admin/products";
        @endphp
        {{-- @dd($routeproducts + "/products')" ? 'show' : '') --}}
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kelola products :</h6>
                <a class="collapse-item {{ Request::is('admin/products/products') ? 'active' : '' }}"
                    href="/admin/products/products">products</a>
                <h6 class="collapse-header">products :</h6>
                <a class="collapse-item {{ Request::is('admin/products/all-products') ? 'active' : '' }}"
                    href="/admin/products/all-products">All products</a>
                <a class="collapse-item {{ Request::is('admin/products/categories') ? 'active' : '' }}"
                    href="/admin/products/categories">Categories products</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other :</h6>
                <a class="collapse-item" href="404.html">Comments</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- recycle bin -->

    <!-- Heading -->
    <div class="sidebar-heading">
        RECYCLE BIN
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecycle"
            aria-expanded="true" aria-controls="collapseRecycle">
            <i class="fas fa-recycle"></i>
            <span>Master Recycle</span>
        </a>
        @php
            $routeQuotes = "Request::is('admin/quotes";
            $routeUsers = "Request::is('admin/quotes";
        @endphp
        {{-- @dd($routeQuotes + "/quotes')" ? 'show' : '') --}}
        <div id="collapseRecycle" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Recycle Quote :</h6>
                <a class="collapse-item {{ Request::is('admin/quotes/quotes') ? 'active' : '' }}"
                    href="/admin/quotes/quotes">Quotes</a>
                <h6 class="collapse-header">Recycle User :</h6>
                <a class="collapse-item {{ Request::is('admin/recycle/users') ? 'active' : '' }}"
                    href="/admin/recycle/users">Users</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other :</h6>
                <a class="collapse-item" href="404.html">Comments</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ Request::is('tables') ? 'active' : '' }}">
        <a class="nav-link" href="/tables">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
