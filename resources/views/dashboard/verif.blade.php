@extends('template.temp')
@section('content')
    <div class="container-fluid">
        <h3>Verifikasi Pengajuan Skripsi dan Magang</h3>

        {{-- Filter Jenis Pengajuan --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('verifikasi') }}">
                    <label for="jenis" class="form-label">Pilih Jenis Pengajuan:</label>
                    <select name="jenis" id="jenis" onchange="this.form.submit()"
                        class="form-control w-25 d-inline-block">
                        <option value="skripsi" {{ $jenis == 'skripsi' ? 'selected' : '' }}>Skripsi</option>
                        <option value="magang" {{ $jenis == 'magang' ? 'selected' : '' }}>Magang</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tabel Pengajuan --}}
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Jenis</th>
                    <th>Instansi</th>
                    <th>Keperluan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $pengajuan)
                    <tr>
                        <td>{{ $pengajuan->user->nama }}</td>
                        <td>{{ $pengajuan->user->nim }}</td>
                        <td>{{ ucfirst($pengajuan->jenis) }}</td>
                        <td>{{ $pengajuan->instansi }}</td>
                        <td>{{ $pengajuan->keperluan }}</td>
                        <td>
                            @if ($pengajuan->status == 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif ($pengajuan->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if ($pengajuan->status == 'menunggu' && !$pengajuan->dokumenSurat)
                                {{-- Form Setujui --}}
                                <form action="{{ route('buatSurat', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    <select name="dosen_id" class="form-select form-select-sm mb-1" required>
                                        <option value="">Pilih Dosen Pembimbing</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}">{{ $dosen->user->nama }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-success btn-sm">Setujui & Buat Surat</button>
                                </form>

                                {{-- Form Tolak --}}
                                <form action="{{ route('tolakPengajuan', $pengajuan->id) }}" method="POST" class="mt-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            @elseif ($pengajuan->status == 'disetujui' && $pengajuan->dokumenSurat)
                                <a href="{{ asset($pengajuan->dokumenSurat->file_surat) }}"
                                    class="btn btn-sm btn-secondary" target="_blank">📄 Lihat Surat</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada pengajuan {{ $jenis }}.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
