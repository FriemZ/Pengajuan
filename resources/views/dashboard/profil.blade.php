@extends('template.temp')
@section('content')
    <!-- Content -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-xl-12">
                <div class="card">
                    <div class="card-body p-2">
                        <img class="card-img-top w-100 profile-bg-height rounded overflow-hidden"
                            src="{{ asset('assets/images/backgrounds/profile-bg.jpg') }}" height="111"
                            alt="Card image cap" />
                        <div class="card-body little-profile text-center p-4">
                            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Foto Profil -->
                                <div class="pro-img mb-3">
                                    <img src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : asset('assets/images/profile/user-1.jpg') }}"
                                        alt="user" class="rounded-circle shadow-sm" width="112" height="112" />

                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label btn btn-outline-primary btn-sm">Ubah Foto
                                        Profil</label>
                                    <input type="file" name="foto" id="foto" class="form-control d-none"
                                        accept="image/*">
                                    @error('foto')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Nama -->
                                <h3 class="mb-1">
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                                        class="form-control text-center fs-4 fw-semibold" required>
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </h3>
                                <!-- Role/Job -->
                                <p class="fs-5 text-muted">{{ $user->role }}</p>

                                <!-- Email -->
                                <div class="mb-3">
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-control text-center" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <input type="password" name="password"
                                        placeholder="Password Baru (kosongkan jika tidak diubah)"
                                        class="form-control text-center">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                                        class="form-control text-center">
                                </div>

                                <button type="submit"
                                    class="waves-effect waves-dark btn btn-primary btn-md btn-rounded mb-4">
                                    Simpan Perubahan
                                </button>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
