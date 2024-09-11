<div class="">
    <div class="py-3 px-2">
        {{-- <form action="" method="POST">
            @csrf --}}
        {{-- @dd() --}}
        <div class="mb-3">
            <select name="user_id" id="user_id" class="form-select input-user_id" style="width: 100%" aria-label="Pilih User" required>
                <option value="" disabled selected>Pilih User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $datas->user_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback feedback-user_id"></div>
        </div>

        <div class="mb-3">
            <select name="category_id" id="category_id" class="form-select input-category_id" style="width: 100%" aria-label="Pilih Kategori" required>
                <option value="" disabled selected>Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $datas->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                @endforeach
            </select>
            <div class="invalid-feedback feedback-category_id"></div>
        </div>

        <div class="mb-3">
            <input type="text" class="form-control input-title" name="title" id="title" value="{{ $datas->title }}"
                placeholder="masukan judul">
                <div class="invalid-feedback feedback-title"></div>
        </div>

        <div class="mb-3">
            <div class="form-floating">
                <textarea class="form-control input-quote" placeholder="Leave a comment here" rows="3" cols="5" name="quote"
                    id="quote">{{ $datas->quote }}</textarea>
                <label for="floatingTextarea">Masukan Quote Kamu</label>
                <div class="invalid-feedback feedback-quote"></div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" data-id={{ $datas->id }} style="width: 50%" id=""
                class="btn btn-primary btn-user btn-block tombol-simpan ladda-button" data-style="expand-right">
                Update Quote
            </button>
        </div>
        {{-- </form> --}}
        {{-- </div> --}}
    </div>
