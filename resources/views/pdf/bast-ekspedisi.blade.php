<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BAST Ekspedisi - {{ $no_bast }}</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 1cm 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0 0 5px 0;
            color: #0b2b4f;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header h2 {
            font-size: 14pt;
            margin: 0 0 5px 0;
            font-weight: normal;
        }
        .header .company-detail {
            font-size: 9pt;
            color: #555;
            line-height: 1.3;
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
            margin: 5px 0;
        }
        .info-table td {
            padding: 4px 0;
            border: none;
        }
        .info-table td:first-child {
            width: 150px;
        }
        
        .sub-section {
            margin: 15px 0 5px 0;
            font-weight: bold;
            text-decoration: underline;
        }
        
        .dotted-line {
            border-bottom: 1px dotted #999;
            margin: 5px 0 10px 0;
        }
        
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }
        table.items th {
            background: #f0f0f0;
            padding: 8px 5px;
            text-align: center;
            border: 1px solid #333;
        }
        table.items td {
            padding: 6px 5px;
            border: 1px solid #333;
        }
        .text-center {
            text-align: center;
        }
        
        .signature-box {
            margin-top: 40px;
            width: 100%;
            overflow: hidden;
        }
        .signature-left {
            float: left;
            width: 45%;
        }
        .signature-right {
            float: right;
            width: 45%;
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
        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }
        .signature-title {
            font-size: 9pt;
            color: #555;
        }
        .clear {
            clear: both;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 8pt;
            color: #999;
            text-align: center;
            padding: 5px 0;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>{{ $company->nama_perusahaan }}</h1>
    <div class="company-detail">
        Head Office: Ruko Topaz Commercial TC16, Summarecon, Bandung<br>
        Branch Office: Jl. Ramin 04 No.02 Komplek Bumi Panyawangan, Cileunyi – Bandung<br>
        Telp. (022) 32093707 – HP: 0813 2498 2023<br>
        E-mail: topasjaya.mandiri@gmail.com
    </div>
</div>

<div class="title">
    TANDA SERAH TERIMA BARANG PENGIRIMAN
</div>

<div class="info-section">
    <div class="sub-section">Sudah diserahkan pengiriman barang untuk tujuan :</div>
    
    <table class="info-table">
        <tr>
            <td>a. Nama Tujuan</td>
            <td>: <strong>{{ $pengiriman->pesanan->client->nama_client ?? '..........................' }}</strong></td>
        </tr>
        <tr>
            <td>b. Nama Penerima</td>
            <td>: <strong>{{ $pengiriman->penerima_client ?? '..........................' }}</strong></td>
        </tr>
        <tr>
            <td>c. Alamat</td>
            <td>: {{ $pengiriman->pesanan->client->alamat ?? '..........................' }}, 
                      {{ $pengiriman->pesanan->client->kabupaten_kota ?? '' }}, 
                      {{ $pengiriman->pesanan->client->provinsi ?? '' }}</td>
        </tr>
        <tr>
            <td>d. No. Telepon Penerima</td>
            <td>: {{ $pengiriman->pesanan->client->no_telp_pic ?? '..........................' }}</td>
        </tr>
    </table>
</div>

<div class="dotted-line"></div>

<div class="info-section">
    <div class="sub-section">Kepada :</div>
    
    <table class="info-table">
        <tr>
            <td>a. Nama Ekspedisi</td>
            <td>: <strong>{{ $pengiriman->ekspedisi ?? '..........................' }}</strong></td>
        </tr>
        <tr>
            <td>b. Nama Kurir</td>
            <td>: <strong>{{ $pengiriman->nama_kurir ?? '..........................' }}</strong></td>
        </tr>
        <tr>
            <td>c. No Telepon</td>
            <td>: {{ $pengiriman->kurir_no_telp ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>d. Jenis Identitas</td>
            <td>: {{ $pengiriman->kurir_jenis_identitas ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>e. No. Identitas</td>
            <td>: {{ $pengiriman->kurir_no_identitas ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>f. Plat Nomor Kendaraan</td>
            <td>: {{ $pengiriman->kurir_plat_nomor ?? '..........................' }}</td>
        </tr>
    </table>
</div>

<div class="dotted-line"></div>

<div class="info-section">
    <div class="sub-section">Barang kiriman sebanyak :</div>
    
    <table class="items">
        <thead>
            <tr>
                <th width="10%">No.</th>
                <th width="45%">Jumlah Barang</th>
                <th width="45%">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengiriman->detailPengiriman as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $detail->jumlah_kirim }}</td>
                <td class="text-center">{{ $detail->detailPesanan->barang->satuan->nama_satuan ?? 'Koli' }}</td>
            </tr>
            @empty
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">..........................</td>
                <td class="text-center">Koli / Dus / Karung / Kantong Plastik</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="signature-box">
    <div class="signature-left">
        <p>Yang Menyerahkan,</p>
        <div class="signature-line"></div>
        <div class="signature-name">{{ $company->nama_direktur ?? '..........................' }}</div>
        <div class="signature-title">{{ $company->nama_perusahaan ?? 'PT. TOPAS JAYA MANDIRI' }}</div>
    </div>
    
    <div class="signature-right">
        <p>Yang Menerima,</p>
        <div class="signature-line"></div>
        <div class="signature-name">{{ $pengiriman->nama_kurir ?? '..........................' }}</div>
    </div>
    <div class="clear"></div>
</div>

<div class="footer">
    <hr>
    <p>Dokumen: {{ $no_bast }} | Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
</div>

</body>
</html>