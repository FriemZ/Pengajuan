@extends('template.temp')
@section('content')
    <div class="container-fluid">
        <div class="datatables">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-content-between">
                        <h4 class="card-title mb-0">Dosen Management</h4>
                        <button class="btn rounded-3 waves-effect waves-light btn-primary" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            Add Dosen
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>TTD</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dosens as $dosen)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($dosen->user->foto)
                                                <img src="{{ asset($dosen->user->foto) }}" alt="Foto" width="50">
                                            @else
                                                <span class="text-muted">No photo</span>
                                            @endif
                                        </td>
                                        <td>{{ $dosen->user->nama ?? '-' }}</td>
                                        <td>{{ $dosen->nip ?? '-' }}</td>
                                        <td>{{ $dosen->jabatan ?? '-' }}</td>
                                        <td>
                                            @if ($dosen->ttd_path)
                                                <a href="{{ asset($dosen->ttd_path) }}" target="_blank"
                                                    class="btn btn-sm btn-secondary">Lihat TTD</a>
                                            @else
                                                <span class="text-muted">No TTD</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dosen->koordinatorAktif)
                                                <form action="{{ route('koordinator.hapus') }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
                                                    <button class="btn btn-warning btn-sm" type="submit">Hapus
                                                        Koordinator</button>
                                                </form>
                                            @else
                                                <button class="setKoordinatorBtn btn btn-info btn-sm"
                                                    data-dosen-id="{{ $dosen->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#setKoordinatorModal">
                                                    Set Koordinator
                                                </button>
                                            @endif



                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit-modal-{{ $dosen->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('dosens.destroy', $dosen->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div id="edit-modal-{{ $dosen->id }}" class="modal fade" tabindex="-1"
                                        aria-labelledby="editModalLabel-{{ $dosen->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Dosen - {{ $dosen->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('dosens.update', $dosen->user->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Foto -->
                                                        <div class="mb-3">
                                                            <label for="foto-{{ $dosen->id }}" class="form-label">Upload
                                                                Foto</label>
                                                            <input type="file" class="form-control"
                                                                id="foto-{{ $dosen->id }}" name="foto"
                                                                accept="image/*">
                                                            @if ($dosen->foto)
                                                                <img src="{{ asset('storage/' . $dosen->foto) }}"
                                                                    width="50" class="mt-2">
                                                            @endif
                                                        </div>

                                                        <!-- TTD -->
                                                        <div class="mb-3">
                                                            <label for="ttd_path-{{ $dosen->id }}"
                                                                class="form-label">Upload TTD</label>
                                                            <input type="file" class="form-control"
                                                                id="ttd_path-{{ $dosen->id }}" name="ttd_path"
                                                                accept="image/*,application/pdf">
                                                            @if ($dosen->ttd_path)
                                                                <a href="{{ asset('storage/' . $dosen->ttd_path) }}"
                                                                    target="_blank" class="d-block mt-2">Lihat TTD Lama</a>
                                                            @endif
                                                        </div>

                                                        <!-- Nama -->
                                                        <div class="mb-3">
                                                            <label for="nama-{{ $dosen->id }}"
                                                                class="form-label">Nama</label>
                                                            <input type="text" class="form-control"
                                                                id="nama-{{ $dosen->id }}" name="nama"
                                                                value="{{ old('nama', $dosen->user->nama) }}" required>
                                                        </div>

                                                        <!-- Email (dari User) -->
                                                        <div class="mb-3">
                                                            <label for="email-{{ $dosen->id }}"
                                                                class="form-label">Email</label>
                                                            <input type="email" class="form-control"
                                                                id="email-{{ $dosen->id }}" name="email"
                                                                value="{{ old('email', $dosen->user->email) }}" readonly>
                                                        </div>

                                                        <!-- NIM -->
                                                        <div class="mb-3">
                                                            <label for="nip-{{ $dosen->id }}"
                                                                class="form-label">NIP</label>
                                                            <input type="text" class="form-control"
                                                                id="nip-{{ $dosen->id }}" name="nip"
                                                                value="{{ old('nip', $dosen->nip) }}">
                                                        </div>

                                                        <!-- Jabatan -->
                                                        <div class="mb-3">
                                                            <label for="jabatan-{{ $dosen->id }}"
                                                                class="form-label">Jabatan</label>
                                                            <input type="text" class="form-control"
                                                                id="jabatan-{{ $dosen->id }}" name="jabatan"
                                                                value="{{ old('jabatan', $dosen->jabatan) }}">
                                                        </div>

                                                        <!-- Jurusan -->
                                                        <div class="mb-3">
                                                            <label for="jurusan_id-{{ $dosen->id }}"
                                                                class="form-label">Jurusan</label>
                                                            <select class="form-control" name="jurusan_id"
                                                                id="jurusan_id-{{ $dosen->id }}">
                                                                @foreach (\App\Models\Jurusan::all() as $jurusan)
                                                                    <option value="{{ $jurusan->id }}"
                                                                        {{ $dosen->user->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                                                        {{ $jurusan->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>


                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Dosen</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Pilih Jabatan -->
                                    <div class="modal fade" id="setKoordinatorModal" tabindex="-1"
                                        aria-labelledby="setKoordinatorLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="setKoordinatorForm">
                                                @csrf
                                                <input type="hidden" name="dosen_id" id="modalDosenId">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Pilih Jabatan Koordinator</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="job_position_id"
                                                                class="form-label">Jabatan</label>
                                                            <select name="job_position_id" id="job_position_id"
                                                                class="form-select" required>
                                                                <option value="">-- Pilih Jabatan --</option>
                                                                @foreach ($job_positions as $job)
                                                                    <option value="{{ $job->id }}">
                                                                        {{ $job->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

            <!-- Add dosen Offcanvas -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add dosen</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="{{ route('dosens.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="foto" class="form-label">Upload Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ttd_path" class="form-label">Upload TTD</label>
                            <input type="file" class="form-control" id="ttd_path" name="ttd_path"
                                accept="image/*,application/pdf">
                            @error('ttd_path')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama') }}" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip"
                                value="{{ old('nip') }}">
                            @error('nip')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="conf_pass" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="conf_pass" name="conf_pass" required>
                            @error('conf_pass')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select class="form-control" name="jurusan_id" id="jurusan_id">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach (\App\Models\Jurusan::all() as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                value="{{ old('jabatan') }}">
                            @error('jabatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        // Pastikan Anda menambahkan event listener untuk membuka modal dengan dosen_id yang benar
        document.querySelectorAll('.setKoordinatorBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                const dosenId = this.getAttribute('data-dosen-id');
                document.getElementById('modalDosenId').value = dosenId;
                // Open modal programmatically if needed
                const myModal = new bootstrap.Modal(document.getElementById('setKoordinatorModal'));
                myModal.show();
            });
        });

        document.getElementById('setKoordinatorForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('koordinator.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert("Koordinator berhasil diset");
                        window.location.reload();
                    } else {
                        alert("Gagal: " + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan.");
                });
        });
    </script>
@endsection
