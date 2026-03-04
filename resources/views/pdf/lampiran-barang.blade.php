<!-- resources/views/pdf/lampiran-barang.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lampiran Barang - {{ $pesanan->no_pesanan }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 1.5cm;
        }
        
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            font-size: 16pt;
            margin: 0;
            color: #0b2b4f;
        }
        
        .lampiran-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        
        .item-card {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        
        .item-header {
            background: #f0f0f0;
            padding: 8px;
            margin: -15px -15px 15px -15px;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
            font-size: 12pt;
        }
        
        .item-photo {
            float: left;
            width: 25%;
            text-align: center;
            min-height: 150px;
        }
        .item-photo img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
            border: 1px solid #ccc;
            padding: 5px;
        }
        .item-details {
            float: right;
            width: 72%;
        }
        .clear {
            clear: both;
        }
        
        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .detail-table td:first-child {
            width: 30%;
            background: #f9f9f9;
            font-weight: bold;
        }
        
        .spesifikasi {
            margin-top: 10px;
            padding: 10px;
            background: #f9f9f9;
            border-left: 4px solid #0b2b4f;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .footer {
            font-size: 8pt;
            color: #999;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="lampiran-title">
    DAFTAR LENGKAP BARANG
</div>

@foreach($pesanan->details as $index => $item)
    <div class="item-card">
        <div class="item-header">
            {{ $index + 1 }}. {{ $item->barang->nama_barang ?? 'Barang' }}
        </div>
        
        <div class="item-photo">
            @if($item->barang && $item->barang->foto_base64)
                <img src="{{ $item->barang->foto_base64 }}" alt="Foto Barang">
            @else
                <div style="border: 1px dashed #ccc; padding: 20px; color: #999;">
                    <i>Tidak ada foto</i>
                </div>
            @endif
        </div>
        
        <div class="item-details">
            <table class="detail-table">
                <tr>
                    <td>Kategori</td>
                    <td>{{ $item->kategori->name_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jenis</td>
                    <td>{{ $item->jenis->name_jenis ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Satuan</td>
                    <td>{{ $item->barang->satuan->nama_satuan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>{{ $item->jumlah }}</td>
                </tr>
                <tr>
                    <td>Harga Satuan</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Subtotal</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
        
        @if($item->barang && $item->barang->spesifikasi)
        <div class="spesifikasi">
            <strong>Spesifikasi:</strong><br>
            {{ $item->barang->spesifikasi }}
        </div>
        @endif
    </div>
    
@endforeach

<div class="footer">
    Lampiran Surat Penawaran Harga - {{ $pesanan->no_pesanan }} | Halaman {{ $loop->iteration ?? 1 }}
</div>

</body>
</html>