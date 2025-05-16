@extends('template.temp')
@section('content')
    <div class="container-fluid">
        <div class="datatables">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-content-between">
                        <h4 class="card-title mb-0">Mahasiswa Management</h4>
                        <button class="btn rounded-3 waves-effect waves-light btn-primary" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            Add Mahasiswa
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Jurusan</th>
                                    <th>Acion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $mahasiswa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($mahasiswa->foto)
                                                <img src="{{ asset($mahasiswa->foto) }}" alt="Foto" width="50">
                                            @else
                                                <span class="text-muted">No photo</span>
                                            @endif
                                        </td>
                                        <td>{{ $mahasiswa->nama }}</td>
                                        <td>{{ $mahasiswa->nim }}</td>
                                        <td>{{ $mahasiswa->jurusan->nama ?? '-' }}</td>
                                        <td>
                                            <!-- Tombol trigger modal edit -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit-modal-{{ $mahasiswa->id }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('mahasiswas.destroy', $mahasiswa->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit mahasiswa -->
                                    <div id="edit-modal-{{ $mahasiswa->id }}" class="modal fade" tabindex="-1"
                                        aria-labelledby="editModalLabel-{{ $mahasiswa->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit mahasiswa - {{ $mahasiswa->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('mahasiswas.update', $mahasiswa->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3">
                                                            <label for="foto-{{ $mahasiswa->id }}"
                                                                class="form-label">Upload Foto</label>
                                                            <input type="file" class="form-control"
                                                                id="foto-{{ $mahasiswa->id }}" name="foto"
                                                                accept="image/*">
                                                            @if ($mahasiswa->foto)
                                                                <img src="{{ asset($mahasiswa->foto) }}" width="50"
                                                                    class="mt-2">
                                                            @endif
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="nama-{{ $mahasiswa->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="nama-{{ $mahasiswa->id }}" name="nama"
                                                                value="{{ old('nama', $mahasiswa->nama) }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email-{{ $mahasiswa->id }}"
                                                                class="form-label">Email</label>
                                                            <input type="email" class="form-control"
                                                                id="email-{{ $mahasiswa->id }}" name="email"
                                                                value="{{ old('email', $mahasiswa->email) }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="nim-{{ $mahasiswa->id }}"
                                                                class="form-label">NIM</label>
                                                            <input type="text" class="form-control"
                                                                id="nim-{{ $mahasiswa->id }}" name="nim"
                                                                value="{{ old('nim', $mahasiswa->nim) }}">
                                                        </div>


                                                        <div class="mb-3">
                                                            <label for="jurusan_id-{{ $mahasiswa->id }}"
                                                                class="form-label">Jurusan</label>
                                                            <select class="form-control" name="jurusan_id"
                                                                id="jurusan_id-{{ $mahasiswa->id }}">
                                                                @foreach (\App\Models\Jurusan::all() as $jurusan)
                                                                    <option value="{{ $jurusan->id }}"
                                                                        {{ $mahasiswa->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                                                        {{ $jurusan->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                mahasiswa</button>
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

        <!-- Add mahasiswa Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add mahasiswa</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{ route('mahasiswas.store') }}" method="POST" enctype="multipart/form-data">
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
