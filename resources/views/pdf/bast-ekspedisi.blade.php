<!-- resources/views/pdf/bast-ekspedisi.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BAST Ekspedisi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
            font-size: 14px;
        }
        .content {
            margin: 20px 0;
        }
        .row {
            margin-bottom: 10px;
        }
        .label {
            font-weight bold;
        }
        .underline {
            text-decoration: underline;
        }
        .dotted-line {
            border-bottom: 1px dotted #000;
            min-width: 200px;
            display: inline-block;
        }
        .instansi-line {
            border-bottom: 1px dotted #000;
            min-width: 300px;
            display: inline-block;
        }
        .alamat-line {
            border-bottom: 1px dotted #000;
            min-width: 400px;
            display: inline-block;
            margin-left: 10px;
        }
        .alamat-block {
            margin-left: 100px;
            margin-top: 5px;
        }
        .sebanyak-item {
            margin-left: 100px;
            margin-bottom: 5px;
        }
        .ttd-section {
            margin-top: 50px;
        }
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ttd-table td {
            text-align: center;
            width: 33.33%;
            padding: 10px;
        }
        .ttd-line {
            margin-top: 30px;
            margin-bottom: 5px;
        }
        .ttd-label {
            margin-top: 5px;
            font-size: 11px;
        }
        .company-name {
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="title">
        SURAT JALAN
    </div>

    <div class="content">
        <div class="row">
            <span class="label">No. :</span> {{ $no_bast }}
        </div>
        <div class="row">
            <span class="label">Perihal :</span> Bukti Serah Terima Barang Pengiriman untuk Ekspedisi
        </div>
        <div class="row">
            <span class="label">Lampiran :</span> -
        </div>

        <div class="row" style="margin-top: 20px;">
            <span class="label">Telah diserahkan barang pengiriman pada:</span>
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Hari :</span> {{ now()->format('l') }}
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Tanggal :</span> {{ now()->format('d F Y') }}
        </div>

        <div class="row" style="margin-top: 20px;">
            <span class="label">Untuk tujuan :</span>
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Nama Instansi :</span> {{ $pengiriman->pesanan->client->nama_client }}
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Nama Penerima :</span> {{ $nama_penerima }}
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Alamat Tujuan :</span> 
            <div class="alamat-block">
                {{ $pengiriman->pesanan->client->alamat }}, 
                {{ $pengiriman->pesanan->client->desa }}, 
                {{ $pengiriman->pesanan->client->kecamatan }}, 
                {{ $pengiriman->pesanan->client->kabupaten_kota }}, 
                {{ $pengiriman->pesanan->client->provinsi }}
            </div>
        </div>

        <div class="row" style="margin-top: 20px;">
            <span class="label">Sebanyak :</span>
        </div>
        @foreach($pengiriman->detailPengiriman as $index => $detail)
        <div class="sebanyak-item">
            {{ $detail->jumlah_kirim }} {{ $detail->satuanKirim->nama_satuan }} - {{ $detail->detailPesanan->barang->nama_barang }}
        </div>
        @endforeach

        <div class="row" style="margin-top: 20px;">
            <span class="label">Kepada :</span>
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Nama Ekspedisi :</span> {{ $ekspedisi->nama_ekspedisi }}
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Nama Kurir :</span> {{ $pengiriman->nama_kurir }}
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">Identitas Kurir :</span> {{ $pengiriman->kurir_jenis_identitas }}
        </div>
        <div class="row">
            <span class="label" style="margin-left: 20px;">No. Identitas :</span> {{ $pengiriman->kurir_no_identitas }}
        </div>

        <div class="row" style="margin-top: 30px;">
            <span>Demikian Bukti Serah Terima Barang Pengiriman untuk Ekspedisi ini dibuat untuk dapat dipertanggungjawabkan.</span>
        </div>

        <div class="ttd-section">
            <table class="ttd-table">
                <tr>
                    <td>
                        <div>Nama Ekspedisi</div>
                        <div class="company-name">{{ $ekspedisi->nama_ekspedisi }}</div>
                    </td>
                    <td>
                        <div>Nama Kurir</div>
                        <div class="ttd-line">{{ $pengiriman->nama_kurir }}</div>
                        <div class="ttd-label">Kurir/Pengemudi</div>
                    </td>
                    <td>
                        <div>Nama Pegawai Gudang</div>
                        <div class="ttd-line">{{ auth()->user()->name ?? 'Staff Gudang' }}</div>
                        <div class="ttd-label">Staff Gudang</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>