<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body onLoad="window.print()">


		<div style="width:800px;height:400px;float:left;">
			<div style="width:30%;float:left;height:80px;">
				<img src="<?=base_url()?>media/img/logo-2.png" style="height:80px;">
			</div>
			<div style="width:70%;text-align:right;float:right;font-weight:bold;font-family:verdana;line-height:20px;font-size:13px;">
				Jalan Katulampa RT. 03 RW. 01, Desa Parung Banteng 
				<br>
				Katulampa, Bogor Timur, Kota Bogor
				<br>
				Telp : 0251 - 8374544, HP : 085 100 282 111

			</div>
			
			<div style="width:100%;float:left;padding:5px;letter-spacing:-2px;font-family:verdana;font-weight:bold;background:#369bd7;margin:10px 0;text-align:center;color:white;font-size:30px;">BUKTI SETORAN TABUNGAN KELAS</div>

			<div style="width:49%;;float:left;font-weight:bold;font-size:14px;">
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Tanggal</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;" id="tgl"><?=tgl_indo($d->row('tgl_transaksi'))?></div>				
				</div>
				<div style="width:100%;float:left;">
				<?
				list($idpem,$namakelas) = explode('__', $d->row('kelas'));
				$namakelas=str_replace('_', ' ', $namakelas);
				?>
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Kelas</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=$namakelas?></div>	
				</div>
			</div>			

			<div style="width:49%;;float:left;font-size:14px;">
			
				<div style="width:59%;float:left;margin:3px 3px 3px 5px;font-weight:bold;">Keterangan :</div>	
				<div style="width:5px;float:left;margin:3px 3px 3px 5px;font-weight:bold;"></div>	
				<div style="width:35%;float:right;margin:3px 3px 3px 5px;">&nbsp;</div>				
			
				<div style="width:100%;float:left">
					<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp;</div>	
					<div style="width:85%;float:left;margin:3px 0 3px ;">Telah <?=$d->row('keterangan')?> <?=($d->row('nama_siswa')=='infaq' ? ' Sebesar ' : ' Dana Tabungan Sebesar')?> Rp. <?=number_format($d->row('jumlah'))?></div>	
				</div>


							
	
			</div>

			<div style="width:100%;float:left;margin:5px;padding:5px;font-size:14px;">
				<div style="width:45%;float:left;padding:10px;">
					&nbsp;
				</div>

				<div style="width:45%;float:right;padding:10px;text-align:center;font-weight:bold">
					<div>Bogor, </div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penyetor,

						<br>
						<br>
						<br>
						
						(<?=str_replace('Di Setor oleh','',$d->row('keterangan'))?>)
					</div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penerima,
						<br>
						<br>
						<br>
						<?=$this->session->userdata('nama')?>
					</div>
				</div>
			</div>
			<div style="width:100%;float:left;margin:5px;border:2px solid #111;background:#ccc;padding:5px;font-size:14px;">
				Terbilang : <br>
				<?
				// $total=str_replace(',', '', $_POST['total']);
				echo ucwords(Terbilang($d->row('jumlah'))).' Rupiah';
				?>
			</div>
		</div>
	</body>
</html>
<style type="text/css" media="print">
  @page { 
  	size: A4; 
  }
  @media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}
</style>
<style type="text/css">
*{
	line-height: 20px;
	font-size : 105%;
}
.tabel th,
.tabel td
{
	
	vertical-align: top;
	padding:3px;
}
.tabel th
{
	background: #ddd;
	vertical-align: middle !important;
}

h1,h2,h3,h4,h5,h6
{
	padding: 1px !important;
	margin: 1px !important;
}
div
{
	font-size: 12px !important;
	padding-top:0px;
	padding-bottom:0px;
	margin-top:-1px !important;
	margin-bottom:0px;
}
ol li 
{
	margin-top:3px !important;
	margin-bottom:0px !important;
}
div.b128{
	border-left: 1px black solid;
	height: 40px !important;
}

</style>