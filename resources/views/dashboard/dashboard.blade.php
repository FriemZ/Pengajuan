@extends('template.temp')
@section('content')
    <!-- Content -->
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">

            @if (auth()->user()->role === 'mahasiswa')
                <div class="col-lg-6 col-6">
                    <div class="card text-bg-dark text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-ethereum display-6 text-white" title="ETH"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Ethereum
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$3589.00k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="card text-bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="JavaScript: void(0);">
                                    <i class="ti ti-currency-dogecoin display-6 text-white" title="LTC"></i>
                                </a>
                                <div class="ms-3">
                                    <h4 class="card-title mb-0 text-white">
                                        Dash
                                    </h4>
                                    <p class="text-white fs-4 mb-0 opacity-75">$900.00k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->role === 'dosen')
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body pb-0">
                            <h4 class="card-title">List Pengajuan Skripsi</h4>
                        </div>
                        <div class="message-box contact-box position-relative">
                            <div class="message-widget contact-widget position-relative">
                                @forelse ($pengajuans as $pengajuan)
                                    @if ($pengajuan->jenis === 'skripsi' && $pengajuan->dosen_id == auth()->user()->dosen->id)
                                        <div
                                            class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                                            <!-- Kiri: Foto dan Info Pengajuan -->
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="user-img position-relative">
                                                    <img src="../assets/images/profile/user-2.jpg" alt="user"
                                                        class="rounded-circle" width="50" height="50">
                                                    <span
                                                        class="profile-status position-absolute text-bg-secondary rounded-circle"
                                                        style="width: 10px; height: 10px; bottom: 2px; right: 2px;">
                                                    </span>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0 text-dark fw-semibold">{{ $pengajuan->user->nama }}</h5>
                                                    <small class="text-muted">
                                                        {{ ucfirst($pengajuan->status) }}
                                                        @if ($pengajuan->file)
                                                            |
                                                            <a href="{{ asset($pengajuan->file) }}" class="text-primary"
                                                                target="_blank">Lihat File</a>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Kanan: Tombol Aksi -->
                                            <div class="d-flex gap-2">
                                                <!-- Tombol Setujui -->
                                                <button type="button"
                                                    class="btn btn-sm bg-primary-subtle text-primary rounded-pill"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalCatatanSetujui-{{ $pengajuan->id }}"
                                                    title="Setujui">
                                                    <i data-feather="check" class="feather-sm"></i>
                                                </button>

                                                <!-- Tombol Tolak -->
                                                <button type="button"
                                                    class="btn btn-sm bg-danger-subtle text-danger rounded-pill"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalCatatanTolak-{{ $pengajuan->id }}" title="Tolak">
                                                    <i data-feather="x" class="feather-sm"></i>
                                                </button>


                                                <!-- Modal Setujui -->
                                                <div class="modal fade" id="modalCatatanSetujui-{{ $pengajuan->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST"
                                                            action="{{ route('pengajuans.verifikasi', $pengajuan->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Catatan Persetujuan</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis catatan (opsional)..."></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-success">Setujui</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Modal Tolak -->
                                                <div class="modal fade" id="modalCatatanTolak-{{ $pengajuan->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST"
                                                            action="{{ route('pengajuans.verifikasi', $pengajuan->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Catatan Penolakan</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis alasan penolakan..."></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Tolak</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="p-4 text-muted text-center">
                                        Belum ada pengajuan skripsi.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif



            @if (auth()->user()->role === 'admin')
                <div class="row justify-content-center gy-4">
                    @php
                        $cards = [
                            [
                                'url' => '/dosens',
                                'icon' => 'mdi:teacher',
                                'title' => 'Dosen',
                                'count' => $jumlahDosen,
                                'bg' => 'dark',
                            ],
                            [
                                'url' => '/mahasiswas',
                                'icon' => 'mdi:account-group',
                                'title' => 'Mahasiswa',
                                'count' => $jumlahMahasiswa,
                                'bg' => 'primary',
                            ],
                            [
                                'url' => '/jurusans',
                                'icon' => 'mdi:school-outline',
                                'title' => 'Jurusan',
                                'count' => $jumlahJurusan,
                                'bg' => 'danger',
                            ],
                            [
                                'url' => '/verifikasi',
                                'icon' => 'mdi:file-document-edit',
                                'title' => 'Pengajuan',
                                'count' => $jumlahPengajuan,
                                'bg' => 'info',
                            ],
                        ];
                    @endphp

                    @foreach ($cards as $card)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-6">
                            <a href="{{ $card['url'] }}" class="text-decoration-none">
                                <div class="card text-bg-{{ $card['bg'] }} text-white shadow-sm h-100 hover-scale">
                                    <div
                                        class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                                        <iconify-icon icon="{{ $card['icon'] }}" class="display-4 mb-3"></iconify-icon>
                                        <h5 class="card-title fw-bold text-white">{{ $card['title'] }}</h5>
                                        <p class="fs-3 mb-0 opacity-75">{{ $card['count'] }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <style>
                /* Hover efek zoom */
                .hover-scale {
                    transition: transform 0.3s ease;
                    cursor: pointer;
                }

                .hover-scale:hover {
                    transform: scale(1.05);
                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
                }

                /* Responsif font */
                @media (max-width: 576px) {
                    .card .card-body p {
                        font-size: 1.25rem !important;
                    }

                    .card .card-body h5 {
                        font-size: 1.15rem !important;
                    }

                    iconify-icon.display-4 {
                        font-size: 2.5rem !important;
                        margin-bottom: 1rem !important;
                    }
                }
            </style>


        </div>
    </div>
    <!-- / Content -->
@endsection
