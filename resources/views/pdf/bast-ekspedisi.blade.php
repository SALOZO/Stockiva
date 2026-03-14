<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BAST Ekspedisi</title>
    <style>
        @page {
            margin: 2cm 2.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.6;
        }

        /* Header info: No, Perihal, Lampiran + tanggal di kanan */
        .top-section {
            width: 100%;
            margin-bottom: 20px;
        }
        .top-left {
            float: left;
            width: 70%;
        }
        .top-right {
            float: right;
            width: 30%;
            text-align: right;
        }
        .clear { clear: both; }

        .info-table {
            border-collapse: collapse;
        }
        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .info-table td.lbl {
            width: 80px;
        }
        .info-table td.sep {
            width: 15px;
        }

        .section {
            margin: 14px 0 4px 0;
        }
        .row-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .row-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .row-table td.lbl {
            width: 30px; 
        }
        .row-table td.field-lbl {
            width: 120px;
        }
        .row-table td.sep {
            width: 15px;
        }
        .field-line {
            display: inline-block;
            min-height: 16px;
            width: 100%;
        }

        .addr-line {
            display: block;
            min-height: 16px;
            width: 100%;
            margin-top: 3px;
        }

        .sebanyak-row {
            display: flex;
            gap: 6px;
        }
        .sebanyak-qty {
            width: 20px;
        }


        .closing {
            margin-top: 20px;
            text-align: justify;
        }

        .ttd-section {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-top {
            width: 100%;
        }
        .ttd-top td {
            width: 50%;
            vertical-align: top;
            padding-bottom: 40px;
        }
        .ttd-top td.right {
            text-align: right;
        }
        .ttd-bottom {
            width: 100%;
        }
        .ttd-bottom td {
            width: 50%;
            vertical-align: top;
        }
        .ttd-bottom td.right {
            text-align: right;
        }
        .sig-name {
            text-decoration: underline;
            font-weight: bold;
        }
        .sig-role {
            font-size: 10pt;
        }
    </style>
</head>
<body>

<div class="top-section">
    <div class="top-left">
        <table class="info-table">
            <tr>
                <td class="lbl">No.</td>
                <td class="sep">:</td>
                <td>{{ $no_bast }}</td>
            </tr>
            <tr>
                <td class="lbl">Perihal</td>
                <td class="sep">:</td>
                <td>Bukti Serah Terima Barang Pengiriman untuk Ekspedisi</td>
            </tr>
            <tr>
                <td class="lbl">Lampiran</td>
                <td class="sep">:</td>
                <td>-</td>
            </tr>
        </table>
    </div>
    <div class="top-right">
        Bandung, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
    </div>
    <div class="clear"></div>
</div>


<div class="section">Telah diserahkan barang pengiriman pada:</div>

<table class="row-table">
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Hari</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd') }}</span></td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Tanggal</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</span></td>
    </tr>
</table>


<div class="section">Untuk tujuan :</div>

<table class="row-table">
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Nama Instansi</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ $pengiriman->pesanan->client->nama_client ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Nama Penerima</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ $nama_penerima ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Alamat Tujuan</td>
        <td class="sep">:</td>
        <td>
            @php
                $alamat = trim(implode(', ', array_filter([
                    $pengiriman->pesanan->client->alamat ?? '',
                    $pengiriman->pesanan->client->desa ?? '',
                    $pengiriman->pesanan->client->kecamatan ?? '',
                    $pengiriman->pesanan->client->kabupaten_kota ?? '',
                    $pengiriman->pesanan->client->provinsi ?? '',
                ])));
            @endphp
            <span class="field-line">{{ $alamat }}</span>
            <span class="addr-line"></span>
        </td>
    </tr>
</table>


<div class="section">Sebanyak :</div>
@foreach($pengiriman->detailPengiriman as $detail)
<div class="sebanyak-row">
    &nbsp;&nbsp;&nbsp;&nbsp;
    <span class="sebanyak-qty">{{ $detail->jumlah_packing }}</span>
    {{ $detail->satuanKirim->nama_satuan ?? 'Koli/Karung/Dus/Plastik' }} 
</div>
@endforeach

<div class="section">Kepada :</div>

<table class="row-table">
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Nama Ekspedisi</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ $ekspedisi->nama_ekspedisi ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Nama Kurir</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ $pengiriman->nama_kurir ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">No Telp Kurir</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ $pengiriman->kurir_no_telp?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Identitas Kurir</td>
        <td class="sep">:</td>
        <td>{{ $pengiriman->kurir_jenis_identitas }}</td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">No. Identitas</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ $pengiriman->kurir_no_identitas ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="field-lbl">Plat Nomer</td>
        <td class="sep">:</td>
        <td><span class="field-line">{{ $pengiriman->kurir_plat_nomor ?? '' }}</span></td>
    </tr>
</table>


<div class="closing">
    Demikian Bukti Serah Terima Barang Pengiriman untuk Ekspedisi ini dibuat untuk dapat dipertanggungjawabkan.
</div>


<div class="ttd-section">

    <table class="ttd-top">
        <tr>
            <td>
                <div>Nama Ekspedisi</div>
                <div><strong>{{ $ekspedisi->nama_ekspedisi ?? '' }}</strong></div>
            </td>
            <td class="right">
                <div>{{ $company->nama_perusahaan ?? 'PT.Catur Niaga Sagara' }}</div>
            </td>
        </tr>
    </table>

    <table class="ttd-bottom">
        <tr>
            <td>
                <div class="sig-name">{{ $pengiriman->nama_kurir ?? 'Nama Kurir' }}</div>
                <div class="sig-role">Kurir/Pengemudi</div>
            </td>
            <td class="right">
                <div class="sig-name">{{ auth()->user()->name }}</div>
                <div class="sig-role"><strong>Stuff {{ auth()->user()->jabatan }}</strong></div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>