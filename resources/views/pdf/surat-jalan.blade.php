<!-- resources/views/pdf/surat-jalan.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat Jalan - {{ $no_sj }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0;
            color: #0b2b4f;
            text-transform: uppercase;
        }
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        .info-section {
            margin: 15px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 0;
            border: none;
        }
        .info-table td:first-child {
            width: 120px;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table.items th {
            background: #f0f0f0;
            padding: 8px;
            border: 1px solid #333;
        }
        table.items td {
            padding: 6px;
            border: 1px solid #333;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            width: 100%;
        }
        .signature-left {
            float: left;
            width: 50%;
        }
        .signature-right {
            float: right;
            width: 50%;
            text-align: right;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 40px 0 5px 0;
        }
        .signature-right .signature-line {
            margin-left: auto;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>{{ $company->nama_perusahaan ?? 'PT. CATUR NIAGA SAGARA' }}</h1>
    <p>{{ $company->alamat ?? '' }}, {{ $company->kota ?? '' }}, {{ $company->provinsi ?? '' }}</p>
    <p>Telp: {{ $company->telepon ?? '-' }} | Email: {{ $company->email ?? '-' }}</p>
</div>

<div class="title">
    SURAT JALAN
</div>

<div style="text-align: center; margin-bottom: 15px;">
    <strong>{{ $no_sj }}</strong>
</div>

<div class="info-section">
    <table class="info-table">
        <tr>
            <td>Nama Penerima</td>
            <td>: <strong>{{ $pengiriman->pesanan->client->nama_pic ?? '..........................' }}</strong></td>
        </tr>
        <tr>
            <td>Alamat Penerima</td>
            <td>: {{ $pengiriman->pesanan->client->alamat ?? '' }}, 
                      {{ $pengiriman->pesanan->client->desa ?? '' }}, 
                      {{ $pengiriman->pesanan->client->kecamatan ?? '' }}, 
                      {{ $pengiriman->pesanan->client->kabupaten_kota ?? '' }}, 
                      {{ $pengiriman->pesanan->client->provinsi ?? '' }}</td>
        </tr>
        <tr>
            <td>Ekspedisi</td>
            <td>: <strong>{{ $pengiriman->ekspedisi ?? $pengiriman->ekspedisiRelasi->nama_ekspedisi ?? '..........................' }}</strong></td>
        </tr>
    </table>
</div>

<div style="margin: 20px 0;">
    <strong>Detail Barang:</strong>
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
            <td class="text-center">{{ $detail->satuanKirim->nama_satuan ?? 'Koli' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px;">
    <p>Bandung, {{ now()->format('d F Y') }}</p>
</div>

<div class="signature">
    <div class="signature-left">
        <p>Mengetahui,</p>
        <div class="signature-line"></div>
        <p><strong>{{ $company->nama_direktur ?? '..........................' }}</strong></p>
        <p>Direktur</p>
    </div>
    <div class="signature-right">
        <p>Hormat kami,</p>
        <div class="signature-line"></div>
        <p><strong>{{ auth()->user()->nama ?? '..........................' }}</strong></p>
        <p>Staff Gudang</p>
    </div>
    <div class="clear"></div>
</div>

</body>
</html>