<div class="py-3 px-2">
    {{-- <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Buat User</h1>
    </div> --}}
    <form id="formNote" action="">
        <div class="mb-3">
            <div class="form-floating">
                <textarea class="form-control input-notes"
                    placeholder=" Silahkan ketikan catatan kamu" rows="4" name="notes"
                    id="notes"></textarea>
                <div class="invalid-feedback feedback-notes"></div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" data-id={{ $data->id }} style="width: 50%" id=""
                class="btn btn-primary btn-user btn-block tombol-add-note ladda-button" data-style="expand-right">
                Buat Catatan
            </button>
        </div>
    </form>
    {{-- </div> --}}
</div>
