<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> Usaha Bersama | {{ $title }}</title>
    <meta content="{{ csrf_token() }}" name="_token">
    <link rel="icon" type="image/png" href="{{ asset('logo-company.png') }}">

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
    {{--
    <!-- Favicons -->
    <link href="{{ \Setting::getLogoWebsiteUrl() }}" rel="icon">
    <link href="{{ \Setting::getLogoWebsiteUrl() }}" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('atlantis/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('atlantis/assets/js/plugin/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('atlantis/assets/js/plugin/select2/select2-bootstrap.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* navbar */
        #mobile-menu {
            transition: transform 0.3s ease-in-out;
        }

        /* whatsapp */
        .whatsapp-button {
            position: fixed;
            bottom: 70px;
            /* Sesuaikan posisi vertikal */
            right: 12px;
            /* Sesuaikan posisi horizontal */
            width: 50px;
            height: 50px;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            font-size: 24px;
            text-align: center;
            line-height: 50px;
        }

        .whatsapp-button:hover {
            background-color: #1DA851;
            text-decoration: none;
        }

        /* Back to top
        .back-to-top {
            transition: opacity 0.3s, transform 0.3s;
        }

        .back-to-top.show {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        .back-to-top {
            opacity: 0;
            transform: translateY(100px);
        } */
    </style>
    @yield('style')
</head>

<body>
    @include('components.seller.menu')
    <!-- Global notification container -->
    <div id="notification-container" aria-live="assertive"
        class="pointer-events-none fixed inset-0 flex items-start px-4 py-6 sm:p-6 z-50">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end"></div>
    </div>
    @yield('content')
    @yield('footer')
    <footer class="bg-gray-900">
        <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center gap-x-6 md:order-2">
                <a href="https://github.com/JamaludinHanif" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Github</span>
                    <svg fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" class="size-6">
                        <path
                            d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                            clipRule="evenodd" fillRule="evenodd" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/_ha_nif" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Instagram</span>
                    <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="https://wa.me/6285161310017" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">WhatsApp</span>
                    <p class="flaticon-whatsapp"></p>
                </a>
            </div>
            <p class="mt-8 text-center text-sm/6 text-gray-400 md:order-1 md:mt-0">&copy; PT. Jamal Company. All
                rights reserved.</p>
        </div>
    </footer>

    <!-- End Footer -->
    <div id="preloader"></div>

    <!-- Back to Top Buttons -->
    <a href="#" title="Scroll ke atas" class="back-to-top flex items-center justify-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!--   Core JS Files   -->
    <script src="{{ asset('atlantis/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('atlantis/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    {{-- jquery-confirm --}}
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-confirm/jquery-confirm.js') }}"></script>

    {{-- ladda --}}
    <script src="{{ asset('ladda/spin.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.jquery.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('atlantis/assets/js/atlantis.min.js') }}"></script>

    {{-- select2 --}}
    <script src="{{ asset('atlantis/assets/js/plugin/select2/select2.min.js') }}"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    {{-- <script src="{{ asset('atlantis/assets/js/setting-demo.js') }}"></script> --}}
    <script src="{{ asset('atlantis/assets/js/demo.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/myJs.js') }}"></script>

    {{-- <script>
        $(document).ready(function() {
            // Event handler untuk tombol logout
            $('body').on('click', '.logout-btn', function() {
                console.log('Logout process initiated.');

                ajaxSetup();
                $.ajax({
                        url: `{{ route('buyer.logout') }}`,
                        method: 'post',
                        dataType: 'json'
                    })
                    .done(response => {
                        successNotification('Berhasil', 'Login Berhasil')
                    })
                    .fail(error => {
                        if (error.responseJSON) {
                            const errorMessage = error.responseJSON.message || error.responseJSON
                                .details; //detailsnya nanti harus diganti jadi error
                            alertTailwind('red', 'Failed', errorMessage, 7000);
                            if (error.responseJSON.errors) {
                                const validationErrors = Object.values(error.responseJSON.errors)
                                    .map(errArray => errArray.join(
                                        '<br>'))
                                    .join('<br>');
                                alertTailwind('yellow', 'Pesan Validasi', validationErrors, 7000);
                            }
                        } else {
                            alertTailwind('red', 'Failed',
                                'An unexpected error occurred. Please try again.', 3000);
                        }
                    })
            });
        });
    </script> --}}

    <script>
        document.getElementById("mobile-menu-button").addEventListener("click", function() {
            var mobileMenu = document.getElementById("mobile-menu");
            var openIcon = this.querySelector("svg.open-btn-nav");
            var closeIcon = this.querySelector("svg.close-btn-nav");

            // Toggle kelas 'hidden' pada menu dan ikon
            if (mobileMenu.classList.contains("hidden")) {
                mobileMenu.classList.remove("hidden", "opacity-0", "scale-95");
                mobileMenu.classList.add("opacity-100", "scale-100");
                openIcon.classList.add("hidden");
                openIcon.classList.remove("block");
                closeIcon.classList.remove("hidden");
            } else {
                closeIcon.classList.add("hidden");
                openIcon.classList.remove("hidden");
                mobileMenu.classList.add("hidden", "opacity-0", "scale-95");
            }
        });

        @if (session('userData'))
            document.getElementById("user-menu-button").addEventListener("click", function() {
                var profilDropdown = document.getElementById("profil-dropdown");

                if (profilDropdown.classList.contains("hidden")) {
                    profilDropdown.classList.remove("hidden");
                    profilDropdown.classList.add("opacity-100", "scale-100");
                } else {
                    profilDropdown.classList.add("opacity-0", "scale-95");
                    profilDropdown.classList.add("hidden");
                }
            })
        @else
        @endif

        $('.back-to-top').click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 'smooth');
        });

        // juamlah keranjang
        function updateCartBadge(count) {
            $('.cart-badge').text(count);
        }
    </script>

    <script>
        $('.on-going').click(function(e) {
            alertTailwind('Peringatan!',
                'Fitur belum tersedia untuk saat ini', 'warning'
            );
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.downloadInvoice').click(function() {
                const $button = $(this);
                const originalText = $button.text();
                const id = $button.data('id');

                $button.text('Loading...').prop('disabled', true);

                $.ajax({
                    url: "{{ route('download.invoice') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        type: 'D' // 'D' untuk force download
                    },
                    xhrFields: {
                        responseType: 'blob' // Untuk menangani file binary
                    },
                    success: function(response, status, xhr) {
                        // Ambil nama file dari header
                        const fileName = xhr.getResponseHeader('Content-Disposition')
                            .split('filename=')[1]
                            .replace(/['"]+/g, '');

                        // Buat URL dari blob
                        const url = window.URL.createObjectURL(new Blob([response]));
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = fileName || 'invoice.pdf';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url); // Hapus blob
                    },
                    error: function(xhr) {
                        console.error('Gagal mengunduh invoice:', xhr.responseJSON || xhr);
                        alert('Terjadi kesalahan saat mengunduh invoice. Silakan coba lagi.');
                    },
                    complete: function() {
                        $button.text(originalText).prop('disabled', false);
                    }
                });
            });
        });
    </script>

    @yield('script')
</body>

</html>
