<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tagihan {{ $noTagihan }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', serif; font-size: 11pt; color: #000; line-height: 1.5; }
        .page { padding: 15mm 20mm 15mm 25mm; }

        /* Header */
        .header { border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 15px; }
        .header table { width: 100%; }
        .company-name { font-size: 14pt; font-weight: bold; }
        .company-sub { font-size: 8pt; color: #333; margin-top: 2px; }

        /* Info surat */
        .info-surat { margin-bottom: 15px; }
        .info-surat table td { padding: 1px 0; vertical-align: top; }
        .info-surat td.label { width: 80px; }
        .info-surat td.colon { width: 10px; }
        .tgl-surat { float: right; margin-top: -52px; }

        /* Tabel rincian */
        .tabel { width: 100%; border-collapse: collapse; margin-bottom: 5px; font-size: 10.5pt; }
        .tabel th, .tabel td { border: 1px solid #000; padding: 5px 7px; }
        .tabel th { text-align: center; font-weight: bold; }
        .tabel td.center { text-align: center; }
        .tabel td.right { text-align: right; }
        .tabel tr.total td { font-weight: bold; }

        /* Rekening */
        .rekening table td { padding: 1px 0; vertical-align: top; }
        .rekening td.label { width: 120px; }
        .rekening td.colon { width: 10px; }

        /* TTD */
        .ttd { text-align: center; margin-top: 10px; float: right; }
        .ttd .space { height: 60px; }
        .ttd .nama { font-weight: bold; text-decoration: underline; }

        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }
        .mb-20 { margin-bottom: 20px; }
        .justify { text-align: justify; line-height: 1.6; }
    </style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <div class="header">
        <table>
            <tr>
                <td style="width:70px; vertical-align:middle;">
                    @if($logoPath)
                        <img src="{{ $logoPath }}" style="max-width:60px; max-height:60px;">
                    @endif
                </td>
                <td style="vertical-align:middle; padding-left:10px;">
                    <div class="company-name">{{ strtoupper($company?->nama_perusahaan) }}</div>
                    <div class="company-sub">{{ $company?->kontak_lengkap }}</div>
                    <div class="company-sub">{{ $company?->alamat_lengkap }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- NOMOR SURAT --}}
    <div class="info-surat mb-15">
        <div class="tgl-surat">{{ $company?->kota }}, {{ $tglSurat }}</div>
        <table>
            <tr>
                <td class="label">Nomor</td>
                <td class="colon">:</td>
                <td>{{ $noTagihan }}</td>
            </tr>
            <tr>
                <td class="label">Lampiran</td>
                <td class="colon">:</td>
                <td>-</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td class="colon">:</td>
                <td><strong>Surat Permohonan Pembayaran</strong></td>
            </tr>
        </table>
        <div style="clear:both;"></div>
    </div>

    {{-- KEPADA --}}
    <div class="mb-15">
        <p>Kepada Yth. :</p>
        <p><strong>{{ $pesanan->client->nama_client }}</strong></p>
        <p>di</p>
        <p style="padding-left:30px;">
            {{ collect([$pesanan->client->alamat, $pesanan->client->kecamatan,
               $pesanan->client->kabupaten_kota, $pesanan->client->provinsi])
               ->filter()->implode(', ') }}
        </p>
    </div>

    {{-- PEMBUKA --}}
    <div class="justify mb-15">
        Sehubungan dengan telah selesainya pekerjaan yang kami laksanakan untuk
        <strong>{{ $pesanan->client->nama_client }}</strong>, maka berdasarkan hal tersebut
        kami mengajukan permohonan pembayaran pekerjaan dengan rincian sebagai berikut :
    </div>

    {{-- TABEL RINCIAN --}}
    <table class="tabel mb-10">
        <thead>
            <tr>
                <th style="width:5%;">No.</th>
                <th style="width:38%;">Nama Barang</th>
                <th style="width:10%;">Jumlah</th>
                <th style="width:12%;">Satuan</th>
                <th style="width:17%;">Harga Satuan</th>
                <th style="width:18%;">Harga Keseluruhan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->details as $i => $detail)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $detail->barang?->nama_barang ?? '-' }}</td>
                <td class="center">{{ $detail->jumlah }}</td>
                <td class="center">{{ $detail->barang?->satuan?->nama_satuan ?? 'Lot' }}</td>
                <td class="right">Rp. {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                <td class="right">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="5" class="center">Jumlah</td>
                <td class="right">Rp. {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- TERBILANG --}}
    {{-- <div class="mb-15" style="font-style:italic; font-size:10.5pt;">
        Terbilang : {{ ucwords(strtolower(terbilang($pesanan->total_keseluruhan))) }} Rupiah
    </div> --}}

    {{-- REKENING --}}
    @if($bank)
    <div class="rekening mb-15">
        <p>Pembayaran dapat dilakukan dengan bank transfer ke :</p>
        <br>
        <table>
            <tr>
                <td class="label">Atas Nama</td>
                <td class="colon">:</td>
                <td>{{ $bank->atas_nama }}</td>
            </tr>
            <tr>
                <td class="label">No. Rekening</td>
                <td class="colon">:</td>
                <td>{{ $bank->nomor_rekening }}</td>
            </tr>
            <tr>
                <td class="label">Bank</td>
                <td class="colon">:</td>
                <td>{{ $bank->nama_bank }}</td>
            </tr>
            @if($bank->cabang)
            <tr>
                <td class="label">Cabang</td>
                <td class="colon">:</td>
                <td>{{ $bank->cabang }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    {{-- PENUTUP --}}
    <div class="justify mb-20">
        Bersama dengan ini juga kami kirimkan dokumen pelengkap pembayaran ini seperti
        kwitansi dan invoice agar bisa memperlancar proses pembayaran ini. Atas perhatian,
        kerjasama dan pengertiannya kami ucapkan terima kasih.
    </div>

    {{-- TTD --}}
    {{-- <div class="ttd">
        <p><strong>{{ strtoupper($company?->nama_perusahaan) }}</strong></p>
        <div class="space"></div>
        <p class="nama">{{ $company?->nama_direktur }}</p>
        <p>{{ strtoupper($company?->jabatan_direktur ?? 'DIREKTUR') }}</p>
    </div>
    <div style="clear:both;"></div> --}}

</div>
</body>
</html>