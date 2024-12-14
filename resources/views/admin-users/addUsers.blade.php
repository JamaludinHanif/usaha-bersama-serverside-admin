                    {{-- form register --}}
                    {{-- <div class="d-flex justify-content-center"> --}}
                    <div class="">
                        <div class="p-2">
                            <form id="formCreate" enctype="multipart/form-data">
                                {{-- @csrf --}}
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" name="name"
                                            class="form-control form-control-user input-name" id="name"
                                            placeholder="Nama">
                                        <div class="invalid-feedback feedback-name"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="username"
                                            class="form-control form-control-user input-username" id="username"
                                            placeholder="Username">
                                        <div class="invalid-feedback feedback-username"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select name="roles" id="roles" class="form-control input-role"
                                            aria-label="Default select example">
                                            <option value="" disabled selected>Pilih Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="kasir">Kasir</option>
                                            <option value="user">User</option>
                                        </select>
                                        <div class="invalid-feedback feedback-role"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" name="no_hp"
                                            class="form-control form-control-user input-no_hp" id="no_hp"
                                            placeholder="No Hp, contoh 62851613100">
                                        <div class="invalid-feedback feedback-no_hp"></div>
                                    </div>
                                </div>
                                {{-- <div class="form-group d-flex justify-content-center">
                                    <div class="mb-3 mb-sm-0">
                                        <label for="image" class="form-label">Pilih Gambar Untuk Foto Profil *opsional</label>
                                        <input class="form-control input-image" type="file" id="image" name="image">
                                        <div class="invalid-feedback feedback-image"></div>
                                    </div>
                                </div> --}}
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    <input type="number" name="debt_limit" value="50000" id="debt_limit" class="form-control input-debt_limit"
                                        placeholder="Masukan Limit (tanpa menggunakan titik dan spasi)"
                                        aria-describedby="basic-addon1">
                                    <div class="invalid-feedback feedback-debt_limit"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="email" name="email"
                                            class="form-control form-control-user input-email" id="email"
                                            placeholder="Email">
                                        <div class="invalid-feedback feedback-email"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password"
                                            class="form-control form-control-user input-password" id="password"
                                            placeholder="Password">
                                        <div class="invalid-feedback feedback-password"></div>
                                    </div>
                                </div>
                                <div style="height: 20px" class=""></div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" style="width: 50%" id="add-item"
                                        class="btn btn-primary btn-user btn-block tombol-tambah ladda-button">
                                        Tambah User
                                    </button>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                    {{-- </div> --}}
