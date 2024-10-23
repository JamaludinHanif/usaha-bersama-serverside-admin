                    {{-- form register --}}
                    {{-- <div class="d-flex justify-content-center"> --}}
                    <div class="">
                        <div class="p-2">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Bunga</h1>
                            </div>
                            <form id="formCreate" enctype="multipart/form-data">
                                {{-- @csrf --}}
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">Nama Bunga :</span>
                                    <input type="text" class="form-control input-name" name="name" id="name"
                                        placeholder="contoh (nyicil pemula)" aria-describedby="basic-addon3">
                                    <div class="invalid-feedback feedback-name"></div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Bunga :</span>
                                    <input type="number" class="form-control input-interest" name="interest" id="interest"
                                        placeholder="Contoh : 10" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                    <div class="invalid-feedback feedback-interest"></div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Jumlah Tanggal :</span>
                                    <input type="number" class="form-control input-amount_day" name="amount_day" id="amount_day"
                                        placeholder="Contoh : 7" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">Hari/Minggu</span>
                                    <div class="invalid-feedback feedback-amount_day"></div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                        <select name="unit_date" id="unit_date" class="form-control input-unit_date"
                                            aria-label="Default select example">
                                            <option value="" disabled selected>Pilih Satuan Tanggal</option>
                                            <option value="hari">Hari</option>
                                            <option value="minggu">Minggu</option>
                                        </select>
                                        <div class="invalid-feedback feedback-unit_date"></div>
                                    </div>
                                </div>
                                <div style="height: 20px" class=""></div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" style="width: 50%" id="add-item"
                                        class="btn btn-primary btn-bunga btn-block tombol-tambah ladda-button">
                                        Tambah Bunga
                                    </button>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                    {{-- </div> --}}
