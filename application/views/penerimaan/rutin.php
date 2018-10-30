	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#"><?=$title?> </a>
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
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
						<div style="width:100%;text-align:left;" id="isi">
							<form class="form-horizontal" action="<?=site_url()?>penerimaan/penerimaanRutin/<?=$jenisP->row('id')?>" method="post">
								  <fieldset style="width:99%;float:left">
									<?php
									$csrf = array(
											'name' => $this->security->get_csrf_token_name(),
											'hash' => $this->security->get_csrf_hash()
									);
									?>
									<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
									<div class="control-group" style="width:33%;float:left">
									  <label class="control-label" for="typeahead">Jenis Penerimaan </label>
									  <div class="controls">
										<!--<label class="control-label" style="text-align:left;font-weight:bold" for="typeahead">-->
										<select name="jenispenerimaan" id="jenispenerimaan" data-rel="chosen" data-placeholder="Jenis Penerimaan">
											<option selected></option>	
											<?
												$jns=$this->pm->getJenisPembayaranByParent(1);

												if($jenisP->row('id')==13)
												{
													echo '<option value="'.$jenisP->row('id').'" selected>'.$jenisP->row('jenis').'</option>';
													//break;
												}
												else
												{
													foreach($jns->result() as $j)
													{
														if($j->id!=3 && $j->id!=4)
														{
															if($jenisP->row('id')==$j->id)
															{
																echo '<option value="'.$jenisP->row('id').'" selected>'.$j->jenis.'</option>';
															}
															else if($j->id==13)
																continue;
															else if($j->id==18)
																continue;
															else
																echo '<option value="'.$j->id.'">'.$j->jenis.'</option>';
														}

													}
												}
												//$jenisP->row('jenis')
											?>
										</select>
									  </div>
									</div>

									<div class="control-group"  style="width:30%;float:left">
									  <label class="control-label" for="date01">Bulan</label>
									  <div class="controls">
										<select name="bulan" id="bulan" data-rel="chosen" data-placeholder="Pilih Bulan">
											<option selected></option>
											<?
											for($i=1;$i<=12;$i++)
											{
												if($i==date('n'))
													echo '<option selected value="'.$i.'">'.getBulan($i).'</option>';
												else	
													echo '<option value="'.$i.'">'.getBulan($i).'</option>';
											}
											?>
										</select>
									  </div>
									</div>
									<div class="control-group"  style="width:30%;float:left">
									  <label class="control-label" for="date01">Tahun</label>
									  <div class="controls">
										<select name="tahun" data-rel="chosen" data-placeholder="Pilih Tahun" id="tahun">
											<option selected></option>
											<?
											for($i=(date('Y')-2);$i<=(date('Y')+1);$i++)
											{
												if($i==date('Y'))
													echo '<option value="'.date('Y').'" selected>'.$i.'</option>';
												else
													echo '<option value="'.$i.'">'.$i.'</option>';
											}
											?>
										</select>
									  </div>
									</div>  
       
									<!--<div class="control-group" style="width:100%;float:right;text-align:right">
									  <div class="controls"  style="float:right">
										<input type="text" name="jumlah" id="jumlah" class="input-xlarge datepicker hasDatepicker" value="<?=$jenisP->row('jumlah')?>">
									  </div>
									  <div class="control-label" for="date01" style="float:right;text-align:right">Jumlah Plafond</div>
									</div>  -
									<div class="control-group">
									  <label class="control-label" for="date01">Input Berdasarkan</label>
									  <div class="controls">
										<select name="input_by" id="input_by" data-rel="chosen" data-placeholder="Input By">
											<option selected></option>
											<option value='0'>Siswa</option>
											<option value='1'>Kelas</option>
											
										</select>
									  </div>
									</div>  -->

								<?
								if($idjenis!=13)
								{
								?>   
									<div class="control-group" id="by_kelas" style="width:50%;float:left;">
									  <label class="control-label" for="date01">Nama Kelas</label>
									  <div class="controls">
										<select name="kelas" id="kelasaktif" data-rel="chosen" data-placeholder="Pilih Kelas">
											<option selected></option>
											<?
											$k_=array();
											$kls=$this->km->getKelasAktif($k_,null,'t');
											foreach($kls->result() as $s)
											{
												echo '<option value="'.$s->idkelas.'|'.$s->id_ajaran.'|'.str_replace(' ', '%20', $s->namakelasaktif).'">'.$s->namakelas.'-'.$s->namakelasaktif.'</option>';
											}
											?>
										</select>
									  </div>
									 </div>
										<div class="control-group"  style="width:40%;float:right;text-align:right;">
											<label class="control-label" for="date01" style="text-align:right !important;">Jumlah Pembayaran</label>
											 <div class="controls">
											 	<input type="text" name="jumlah" id="jumlah" class=""  style="width:250px" value="<?=$jenisP->row('jumlah')?>">
											</div>         
										</div>         
										
										  <div style="width:100%;float:left;margin-top:10px" id="datasiswa"></div>
							<?
								}
								else
								{
							?>
								<div class="control-group" id="by_kelas" style="width:50%;float:left;">
									  <label class="control-label" for="date01">Nama Driver</label>
									  <div class="controls">
										<select name="driver" id="driver" data-rel="chosen" data-placeholder="Pilih Driver">
											<option selected></option>
											<?
											$dr=array();
											$driver=$this->cm->getDriver(-1);
											foreach($driver->result() as $d)
											{
												echo '<option value="'.$d->id.'">'.$d->nama_driver.'</option>';
											}
											?>
										</select>
									  </div>
								  </div>
									  	<div style="float:right;margin-right:10px;">
									  		<button type="button" class="btn btn-primary" id="adddriversiswa">Tambah Siswa</button>
									  	</div>
								 		<div style="width:100%;float:left;margin-top:10px" id="datasiswa"></div>
								  <script type="text/javascript">
								  	$(document).ready(function(){
								  		$('#simpansiswa').click(function(){
								  			$('#form-add').submit();
								  		});
								  		$('#driver').change(function(){
								  			var id=$(this).val();
								  			var bulan=$('#bulan').val();
								  			var tahun=$('#tahun').val();
											var idjenis=$('#jenispenerimaan').val();
								  			$('#iddriver').val(id);
								  			$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByDriver/'+id+'/'+bulan+'/<?=$idjenis?>/'+tahun);
								  		});
								  		$('#adddriversiswa').click(function(){
								  			if($('#driver').val()=='')
								  			{
								  				$('#myModal').modal('show');
								  				$('#isiModal').html('Nama Driver Belum Dipilih');
								  			}
								  			else
								  				$('#ModalTambahSiswa').modal('show');
								  		});
								  		
								  	});
								  </script>
								  
							<?		
								}
							?>
								  </fieldset>
									<div class="form-actions" style="float:left;width:82%">
									  <button type="submit" class="btn btn-primary">Save changes</button>
									  <a href="<?=site_url()?>penerimaan" type="reset" class="btn">Cancel</a>
									</div>
								  	
								</form>
						</div>
					</div>
				</div>
		</div>
	</div>
	<script>
	function format(val,id)
	{
		$('#'+id).formatCurrency({ symbol:'' });
	}
	$(document).ready(function(){
		var bulan=$('#bulan').val();
		var idjenis=$('#jenispenerimaan').val();
		$('#jumlah').formatCurrency({ symbol:'' });
		$('input#jumlah').each(function(){
				$(this).keyup(function(){
				$(this).formatCurrency({symbol:''});
			});
		});

		$('#jenispenerimaan').change(function(){
			var idjenis=$(this).val();
			var id=$('#kelasaktif').val();
			var bulan=$('#bulan').val();
			var tahun=$('#tahun').val();
			$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByKelas/'+(id.trim())+'/'+bulan+'/'+idjenis+'/'+tahun);
		});


		$('#kelasaktif').change(function(){
			var id=$(this).val();
			var bulan=$('#bulan').val();
			var tahun=$('#tahun').val();
			var idjenis='<?=$idjenis?>';
			// alert()
			$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByKelas/'+(id.trim())+'/'+bulan+'/'+idjenis+'/'+tahun);
		});


		var idj='<?=$idjenis?>';
		if(idj==13)
		{
			$('#bulan').change(function(){
				var bln=$(this).val();
				var thn=$('#tahun').val();
				var driver=$('#driver').val();
				if(driver=='')
				{
					$('#myModal').modal('show');
					$('#isiModal').html('Nama Driver Belum Dipilih');
				}
				else
					$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByDriver/'+driver+'/'+bln+'/<?=$idjenis?>/'+thn);
			});

			$('#tahun').change(function(){
				var thn=$(this).val();
				var bln=$('#bulan').val();
				var driver=$('#driver').val();
				if(driver=='')
				{
					$('#myModal').modal('show');
					$('#isiModal').html('Nama Driver Belum Dipilih');
				}
				else
					$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByDriver/'+driver+'/'+bln+'/<?=$idjenis?>/'+thn);
			});
		}
		else
		{
			$('#bulan').change(function(){
				var bln=$(this).val();
				var thn=$('#tahun').val();
				var idkelasaktif=$('#kelasaktif').val();
				if(idkelasaktif=='')
				{
					$('#myModal').modal('show');
					$('#isiModal').html('Silahkan Memilih Kelas Terlebih Dahulu');
				}
				else
					$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByKelas/'+(idkelasaktif.trim())+'/'+bln+'/'+idjenis+'/'+thn);
			});

			$('#tahun').change(function(){
				var thn=$(this).val();
				var bln=$('#bulan').val();
				var idkelasaktif=$('#kelasaktif').val();
				if(idkelasaktif=='')
				{
					$('#myModal').modal('show');
					$('#isiModal').html('Silahkan Memilih Kelas Terlebih Dahulu');
				}
				else
					$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByKelas/'+(idkelasaktif.trim())+'/'+bln+'/'+idjenis+'/'+thn);
			});
		}
		$('#by_siswa').hide();
		//$('#by_kelas').hide();
		$('#input_by').change(function(){
			var i=$(this).val();
			if(i==0)
			{
				$('#by_siswa').show();
				$('#by_kelas').hide();
			}
			else if(i==1)
			{
				$('#by_siswa').hide();
				$('#by_kelas').show();
			}
			else
			{
				$('#by_siswa').hide();
				$('#by_kelas').hide();
			}
		});
	});
