@extends('template.temp')
@section('content')
    <!-- Content -->
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <!-- Profile Activitiy card -->
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Activitiy</h4>
                        <p class="card-subtitle">
                            Skirpsi n magang
                        </p>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab nav-justified gap-9 my-7" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link px-3 py-9 vstack gap-6 align-items-center text-center"
                                    data-bs-toggle="tab" href="#skripsi" role="tab">
                                    <iconify-icon icon="solar:user-circle-linear" class="fs-7"></iconify-icon>
                                    <span class="d-none d-md-inline-block">Pengajuan Skripsi</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active px-3 py-9 vstack gap-6 align-items-center text-center"
                                    data-bs-toggle="tab" href="#magang" role="tab">
                                    <iconify-icon icon="solar:user-circle-linear" class="fs-7"></iconify-icon>
                                    <span class="d-none d-md-inline-block">Pengajuan Magang</span>
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            {{-- FORM SKRIPSI --}}
                            <div class="tab-pane" id="skripsi" role="tabpanel">
                                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="jenis" value="skripsi">
                                    <input type="hidden" name="tipe" value="sendiri"> {{-- karena skripsi default sendiri --}}

                                    <input type="hidden" name="keperluan" value="Pengajuan Skripsi">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Upload Proposal (PDF)</label>
                                        <input type="file" name="file" accept=".pdf" class="form-control" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Kirim Pengajuan Skripsi</button>
                                </form>
                            </div>


                            {{-- FORM MAGANG --}}
                            <div class="tab-pane active" id="magang" role="tabpanel">
                                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="jenis" value="magang">

                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Nama Instansi</label>
                                        <input type="text" name="instansi" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
                                        <input type="text" name="alamat_instansi" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jangka_waktu" class="form-label">Jangka Waktu</label>
                                        <input type="text" name="jangka_waktu" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipe" class="form-label">Tipe Pengajuan</label>
                                        <select name="tipe" id="tipe" class="form-control" required
                                            onchange="toggleKelompokFields()">
                                            <option value="sendiri">Sendiri</option>
                                            <option value="kelompok">Kelompok</option>
                                        </select>
                                    </div>

                                    <!-- FIELD TAMBAHAN UNTUK KELOMPOK -->
                                    <div id="kelompok-fields" style="display: none;">
                                        <hr>
                                        <div class="mb-3">
                                            <select name="anggota_id[]" class="select2 form-control" multiple>
                                                <option value="">-- Pilih Mahasiswa --</option>
                                                @foreach ($mahasiswas as $mhs)
                                                    <option value="{{ $mhs->id }}">{{ $mhs->nama }} -
                                                        {{ $mhs->nim }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" name="keperluan" value="Pengajuan Magang">

                                    <button type="submit" class="btn btn-success">Kirim Pengajuan Magang</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <script>
        function toggleKelompokFields() {
            var tipe = document.getElementById('tipe').value;
            var kelompokFields = document.getElementById('kelompok-fields');
            if (tipe === 'kelompok') {
                kelompokFields.style.display = 'block';
            } else {
                kelompokFields.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleKelompokFields(); // Inisialisasi saat load
        });
    </script>
@endsection
