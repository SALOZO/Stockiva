<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $noKwitansi }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11pt; color: #000; }
        .page { padding: 15mm 20mm; }

        /* Header */
        .header { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .company-name { font-size: 18pt; font-weight: bold; color: #1a3a6b; }
        .company-sub { font-size: 9pt; color: #333; margin-top: 3px; }

        /* Judul */
        .judul {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 20px;
            padding-bottom: 5px;
        }

        /* Info atas 2 kolom */
        .info-table { width: 100%; margin-bottom: 25px; }
        .info-table td { padding: 2px 0; vertical-align: top; font-size: 10.5pt; }
        .info-table td.label { width: 90px; }
        .info-table td.colon { width: 10px; }
        .info-table td.value { }

        /* Body kwitansi */
        .body-table { width: 100%; margin-bottom: 15px; }
        .body-table td { padding: 6px 0; vertical-align: top; font-size: 11pt; }
        .body-table td.label { width: 150px; }
        .body-table td.colon { width: 15px; }

        /* Total */
        .total-box { text-align: right; margin-bottom: 20px; }
        .total-box .label-rp { font-size: 13pt; font-weight: bold; margin-right: 30px; }
        .total-box .nilai { font-size: 15pt; font-weight: bold; }

        /* Rekening */
        .rekening { font-size: 10pt; margin-bottom: 30px; }
        .rekening p { margin-bottom: 3px; }

        /* TTD */
        .ttd { text-align: center; float: right; width: 220px; }
        .ttd .space { height: 70px; }
        .ttd .nama { font-weight: bold; text-decoration: underline; font-size: 11pt; }
        .ttd .jabatan { font-size: 10pt; }
    </style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <div class="header">
        <table>
            <tr>
                <td style="width:80px; vertical-align:middle;">
                    @if($logo)
                        <img src="{{ $logo }}" style="max-width:70px; max-height:70px;">
                    @endif
                </td>
                <td style="vertical-align:middle; padding-left:12px;">
                    <div class="company-name">{{ strtoupper($company?->nama_perusahaan) }}</div>
                    <div class="company-sub">{{ $company?->alamat_lengkap }}</div>
                    <div class="company-sub">{{ $company?->kontak_lengkap }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- JUDUL --}}
    <div class="judul">KWITANSI</div>

    {{-- INFO 2 KOLOM --}}
    <table class="info-table">
        <tr>
            <td style="width:50%; vertical-align:top;">
                <table>
                    <tr>
                        <td class="label">No.</td>
                        <td class="colon">:</td>
                        <td>{{ $noKwitansi }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pelanggan</td>
                        <td class="colon">:</td>
                        <td>{{ $pesanan->client->nama_client }}</td>
                    </tr>
                    <tr>
                        <td class="label">Alamat</td>
                        <td class="colon">:</td>
                        <td>{{ $pesanan->client->kabupaten_kota ?? $pesanan->client->alamat }}</td>
                    </tr>
                </table>
            </td>
            <td style="width:50%; vertical-align:top; padding-left:20px;">
                <table>
                    <tr>
                        <td class="label">No. SPH</td>
                        <td class="colon">:</td>
                        <td>{{ $pesanan->no_sph }}</td>
                    </tr>
                    <tr>
                        <td class="label">No. Invoice</td>
                        <td class="colon">:</td>
                        <td>{{ $pesanan->no_invoice ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal</td>
                        <td class="colon">:</td>
                        <td>{{ $tglSurat }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- BODY --}}
    <table class="body-table">
        <tr>
            <td class="label">Telah diterima dari</td>
            <td class="colon">:</td>
            <td>{{ $pesanan->client->nama_client }}</td>
        </tr>
        <tr>
            <td class="label">Uang sejumlah</td>
            <td class="colon">:</td>
            <td>{{ $terbilang }}</td>
        </tr>
        <tr>
            <td class="label">Untuk pembayaran</td>
            <td class="colon">:</td>
            <td>{{ $untukPembayaran }}</td>
        </tr>
    </table>

    {{-- TOTAL --}}
    <div class="total-box">
        <span class="label-rp">Rp.</span>
        <span class="nilai">{{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</span>
    </div>

    {{-- REKENING --}}
    @if($bank)
    <div class="rekening">
        <p>Pembayaran dapat dilakukan dengan mentransfer ke rekening :</p>
        <p style="padding-left:15px;">- {{ $bank->nama_bank }}{{ $bank->cabang ? ' ' . $bank->cabang : '' }}</p>
        <p style="padding-left:22px;">{{ $bank->nomor_rekening }}</p>
        <p style="padding-left:22px;">a/n {{ $bank->atas_nama }}</p>
    </div>
    @endif

    {{-- TTD --}}
    <div class="ttd">
        <p>{{ $company?->kota }}, {{ $tglSurat }}</p>
        <p style="margin-top:4px;"><strong>{{ $company?->nama_perusahaan }}</strong></p>
        @if($ttd_base64)
            <img src="{{ $ttd_base64 }}" style="height:60px; margin: 5px 0;">
        @else
            <div class="space"></div>
        @endif
        <p class="nama">{{ $approved_by }}</p>
        <p class="jabatan">{{ strtoupper($approved_jabatan ?? 'DIREKTUR') }}</p>
    </div>
    <div style="clear:both;"></div>

</div>
</body>
</html>