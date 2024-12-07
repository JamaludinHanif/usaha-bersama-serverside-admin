<div class="py-3 px-2">
    {{-- <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Buat User</h1>
    </div> --}}
    <form id="formSend" action="">
        <div class="mb-3">
            <div class="form-floating">
                <textarea class="form-control input-message"
                    placeholder="Ketikan pesan/chat untuk penghutang contoh : bayar hutang lu ganteng!!!!" rows="7" name="message"
                    id="message">Halo *{{ $data->user->name }}* 🙏, kami mengingatkan untuk segera membayar hutang Anda sebesar *Rp. {{ number_format($data->debt_remaining ?? 0, 0, ',', '.') }}*, yang akan jatuh tempo pada tanggal *{{ \Carbon\Carbon::parse($data->due_date)->format('d-M-Y') }}*, kami mengharapkan kerja sama dari anda.

Hormat kami, -admin Usaha Bersama-</textarea>
                <div class="invalid-feedback feedback-message"></div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" data-id={{ $data->user->no_hp }} style="width: 50%" id=""
                class="btn btn-primary btn-user btn-block tombol-send ladda-button" data-style="expand-right">
                Send Message
            </button>
        </div>
    </form>
    {{-- </div> --}}
</div>
