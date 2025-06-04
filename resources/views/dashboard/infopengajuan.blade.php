@extends('template.temp')
@section('content')
    <div class="container-fluid">
        <div class="row g-4">
            @foreach ($pengajuans as $pengajuan)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card shadow-sm h-100">
                        <div class="row g-0">
                            <!-- Kiri -->
                            <div class="col-12 col-sm-6 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title mb-1">
                                        {{ $pengajuan->jenis === 'magang' ? $pengajuan->instansi ?? '-' : 'Pengajuan Skripsi' }}
                                    </h5>
                                    <p class="text-muted text-capitalize mb-3">{{ $pengajuan->jenis }}</p>
                                </div>

                                <ul class="list-inline d-flex justify-content-between align-items-center mb-0">
                                    <!-- Status -->
                                    <li class="list-inline-item">
                                        @if ($pengajuan->status === 'disetujui')
                                            <iconify-icon icon="mdi:check-circle-outline" class="text-success"
                                                width="24" height="24" title="Disetujui"></iconify-icon>
                                        @elseif($pengajuan->status === 'ditolak')
                                            <iconify-icon icon="mdi:close-circle-outline" class="text-danger" width="24"
                                                height="24" title="Ditolak"></iconify-icon>
                                        @endif
                                    </li>

                                    <li class="list-inline-item text-muted small">
                                        {{ \Carbon\Carbon::parse($pengajuan->updated_at)->format('d-m-Y') }}
                                    </li>


                                    <!-- Download -->
                                    <li class="list-inline-item">
                                        @if ($pengajuan->dokumenSurat && $pengajuan->dokumenSurat->file_surat)
                                            <a href="{{ asset($pengajuan->dokumenSurat->file_surat) }}" download
                                                title="Download Surat">
                                                <iconify-icon icon="mdi:download-circle-outline" class="text-primary"
                                                    width="24" height="24"></iconify-icon>
                                            </a>
                                        @else
                                            <iconify-icon icon="mdi:file-remove-outline" class="text-muted" width="24"
                                                height="24" title="Tidak ada surat"></iconify-icon>
                                        @endif
                                    </li>
                                </ul>
                            </div>

                            <!-- Kanan -->
                            <div class="col-12 col-sm-6">
                                <div class="h-100 w-100">
                                    @if ($pengajuan->jenis === 'skripsi')
                                        <div class="p-3 d-flex align-items-center h-100 text-center bg-light">
                                            <p class="text-muted mb-0 w-100">
                                                {{ $pengajuan->catatan ?? 'Tidak ada catatan.' }}</p>
                                        </div>
                                    @elseif($pengajuan->jenis === 'magang')
                                        <div class="h-100" style="height: 300px;">
                                            @if ($pengajuan->dokumenSurat && $pengajuan->dokumenSurat->file_surat)
                                                <iframe src="{{ asset($pengajuan->dokumenSurat->file_surat) }}"
                                                    width="100%" height="100%"
                                                    style="border:none; object-fit: cover;"></iframe>
                                            @else
                                                <div class="d-flex justify-content-center align-items-center h-100">
                                                    <span class="text-muted text-center">Dokumen belum tersedia</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </div> <!-- end card -->
                </div>
            @endforeach
        </div>
    </div>
@endsection
