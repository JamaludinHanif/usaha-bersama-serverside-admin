<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
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
    {{-- ladda --}}
    <link rel="stylesheet" href="{{ asset('ladda/ladda-themeless.min.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        /* html,
        body {
            height: 100%;
        } */

        body.my-login-page {
            background-color: #f7f9fb;
            font-size: 14px;
        }

        .my-login-page .brand {
            width: 90px;
            height: 90px;
            overflow: hidden;
            border-radius: 50%;
            margin: 40px auto;
            /* background-color: white; */
            box-shadow: 0 4px 8px rgba(0, 0, 0, .05);
            position: relative;
            z-index: 1;
        }

        .my-login-page .brand img {
            padding: 20px;
            width: 100%;
            margin-right: 5px
        }

        .my-login-page .card-wrapper {
            width: 400px;
        }

        .my-login-page .card {
            border-color: transparent;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .05);
        }

        .my-login-page .card.fat {
            padding: 10px;
        }

        .my-login-page .card .card-title {
            margin-bottom: 30px;
        }

        .my-login-page .form-control {
            border-width: 2.3px;
        }

        .my-login-page .form-group label {
            width: 100%;
        }

        .my-login-page .btn.btn-block {
            padding: 12px 10px;
        }

        .my-login-page .footer {
            margin: 40px 0;
            color: #888;
            text-align: center;
        }

        @media screen and (max-width: 425px) {
            .my-login-page .card-wrapper {
                width: 90%;
                margin: 0 auto;
            }
        }

        @media screen and (max-width: 320px) {
            .my-login-page .card.fat {
                padding: 0;
            }

            .my-login-page .card.fat .card-body {
                padding: 15px;
            }
        }

        body {
            margin: auto;
            height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
            overflow: auto;
            background: linear-gradient(315deg, rgba(101, 0, 94, 1) 3%, rgba(60, 132, 206, 1) 38%, rgba(48, 238, 226, 1) 68%, rgba(255, 25, 25, 1) 98%);
            animation: gradient 15s ease infinite;
            background-size: 400% 400%;
            background-attachment: fixed;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        .wave {
            background: rgb(255 255 255 / 25%);
            border-radius: 1000% 1000% 0 0;
            position: fixed;
            width: 200%;
            height: 12em;
            animation: wave 10s -3s linear infinite;
            transform: translate3d(0, 0, 0);
            opacity: 0.8;
            bottom: 0;
            left: 0;
            z-index: -1;
        }

        .wave:nth-of-type(2) {
            bottom: -1.25em;
            animation: wave 18s linear reverse infinite;
            opacity: 0.8;
        }

        .wave:nth-of-type(3) {
            bottom: -2.5em;
            animation: wave 20s -1s reverse infinite;
            opacity: 0.9;
        }

        @keyframes wave {
            2% {
                transform: translateX(1);
            }

            25% {
                transform: translateX(-25%);
            }

            50% {
                transform: translateX(-50%);
            }

            75% {
                transform: translateX(-25%);
            }

            100% {
                transform: translateX(1);
            }
        }
    </style>
</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="https://jamaludinhanif.github.io/portofolio-hanif/dist/img/logo%20by%20tegar.png"
                            alt="logo">
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            @if (session()->has('loginError'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('loginError') }}
                                </div>
                            @endif
                            @if (session()->has('errorMiddleware'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('errorMiddleware') }}
                                </div>
                            @endif
                            <h4 class="card-title">Login</h4>
                            <form method="POST" action="/auth/login" class="my-login-validation">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Username :</label>
                                    <input id="username" type="text" class="form-control" name="username"
                                        value="" required autofocus>
                                    <div class="invalid-feedback">
                                        Username is invalid
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password :
                                        <a href="forgot.html" class="float-right">
                                            Forgot Password?
                                        </a>
                                    </label>
                                    <input id="password" type="password" class="form-control" name="password" required
                                        data-eye>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" name="remember" id="remember"
                                            class="custom-control-input">
                                        <label for="remember" class="custom-control-label">Remember Me</label>
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" id="submitButton"
                                        class="btn btn-primary btn-block ladda-button">
                                        Login
                                        <i class="fas fa-spinner fa-spin" id="spinner"
                                            style="display: none;margin-left: 10px"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; 2024 &mdash; Usaha Bersama (by hanif)
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- Bootstrap Notify -->
    <script src="{{ asset('atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script>
        $(function() {

            $("input[type='password'][data-eye]").each(function(i) {
                var $this = $(this),
                    id = 'eye-password-' + i,
                    el = $('#' + id);

                // Bungkus input password dengan div yang relative
                $this.wrap($("<div/>", {
                    style: 'position:relative',
                    id: id
                }));

                // Berikan padding kanan untuk ikon mata
                $this.css({
                    paddingRight: 60
                });

                // Tambahkan ikon mata untuk toggle visibility
                $this.after($("<div/>", {
                    html: '<i class="fas fa-eye"></i>',
                    id: 'passeye-toggle-' + i,
                }).css({
                    position: 'absolute',
                    right: 10,
                    top: ($this.outerHeight() / 2) - 12,
                    padding: '2px 7px',
                    fontSize: 12,
                    cursor: 'pointer',
                }));

                // Tambahkan input hidden untuk menyimpan password
                $this.after($("<input/>", {
                    type: 'hidden',
                    id: 'passeye-' + i
                }));

                // Update hidden input saat ada perubahan di input password
                $this.on("keyup paste", function() {
                    $("#passeye-" + i).val($(this).val());
                });

                // Fungsi untuk toggle visibility password
                $("#passeye-toggle-" + i).on("click", function() {
                    if ($this.attr('type') === 'password') {
                        $this.attr('type', 'text');
                        $(this).html(
                            '<i class="fas fa-eye-slash"></i>'); // Ganti ikon menjadi 'eye-slash'
                    } else {
                        $this.attr('type', 'password');
                        $(this).html('<i class="fas fa-eye"></i>'); // Kembalikan ikon menjadi 'eye'
                    }
                });
            });

        });
    </script>

    {{-- ladda --}}
    <script src="{{ asset('ladda/spin.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.jquery.min.js') }}"></script>

    <script>
        $('#submitButton').on('click', function(e) {
            var form = $(this).closest('form');

            // Cek validasi form
            if (form[0].checkValidity() === false) {
                e.preventDefault(); // Cegah submit jika tidak valid
                e.stopPropagation();
            } else {
                $('#spinner').show(); // Tampilkan spinner
            }
        });
    </script>

</body>

</html>
