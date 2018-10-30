	<div >
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#"><?=$title?></a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> <?=$title?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>

					<div class="box-content" style="background:#fff">
						<div style="width:100%;text-align:right;">
							<button class="btn btn-mini btn-primary" onclick="topdf()">
								<i class="icon icon-white icon-pdf"></i>&nbsp;Cetak PDF
							</button>

						<script type="text/javascript">
							function topdf()
							{
								var idjenis=$('#pembayaram').val();
								var kelas=$('#datakelas').val();
								if(idjenis!='' && kelas !='')
									location.href='<?=site_url()?>topdf/pembayaranPerKelas/'+idjenis+'/'+kelas;
								else
								{
									$('#myModal').modal('show');
									$('#isiModal').html('Jenis Pembayaran dan Data Kelas Belum Dipilih');
								}
							}
						</script>
						</div>
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
							<form class="form-horizontal">
							  
								<div class="control-group">
								  <label class="control-label" for="date01">Jenis Pembayaran</label>
								  <div class="controls">
									<select name="pembayaran" id="pembayaram" data-rel="chosen" data-placeholder="Pembayaran">
										<option selected></option>
										<?
						
										$pen=$this->pm->getJenisPembayaranByParent(1);
										foreach($pen->result() as $p)
										{
											//if($p->id!=3 && $p->id!=4)
												echo '<option value="'.$p->id.'-'.$p->jenis.'">'.$p->jenis.'</option>';
										}
										?>

										
									</select>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="date01">Kelas</label>
								  <div class="controls">
									<select name="kelas" id="datakelas" data-rel="chosen" data-placeholder="Kelas">
										<option selected></option>
										<?
										$k=array();
										$kel=$this->km->getKelasAktif($k,null,'t');
										foreach($kel->result() as $kl)
										{
											echo '<option value="'.$kl->idkelas.'|'.$kl->id_ajaran.'|'.str_replace(' ', '%20', $kl->namakelasaktif).'">'.$kl->namakelas.' : '.$kl->namakelasaktif.'</option>';
										}
										?>

										<?
										$k=array();
										$kel=$this->km->getKelasAktif($k,null,'f');
										foreach($kel->result() as $kl)
										{
											echo '<option value="'.$kl->idkelas.'|'.$kl->id_ajaran.'|'.str_replace(' ', '%20', $kl->namakelasaktif).'">'.$kl->namakelas.' : '.$kl->namakelasaktif.'</option>';
										}
										?>
									</select>
								  </div>
								</div>

								
								<fieldset>
									<legend>Data Pembayaran <span id="pembb"></span></legend>
									<div id="datas"></div>
							  	</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#pembayaram').change(function(){
			var pem=$(this).val();
			var pp=pem.split('-');
			
			var idkelas=$('#datakelas').val();
			
			$('#pembb').text(pp[1]);
			if(idkelas!='')
			{
				var dd=idkelas.split('|');
				var idk=dd[0];
				var idj=dd[1];

				$('#datas').load('<?=site_url()?>laporan/getDataPerKelas/'+idk+'/'+idj+'/'+dd[2]+'/'+pp[0]);
			}

		});

		$('#datakelas').change(function(){
			var idkelas=$(this).val();
			var pem=$('#pembayaram').val();

			var pp=pem.split('-');

			$('#pembb').text(pp[1]);

			var dd=idkelas.split('|');
			//alert(dd[1]);
			var idk=dd[0];
			var idj=dd[1];
			$('#datas').load('<?=site_url()?>laporan/getDataPerKelas/'+idk+'/'+idj+'/'+dd[2]+'/'+pp[0]);
		});
	});
</script>