<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pemberitahuan Permohonan Pedagang</title>
    <style>
        @page {
            size: A4;
            margin: 5mm;
        }

    body {
        font-family: "Times New Roman", serif;
        font-size: 11pt;
        line-height: 1.3;
        margin: 0;
        padding: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: avoid;
    }

    p {
        margin: 2px 0;
        text-align: justify;
    }

    .judul {
        text-align: center;
        font-weight: bold;
        margin-top: 20px;
    }

    .kop-surat {
        margin-bottom: 10px;
    }

    .kop-surat img {
        display: block;
        margin: auto;
    }

    .garis-kop {
        border-bottom: 2px solid black;
        border-top: 1px solid black;
        margin-top: 15px;
        margin-bottom: 10px;
    }

    .isi {
        margin: 20px 60px 10px 60px;
    }

    .checkbox-img {
        width: 13px;
        height: 13px;
        vertical-align: middle;
        margin-right: 5px;
    }

    .ttd {
        width: 100%;
        margin-top: 30px;
    }

    .ttd td {
        text-align: center;
        vertical-align: top;
    }

    .ttd .kanan {
        width: 50%;
    }

    .isi-table td {
        vertical-align: top;
        padding-bottom: 5px;
    }

    .isi-utama {
        margin-top: 10px;
        text-align: justify;
    }

</style>

</head>

<body>
    <div class="kop-surat">
        <table>
            <tr>
                <td style="width: 90px; text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('backend/assets/images/logo_kota_dumai.png') }}" alt="Logo"
                        style="width:70px; height:auto;">
                </td>
                <td style="text-align: center; line-height: 1.2; padding-left: 20px;">
                    <span style="font-size: 12pt;">PEMERINTAH KOTA DUMAI</span><br>
                    <span style="font-size: 14pt; font-weight: bold;">DINAS PERDAGANGAN</span><br>
                    <span style="font-size: 10pt;">
                        Jl. Sultan Syarif Kasim No. 16 Telp (0765) 35760 Fax. (0765) 439750 Kode Pos 28815
                    </span><br>
                    <span style="font-size: 11pt; font-weight: bold;">D U M A I</span>
                </td>
                <td style="width: 70px;"></td>
            </tr>
        </table>
        <div class="garis-kop"></div>
    </div>

<div class="judul">
    <h3>PEMBERITAHUAN PERSETUJUAN ATAU PENOLAKAN MENJADI PEDAGANG</h3>
</div>

<div class="isi">
    <!-- Baris 1: Kepada -->
    <table class="isi-table">
        <tr>
            <td style="width:50%"></td>
            <td style="text-align: left;">
                Kepada :<br>
                Yth. {{ $permohonan->nama ?? '....................................' }}<br>
                Di - Dumai
            </td>
        </tr>
        <!-- Baris 2: Hal -->
        <tr>
            <td style="text-align:left;">Hal : Pemberitahuan</td>
            <td></td>
        </tr>
    </table>

    <div class="isi-utama">
        <p>Memperhatikan surat permohonan saudara tanggal {{ $tanggal_permohonan }}
            perihal permohonan menjadi pedagang, maka permohonan saudara :</p>

        <p>
            <img src="{{ strtolower($permohonan->status) === 'disetujui' ? public_path('backend/assets/images/ceklist.png') : public_path('backend/assets/images/ceklist_kosong.png') }}"
                alt="Check - DIKABULKAN" class="checkbox-img">
            DIKABULKAN, untuk selanjutnya kepada saudara diminta untuk hadir di Kantor UPT. Pelayanan Pasar /
            koordinator Pasar untuk segera mengikuti arahan langkah selanjutnya.
        </p>

        <p>
            <img src="{{ strtolower($permohonan->status) === 'ditolak' ? public_path('backend/assets/images/ceklist.png') : public_path('backend/assets/images/ceklist_kosong.png') }}"
                alt="Check - TIDAK DIKABULKAN" class="checkbox-img">
            TIDAK DIKABULKAN, karena {{ strtolower($permohonan->status) === 'ditolak' ? $permohonan->keterangan : '..........................................................................................' }}
        </p>

        <p>Demikian, atas perhatiannya diucapkan terima kasih.</p>
    </div>

    <!-- Tanda Tangan -->
    <table class="ttd">
        <tr>
            <td></td>
            <td class="kanan">
                Dumai, {{ $tanggal }}<br>
                KEPALA<br>
                <strong style="font-size: 14pt; text-transform: uppercase;">DTO</strong><br>
                <strong>Zulfikar, SE, M.Si.</strong><br>
                ( ................................... )
            </td>
        </tr>
    </table>
</div>

</body>

</html>
