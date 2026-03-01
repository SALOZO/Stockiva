<!-- resources/views/pdf/sph.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SPH - {{ $no_sph }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 22px;
            margin: 5px 0;
            color: #0b2b4f;
            text-transform: uppercase;
        }
        .header .company-detail {
            font-size: 9pt;
            color: #555;
            margin: 2px 0;
        }
        .header .logo {
            margin-bottom: 10px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
        .sph-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: underline;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }
        table th {
            background: #0b2b4f;
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 10pt;
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
        .text-left {
            text-align: left;
        }
        .total-row {
            font-weight: bold;
            background: #f0f0f0;
        }
        .note-section {
            margin-top: 30px;
            font-size: 10pt;
        }
        .note-section h4 {
            margin-bottom: 5px;
        }
        .note-section ul, .note-section ol {
            margin-top: 5px;
            padding-left: 20px;
        }
        .signature-box {
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
            margin-top: 50px;
        }
        .signature-right .signature-line {
            margin-left: auto;
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
            padding: 10px 0;
        }
        .header table {
            border-collapse: collapse;
            width: 100%;
        }

        .header table td {
            border: none;
            padding: 5px;
        }

        .header img {
            max-height: 70px;
            max-width: 150px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>
    {{-- Header Perusahaan --}}
        <div class="header">
            <table style="width: 100%; border: none; margin-bottom: 15px;">
                <tr>
                    <td style="width: 20%; border: none; vertical-align: middle; text-align: left;">
                        @if($logo_base64)
                            <img src="{{ $logo_base64 }}" style="max-height:70px;">
                        @endif
                    </td>
                    <td style="width: 80%; border: none; vertical-align: middle; text-align: left;">
                        <h1 style="font-size: 22px; margin: 0; color: #0b2b4f; text-transform: uppercase;">{{ $company->nama_perusahaan ?? 'Stockiva' }}</h1>
                        @if($company)
                        <div class="company-detail" style="font-size: 9pt; color: #555; margin-top: 5px;">
                            {{ $company->alamat ?? '' }}, {{ $company->kelurahan ?? '' }}, {{ $company->kecamatan ?? '' }}<br>
                            {{ $company->kota ?? '' }}, {{ $company->provinsi ?? '' }} {{ $company->kode_pos ?? '' }}<br>
                            Telp.: {{ $company->telepon ?? '' }} | Email: {{ $company->email ?? '' }} | Web.: {{ $company->website ?? '' }}
                        </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

    {{-- Info SPH --}}
    <div class="info-section">
        <table style="border: none; width: 100%; margin-bottom: 10px;">
            <tr>
                <td style="border: none; width: 50%;">
                    <strong>Nomor :</strong> {{ $no_sph }}<br>
                    <strong>Perihal :</strong> {{ $perihal }}<br>
                    <strong>Lampiran :</strong> 1 Lembar
                </td>
                <td style="border: none; width: 50%; text-align: right;">
                    <strong>{{ $company->kota ?? 'Jakarta' }},</strong> {{ $tanggal }}
                </td>
            </tr>
        </table>
    </div>

    {{-- Kepada Yth --}}
    <div class="info-section">
        <strong>Kepada Yth,</strong><br>
        Bagian Pengadaan /UP. {{ $client->nama_pic ?? '-' }}<br>
        <strong>{{ $client->nama_client ?? '-' }}</strong><br>
        {{ $client->alamat ?? '-' }}, {{ $client->desa ?? '-' }}, {{ $client->kecamatan ?? '-' }}<br>
        {{ $client->kabupaten_kota ?? '-' }}, {{ $client->provinsi ?? '-' }}
    </div>

    {{-- Pembuka --}}
    <div class="info-section" style="margin-top: 15px;">
        <p><strong>Dengan Hormat,</strong></p>
        <p>Sehubungan dengan adanya kebutuhan di {{ $client->nama_client ?? 'perusahaan' }} atas barang yang dimaksud, dengan ini kami menyampaikan penawaran harga yang sesuai dengan kebutuhan dan spesifikasi yang diinginkan, sebagai berikut:</p>
    </div>

    {{-- Tabel Barang --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="25%">Nama Barang</th>
                <th width="10%">Kebutuhan</th>
                <th width="10%">Satuan</th>
                <th width="20%">Harga Satuan</th>
                <th width="20%">Jumlah Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                <td class="text-center">{{ $item->jumlah }}</td>
                <td class="text-center">{{ $item->barang->satuan->nama_satuan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    {{-- Note --}}
    <div class="note-section">
        <h4>Note:</h4>
        <ul>
            <li>{{ $catatan_ppn }};</li>
            <li>Harga penawaran berlaku {{ $masa_berlaku }}, terhitung dari tanggal surat penawaran;</li>
            <li>Waktu pengerjaan sesuai dengan spesifikasi dan model yang diinginkan adalah {{ $waktu_pengerjaan }};</li>
        </ul>
    </div>

    {{-- Penutup --}}
    <div class="note-section">
        <p>{{ $footer_text }}</p>
    </div>

    {{-- Tanda Tangan --}}
    <div class="signature-box">
        <div class="signature-left">
            <p>Hormat kami,</p>
            <br><br><br>
            <div class="signature-line"></div>
            <p><strong>{{ $company->nama_direktur ?? 'Direktur' }}</strong></p>
            <p>{{ $company->jabatan_direktur ?? 'Direktur Utama' }}</p>
        </div>
        <div class="signature-right">
            <p>Mengetahui,</p>
            <br><br><br>
            <div class="signature-line"></div>
            <p><strong>{{ $pesanan->createdBy->nama ?? 'Marketing' }}</strong></p>
            <p>Marketing</p>
        </div>
        <div class="clear"></div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Stockiva. Berlaku tanpa tanda tangan basah.</p>
    </div>
</body>
</html>