<div class="">
    <div class="py-3 px-2">
        {{-- <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Buat User</h1>
        </div> --}}
        <form id="formCreate" action="">
            {{-- @csrf --}}

            <div class="form-floating mb-3">
                <input type="text" class="form-control input-name" name="name" id="name"
                    placeholder="Masukan Nama Produk (masukan juga detail variant dan gram nya)">
                <div class="invalid-feedback feedback-name"></div>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Rp.</span>
                <input type="number" name="price" id="price" class="form-control input-price" placeholder="Masukan Harga (tanpa menggunakan titik dan spasi)" aria-describedby="basic-addon1">
                <div class="invalid-feedback feedback-price"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="number" class="form-control input-stock" name="stock" id="stock"
                    placeholder="Masukan Stok (tanpa menggunakan titik dan spasi)">
                <div class="invalid-feedback feedback-stock"></div>
            </div>

            <div class="mb-3">
                <select name="category" id="category" class="form-control input-category" aria-label="Pilih User123"
                    required>
                    <option value="" disabled selected>Pilih Kategori</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="pembersih">Pembersih</option>
                        <option value="lainnya">Lainnya</option>
                </select>
                <div class="invalid-feedback feedback-category"></div>
            </div>

            <div class="mb-3">
                <select name="unit" id="unit" class="form-control input-unit"
                    aria-label="Pilih Kategori" required>
                    <option value="" disabled selected>Pilih Satuan</option>
                        <option value="pcs">Pcs</option>
                        <option value="pak">Pack</option>
                        <option value="dos">Dos</option>
                        <option value="1/4">1/4 kg</option>
                </select>
                <div class="invalid-feedback feedback-unit"></div>
            </div>

            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control input-image" placeholder="Masukan gambar (opsional) *gambar harus berbentuk URL" rows="3" name="image"
                        id="image"></textarea>
                    <div class="invalid-feedback feedback-image"></div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" style="width: 50%" id=""
                    class="btn btn-primary btn-user btn-block tombol-tambah ladda-button" data-style="expand-right">
                    Tambahkan
                </button>
            </div>
        </form>
        {{-- </div> --}}
    </div>
