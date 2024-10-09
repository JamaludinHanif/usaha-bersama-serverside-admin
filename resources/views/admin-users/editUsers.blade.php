                    {{-- form register --}}
                    {{-- <div class="d-flex justify-content-center"> --}}
                    {{-- @dd($datas) --}}
                    <div class="">
                        <div class="p-2">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Edit User</h1>
                            </div>
                            <form id="formEdit" enctype="multipart/form-data">
                                {{-- @csrf --}}
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" name="name"
                                            class="form-control form-control-user input-name" id="name"
                                            placeholder="Nama" value="{{ $datas->name }}">
                                        <div class="invalid-feedback feedback-name"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="username"
                                            class="form-control form-control-user input-username" id="username"
                                            placeholder="Username" value="{{ $datas->username }}">
                                        <div class="invalid-feedback feedback-username"></div>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                        <select name="role" id="role" class="form-control input-role"
                                            aria-label="Default select example">
                                            <option value="" disabled selected>Pilih Role</option>
                                            <option value="admin" {{ $datas->role == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="user" {{ $datas->role == 'user' ? 'selected' : '' }}>User
                                            </option>
                                        </select>
                                        <div class="invalid-feedback feedback-role"></div>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <div class="mb-3 mb-sm-0 d-flex justify-content-center col">
                                        <img src="{{ $datas->image == null ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' : asset('storage/' . $datas->image) }}"
                                            width="100" alt="">
                                    </div>
                                    <div class="mb-3 mb-sm-0 col">
                                        <label for="image" class="form-label">Pilih Gambar Untuk Foto Profil
                                            *opsional</label>
                                        <input class="form-control input-image" type="file" id="image"
                                            name="image">
                                        <div class="invalid-feedback feedback-image"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="email" name="email"
                                            class="form-control form-control-user input-email" id="email"
                                            placeholder="Email" value="{{ $datas->email }}">
                                        <div class="invalid-feedback feedback-email"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password"
                                            class="form-control form-control-user input-password" id="password"
                                            placeholder="Password" value="">
                                        <div class="invalid-feedback feedback-password"></div>
                                    </div>
                                </div>
                                <div style="height: 20px" class=""></div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" data-id={{ $datas->id }} style="width: 50%" id="add-item"
                                        class="btn btn-primary btn-user btn-block tombol-simpan ladda-button">
                                        {{ $title }}
                                    </button>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                    {{-- </div> --}}
