@extends('template.temp')
@section('content')
    <div class="container-fluid">
        <div class="datatables">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-content-between">
                        <h4 class="card-title mb-0">User Management</h4>
                        <button class="btn rounded-3 waves-effect waves-light btn-primary" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            Add User
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span
                                                class="btn 
        @if ($user->role == 'admin') btn-primary
        @elseif ($user->role == 'dosen')
            btn-warning text-white
        @elseif ($user->role == 'mahasiswa')
            btn-success 
        @else
            btn-secondary @endif
        btn-sm disabled">
                                                {{ $user->role }}
                                            </span>
                                        </td>

                                        <td>{{ $user->conf_pass }}</td>
                                        <td>
                                            <!-- Tombol trigger modal edit -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit-modal-{{ $user->id }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>


                                    <!-- Modal Edit User -->
                                    <div id="edit-modal-{{ $user->id }}" class="modal fade" tabindex="-1"
                                        aria-labelledby="editModalLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User - {{ $user->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('users.update', $user->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3">
                                                            <label for="foto-{{ $user->id }}" class="form-label">Upload
                                                                Foto</label>
                                                            <input type="file" class="form-control"
                                                                id="foto-{{ $user->id }}" name="foto"
                                                                accept="image/*">
                                                            @if ($user->foto)
                                                                <img src="{{ asset($user->foto) }}" width="50"
                                                                    class="mt-2">
                                                            @endif
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="nama-{{ $user->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="nama-{{ $user->id }}" name="nama"
                                                                value="{{ old('nama', $user->nama) }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email-{{ $user->id }}"
                                                                class="form-label">Email</label>
                                                            <input type="email" class="form-control"
                                                                id="email-{{ $user->id }}" name="email"
                                                                value="{{ old('email', $user->email) }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="nim-{{ $user->id }}"
                                                                class="form-label">NIM</label>
                                                            <input type="text" class="form-control"
                                                                id="nim-{{ $user->id }}" name="nim"
                                                                value="{{ old('nim', $user->nim) }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="password-{{ $user->id }}"
                                                                class="form-label">Password (Kosongkan jika tidak
                                                                diubah)</label>
                                                            <input type="password" class="form-control"
                                                                id="password-{{ $user->id }}" name="password">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="conf_pass-{{ $user->id }}"
                                                                class="form-label">Confirm Password</label>
                                                            <input type="password" class="form-control"
                                                                id="conf_pass-{{ $user->id }}" name="conf_pass">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="role-{{ $user->id }}"
                                                                class="form-label">Role</label>
                                                            <select class="form-control" name="role"
                                                                id="role-{{ $user->id }}" required>
                                                                <option value="admin"
                                                                    {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                                <option value="dosen"
                                                                    {{ $user->role == 'dosen' ? 'selected' : '' }}>Dosen
                                                                </option>
                                                                <option value="mahasiswa"
                                                                    {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>
                                                                    Mahasiswa</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="jurusan_id-{{ $user->id }}"
                                                                class="form-label">Jurusan</label>
                                                            <select class="form-control" name="jurusan_id"
                                                                id="jurusan_id-{{ $user->id }}">
                                                                @foreach (\App\Models\Jurusan::all() as $jurusan)
                                                                    <option value="{{ $jurusan->id }}"
                                                                        {{ $user->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                                                        {{ $jurusan->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                User</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add User Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add User</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="foto" class="form-label">Upload Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="conf_pass" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="conf_pass" name="conf_pass" required>

                        <!-- Tampilkan pesan error jika validasi gagal -->
                        @if ($errors->has('conf_pass'))
                            <div class="alert alert-danger mt-2">
                                The confirm password must match the password.
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" name="role" id="role" required>
                            <option value="admin">Admin</option>
                            <option value="dosen">Dosen</option>
                            <option value="mahasiswa">Mahasiswa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan_id" class="form-label">Jurusan</label>
                        <select class="form-control" name="jurusan_id" id="jurusan_id">
                            @foreach (\App\Models\Jurusan::all() as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

    </div>
@endsection
