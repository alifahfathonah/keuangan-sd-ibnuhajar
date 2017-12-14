<!DOCTYPE html>
	<html>
		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		</head>
		<body onLoad="window.print()">
			<div style="width:50%;float:left;margin-right: 5px;padding : 8px;border-top:1px solid #ddd;">
				<h5>BUKTI KAS KELUAR<br>YAYASAN DEMIMASA KEHALUTUJU</h5>
				<p style="margin-top: -20px;font-size: 12px">
				Kantor : Sekolah Islam Ibnu Hajar, Kel. Katulampa, Bogor Timur, Kota Bogor - Telp (0251) 8374544
				</p>
				<hr>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Tanggal</div>
					<div style="width:44%;float:left;border-bottom:1px solid #bbb">&nbsp;</div>
					<div style="width:25%;float:right;border:1px solid #bbb;"><?=tgl_indo2($d[0]->tgl_transaksi)?></div>
				</div>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Dibayarkan Kepada</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=($d[0]->dibayar_kepada)?></div>
				</div>				
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Uang Sejumlah</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=number_format($d[0]->jumlah)?></div>
				</div>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Untuk Keperluan</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=($d[0]->ket)?></div>
				</div>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Terbilang</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=Terbilang($d[0]->jumlah)?></div>
				</div>
				<div style="width:100%;float:left;">
					<div style="width:32%;float:left;border:1px solid #bbb;text-align: center;">Peneriman</div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;">Bendahara</div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;">Kasir</div>
				</div>				
				<div style="width:100%;float;left">
					<div style="width:32%;float:left;border:1px solid #bbb;text-align: center;height:auto;vertical-align: bottom;"><br><br><?=($d[0]->dibayar_kepada)?></div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;height:auto;vertical-align: bottom;"><br><br><?=($d[0]->bendahara)?></div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;height:auto;vertical-align: bottom;"><br><br><?=($d[0]->kasir)?></div>
				</div>
			</div>
			<div style="width:50%;float:left;padding : 8px;border-top:1px solid #ddd;">
				<h5>BUKTI KAS KELUAR<br>YAYASAN DEMIMASA KEHALUTUJU</h5>
				<p style="margin-top: -20px;font-size: 12px">
				Kantor : Sekolah Islam Ibnu Hajar, Kel. Katulampa, Bogor Timur, Kota Bogor - Telp (0251) 8374544
				</p>
				<hr>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Tanggal</div>
					<div style="width:44%;float:left;border-bottom:1px solid #bbb">&nbsp;</div>
					<div style="width:25%;float:right;border:1px solid #bbb;"><?=tgl_indo2($d[0]->tgl_transaksi)?></div>
				</div>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Dibayarkan Kepada</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=($d[0]->dibayar_kepada)?></div>
				</div>				
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Uang Sejumlah</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=number_format($d[0]->jumlah)?></div>
				</div>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Untuk Keperluan</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=($d[0]->ket)?></div>
				</div>
				<div style="width:100%;float:left;margin-bottom: 5px;">
					<div style="width:28%;float:left;border:1px solid #bbb;font-size:11px;padding:2px;">Terbilang</div>
					<div style="width:70%;float:right;border-bottom:1px solid #bbb"><?=Terbilang($d[0]->jumlah)?></div>
				</div>
				<div style="width:100%;float:left;">
					<div style="width:32%;float:left;border:1px solid #bbb;text-align: center;">Peneriman</div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;">Bendahara</div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;">Kasir</div>
				</div>				
				<div style="width:100%;float;left">
					<div style="width:32%;float:left;border:1px solid #bbb;text-align: center;height:auto;vertical-align: bottom;"><br><br><?=($d[0]->dibayar_kepada)?></div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;height:auto;vertical-align: bottom;"><br><br><?=($d[0]->bendahara)?></div>
					<div style="width:33%;float:left;border:1px solid #bbb;text-align: center;height:auto;vertical-align: bottom;"><br><br><?=($d[0]->kasir)?></div>
				</div>
			</div>

		</body>
	</html>