<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    {{-- <meta name="turbolinks-cache-control" content="no-cache"> --}}

    <title>Usaha Bersama Admin</title>

    {{-- bootstrap cdn --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

    @notifyCss

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-9/assets/css/login-9.css">

    {{-- ladda --}}
    <link rel="stylesheet" href="{{ url('vendor/ladda/ladda-themeless.min.css') }}">

    {{-- sweetalert cdn --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> --}}

    <!-- Custom fonts for this template -->
    <link href="{{ url('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url('css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- select2 --}}
    <link rel="stylesheet" href="{{ url('vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ url('css/select2-atlantis.css') }}">

    <!-- Turbolinks CDN -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
    <script>
        Turbolinks.start();
    </script> --}}

    {{-- pace js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-flash.min.css">

    <!-- Custom styles for this page -->
    <link href="{{ url('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    @yield('style')
    {{-- @livewireStyles --}}

</head>

<body id="page-top">
    <div id="loading-spinner"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255,255,255,0.8); z-index: 9999; text-align: center;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        {{-- @livewire('sidebar') --}}
        @include('components.side-bar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <x-nav-bar></x-nav-bar>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
                    <div class="" style="height: 35px"></div>

                    @yield('content')

                    @yield('modal')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <x-logout-alert></x-logout-alert>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ url('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- chart js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('js/sb-admin-2.min.js') }}"></script>

    {{-- ladda --}}
    <script src="{{ url('vendor/ladda/spin.min.js') }}"></script>
    <script src="{{ url('vendor/ladda/ladda.min.js') }}"></script>
    <script src="{{ url('vendor/ladda/ladda.jquery.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ url('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>

    {{-- toast alert --}}
    <script src="{{ url('vendor/bootstrap-5-toast-snackbar/src/toast.js') }}"></script>

    {{-- setup.js --}}
    <script src="{{ url('js/mySetup.js') }}"></script>

    {{-- select2 --}}
    <script src="{{ url('vendor/select2/select2.min.js') }}"></script>

    {{-- pace js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>

    {{-- bootstrap cdn --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}

    <!-- Tambahkan JS SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')

    <script>
        $(document).ready(function() {
            // Mendapatkan URL saat ini
            var path = window.location.pathname;

            // Menambahkan kelas 'active' pada elemen nav-item yang sesuai
            $(".nav-item a.nav-link").each(function() {
                var href = $(this).attr('href');
                if (path === href) {
                    $(this).closest(".nav-item").addClass("active");
                    if ($(this).hasClass('collapsed')) {
                        $(this).attr("aria-expanded", "true");
                        $(this).closest(".collapse").addClass("show");
                        $(this).removeClass('collapsed');
                    }
                }
            });

            // Menambahkan kelas 'active' dan 'show' pada item collapse jika salah satu item di dalamnya aktif
            $(".collapse-item").each(function() {
                var href = $(this).attr('href');
                if (path === href) {
                    $(this).closest(".collapse").addClass("show");
                    $(this).closest(".nav-item").addClass("active").find(".nav-link").attr("aria-expanded",
                            "true")
                        .removeClass('collapsed');
                    $(this).addClass("active");
                }
            });

            // // loading
            $(document).on('click', 'a', function(e) {
                var href = $(this).attr('href');

                if (href && href !== "#" && href.indexOf('#') === -1) {
                    $('#loading-spinner').show();
                    setTimeout(() => {
                        $('#loading-spinner').hide();
                    }, 500);
                }
            });

            // $(window).on('load', function() {
            //
            // });
        });
    </script>



    {{-- @livewireScripts --}}
    {{-- @include('notify::messages') --}}
    @notifyJs
    @yield('scripts')

</body>

</html>
