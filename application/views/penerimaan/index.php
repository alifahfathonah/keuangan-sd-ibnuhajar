	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Transaksi Penerimaan</a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Transaksi Penerimaan</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>

					<div class="box-content" style="background:#fff">
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">

						

						<div style="width:25%;float:left;padding:10px;border:1px solid #ddd;text-align:center;margin:10px;">
							<?=form_open('penerimaan/addplafond')?>
							<select name="jenispenerimaan" id="jenispenerimaan" data-rel="chosen" data-placeholder="Kewajiban Tahunan">
								<option selected value=""></option>
								<option style="text-align:left" value="<?=$pen['lain'][0]->id?>"><?=$pen['lain'][0]->jenis?></option>
								<option style="text-align:left" value="<?=$pen['lain'][1]->id?>"><?=$pen['lain'][1]->jenis?></option>
								<?
								$lain=$pen['lain'];
								$tb='';
								foreach($lain as $key=> $ut)
								{
									if($ut->id==3 && $ut->id==4)
									{
										echo '<option style="text-align:left" value="'.$ut->id.'">'.$ut->jenis.'</option>';
									}
								}
								?>
								
							</select><br>
							<Button type="submit" style="margin-top:0px;" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>&nbsp;Proses</button>
						</div>
						<div style="width:25%;float:left;padding:10px;border:1px solid #ddd;text-align:center;margin:10px;">
						<?=form_close()?>
						<form id="penerimaanRutin">
							<select name="jenispenerimaanrutin" id="jenispenerimaanrutin" data-rel="chosen" data-placeholder="Kewajiban Rutin">
								<option selected value=""></option>
								
								<?
								$lainn=$pen['lain'];
								$tb='';
								foreach($lainn as $key=> $ut)
								{
									if($ut->id!=3 && $ut->id!=4)
									{
										if($ut->id==18)
											continue;
										else
											echo '<option style="text-align:left" value="'.$ut->id.'">'.$ut->jenis.'</option>';
									}
								}
								?>
								
							</select><br>
							<Button type="button" id="rutin" style="" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>&nbsp;Proses</button>
						<?=form_close()?>
						</div>
						<div style="width:25%;float:left;padding:10px;border:1px solid #ddd;text-align:center;margin:10px;">
							<!--<a href="<?=site_url()?>penerimaan/transaksi/tahunan" style="margin-bottom:4px;"class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>&nbsp;Tambah Transaksi Tahunan</a>
							<br>-->
							<a href="<?=site_url()?>penerimaan/transaksi/rutin" style="margin-bottom:4px;" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>&nbsp;Tambah Data Transaksi</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-tasks"></i> Penerimaan Harian</h2>
					</div>
					<div class="box-content" style="background:#fff">
						<div style="float:right;width:100%">
							<input class="span2" type="text" id="tgll" name="tgl" style="float:left;" readonly value="<?=date('d-m-Y')?>">
							<!-- <Button type="button" id="rutin" style="float:right" class="btn btn-primary btn-mini">
								<i class="icon-print icon-white"></i>&nbsp;Cetak Laporan</button> -->
						</div>
						<div id="grafik" style="width:100%;float:left"></div>
					</div>
				</div>
			</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#rutin').click(function()
		{
			var idjenis=$('#jenispenerimaanrutin').val();
			if(idjenis=='')
			{
				$('#myModal').modal('show');
				$('#isiModal').html('Jenis Penerimaan Belum Dipilih');
			}
			else
				location.href='<?=site_url()?>penerimaan/rutin/'+idjenis;
		});

		$('#grafik').load('<?=site_url()?>penerimaan/penerimaanharian');

		$( "#tgll" ).datepicker({
				showOn: "button",
				buttonImage: "<?=base_url()?>media/img/calendar146.png",
				buttonImageOnly: true,
				dateFormat:'dd-mm-yy',
				changeMonth: true,
				changeYear: true,
				onClose: function( selectedDate ) 
				{
		        	$('#grafik').load('<?=site_url()?>penerimaan/penerimaanharian/'+selectedDate);
		    	}
		});

	});
</script>