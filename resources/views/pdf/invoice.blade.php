<!DOCTYPE html>
<html>
<head>
    <title>Invoice - {{ $no_invoice }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #222;
            margin: 1.5cm 2cm;
        }

        /* ── HEADER ── */
        .header {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 4px;
        }
        .logo {
            height: 70px;
            width: auto;
        }
        .company-info {
            line-height: 1.55;
        }
        .company-name {
            font-size: 20pt;
            font-weight: 900;
            color: #1a3a6b;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .company-address {
            font-size: 9pt;
            color: #1a3a6b;
            font-weight: 600;
        }
        .company-contact {
            font-size: 9pt;
            color: #1a3a6b;
        }

        /* ── DIVIDER ── */
        .divider {
            border: none;
            border-top: 3px solid #1a3a6b;
            margin: 10px 0 4px 0;
        }
        .divider-thin {
            border: none;
            border-top: 1px solid #1a3a6b;
            margin: 3px 0 14px 0;
        }

        /* ── TITLE ── */
        .title {
            font-size: 16pt;
            font-weight: 900;
            text-align: center;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin: 10px 0 16px 0;
            color: #111;
        }

        /* ── META TABLE (No Invoice, Pelanggan, dll) ── */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .meta-table td {
            padding: 3px 4px;
            vertical-align: top;
            font-size: 10pt;
        }
        .meta-table .label { width: 18%; color: #222; }
        .meta-table .colon { width: 2%; }
        .meta-table .value { width: 30%; }

        /* ── DETAIL TAGIHAN HEADING ── */
        .section-title {
            font-size: 11pt;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            color: #111;
        }

        /* ── ITEMS TABLE ── */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10pt;
        }
        .table th {
            background-color: #fff;
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: center;
            font-weight: 700;
        }
        .table td {
            border: 1px solid #333;
            padding: 6px 8px;
        }
        .table td.center { text-align: center; }
        .table td.right  { text-align: right; }
        .table tfoot td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-weight: 700;
        }
        .table tfoot td.right { text-align: right; }

        /* ── TERBILANG ── */
        .terbilang {
            display: flex;
            gap: 6px;
            margin: 8px 0 20px 0;
            font-size: 10pt;
        }
        .terbilang .tb-label { font-weight: 700; white-space: nowrap; }
        .terbilang .tb-value { text-decoration: underline; font-style: italic; }

        /* ── BANK INFO ── */
        .bank-info {
            margin: 10px 0 30px 0;
            font-size: 10pt;
            line-height: 1.7;
        }
        .bank-info p { margin: 0; }
        .bank-indent { padding-left: 20px; }

        /* ── SIGNATURE ── */
        .signature-block {
            text-align: right;
            margin-top: 10px;
            font-size: 10pt;
        }
        .signature-block .company-sig {
            font-weight: 700;
            margin-bottom: 55px;
        }
        .signature-block .sig-name {
            font-weight: 700;
            text-decoration: underline;
        }
        .signature-block .sig-title {
            font-weight: 400;
        }
    </style>
</head>
<body>

    {{-- ── HEADER ── --}}
    <div class="header">
        @if($logo)
            <img src="{{ $logo }}" class="logo">
        @endif
        <div class="company-info">
            <div class="company-name">{{ $company->nama_perusahaan }}</div>
            <div class="company-address">{{ $company->alamat }}, {{ $company->kota }}, {{ $company->provinsi }}</div>
            <div class="company-contact">
                Telp. : {{ $company->telepon }}
                @if($company->website)
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    web : {{ $company->website }}
                @endif
            </div>
        </div>
    </div>

    <hr class="divider">
    <hr class="divider-thin">

    {{-- ── TITLE ── --}}
    <div class="title">INVOICE</div>

    {{-- ── META INFO (2 kolom) ── --}}
    <table class="meta-table">
        <tr>
            <td class="label">No.</td>
            <td class="colon">:</td>
            <td class="value">{{ $no_invoice }}</td>
            <td class="label">No. SPH</td>
            <td class="colon">:</td>
            <td class="value">{{ $pesanan->no_sph }}</td>
        </tr>
        <tr>
            <td class="label">Pelanggan</td>
            <td class="colon">:</td>
            <td class="value">{{ $pesanan->client->nama_client }}</td>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ $tanggal }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $pesanan->client->alamat }}, 
                {{ $pesanan->client->kota }}, 
                {{ $pesanan->client->provinsi }}
            </td>
            <td class="label">Jatuh Tempo</td>
            <td class="colon">:</td>
            <td class="value">{{ $jatuh_tempo->format('d F Y') }}</td>
        </tr>
    </table>

    {{-- ── DETAIL TAGIHAN ── --}}
    <div class="section-title">Detail Tagihan</div>

    <table class="table">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:40%;">Nama Barang</th>
                <th style="width:10%;">Banyak</th>
                <th style="width:10%;">Satuan</th>
                <th style="width:17%;">Harga Satuan</th>
                <th style="width:18%;">Jumlah Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->details as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td class="center">{{ $item->jumlah }}</td>
                <td class="center">{{ $item->barang->satuan->nama_satuan ?? 'Pcs' }}</td>
                <td>Rp. <span style="float:right;">{{ number_format($item->harga_satuan, 0, ',', '.') }}</span></td>
                <td>Rp. <span style="float:right;">{{ number_format($item->subtotal, 0, ',', '.') }}</span></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="border:none; background:transparent;"></td>
                <td style="text-align:center; font-weight:700;">Total</td>
                <td class="right">Rp. {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- ── TERBILANG ── --}}
    <div class="mb-15" style="font-family: Arial, Helvetica, sans-serif; font-size:10.5pt;">
        Terbilang : {{ $terbilang }}
    </div>

    {{-- ── BANK INFO ── --}}
    <div class="bank-info">
        <p>Pembayaran dapat dilakukan dengan mentransfer ke rekening :</p>
        <div class="bank-indent">
            <p>- {{ $bank->nama_bank }} {{ $bank->cabang }}</p>
            <p>&nbsp;&nbsp;{{ $bank->nomor_rekening }}</p>
            <p>&nbsp;&nbsp;a/n {{ $bank->atas_nama }}</p>
        </div>
    </div>

    {{-- ── TANDA TANGAN ── --}}
    {{-- <div class="signature-block">
        <div class="company-sig">{{ $company->nama_perusahaan }}</div>
        <div class="sig-name">{{ $company->nama_direktur }}</div>
        <div class="sig-title">Direktur Keuangan</div>
    </div> --}}

</body>
</html>