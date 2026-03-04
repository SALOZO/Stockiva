<!-- resources/views/pdf/sph-approved.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SPH - {{ $no_sph }}</title>
    <style>
        @page {
            margin: 0.5cm 1cm 0.8cm 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10.5pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }
        
        /* Header */
        .header {
            margin: 0 0 6px 0;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        .header h1 {
            font-size: 18pt;
            margin: 0 0 3px 0;
            color: #0b2b4f;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header .company-detail {
            font-size: 8.5pt;
            color: #555;
            line-height: 1.25;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            border: none;
            padding: 2px;
            vertical-align: middle;
        }
        .header-logo {
            max-height: 65px;
            max-width: 140px;
            object-fit: contain;
        }
        
        /* Info Surat */
        .sph-ref {
            width: 100%;
            margin: 6px 0 10px 0;
            font-size: 10pt;
        }
        .sph-ref td {
            border: none;
            padding: 2px 0;
        }
        
        /* Kepada */
        .kepada {
            margin: 10px 0;
            font-size: 10pt;
            line-height: 1.3;
        }
        
        /* Pembuka */
        .pembuka {
            margin: 10px 0;
            text-align: justify;
        }
        .pembuka p {
            margin: 4px 0;
        }
        
        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 9.5pt;
            table-layout: fixed;
        }
        table th {
            background: #0b2b4f;
            color: white;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 9.5pt;
            border: 1px solid #0b2b4f;
        }
        table td {
            border: 1px solid #999;
            padding: 5px 4px;
            word-wrap: break-word;
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
        
        /* Kolom Lebar */
        th:nth-child(1) { width: 5%; }
        th:nth-child(2) { width: 25%; }
        th:nth-child(3) { width: 15%; }
        th:nth-child(4) { width: 10%; }
        th:nth-child(5) { width: 20%; }
        th:nth-child(6) { width: 30%; }
        
        /* Note */
        .note-section {
            margin: 8px 0;
            font-size: 9.5pt;
        }
        .note-section ul {
            margin: 3px 0 0 18px;
            padding-left: 0;
        }
        .note-section li {
            margin-bottom: 2px;
        }
        
        /* Penutup */
        .penutup {
            margin: 8px 0;
            text-align: justify;
            font-size: 9.5pt;
            line-height: 1.3;
        }
        .penutup p {
            margin: 0;
        }
        
        /* Tanda Tangan */
        .signature-wrapper {
            width: 100%;
            margin-top: 12px;
            overflow: hidden;
            page-break-inside: avoid;
        }
        .signature-box {
            float: right;
            width: 230px;
            text-align: center;
            font-size: 10pt;
        }
        .signature-box p {
            margin: 2px 0;
        }
        .signature-img {
            height: 60px;
            max-width: 180px;
            object-fit: contain;
            display: block;
            margin: 4px auto;
        }
        .signature-line {
            width: 190px;
            border-top: 1px solid #000;
            margin: 6px auto 4px auto;
        }
        .clear {
            clear: both;
        }
        
        /* Footer */
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
            margin: 4px 0;
        }
        
        /* Utility */
        .page-break {
            page-break-after: always;
        }
        .no-margin {
            margin: 0;
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
                    <img src="{{ $logo_base64 }}" class="header-logo" alt="Logo">
                @endif
            </td>
            <td style="width: 82%;">
                <h1>{{ $company->nama_perusahaan ?? 'Stockiva' }}</h1>
                @if($company)
                <div class="company-detail">
                    {{ $company->alamat ?? '' }}{{ $company->alamat && $company->kelurahan ? ', ' : '' }}{{ $company->kelurahan ?? '' }}{{ ($company->alamat || $company->kelurahan) && $company->kecamatan ? ', ' : '' }}{{ $company->kecamatan ?? '' }}<br>
                    {{ $company->kota ?? '' }}{{ $company->kota && $company->provinsi ? ', ' : '' }}{{ $company->provinsi ?? '' }} {{ $company->kode_pos ?? '' }}<br>
                    Telp.: {{ $company->telepon ?? '-' }} | Email: {{ $company->email ?? '-' }} | Web: {{ $company->website ?? '-' }}
                </div>
                @endif
            </td>
        </tr>
    </table>
</div>

{{-- Nomor, Perihal, Tanggal --}}
<table class="sph-ref">
    <tr>
        <td style="width: 60%;">
            <strong>Nomor :</strong> {{ $no_sph }}<br>
            <strong>Perihal :</strong> {{ $perihal }}<br>
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
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Kebutuhan</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>Jumlah Harga</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->barang->nama_barang ?? $item->nama_barang ?? '-' }}</td>
            <td class="text-center">{{ $item->jumlah }}</td>
            <td class="text-center">{{ $item->barang->satuan->nama_satuan ?? $item->satuan ?? '-' }}</td>
            <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data barang</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="5" class="text-right"><strong>Total</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($pesanan->total_keseluruhan ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
        @if($ppn_aktif)
            <tr>
                <td colspan="5" class="text-right"><strong>PPN {{ $ppn_persen }}%</strong></td>
                <td class="text-right">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>Total termasuk PPN</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($total_include_ppn, 0, ',', '.') }}</strong></td>
            </tr>
        @endif
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
        <p>Hormat kami,</p>
        
        @if($ttd_base64)
            <img src="{{ $ttd_base64 }}" class="signature-img">
        @else
            <p style="margin-top: 30px;">&nbsp;</p>
        @endif
        
        <div class="signature-line"></div>
        <p><strong>{{ $approved_by_name ?? $company->nama_direktur ?? 'Direktur' }}</strong></p>
        <p>{{ $approved_by_jabatan ?? $company->jabatan_direktur ?? 'Direktur Utama' }}</p>
        
        @if($approved_at)
            <p style="font-size: 8pt; margin-top: 3px;">{{ \Carbon\Carbon::parse($approved_at)->format('d/m/Y') }}</p>
        @endif
    </div>
    <div class="clear"></div>
</div>

</body>
</html>