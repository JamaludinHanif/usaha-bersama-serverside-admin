                    {{-- form register --}}
                    {{-- <div class="d-flex justify-content-center"> --}}
                    <div class="">
                        <div class="p-2">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat User</h1>
                            </div>
                            <form id="formCreate" enctype="multipart/form-data">
                                {{-- @csrf --}}
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" name="name"
                                            class="form-control form-control-user input-name"
                                            id="name" placeholder="Nama" >
                                            <div class="invalid-feedback feedback-name"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="username"
                                            class="form-control form-control-user input-username"
                                            id="username" placeholder="Username" >
                                            <div class="invalid-feedback feedback-username"></div>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                        <select name="roles" id="roles" class="form-control input-role" aria-label="Default select example">
                                            <option value="" disabled selected>Pilih Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                        <div class="invalid-feedback feedback-role"></div>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <div class="mb-3 mb-sm-0">
                                        <label for="image" class="form-label">Pilih Gambar Untuk Foto Profil *opsional</label>
                                        <input class="form-control input-image" type="file" id="image" name="image">
                                        <div class="invalid-feedback feedback-image"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="email" name="email"
                                            class="form-control form-control-user input-email"
                                            id="email" placeholder="Email">
                                            <div class="invalid-feedback feedback-email"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password"
                                            class="form-control form-control-user input-password"
                                            id="password" placeholder="Password">
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
