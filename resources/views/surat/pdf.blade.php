<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar</title>
    <link href="{{ public_path('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            /* kecilkan font juga */
            margin: 0;
            padding: 10px;
            border: 2px solid black;
        }

        .surat-container {
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }


        .header img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 15px;
        }

        .content table td,
        .footer table td {
            padding: 5px 10px;
            vertical-align: top;
        }

        .content table,
        .footer table {
            font-size: 12px;
        }

        .footer {
            margin-top: 40px;
        }

        .signature-space {
            height: 60px;
        }

        .text-small {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        table td {
            padding: 1px 3px !important;
            vertical-align: top;
        }

        td[style*="padding-bottom: 65px"] {
            padding-bottom: 20px !important;
        }
    </style>
</head>

<body>
    <div class="surat-container">
        <div class="header text-center">
            <img src="{{ public_path('images/header.png') }}" alt="Logo">
        </div>

        <div class="content">
            <table class="table table-borderless">
                <tr>
                    <td style="width: 37%;">Nama</td>
                    <td>: {{ $user->nama ?? $pengajuan->user->nama }}</td>
                </tr>
                <tr>
                    <td>NPM</td>
                    <td>: {{ $user->nim ?? $pengajuan->user->nim }}</td>
                </tr>
                <tr>
                    <td>Prodi</td>
                    <td>: {{ $pengajuan->user->jurusan->nama }}</td>
                </tr>
                <tr>
                    <td>Dosen Pembimbing</td>
                    <td>:</td>
                </tr>
            </table>

            <table class="table table-borderless">
                <tr>
                    <td style="width: 37%;">Surat Pengantar</td>
                    <td>: 1. Pengantar KP / Magang</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp; 2. Pengantar Thesis</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp; 3. Pengantar Dosen Pembimbing I Thesis</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp; 4. Magang</td>
                </tr>
                <tr>
                    <td>Instansi/Perusahaan</td>
                    <td>: {{ $pengajuan->instansi }}</td>
                </tr>
            </table>

            <table class="table table-borderless">
                <tr>
                    <td colspan="2"><u>Isian untuk pengantar KP/Magang</u></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 45px; width: 37%;;">Judul Penelitian</td>
                    <td style="padding-bottom: 5px;">:</td>
                </tr>
                <tr>
                    <td style="width: 37%;">Jangka Waktu Penelitian</td>
                    <td>: {{ $pengajuan->jangka_waktu }}</td>
                </tr>
                <tr>
                    <td style="width: 37%;">Identitas Surat Balasan</td>
                    <td>: {{ $pengajuan->identitas_surat_balasan }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p class="text-center" style="font-size: 12px;">Sumenep, {{ now()->translatedFormat('d F Y') }}</p>
            <table class="table table-borderless w-100" style="font-size: 12px;">
                <tr>
                    <td class="text-center" style="padding-right: 60px;">Mengetahui</td>
                    <td class="text-center" style="padding-left: 60px;">Pemohon</td>
                </tr>
                <tr>
                    <td class="text-center" style="padding-right: 60px;">Koordinator KP/Magang</td>
                    <td class="text-center" style="padding-left: 60px;"></td>
                </tr>
                <tr>
                    <td class="text-center" style="padding-bottom: 10px; padding-right: 60px;">
                        <img src="{{ public_path($dosen->ttd_path) }}" alt="Tanda Tangan" style="max-height: 70px;">
                    </td>

                    <td class="text-center" style="padding-bottom: 70px;"></td>
                </tr>
                <tr>
                    <td class="text-center" style="padding-right: 60px;">( {{ $dosen->user->nama }} )</td>
                    <td class="text-center" style="padding-left: 60px;">{{ $user->nama ?? $pengajuan->user->nama }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center" style="padding-right: 60px;">NIP. {{ $dosen->nip ?? '-' }}</td>
                    <td class="text-center" style="padding-left: 60px;">NIM. {{ $user->nim ?? $pengajuan->user->nim }}
                    </td>
                </tr>
            </table>

        </div>
    </div>

</body>

</html>
