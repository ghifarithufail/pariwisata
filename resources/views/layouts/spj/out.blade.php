<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="5qdZDOOsTk1xdv5nhwNrlwNB1H36bfOGJO0nkmo8">
    <title>spj</title>
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <style>
        @page {
            size: 58mm auto;
            margin: 0;
        }

        body {
            font-size: 12px;
            font-family: calibri;
            background: #eee;
        }

        h1 {
            font-size: 1em;
            font-weight: 700;
        }

        .devider {
            border: 1px dashed #444;
        }

        #section {
            margin-bottom: 10px;
            text-align: left !important;
            padding: 10px 30px;
            font-size: 15px;
        }

        #end {
            page-break-after: always;
        }

        #receipt {
            background-color: white;
            width: 20cm;
            min-height: 14cm;
            font-size: 12px;
            margin: auto;
            padding: 5px;
            border: 1px solid #ddd;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
            /* line-height: 24px; */
            color: #555;
        }

        .box-logo {
            padding: 5px 20px;
            margin-bottom: 5px;
            height: 80px;
            border: 0px solid #f00;
            text-align: left;
        }

        .logo {
            width: 80px;
        }

        .floatLeft {
            float: left;
        }

        .floatRight {
            float: right;
        }

        .textRight {
            text-align: right;
        }

        .textCenter {
            text-align: center;
        }

        .titleLeft {
            padding-top: 3px;
        }

        .titleRight {
            margin-left: 20px;
            border: 0px solid #f0f;
            padding-top: 7px;
        }

        .titleMain {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .titleStore {
            font-size: 13px;
            text-align: left;
        }

        .title2 {
            margin-top: 10px;
            font-size: 13px;
        }

        .title3 {
            font-size: 13px;
        }

        .pr-200 {
            padding-right: 200px;
        }
    </style>
</head>

<body>
    <div id="receipt">
        <div id="section">
            <center>
                <h2>SURAT PERINTAH JALAN</h2>

            </center>
            <hr>
            <center>
                <h3 style="text-decoration: underline;">{{ $spj->no_spj }}</h3>
            </center>

            <div>Surat ini adalah surat perintah jalan dengan detail sebagai berikut :</div>
            <div style="padding: 10px; font-size: 13px;">
                <table>
                    <tr>
                        <td width="170">Pengemudi</td>
                        <td width="1%">:</td>
                        <td>{{ $spj->booking_details->supir_id }}</td>
                    </tr>
                    <tr>
                        <td width="170">No Induk / No Pol</td>
                        <td width="1%">:</td>
                        <td>{{ $spj->booking_details->armadas->merk }} / {{ $spj->booking_details->armadas->nopolisi }}
                        </td>
                    </tr>
                    <tr>
                        <td width="170">Start KM / Selesai KM</td>
                        <td width="1%">:</td>
                        <td>
                            @if ($spj->km_masuk == null)
                                {{ $spj->km_keluar }} Km
                            @else
                                {{ $spj->km_keluar }} Km / {{ $spj->km_masuk }} Km
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="170">Uang Jalan</td>
                        <td width="1%">:</td>
                        <td>Rp. {{ number_format($spj->uang_jalan) }}</td>
                    </tr>
                </table>
            </div>
            <div>Dengan rincian detail booking sebagai berikut : </div>
            <div style="padding: 10px; font-size: 13px; margin-bottom:">
                <table width="100%">
                    <tr>
                        <td width="170">Nama</td>
                        <td width="1%">:</td>
                        <td>{{ $spj->booking_details->bookings->customer }}</td>
                    </tr>
                    <tr>
                        <td width="170">Lokasi Jemput</td>
                        <td width="1%">:</td>
                        <td>{{ $spj->lokasi_jemput }}</td>
                    </tr>
                    <tr>
                        <td width="170">Jam Jemput</td>
                        <td width="1%">:</td>
                        <td>{{ $spj->jam_jemput }}</td>
                    </tr>
                </table>
            </div>

            @if ($spj->km_masuk != null)
                <div>Data rincian biaya perjalanan sebagai berikut : </div>
                <div style="padding: 10px; font-size: 13px;">
                    <table width="100%">
                        <tr>
                            <td colspan="3">
                                <table width="100%" border="1" cellpadding="5" cellspacing="0"
                                    style="border-collapse: collapse;">
									<tr>
										<th>Nama</th>
										<th style="text-align: right">Harga</th>
									</tr>
                                    <tr>
                                        <td>Uang Jalan</td>
                                        <td style="text-align: right">{{ number_format($spj->uang_jalan) }}</td>
                                    </tr>
                                    <tr>
                                        <td>BBM</td>
                                        <td style="text-align: right">{{ number_format($spj->bbm) }}</td>

                                    </tr>
                                    <tr>
                                        <td>Uang Makan</td>
                                        <td style="text-align: right">{{ number_format($spj->uang_makan) }}</td>

                                    </tr>
                                    <tr>
                                        <td>Parkir</td>
                                        <td style="text-align: right">{{ number_format($spj->parkir) }}</td>

                                    </tr>
                                    <tr>
                                        <td>Tol</td>
                                        <td style="text-align: right">{{ number_format($spj->tol) }}</td>

                                    </tr>
                                    <tr>
                                        <td>Biaya Lain</td>
                                        <td style="text-align: right">{{ number_format($spj->biaya_lain) }}</td>
                                    </tr>
									<tr>
										<th style="text-align: right">Total Biaya yang harus dikembalikan: </th>
										<th style="text-align: right">{{number_format($spj->uang_jalan - $spj->bbm - $spj->uang_makan - $spj->parkir - $spj->tol - $spj->biaya_lain)}}</th>
									</tr>
                                </table>
                            </td>
                        </tr>
                    </table>
            @endif


            {{-- <div style="margin-bottom: 20px;">Barang di atas akan disimpan dalam program Gold Priority selama 12 bulan.
                Dari transaksi ini customer mendapatkan benefit Jewellery Certificate yang akan dikirimkan melalui
                aplikasi CMK Club.</div> --}}
            <div style="margin-bottom: 20px;">Demikian perintah jalan ini dibuat secara sadar sebagai bukti
                yang sah dan dapat digunakan sesuai isi dalam surat ini.</div>

            <table width="100%">
                <tr>
                    <td width="30%">
                        <div style="height: 80px; padding-top: 10px;">Yang Menerima (AE)</div>
                        ( ........................ )
                    </td>
                    <td width="30%">
                        <div style="height: 80px; padding-top: 10px;">Yang Mengetahui (SM)</div>
                        ( ........................ )
                    </td>
                    <td>
                        ____________, {{ \Carbon\Carbon::now()->format('d F Y') }}
                        <div style="height: 80px;">Yang Menyerahkan</div>
                        ( ........................ )
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
{{-- <script>window.print();</script> --}}

</html>
