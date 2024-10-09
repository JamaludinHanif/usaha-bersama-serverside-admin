<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    {{-- atlantis font --}}
    <script src="{{ asset('atlantis/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('atlantis/assets/css/fonts.min.css') }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!-- Include CSS dari Atlantis -->
    <link rel="stylesheet" href="{{ asset('atlantis/assets/css/bootstrap.min.css') }}">
    <link href="{{ asset('atlantis/assets/css/atlantis.min.css') }}" rel="stylesheet">

    {{-- ladda --}}
    <link rel="stylesheet" href="{{ asset('ladda/ladda-themeless.min.css') }}">

    {{-- sweetalert cdn --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- pace js --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-flash.min.css">
    <style>
        .pace .pace-progress {
            background: white;
            /* Ubah menjadi warna favoritmu */
        }

        .pace .pace-activity {
            border-top-color: white;
            /* Ubah warna lingkaran */
            border-left-color: white;
        }
    </style>

    {{-- select2 --}}
    <link rel="stylesheet" href="{{ asset('select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('select2/select2-atlantis.css') }}">

    @yield('style')
</head>

<body>

    <div class="wrapper">
        {{-- header --}}
        @include('components.nav-bar')

        {{-- sidebar --}}
        @include('components.side-bar')

        <div class="main-panel">
            <div class="content">

                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-5">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white pb-2 fw-bold">@yield('title')</h2>
                                <h5 class="text-white op-7 mb-2">@yield('title2')</h5>
                                <div class="" style="height: 10px"></div>
                                @yield('breadcrumbs')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner"> {{-- mt--5 --}}
                    @yield('content')
                </div>
            </div>
            @yield('modal')
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="https://www.instagram.com/_ha_nif/">
                                    Hanif Dev
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Help
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright ml-auto">
                        2024, made with <i class="fa fa-heart heart text-danger"></i> by <a
                            href="https://www.instagram.com/_ha_nif/">Jamaludin Hanif</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>



    <!--   Core JS Files   -->
    <script src="{{ asset('atlantis/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('atlantis/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('atlantis/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('atlantis/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    {{-- pace js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('atlantis/assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

    <!-- Tambahkan JS SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ladda --}}
    <script src="{{ asset('ladda/spin.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.jquery.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('atlantis/assets/js/atlantis.min.js') }}"></script>

    {{-- select2 --}}
    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    {{-- <script src="{{ asset('atlantis/assets/js/setting-demo.js') }}"></script> --}}
    <script src="{{ asset('atlantis/assets/js/demo.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(document).on('click', 'a', function(e) {
                var href = $(this).attr('href');

                if (href && href !== "#" && href.indexOf('#') === -1) {
                    $('#loading-spinner').show();
                    setTimeout(() => {
                        $('#loading-spinner').hide();
                    }, 500);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Mendapatkan URL saat ini
            var path = window.location.pathname;

            // Menambahkan kelas 'active' pada elemen nav-item dan sub-item yang sesuai
            $(".nav-item a").each(function() {
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
            $(".nav-collapse a").each(function() {
                var href = $(this).attr('href');
                if (path === href) {
                    $(this).closest(".collapse").addClass("show");
                    $(this).closest(".nav-item").addClass("active").find("a").attr("aria-expanded", "true");
                    $(this).addClass("active");
                }
            });
        });
    </script>


    @yield('scripts') <!-- Stack tambahan untuk JS khusus tiap halaman -->
</body>

</html>
