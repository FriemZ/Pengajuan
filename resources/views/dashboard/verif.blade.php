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
                    @if ($jenis == 'magang')
                        <th>Instansi</th>
                    @endif
                    @if ($jenis == 'skripsi')
                        <th>File</th>
                    @endif
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
                        @if ($pengajuan->jenis == 'magang')
                            <td>{{ $pengajuan->instansi }}</td>
                        @endif
                        @if ($pengajuan->jenis == 'skripsi')
                            <td>
                                @if ($pengajuan->file)
                                    <a href="{{ asset($pengajuan->file) }}" target="_blank" rel="noopener noreferrer">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </td>
                        @endif
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
                            @if ($pengajuan->jenis == 'magang')
                                @if ($pengajuan->status == 'menunggu' && !$pengajuan->dokumenSurat)
                                    {{-- Form Setujui --}}
                                    <form action="{{ route('buatSurat', $pengajuan->id) }}" method="POST" class=" d-flex">
                                        @csrf
                                        <select name="dosen_id" class="form-select form-select-sm mb-1" required>
                                            <option value="">Pilih Dosen Pembimbing</option>
                                            @foreach ($koordinators as $jabatan => $items)
                                                <optgroup label="{{ $jabatan }}">
                                                    @foreach ($items as $koor)
                                                        <option value="{{ $koor->dosen->id }}">
                                                            {{ $koor->dosen->user->nama }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm"> <iconify-icon
                                                icon="mdi:check-bold" width="20" height="20"></iconify-icon></button>
                                    </form>

                                    {{-- Form Tolak --}}
                                    <form action="{{ route('tolakPengajuan', $pengajuan->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @endif
                            @else
                                <select name="dosen_id" id="select-dosen-{{ $pengajuan->id }}"
                                    class="form-select form-select-sm mb-1" required>
                                    @if (is_null($pengajuan->dosen_id))
                                        <option value="">Pilih Dosen Pembimbing</option>
                                    @endif
                                    @foreach ($koordinators as $jabatan => $items)
                                        <optgroup label="{{ $jabatan }}">
                                            @foreach ($items as $koor)
                                                <option value="{{ $koor->dosen->id }}">
                                                    {{ $koor->dosen->user->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $(function() {
                                            $('select[name="dosen_id"]').on('change', function() {
                                                let select = $(this);
                                                let selectedOption = select.find('option:selected');
                                                let dosenId = selectedOption.val();
                                                let dosenName = selectedOption.text();
                                                let pengajuanId = select.attr('id').replace('select-dosen-', '');

                                                if (dosenId) {
                                                    $.ajax({
                                                        url: `/pengajuan/set-dosen/${pengajuanId}`,
                                                        type: 'PUT',
                                                        data: {
                                                            _token: '{{ csrf_token() }}',
                                                            dosen_id: dosenId
                                                        },
                                                        success: function() {
                                                            // Update teks option pertama
                                                            let placeholderOption = select.find('option[value=""]');
                                                            placeholderOption.text(dosenName);
                                                            placeholderOption.prop('selected', true); // Set agar tetap terlihat
                                                        },
                                                        error: function() {
                                                            alert('Gagal menyimpan dosen pembimbing.');
                                                        }
                                                    });
                                                }
                                            });
                                        });
                                    </script>
                                </select>

                                <form action="{{ route('setujuPengajuan', $pengajuan->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf

                                    @method('PUT')
                                    <div class="input-group mb-2">
                                        <textarea name="catatan" class="form-control" placeholder="Catatan (opsional)..." rows="1"></textarea>
                                        <button type="submit" class="btn btn-success">
                                            <iconify-icon icon="mdi:check-circle-outline" width="24"
                                                height="24"></iconify-icon>
                                        </button>
                                    </div>
                                </form>

                                <form action="{{ route('tolakPengajuan', $pengajuan->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="catatan" value="">
                                    <button type="submit" class="btn btn-danger">
                                        <iconify-icon icon="mdi:close-circle-outline" width="24"
                                            height="24"></iconify-icon>
                                    </button>
                                </form>
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
