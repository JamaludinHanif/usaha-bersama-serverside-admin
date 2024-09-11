<div class="">
    <div class="py-3 px-2">
        {{-- <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Buat User</h1>
        </div> --}}
        <form id="formCreate" action="">
            {{-- @csrf --}}
            <div class="mb-3">
                <select name="user_id" id="user_id" class="form-select input-user_id" aria-label="Pilih User123"
                    required>
                    <option value="" disabled selected>Pilih User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        {{-- <option value="">{{ $user->name }}</option> --}}
                    @endforeach
                </select>
                <div class="invalid-feedback feedback-user_id"></div>
            </div>

            <div class="mb-3">
                <select name="category_id" id="category_id" class="form-select input-category_id"
                    aria-label="Pilih Kategori" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback feedback-category_id"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control input-title" name="title" id="title"
                    placeholder="masukan judul">
                    <label for="floatingInput">Masukan Judul</label>
                <div class="invalid-feedback feedback-title"></div>
            </div>

            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control input-quote" placeholder="Leave a comment here" rows="3" name="quote"
                        id="quote"></textarea>
                    <label for="floatingTextarea">Masukan Quotes Kamu</label>
                    <div class="invalid-feedback feedback-quote"></div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" style="width: 50%" id=""
                    class="btn btn-primary btn-user btn-block tombol-tambah ladda-button" data-style="expand-right">
                    New Quotes
                </button>
            </div>
        </form>
        {{-- </div> --}}
    </div>
