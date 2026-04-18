<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tagihan {{ $noTagihan }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', serif; font-size: 11pt; color: #000; line-height: 1.5; }
        .page { padding: 15mm 20mm 15mm 25mm; }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .header-logo-cell {
            width: 110px;
            vertical-align: middle;
            padding-right: 18px;
        }
        .header-info-cell {
            vertical-align: middle;
            text-align: center;
        }
        .logo {
            height: 90px;
            width: auto;
            display: block;
        }
        .company-name {
            font-size: 20pt;
            font-weight: 900;
            color: #1a3a6b;
            letter-spacing: 1px;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 4px;
        }
        .company-address {
            font-size: 9pt;
            color: #1a3a6b;
            font-weight: 600;
            line-height: 1.6;
        }
        .company-contact {
            font-size: 9pt;
            color: #1a3a6b;
            line-height: 1.6;
        }

        .header { border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 15px; }
        .header table { width: 100%; }
        .company-name { font-size: 20pt; font-weight: bold; }
        .company-sub { font-size: 12pt; color: #333; margin-top: 2px; }

        .info-surat { margin-bottom: 15px; }
        .info-surat table td { padding: 1px 0; vertical-align: top; }
        .info-surat td.label { width: 80px; }
        .info-surat td.colon { width: 10px; }
        .tgl-surat { float: right; margin-top: -3px; }

        .tabel { width: 100%; border-collapse: collapse; margin-bottom: 5px; font-size: 10.5pt; }
        .tabel th, .tabel td { border: 1px solid #000; padding: 5px 7px; }
        .tabel th { text-align: center; font-weight: bold; }
        .tabel td.center { text-align: center; }
        .tabel td.right { text-align: right; }
        .tabel tr.total td { font-weight: bold; }

        .rekening table td { padding: 1px 0; vertical-align: top; }
        .rekening td.label { width: 120px; }
        .rekening td.colon { width: 10px; }

        .ttd { text-align: center; margin-top: 10px; float: right; }
        .ttd .space { height: 60px; }
        .ttd .nama { font-weight: bold; text-decoration: underline; }

        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }
        .mb-20 { margin-bottom: 20px; }
        .justify { text-align: justify; line-height: 1.6; }
        .divider { border: none; border-top: 3px solid #1a3a6b; margin: 10px 0 4px 0; }
    </style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            @if(isset($logo) && $logo)
            <td class="header-logo-cell">
                <img src="{{ $logo }}" class="logo" alt="Logo">
            </td>
            @endif
            <td class="header-info-cell">
                <div class="company-name">{{ $company->nama_perusahaan }}</div>
                <div class="company-address">
                    {{ $company->alamat }}
                    {{ $company->kota }}, {{ $company->provinsi }}
                </div>
                <div class="company-contact">
                    Telp. : {{ $company->telepon }}
                    @if(isset($company->website) && $company->website)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        web : {{ $company->website }}
                    @endif
                </div>
            </td>
        </tr>
    </table>
    <hr class="divider">
    {{-- TITLE --}}
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
            {{-- Total DPP --}}
            <tr class="total">
                <td> </td>
                <td> </td>
                <td colspan="3" class="center">Jumlah</td>
                <td class="right">Rp. {{ number_format($dpp, 0, ',', '.') }}</td>
            </tr>
            {{-- PPN — hanya muncul jika aktif --}}
            @if($ppn_aktif)
            <tr>
                <td> </td>
                <td> </td>
                <td colspan="3" class="center">PPN {{ $ppn_persen }}%</td>
                <td class="right">Rp. {{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td> </td>
                <td> </td>
                <td colspan="3" class="center">Total termasuk PPN</td>
                <td class="right">Rp. {{ number_format($total_include_ppn, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tfoot>
    </table>

    {{-- TERBILANG --}}
    <div class="mb-15" style="font-family: Arial, Helvetica, sans-serif; font-size:10.5pt; text-indent: 50px; ">
        Terbilang : {{ $terbilang }}
    </div>

    {{-- REKENING --}}
    @if($bank)
    <p>Pembayaran dapat dilakukan dengan bank transfer ke :</p>
    <div class="rekening mb-15" style="margin-left: 30px">
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

</div>
</body>
</html>