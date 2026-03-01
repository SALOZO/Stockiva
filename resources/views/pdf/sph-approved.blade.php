<!-- resources/views/pdf/sph-approved.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SPH APPROVED - {{ $no_sph }}</title>
    <style>
        /* Style sama dengan sph.blade.php */
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #0b2b4f;
        }
        .header h2 {
            font-size: 14px;
            margin: 5px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table th {
            background: #0b2b4f;
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 11px;
        }
        table td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background: #f0f0f0;
        }
        .footer {
            margin-top: 30px;
        }
        .signature-box {
            margin-top: 50px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 40px;
        }
        .signature-img {
            max-width: 150px;
            max-height: 60px;
        }
        .approved-stamp {
            color: #28a745;
            font-size: 40px;
            font-weight: bold;
            opacity: 0.3;
            transform: rotate(-15deg);
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>STOCKIVA</h1>
        <h2>SURAT PENAWARAN HARGA</h2>
        <p>{{ $no_sph }}</p>
    </div>

    <div class="info-section">
        <table style="border: none; width: 100%;">
            <tr>
                <td style="border: none; width: 50%;">
                    <strong>Kepada Yth:</strong><br>
                    {{ $client->nama_client }}<br>
                    {{ $client->nama_pic }} ({{ $client->jabatan_pic }})<br>
                    {{ $client->alamat }}, {{ $client->desa }}, {{ $client->kecamatan }}<br>
                    {{ $client->kabupaten_kota }}, {{ $client->provinsi }}
                </td>
                <td style="border: none; width: 50%;">
                    <strong>Tanggal:</strong> {{ $tanggal }}<br>
                    <strong>No. Pesanan:</strong> {{ $pesanan->no_pesanan }}<br>
                    <strong>Disetujui:</strong> {{ $approved_at }}<br>
                    <strong>Oleh:</strong> {{ $approved_by }}
                </td>
            </tr>
        </table>
    </div>

    <div class="info-box">
        <strong>Perihal:</strong> Penawaran Harga Barang (APPROVED)
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                <td>{{ $item->kategori->name_kategori ?? '-' }}</td>
                <td>{{ $item->jenis->name_jenis ?? '-' }}</td>
                <td class="text-center">{{ $item->barang->satuan->nama_satuan ?? '-' }}</td>
                <td class="text-center">{{ $item->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="7" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p><strong>Catatan:</strong> Harga sudah termasuk PPN.</p>
    </div>

    <div class="signature-box">
        <table style="border: none; width: 100%;">
            <tr>
                <td style="border: none; width: 33%; text-align: center;">
                    <p>Marketing</p>
                    <div class="signature-line"></div>
                    <p>{{ $pesanan->createdBy->nama ?? 'Marketing' }}</p>
                </td>
                <td style="border: none; width: 33%; text-align: center;">
                    <p>Mengetahui</p>
                    <div class="signature-line"></div>
                    <p>Manager</p>
                </td>
                <td style="border: none; width: 33%; text-align: center;">
                    <p>Menyetujui,</p>
                    @if(isset($ttd))
                        <img src="{{ $ttd }}" class="signature-img" alt="Tanda Tangan">
                    @else
                        <div class="signature-line"></div>
                    @endif
                    <p>{{ $approved_by }}</p>
                    <p><small>Direktur</small></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>