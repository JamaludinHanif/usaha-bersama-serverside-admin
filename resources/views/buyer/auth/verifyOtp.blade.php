<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('logo-company.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Usaha Bersama | {{ $title }} </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- Global notification container -->
    <div id="notification-container" aria-live="assertive"
        class="pointer-events-none fixed inset-0 flex items-start px-4 py-6 sm:p-6 z-50">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end"></div>
    </div>

    <div class="flex bg-gray-100 min-h-screen flex-1 flex-col justify-center">
        <div class="bg-white shadow-sm border rounded-md mx-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Verifikasi Otp
                </h3>
                <div class="mt-6 max-w-xl text-sm text-gray-500">
                    <p>Silahkan cek kode OTP, dipesan Whatsapp yang kami kirim</p>
                </div>
                <form class="space-y-6" id="formVerifyOtp">
                    <div class="mt-6">
                        <input type="number" name="otp" id="otp" placeholder="Masukan Kode OTP" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 placeholder:text-xs sm:text-sm/6">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                    </div>
                    <button type="submit"
                        class="mt-10 inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:ml-3 sm:mt-0 sm:w-auto">
                        Verifikasi
                    </button>
                </form>
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

            const $formVerifyOtp = $('#formVerifyOtp');
            const $formVerifyOtpSubmitBtn = $('#formVerifyOtp').find(`[type="submit"]`);
            const originalBtnText = $formVerifyOtpSubmitBtn.text();


            $formVerifyOtp.on('submit', function(e) {
                e.preventDefault();
                $('.message-error').html('')

                const formData = $(this).serialize();
                $formVerifyOtpSubmitBtn.prop('disabled', true).text(
                    'Loading...'); // Ubah teks tombol dan disable

                ajaxSetup();
                $.ajax({
                        url: `{{ route('buyer.otp') }}`,
                        method: 'post',
                        data: formData,
                        dataType: 'json'
                    })
                    .done(response => {
                        alertTailwind('Berhasil!', response.success, 'success');
                        $formVerifyOtpSubmitBtn.prop('disabled', false).text(
                            originalBtnText);
                        setTimeout(() => {
                            location.href = `{{ route('buyer.index') }}`;
                        }, 1500)
                    })
                    .fail(error => {
                        $formVerifyOtpSubmitBtn.prop('disabled', false).text(
                            originalBtnText);
                        if (error.responseJSON) {
                            if (error.responseJSON.errors) {
                                const validationErrors = Object.values(error.responseJSON.errors)
                                    .map(errArray => errArray.join(
                                        '<br>'))
                                    .join('<br>');
                                alertTailwind('Pesan Validasi!', validationErrors, 'warning');
                            } else {
                                const errorMessage = error.responseJSON.message || error.responseJSON
                                    .details; //detailsnya kudu harus diganti jadi error
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
