<!-- resources/views/pdf/sph-approved.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SPH - {{ $no_sph }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 1.5cm;
        }
        
        .header {
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 20pt;
            margin: 0 0 5px 0;
            color: #0b2b4f;
            text-transform: uppercase;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            border: none;
            padding: 5px;
            vertical-align: middle;
        }
        .header-logo {
            max-height: 70px;
            max-width: 150px;
            object-fit: contain;
        }
        
        .sph-ref {
            width: 100%;
            margin: 10px 0 15px 0;
        }
        .sph-ref td {
            border: none;
            padding: 3px 0;
        }
        
        .kepada {
            margin: 15px 0;
            line-height: 1.3;
        }
        
        .pembuka {
            margin: 15px 0;
            text-align: justify;
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
            padding: 8px 5px;
            text-align: center;
        }
        table td {
            border: 1px solid #999;
            padding: 6px 5px;
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
        
        .note-section {
            margin: 15px 0;
        }
        .note-section ul {
            margin: 5px 0 0 20px;
        }
        
        .penutup {
            margin: 15px 0;
            text-align: justify;
        }
        
        .signature-wrapper {
            width: 100%;
            margin-top: 30px;
            overflow: hidden;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-box p {
            margin: 3px 0;
        }
        .signature-img {
            max-height: 50px;
            max-width: 180px;
            object-fit: contain;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 10px auto 5px auto;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

{{-- Header Perusahaan --}}
<div class="header">
    <table class="header-table">
        <tr>
            <td style="width: 18%;">
                @if($logo_base64)
                    <img src="{{ $logo_base64 }}" class="header-logo">
                @endif
            </td>
            <td style="width: 82%;">
                <h1>{{ $company->nama_perusahaan ?? 'Stockiva' }}</h1>
                <div>
                    {{ $company->alamat ?? '' }}, {{ $company->kota ?? '' }}, {{ $company->provinsi ?? '' }}<br>
                    Telp: {{ $company->telepon ?? '-' }} | Email: {{ $company->email ?? '-' }}
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- Nomor, Perihal, Tanggal --}}
<table class="sph-ref">
    <tr>
        <td style="width: 60%;">
            <strong>Nomor :</strong> {{ $no_sph }}<br>
            <strong>Perihal :</strong> {{ $perihal }}
            <strong>Lampiran :</strong> {{ $lampiran_text }}
        </td>
        <td style="width: 40%; text-align: right;">
            <strong>{{ $company->kota ?? 'Jakarta' }},</strong> {{ $tanggal }}
        </td>
    </tr>
</table>

{{-- Kepada Yth --}}
<div class="kepada">
    <strong>Kepada Yth,</strong><br>
    Bagian Pengadaan / UP. {{ $client->nama_pic ?? '-' }}<br>
    <strong>{{ $client->nama_client ?? '-' }}</strong><br>
    {{ $client->alamat ?? '-' }}{{ $client->alamat && $client->desa ? ', ' : '' }}{{ $client->desa ?? '' }}{{ ($client->alamat || $client->desa) && $client->kecamatan ? ', ' : '' }}{{ $client->kecamatan ?? '' }}<br>
    {{ $client->kabupaten_kota ?? '-' }}{{ $client->kabupaten_kota && $client->provinsi ? ', ' : '' }}{{ $client->provinsi ?? '-' }}
</div>

{{-- Pembuka --}}
<div class="pembuka">
    <p><strong>Dengan Hormat,</strong></p>
    <p>Sehubungan dengan adanya kebutuhan di <strong>{{ $client->nama_client ?? 'perusahaan' }}</strong> atas barang yang dimaksud, dengan ini kami menyampaikan penawaran harga yang sesuai dengan kebutuhan dan spesifikasi yang diinginkan, sebagai berikut:</p>
</div>

{{-- Tabel Barang --}}
<table>
    <thead class="text-center">
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Kebutuhan</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>Jumlah Harga</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @forelse($items as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
            <td class="text-center">{{ $item->jumlah }}</td>
            <td class="text-center">{{ $item->barang->satuan->nama_satuan ?? '-' }}</td>
            <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">-</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="5" class="text-right"><strong>Total</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($pesanan->total_keseluruhan ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
    </tfoot>
</table>

{{-- Note --}}
<div class="note-section">
    <strong>Note:</strong>
    <ul>
        <li>{{ $catatan_ppn ?? 'Harga belum termasuk PPN' }};</li>
        <li>Harga penawaran berlaku {{ $masa_berlaku ?? '14 (empat belas) hari kalender' }}, terhitung dari tanggal surat penawaran;</li>
        <li>Waktu pengerjaan sesuai dengan spesifikasi dan model yang diinginkan adalah {{ $waktu_pengerjaan ?? '25 hari kalender' }};</li>
    </ul>
</div>

{{-- Penutup --}}
<div class="penutup">
    <p>Demikian Surat Penawaran Harga ini kami buat beserta lampirannya, agar dapat membantu Bapak/Ibu untuk membuat keputusan yang tepat. Jika Bapak/Ibu membutuhkan informasi lanjutan, dapat menghubungi kami langsung pada kontak yang tertera di atas. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
</div>

{{-- Tanda Tangan --}}
<div class="signature-wrapper">
    <div class="signature-box">
        <p>Hormat kami, {{ $company->nama_perusahaan }}</p>
        
        @if($ttd_base64)
            <img src="{{ $ttd_base64 }}" class="signature-img">
        @else
            <p style="margin-top: 20px;">&nbsp;</p>
        @endif
        
        <div class="signature-line"></div>
        <p><strong>{{ $approved_by_name ?? $company->nama_direktur ?? 'Direktur' }}</strong></p>
        <p>{{ $approved_by_jabatan ?? $company->jabatan_direktur ?? 'Direktur Utama' }}</p>
        
        @if($approved_at)
            <p style="font-size: 8pt; margin-top: 5px;">{{ \Carbon\Carbon::parse($approved_at)->format('d/m/Y') }}</p>
        @endif
    </div>
    <div class="clear"></div>
</div>

</body>
</html>