@extends('template.temp')
@section('content')
    <div class="container-fluid">
        <div class="datatables">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-content-between">
                        <h4 class="card-title mb-0">Rekapitulasi Pengajuan Magang Disetujui</h4>
                    </div>
                    <div class="table-responsive">
                        <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengaju</th>
                                    <th>NIM</th>
                                    <th>Jurusan</th>
                                    <th>Instansi</th>
                                    <th>Alamat Instansi</th>
                                    <th>Jangka Waktu</th>
                                    <th>Keperluan</th>
                                    <th class="no-export">Surat</th> <!-- Kolom baru -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuans as $pengajuan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengajuan->user->nama ?? '-' }}</td>
                                        <td>{{ $pengajuan->user->nim ?? '-' }}</td>
                                        <td>{{ $pengajuan->user->jurusan->nama ?? '-' }}</td>
                                        <td>{{ $pengajuan->instansi ?? '-' }}</td>
                                        <td>{{ $pengajuan->alamat_instansi ?? '-' }}</td>
                                        <td>{{ $pengajuan->jangka_waktu ?? '-' }}</td>
                                        <td>{{ $pengajuan->keperluan }}</td>
                                        <td class="no-export">
                                            @if ($pengajuan->dokumenSurat && $pengajuan->dokumenSurat->file_surat)
                                                <a href="{{ asset($pengajuan->dokumenSurat->file_surat) }}" download
                                                    class="btn btn-sm btn-primary" title="Download PDF">
                                                    <iconify-icon icon="mdi:download" width="20"
                                                        height="20"></iconify-icon>
                                                </a>
                                            @else
                                                <span class="text-muted">Belum tersedia</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
