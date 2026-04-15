<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $noKwitansi }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11pt; color: #000; }
        .page { padding: 15mm 20mm; }

        .header { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .company-name { font-size: 18pt; font-weight: bold; color: #1a3a6b; }
        .company-sub { font-size: 9pt; color: #333; margin-top: 3px; }

        .judul {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 20px;
            padding-bottom: 5px;
        }

        .info-table { width: 100%; margin-bottom: 25px; }
        .info-table td { padding: 2px 0; vertical-align: top; font-size: 10.5pt; }
        .info-table td.label { width: 90px; }
        .info-table td.colon { width: 10px; }

        .body-table { width: 100%; margin-bottom: 15px; }
        .body-table td { padding: 6px 0; vertical-align: top; font-size: 11pt; }
        .body-table td.label { width: 150px; }
        .body-table td.colon { width: 15px; }

        /* Total box */
        .total-section { margin-bottom: 20px; }
        .total-row { display: flex; justify-content: flex-end; align-items: center; gap: 20px; margin-bottom: 4px; }
        .total-row .lbl { font-size: 11pt; }
        .total-row .val { font-size: 13pt; font-weight: bold; min-width: 150px; text-align: right; }
        .total-row.ppn-row .lbl { font-size: 10.5pt; }
        .total-row.ppn-row .val { font-size: 11pt; font-weight: normal; }
        .total-row.grand .val { font-size: 15pt; }
        .divider-total { border-top: 1px solid #000; margin: 4px 0; width: 300px; float: right; clear: both; }

        .rekening { font-size: 10pt; margin-bottom: 30px; }
        .rekening p { margin-bottom: 3px; }

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
    <div class="total-section">
        {{-- DPP --}}
        <div class="total-row">
            <span class="lbl">Rp.</span>
            <span class="val">{{ number_format($dpp, 0, ',', '.') }}</span>
        </div>

        {{-- PPN — hanya muncul jika aktif --}}
        @if($ppn_aktif)
        {{-- <div class="divider-total"></div> --}}
        <div class="total-row ppn-row">
            <span class="lbl">PPN {{ $ppn_persen }}%</span>
            <span class="val">{{ number_format($ppn, 0, ',', '.') }}</span>
        </div>
        {{-- <div class="divider-total"></div> --}}
        <div class="total-row grand">
            <span class="lbl"><strong>Total termasuk PPN</strong></span>
            <span class="val">{{ number_format($total_include_ppn, 0, ',', '.') }}</span>
        </div>
        @endif
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
        <div class="space"></div>
        <p class="nama">{{ $company?->nama_direktur }}</p>
        <p class="jabatan">{{ $company?->jabatan_direktur ?? 'Direktur' }}</p>
    </div>
    <div style="clear:both;"></div>

</div>
</body>
</html>