function hapusdatasiswadriver(nis,iddriver,bln,thn)
{
	var c=confirm('Yakin ingin menghapus Data Ini ??');
	if(c)
	{
		$.ajax({
			url : '<?=site_url()?>penerimaan/hapusdatasiswadriver',
			type : 'POST',
			data : {n:nis, id:iddriver, bl : bln, th:thn},
			success : function(a)
			{
				$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByDriver/'+iddriver+'/'+bln+'/13/'+thn);
			}
		});
	}
}
function hapusdata(id,jns)
{
	var c=confirm('Yakin ingin menghapus Data Penerimaan ini ??');
	if(c)
	{
		if (jns == 'jemputan') 
		{
			var cekexplode=id.split('__');
			var kelasaktif=cekexplode[2]+'|'+cekexplode[3]+'|'+cekexplode[4];
			id=cekexplode[1];
		}
		else
		{
			var kelasaktif=$('#kelasaktif').val();
		}
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		var jenis=$('#jenispenerimaan').val();
		//alert(kelasaktif.trim());
		$.ajax({
			url : '<?=site_url()?>siswa/hapusdatapenerimaan/'+id+'/'+jns+'/'+(kelasaktif.trim())+'/'+bulan+'/'+jenis+'/'+tahun,
			success : function(a)
			{
				if(jns=='jemputan')
				{
					var driver=$('#driver').val();
					$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByDriver/'+driver+'/'+bulan+'/'+jenis+'/'+tahun);		
				}
				else
					$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByKelas/'+(kelasaktif.trim())+'/'+bulan+'/'+jenis+'/'+tahun);			
			}
		});
	}

}
function hapusdatajemputan(id)
{
	$.ajax({
			url : '<?=site_url()?>penerimaan/hapusdatajemputan/'+id,
			success : function(a)
			{
				var bulan=$('#bulan').val();
				var tahun=$('#tahun').val();
				var jenis=$('#jenispenerimaan').val();
				var driver=$('#driver').val();
				$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByDriver/'+driver+'/'+bulan+'/'+jenis+'/'+tahun);
			}
	});
}
function pilihsemua(idselector)
{	


 	if ($('input#'+idselector).attr("data-type") === "uncheck") 
 	{
		$('input#pilihan').prop("checked", false);
		$('input#'+idselector).attr("data-type", "check");
	} 
	else 
	{
		$('input#pilihan').prop("checked", true);
		$('input#'+idselector).attr("data-type", "uncheck");
	}

}
	</script>
								<div class="modal hide fade" id="ModalTambahSiswa" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">×</button>
										<h3>Tambah Siswa Jemputan</h3>
									</div>
									<div class="modal-body" style="height:380px !important">
										<form class="form-horizontal" action="<?=site_url()?>config/adddriversiswa/<?=$idjenis?>" id="form-add" method="post">
										    <input type="hidden" id="iddriver" name="iddriver">
										    <?
										    for($si=0;$si<5;$si++)
										    {
										    ?>
										    <div class="control-group">
										      <label class="control-label" for="input01">Nama Siswa</label>
										      <div class="controls">
										        <select name="namasiswa[]" id="namasiswa_<?=$si?>" data-rel="chosen" data-placeholder="Pilih Siswa" style="width:300px !important">
										        	<option selected></option>
										        	<?
										        	$sa=$this->sm->getSiswaAktifKelasAktif('t')->result();
										        	$ca=count($sa);
										        	if($ca!=0)
										        	{
										        		for($c=0;$c<$ca;$c++)
										        		{
										        			echo '<option value="'.$sa[$c]->nis.'">'.$sa[$c]->nama.' || '.$sa[$c]->namakelasaktif.'</option>';
										        		}
										        	}
										        	?>
										        </select>
										      </div>
										    </div>
										    <?
											}
										    ?>
										</form>
									</div>
									<div class="modal-footer">
										<a href="#" class="btn btn-danger" data-dismiss="modal">Tidak</a>
										<a href="#" class="btn btn-primary" data-dismiss="modal" id="simpansiswa">Simpan</a>
									</div>
								</div>
								