<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat Jalan - {{ $no_sj }}</title>
    <style>
        @page {
            margin: 2cm 2.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
        }
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 30px 0 5px 0;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .no-sj {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 30px;
        }
        .info-section {
            margin: 15px 0 20px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 0;
            border: none;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 130px;
        }
        .info-table td:nth-child(2) {
            width: 10px;
        }
        .info-table .field-value {
            border-bottom: 1px solid #000;
            width: 100%;
            display: inline-block;
            min-height: 18px;
        }
        .info-table .field-value-multiline {
            border-bottom: 1px solid #000;
            display: block;
            min-height: 18px;
            margin-bottom: 4px;
        }
        .detail-label {
            margin: 15px 0 5px 0;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 30px 0;
        }
        table.items th {
            font-weight: bold;
            padding: 6px 8px;
            border: 1px solid #333;
            text-align: center;
            background: #fff;
        }
        table.items td {
            padding: 6px 8px;
            border: 1px solid #333;
            height: 22px;
        }
        .text-center {
            text-align: center;
        }
        .date-section {
            text-align: right;
            margin: 20px 0;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
        }
        .signature-name {
            text-decoration: underline;
        }
        .signature-company {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="title">SURAT JALAN</div>
<div class="no-sj">{{ $no_sj }}</div>

<div class="info-section">
    <table class="info-table">
        <tr>
            <td>Nama Penerima</td>
            <td>:</td>
            <td>
                <span class="field-value">{{ $pengiriman->pesanan->client->nama_pic ?? '' }}</span>
            </td>
        </tr>
        <tr>
            <td>Alamat Penerima</td>
            <td>:</td>
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

                <span class="field-value-multiline">{{ $alamat ? substr($alamat, 0, 60) : '' }}</span>
                <span class="field-value-multiline">{{ $alamat && strlen($alamat) > 60 ? substr($alamat, 60, 60) : '' }}</span>
                <span class="field-value-multiline">{{ $alamat && strlen($alamat) > 120 ? substr($alamat, 120) : '' }}</span>
            </td>
        </tr>
        <tr>
            <td>Ekspedisi</td>
            <td>:</td>
            <td>
                <span class="field-value">{{ $pengiriman->ekspedisi ?? $pengiriman->ekspedisiRelasi->nama_ekspedisi ?? '' }}</span>
            </td>
        </tr>
        <tr>
            <td>Detail Barang</td>
            <td>:</td>
            <td></td>
        </tr>
    </table>
</div>

<table class="items">
    <thead>
        <tr>
            <th width="10%">No.</th>
            <th width="50%">Nama Barang</th>
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
            {{-- <td class="text-center">{{$detail->detailPesanan->produced_qty}}</td> --}}
            <td class="text-center">{{ $detail->detailPesanan->barang->satuan->nama_satuan }}</td>
        @endforeach

    </tbody>
</table>

<div class="date-section">
    Bandung, {{ now()->locale('id')->translatedFormat('d F Y') }}
</div>

<div class="signature">
    <p class="signature-name">{{ auth()->user()->name ?? 'Nama Pegawai Gudang' }}</p>
    <p class="signature-company">{{ $company->nama_perusahaan ?? 'PT. Catur Niaga Sagara' }}</p>
</div>

</body>
</html>