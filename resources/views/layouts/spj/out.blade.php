
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="5qdZDOOsTk1xdv5nhwNrlwNB1H36bfOGJO0nkmo8">
<title>Laku Gadai</title>
<link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
<style>
	@page  { 
		size: 58mm auto; 
		margin:0;
	}
	
    body {
        font-size:12px;
        font-family:calibri;	
        background: #eee;			
    }   

	h1 { font-size:1em; font-weight:700; }

	.devider {
		border: 1px dashed #444;
	}
	
	#section {
		margin-bottom:10px;
		text-align: left !important;
		padding: 10px 30px;
		font-size:  15px;
	}
	
	#end { page-break-after: always; }

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
    	margin-bottom:5px;
    	height: 80px;
    	border: 0px solid #f00;
    	text-align: left;
    }

    .logo { width:80px; }
	.floatLeft { float: left; }   
	.floatRight { float: right; }   
	.textRight { text-align: right; }   
	.textCenter { text-align: center; }   
	.titleLeft { padding-top: 3px; }    
	.titleRight { margin-left: 20px; border: 0px solid #f0f; padding-top: 7px;}    
	.titleMain { font-size: 17px; font-weight: bold; margin-bottom: 3px;} 			
	.titleStore { font-size: 13px; text-align: left; }
	.title2 { margin-top:10px; font-size: 13px; }
	.title3 { font-size: 13px; }
	.pr-200 { padding-right: 200px; }
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
                <h3 style="text-decoration: underline;">{{$spj->no_spj}}</h3>
            </center>

			<div>Surat ini adalah surat perintah jalan keluar dengan detail sebagai berikut :</div>
			<div style="padding: 10px; font-size: 13px;">
				<table>
					<tr>
						<td width="170">Pengemudi</td>
						<td width="1%">:</td>
						<td>{{$spj->booking_details->supir_id}}</td>
					</tr>
					<tr>
						<td width="170">No Induk / No Pol</td>
						<td width="1%">:</td>
						<td></td>
					</tr>
					<tr>
						<td width="170">Start KM / Selesai KM</td>
						<td width="1%">:</td>
						<td></td>
					</tr>
                    <tr>
						<td width="170">Start AC Jam / Selesai AC Jam</td>
						<td width="1%">:</td>
						<td></td>
					</tr>
				</table>
			</div>
			<div>Menyatakan telah menerima emas untuk disimpan dari dan dengan rincian sebagai berikut :</div>
			<div style="padding: 10px; font-size: 13px;">
				<table width="100%">
					<tr>
						<td width="150">Nama</td>
						<td width="1%">:</td>
						{{-- <td>{{ $lakusimpan->customer->name }}</td> --}}
					</tr>
					<tr>
						<td width="150">NIK</td>
						<td width="1%">:</td>
						{{-- <td>{{ $lakusimpan->customer->tanda_pengenal ? json_decode($lakusimpan->customer->tanda_pengenal, true)['nomor'] : '~' }} </td> --}}
					</tr>
					<tr>
						<td width="150">Jumlah Gramasi</td>
						<td width="1%">:</td>
						{{-- <td>{{ $lakusimpan->total_weight }} Gram</td> --}}
					</tr>
					<tr>
						<td width="150">Detail Barang</td>
						<td width="1%"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="3">
							<table width="100%" border="1" cellpadding="5"  cellspacing="0" style="border-collapse: collapse;">
								<tr>
									<th>No</th>
									<th>Jenis Emas</th>
									<th>Brand Emas</th>
									<th>Gramasi</th>
									{{-- @if($lakusimpan->items[0]->item_type == 'fisik') --}}
										<th>Foto Barang</th>
										<th>Foto Sertifikat</th>
									{{-- @endif --}}
								</tr>
		                    	{{-- @foreach($lakusimpan->items as $key => $item)
			                    	<tr>
			                    		<td>{{ $key + 1 }}</td>
			                    		<td>{{ $item->item_type == 'fisik' ? 'Emas Fisik' : 'Emas Digital' }}</td>
			                    		<td>{{ $item->item_type == 'fisik' ? $item->item_brand->brand_name : 'Lakuemas' }}</td>
			                    		<td>{{ $item->weight }} Gram</td>
										@if($lakusimpan->items[0]->item_type == 'fisik')
				                    		<td>
												@if($item->photo_barang)
													<a href="{{ $pathOSS . '/' . $item->photo_barang }}">
			                                            <img class="img_ktp" src="{{ $pathOSS . '/' . $item->photo_barang }}" style="max-height: 45px; padding: 3px; border: 1px solid #ccc;" />
			                                        </a>
			                                    @endif
				                    		</td>
				                    		<td>
												@if($item->photo_certificate)
													<a href="{{ $pathOSS . '/' . $item->photo_certificate }}">
			                                            <img class="img_ktp" src="{{ $pathOSS . '/' . $item->photo_certificate }}" style="max-height: 45px; padding: 3px; border: 1px solid #ccc;" />
			                                        </a>
			                                    @endif
				                    		</td>
		                                @endif
			                    	</tr>
		                    	@endforeach --}}
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div style="margin-bottom: 20px;">Barang di atas akan disimpan dalam program Gold Priority selama 12 bulan. Dari transaksi ini customer mendapatkan benefit Jewellery Certificate  yang akan dikirimkan melalui aplikasi CMK Club.</div>
			<div style="margin-bottom: 20px;">Demikian surat tanda terima barang ini dibuat secara sadar sebagai bukti yang sah dan dapat digunakan untuk kepentingan tertentu.</div>

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
