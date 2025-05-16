<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;
            /* jarak antar baris surat */
        }

        td {
            border: 2px solid #000;
            vertical-align: top;
            padding: 6px;
            box-sizing: border-box;
            width: 50%;
        }

        .column {
            width: 96%;
            padding: 4px;
            box-sizing: border-box;
            border: 2px solid #000;
        }
    </style>
</head>

<body>
    @if ($pengajuan->tipe === 'sendiri')
        {{-- Tipe sendiri: tampil biasa, 1 halaman --}}
        @include('surat.pdf', [
            'user' => $pengajuan->user,
            'pengajuan' => $pengajuan,
            'dosen' => $dosen,
        ])
    @else
        {{-- Tipe kelompok: dua surat per halaman landscape --}}
        @php
            $allUsers = collect([$pengajuan->user])
                ->merge($anggotaList->pluck('user'))
                ->values();
        @endphp

        @foreach ($allUsers->chunk(2) as $chunk)
            <table>
                <tr>
                    @foreach ($chunk as $user)
                        <td>
                            <div class="column">

                                @include('surat.pdf', [
                                    'user' => $user,
                                    'pengajuan' => $pengajuan,
                                    'dosen' => $dosen,
                                ])
                            </div>
                        </td>
                    @endforeach
                </tr>
            </table>
        @endforeach
    @endif
</body>

</html>
