<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BAST Client - {{ $no_bast }}</title>
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
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0;
            color: #0b2b4f;
            text-transform: uppercase;
        }
        .doc-info {
            width: 100%;
            margin: 10px 0;
        }
        .doc-info td {
            border: none;
            padding: 2px 0;
        }
        .title {
            font-size: 13pt;
            font-weight: bold;
            margin: 15px 0;
        }
        .content {
            margin: 10px 0;
            line-height: 1.5;
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
        .clear {
            clear: both;
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
        .underline {
            text-decoration: underline;
        }
        .dotted-line {
            border-bottom: 1px dotted #000;
            min-width: 150px;
            display: inline-block;
        }
    </style>
</head>
<body>
<table class="doc-info">
    <tr>
        <td style="width: 50%;">
            <strong>No.</strong> : {{ $no_bast }}
        </td>
        <td style="width: 50%; text-align: right;">
            <strong>{{ $company->kota ?? 'Bandung' }},</strong> {{ now()->format('d F Y') }}
        </td>
    </tr>
    <tr>
        <td>
            <strong>Perihal</strong> : {{ $perihal }}
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <strong>Lampiran</strong> : -
        </td>
        <td></td>
    </tr>
</table>

<div class="content">
    <p>Berdasarkan pesanan yang kami terima melalui Surat Perintah Kerja / Purchase Order (PO) / Surat Pesanan Nomor : <strong>{{ $no_po }}</strong> tertanggal : <strong>{{ $tanggal_po->format('d/m/Y') }}</strong>, dengan ini kami serahkan barang pesanan pada :</p>
    
    <p style="margin-left: 20px;">
        <strong>Hari</strong> : {{ $pengiriman->hari_penyerahan }}<br>
        <strong>Tanggal</strong> : {{ \Carbon\Carbon::parse($pengiriman->tanggal_penyerahan)->format('d/m/Y') }}
    </p>
    
    <p><strong>Untuk tujuan :</strong></p>
    <p style="margin-left: 20px;">
        <strong>Nama Instansi</strong> : {{ $pengiriman->pesanan->client->nama_client ?? '..........................' }}<br>
        <strong>Nama Pemesan</strong> : {{ $pengiriman->pesanan->client->nama_pic ?? '..........................' }}<br>
        <strong>Nama Penerima</strong> : {{ $pengiriman->penerima_client ?? '..........................' }}<br>
        <strong>Jabatan Penerima</strong> : {{ $pengiriman->jabatan_penerima ?? '..........................' }}<br>
        <strong>Alamat Tujuan</strong> : 
            {{ $pengiriman->pesanan->client->alamat ?? '' }}, 
            {{ $pengiriman->pesanan->client->desa ?? '' }}, 
            {{ $pengiriman->pesanan->client->kecamatan ?? '' }}, 
            {{ $pengiriman->pesanan->client->kabupaten_kota ?? '' }}, 
            {{ $pengiriman->pesanan->client->provinsi ?? '' }}
    </p>
    
    <p><strong>Sebanyak :</strong></p>
    <p style="margin-left: 20px;">
        @foreach($pengiriman->detailPengiriman as $detail)
            <div>
                {{ $detail->detailPesanan->barang->nama_barang ?? '-' }}: 
                {{ $detail->jumlah_kirim }} {{ $detail->satuanKirim->nama_satuan ?? 'Koli' }}
            </div>
        @endforeach
    </p>
    
    <p><strong>Melalui :</strong></p>
    <p style="margin-left: 20px;">
        <strong>Nama Ekspedisi</strong> : {{ $pengiriman->ekspedisi ?? '..........................' }}<br>
        <strong>Nama Kurir</strong> : {{ $pengiriman->nama_kurir ?? '..........................' }}<br>
        <strong>No Telp Kurir</strong> : {{ $pengiriman->kurir_no_telp ?? '..........................' }}<br>
        <strong>Identitas Kurir</strong> : {{ $pengiriman->kurir_jenis_identitas ?? '..........................' }}<br>
        <strong>No. Identitas</strong> : {{ $pengiriman->kurir_no_identitas ?? '..........................' }}<br>
        <strong>Plat Nomer Kurir</strong> : {{ $pengiriman->kurir_plat_nomor ?? '..........................' }}
    </p>
    
    <p><strong>Dengan rincian barang :</strong></p>
    
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
                <td class="text-center">{{ $detail->detailPesanan->barang->satuan->nama_satuan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Demikian Berita Acara Serah Terima Barang Pengiriman untuk Pelanggan ini dibuat untuk digunakan sebagai bukti telah diserahkannya barang sesuai pesanan untuk selanjutnya dapat ditindaklanjuti oleh Pihak Pemesan/Klien. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
</div>

<div class="signature-box">
    <div class="signature-left">
        <p><strong>{{ $pengiriman->pesanan->client->nama_client }}</strong></p>
        <div class="signature-line"></div>
        <p><strong>{{ $pengiriman->pesanan->client->nama_pic }}</strong></p>
        <p><strong>{{ $pengiriman->pesanan->client->jabatan_pic }}</strong></p>
    </div>
    
    <div class="signature-right">
        <p><strong>{{ $company->nama_perusahaan ?? 'PT. CATUR NIAGA SAGARA' }}</strong></p>
        <div class="signature-line"></div>
        <p><strong>{{ $company->nama_direktur ?? '..........................' }}</strong></p>
        <p>Direktur</p>
    </div>
    <div class="clear"></div>
</div>

</body>
</html>