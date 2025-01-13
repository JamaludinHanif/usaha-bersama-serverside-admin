<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Usaha Bersama | Masuk </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    {{-- <div id="alert-container" class="fixed top-5 lg:w-1/4 w-5/6 right-5 space-y-4 z-50"></div> --}}

    <!-- Global notification container -->
    <div id="notification-container" aria-live="assertive"
        class="pointer-events-none fixed inset-0 flex items-start px-4 py-6 sm:p-6 z-50">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end"></div>
    </div>
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            {{-- <img class="mx-auto h-10 w-auto" src="{{ \Setting::getLogoWebsiteUrl() }}"
                alt="Your Company"> --}}
            <h2 class=" text-center text-2xl/9 font-bold tracking-tight text-gray-900">Login</h2>
        </div>

        <div class="mt-10 sm:mx-auto lg:border lg:shadow sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 sm:rounded-lg sm:px-12">
                <form class="space-y-6" id="formLogin">
                    <div>
                        <label for="username" class="block text-sm/6 font-medium text-gray-900">Username :</label>
                        <div class="mt-2">
                            <input required type="text" name="username" id="username" autocomplete="username"
                                placeholder="Masukan Username Anda"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 placeholder:text-xs sm:text-sm/6">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password :</label>
                        <div class="mt-2">
                            <input required type="password" name="password" id="password" autocomplete="current-password"
                                placeholder="Masukan Password Anda"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 placeholder:text-xs sm:text-sm/6">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            <div class="flex h-6 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input id="remember-me" name="remember-me" type="checkbox"
                                        class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                                        viewBox="0 0 14 14" fill="none">
                                        <path class="opacity-0 group-has-[:checked]:opacity-100" d="M3 8L6 11L11 3.5"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path class="opacity-0 group-has-[:indeterminate]:opacity-100" d="M3 7H11"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <label for="remember-me" class="block text-sm/6 text-gray-900">Remember me</label>
                        </div>

                        <div class="text-sm/6">
                            <a href="{{ route('buyer.forgotPassword.view') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-500">Lupa
                                password?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Masuk</button>
                    </div>
                </form>

                <div>
                    <div class="relative mt-10">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm/6 font-medium">
                            <span class="bg-white px-6 text-gray-900">Kamu Seorang Penjual ?</span>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <a href="{{ route('seller.loginView') }}"
                            class="flex w-1/2 items-center justify-center gap-3 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:ring-transparent">
                            <span class="text-sm/6 font-semibold">Login Penjual</span>
                        </a>
                    </div>

                    <div class="relative mt-6">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm/6 font-medium">
                            <span class="bg-white px-6 text-gray-900">Belum Punya Akun ? <a
                                    href="{{ route('buyer.register.view') }}"
                                    class="text-blue-500 hover:underline">Daftar Sekarang</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('atlantis/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    {{-- ladda --}}
    <script src="{{ asset('ladda/spin.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('ladda/ladda.jquery.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('atlantis/assets/js/atlantis.min.js') }}"></script>

    <script src="{{ asset('atlantis/assets/js/myJs.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            @if (session('error'))
                let errorMessage = @json(session('error'));
                alertTailwind('Gagal!', errorMessage, 'error');
            @endif

            @if (session('middleware-auth.buyer'))
                let message = @json(session('middleware-auth.buyer'));
                alertTailwind('Peringatan!', message, 'warning');
            @endif

            @if (session('logout-success'))
                let message = @json(session('logout-success'));
                alertTailwind('Berhasil!', message, 'success');
            @endif

            const $formLogin = $('#formLogin');
            const $formLoginSubmitBtn = $('#formLogin').find(`[type="submit"]`);
            const originalBtnText = $formLoginSubmitBtn.text();


            $formLogin.on('submit', function(e) {
                e.preventDefault();
                $('.message-error').html('')

                const formData = $(this).serialize();
                $formLoginSubmitBtn.prop('disabled', true).text(
                    'Loading...'); // Ubah teks tombol dan disable

                ajaxSetup();
                $.ajax({
                        url: `{{ route('buyer.login') }}`,
                        method: 'post',
                        data: formData,
                        dataType: 'json'
                    })
                    .done(response => {
                        alertTailwind('Berhasil!', 'Login Berhasil', 'success');
                        $formLoginSubmitBtn.prop('disabled', false).text(
                            originalBtnText); // Kembalikan teks tombol
                        setTimeout(() => {
                            location.href = `{{ route('buyer.index') }}`;
                        }, 1500)
                    })
                    .fail(error => {
                        $formLoginSubmitBtn.prop('disabled', false).text(
                            originalBtnText); // Kembalikan teks tombol
                        if (error.responseJSON) {
                            if (error.responseJSON.errors) {
                                const validationErrors = Object.values(error.responseJSON.errors)
                                    .map(errArray => errArray.join(
                                        '<br>'))
                                    .join('<br>');
                                alertTailwind('Pesan Validasi!', validationErrors, 'warning');
                            } else {
                                const errorMessage = error.responseJSON.message || error.responseJSON
                                    .details; //detailsnya nanti harus diganti jadi error
                                alertTailwind('Gagal!', errorMessage, 'error');
                            }
                        } else {
                            alertTailwind('Error!', 'An unexpected error occurred. Please try again.',
                                'error');
                        }
                    })
            })

        })
    </script>
</body>

</html>