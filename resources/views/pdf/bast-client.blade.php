<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BAST Client - {{ $no_bast }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.45;
        }

        .doc-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .doc-info td {
            border: none;
            padding: 2px 0;
            vertical-align: top;
        }

        .content {
            margin: 8px 0;
        }
        .content p {
            margin: 6px 0;
        }

        .info-table {
            border-collapse: collapse;
            margin-left: 20px;
            width: calc(100% - 20px);
        }
        .info-table td {
            padding: 2px 0;
            vertical-align: top;
            border: none;
        }
        .info-table td.lbl {
            width: 145px;
            white-space: nowrap;
        }
        .info-table td.sep {
            width: 12px;
        }

        .sebanyak-row {
            margin: 2px 0 2px 20px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
        }
        table.items th {
            padding: 5px 6px;
            border: 1px solid #333;
            text-align: center;
            font-size: 10pt;
        }
        table.items td {
            padding: 4px 6px;
            border: 1px solid #333;
            font-size: 10pt;
        }
        .text-center { text-align: center; }


        .sig-section {
            margin-top: 20px;
            width: 100%;
        }

        .sig-top {
            width: 100%;
            border-collapse: collapse;
        }
        .sig-top td {
            width: 50%;
            vertical-align: top;
            padding-bottom: 35px; 
        }
        .sig-top td.right {
            text-align: right;
        }

        .sig-bottom {
            width: 100%;
            border-collapse: collapse;
        }
        .sig-bottom td {
            width: 50%;
            vertical-align: top;
        }
        .sig-bottom td.right {
            text-align: right;
        }
        .sig-name {
            text-decoration: underline;
            font-weight: bold;
        }
        .sig-role {
            font-size: 9.5pt;
        }

        .sig-divider {
            border-top: 1px solid #ccc;
            margin: 8px 0;
        }
    </style>
</head>
<body>

<table class="doc-info">
    <tr>
        <td style="width:55%;">
            <strong>No.</strong> : {{ $no_bast }}
        </td>
        <td style="width:45%; text-align:right;">
            {{ $company->kota }}, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
        </td>
    </tr>
    <tr>
        <td><strong>Perihal</strong> : {{ $perihal }}</td>
        <td></td>
    </tr>
    <tr>
        <td><strong>Lampiran</strong> : -</td>
        <td></td>
    </tr>
</table>

@php
    $kontrak = \App\Models\DokumenKontrak::where('pesanan_id', $pengiriman->pesanan_id)->latest()->first();
@endphp

<div class="content">

    <p>Berdasarkan pesanan yang kami terima melalui  <strong>{{ $kontrak->jenis }}</strong>  : <strong>{{  $kontrak->nomor_kontrak }}</strong> tertanggal : <strong>{{ $kontrak->tanggal_kontrak->format('d/m/Y') }}</strong>, dengan ini kami serahkan barang pesanan pada :</p>

    <table class="info-table">
        <tr>
            <td class="lbl">Hari</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->hari_penyerahan }}</td>
        </tr>
        <tr>
            <td class="lbl">Tanggal</td>
            <td class="sep">:</td>
            <td>{{ \Carbon\Carbon::parse($pengiriman->tanggal_penyerahan)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <p><strong>Untuk tujuan :</strong></p>
    <table class="info-table">
        <tr>
            <td class="lbl">Nama Instansi</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->pesanan->client->nama_client ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Nama Pemesan</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->pesanan->client->nama_pic ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Nama Penerima</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->penerima_client ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Jabatan Penerima</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->jabatan_penerima ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Alamat Tujuan</td>
            <td class="sep">:</td>
            <td>{{ trim(implode(', ', array_filter([
                $pengiriman->pesanan->client->alamat ?? '',
                $pengiriman->pesanan->client->desa ?? '',
                $pengiriman->pesanan->client->kecamatan ?? '',
                $pengiriman->pesanan->client->kabupaten_kota ?? '',
                $pengiriman->pesanan->client->provinsi ?? '',
            ]))) }}</td>
        </tr>
    </table>

    <p><strong>Sebanyak :</strong></p>
    @foreach($pengiriman->detailPengiriman as $detail)
    <div class="sebanyak-row">
        {{ $detail->jumlah_kirim }} {{ $detail->satuanKirim->nama_satuan }}
    </div>
    @endforeach

    <p><strong>Melalui :</strong></p>
    <table class="info-table">
        <tr>
            <td class="lbl">Nama Ekspedisi</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->ekspedisi ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Nama Kurir</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->nama_kurir ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">No Telp Kurir</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->kurir_no_telp ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Identitas Kurir</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->kurir_jenis_identitas }}</td>
        </tr>
        <tr>
            <td class="lbl">No. Identitas</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->kurir_no_identitas ?? '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Plat Nomer Kurir</td>
            <td class="sep">:</td>
            <td>{{ $pengiriman->kurir_plat_nomor ?? '' }}</td>
        </tr>
    </table>

    <p><strong>Dengan rincian barang :</strong></p>
    <table class="items">
        <thead>
            <tr>
                <th width="8%">No.</th>
                <th width="52%">Nama Barang</th>
                <th width="20%">Jumlah</th>
                <th width="20%">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengiriman->detailPengiriman as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $detail->detailPesanan->barang->nama_barang ?? '-' }}</td>
                <td class="text-center">{{ $detail->jumlah_kirim }}</td>
                {{-- <td class="text-center">{{ $detail->satuanKirim->nama_satuan ?? '-' }}</td> --}}
                <td class="text-center">{{ $detail->detailPesanan->barang->satuan->nama_satuan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align: justify;">Demikian Berita Acara Serah Terima Barang Pengiriman untuk Pelanggan ini dibuat untuk digunakan sebagai bukti telah diserahkannya barang sesuai pesanan untuk selanjutnya dapat ditindaklanjuti oleh Pihak Pemesan/Klien. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

</div>


<div class="sig-section">

    <table class="sig-top">
        <tr>
            <td>
                <div>{{ $pengiriman->pesanan->client->nama_client ?? 'Nama Klien' }}</div>
            </td>
            <td class="right">
                <div>{{ $company->nama_perusahaan ?? 'PT.Catur Niaga Sagara' }}</div>
            </td>
        </tr>
    </table>

    <table class="sig-bottom">
        <tr>
            <td>
                <div class="sig-name">{{ $pengiriman->pesanan->client->nama_pic ?? 'Nama Pemesan' }}</div>
                <div class="sig-role">{{ $pengiriman->pesanan->client->jabatan_pic ?? 'Jabatan Pemesan' }}</div>
            </td>
            <td class="right">
                <div class="sig-name">{{ $company->nama_direktur ?? 'Nama Direktur' }}</div>
                <div class="sig-role"><strong>Direktur</strong></div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>