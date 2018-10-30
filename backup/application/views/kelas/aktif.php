			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><?=$title?></a>
					</li>
				</ul>
			</div>
			<div class="row-fluid sortable ui-sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-edit"></i> <?=$title?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						<div class="box-content">
							<ul class="nav nav-tabs" id="myTab">
								<li class="active"><a href="#info">Data Kelas Aktif</a></li>
								<!-- <li class="" ><a href="#custom">Kelas Tidak Aktif</a></li> -->
								<li class=""><a href="#add">Tambah Kelas Aktif</a></li>
								
							</ul>
							 
							<div id="myTabContent" class="tab-content">
								<div class="tab-pane active" id="info">
									
										<div style="width:100%;text-align:right;float:left;">

											<input class="input-xlarge focused"  style="float:right;" id="searchaktiv" type="text" placeholder="Search Class Active">

										</div>

										<div id="isiAktif" style="float:left;width:100%"></div>
											     
									
								</div>
								<!-- <div class="tab-pane" id="custom">
									
										<div style="width:100%;text-align:right">

											<input class="input-xlarge focused"  style="float:right;" id="searchnonaktiv" type="text" placeholder="Search Class Non Active">

										</div>

										<div id="isiTdkAktif"></div>
											     
									</div>	 -->
								<div class="tab-pane" id="add">
											<form id="fform-action" class="form-horizontal" action="<?=site_url()?>kelas/addkelasaktif" method="post" enctype="multipart/form-data">
											<div class="row-fluid">
												<div class="span5">
																		
<?php
	$l=$k=$u=array();
	$siswa=$this->sm->getSiswa($l,'null');
	$kelas=$this->km->getKelas($k,'null');
	$user=$this->um->getUser($u,'null',1);
?>													<div class="control-group">
													  <label class="control-label" for="typeahead">Nama Siswa*</label>
													  <div class="controls">
														
														<select id="selectError" data-rel="chosen" name="nama" data-placeholder="Pilih Nama Siswa">
														<option value=""></option>
														<?
														foreach($siswa->result() as $s)
														{
															echo '<option value="'.$s->nis.'">'.$s->nama.'</option>';
														}
														?>	
														</select>
													  </div>
													</div>
													<div class="controls-group">
													<label class="control-label" for="typeahead">Kewajiban*</label>
													<div class="controls">
													  <label class="radio">
														<span class="radio" id="uniform-optionsRadios1">
															<span class="checked">
																<input type="radio" name="bayar" id="optionsRadios1" value="4" checked="checked" style="opacity: 0;">
															</span>
														</span>
														PPTAB
													  </label>
													  <div style="clear:both"></div>
													  <label class="radio">
														<span class="radio" id="uniform-optionsRadios2">
															<span>
																<input type="radio" name="bayar" id="optionsRadios2" value="3" style="opacity: 0;">
															</span>
														</span>
														UTAB
													  </label>
													</div>
													</div>
													<div class="control-group">
													  <label class="control-label" for="typeahead">Kelas*</label>
													  <div class="controls">
														<select id="selectError1" data-rel="chosen" name="kelas" data-placeholder="Pilih Kelas">
														<option value=""></option>
														<?
														foreach($kelas->result() as $kl)
														{
															echo '<option value="'.$kl->id.'">'.$kl->namakelas.'</option>';
														}
														?>	
														</select>
													  </div>
													</div>	
													<div class="control-group">
													  <label class="control-label" for="typeahead">Nama Kelas*</label>
													  <div class="controls">
														<input type="text" name="namakelas" id="namakelas">
													  </div>
													</div>												
													<div class="control-group">
													  <label class="control-label" for="typeahead">Wali Kelas*</label>
													  <div class="controls">
														<select id="selectError2" data-rel="chosen" name="walikelas" data-placeholder="Wali Kelas">
														<option value=""></option>
														<?
														foreach($user->result() as $us)
														{
															echo '<option value="'.$us->id.'">'.$us->nama.'</option>';
														}
														?>	
														</select>
													  </div>
													</div>
													<div class="control-group">
													  <label class="control-label" for="typeahead">Tahun Ajaran*</label>
													  <div class="controls">
														<select name="ajaran" data-rel="chosen">
															<option value=''>-Tahun Ajaran-</option>
															<?
															$aj=$this->db->query('select * from t_ajaran order by id');
															foreach($aj->result() as $a)
															{
																echo '<option value="'.$a->id.'">'.$a->tahunajaran.'</option>';
															}
															?>
														</select>
													  </div>

													</div>
												
												</div>
											</div>
											<div class="form-actions" style="text-align:center">
											  	<button type="Submit" class="btn btn-primary" id="submit">Save changes</button>
												<a href="<?=site_url()?>kelas/aktif" type="reset" class="btn">Cancel</a>
											</div>
										</form>
								</div>
								
								
							</div>
						</div>
					</div>
				</div><!--/span-->

			</div> 

<script>
$(document).ready(function(){
	$('#isiAktif').load('<?=site_url()?>kelas/getKelasAktif/null/t');
	$('#isiTdkAktif').load('<?=site_url()?>kelas/getKelasAktif/null/f');
	$('#searchaktiv').keyup(function(){
		var se=$(this).val();
		if(se=='')
			$('#isiAktif').load('<?=site_url()?>kelas/getKelasAktif/null/t');
		else
			$('#isiAktif').load('<?=site_url()?>kelas/getKelasAktif/'+se+'/t');
	});

	$('#searchnonaktiv').keyup(function(){
		var se=$(this).val();
		if(se=='')
			$('#isiTdkAktif').load('<?=site_url()?>kelas/getKelasAktif/null/f');
		else
			$('#isiTdkAktif').load('<?=site_url()?>kelas/getKelasAktif/'+se+'/f');
	});

	$('#Yes').click(function(){
		var idd=$('#iddd').val();
		location.href='<?=site_url()?>kelas/hapuskelas/'+idd;
	});
});

function del(id)
{
	$('#myModalConfirm').modal('show');
	$('#isiModalConfirm').html('<h3>Apakah Anda Yakin Mengahpus Data Kelas Ini ?</h3>');
	$('#iddd').val(id);
}

function pilihsemua(idselector,st)
{	


 	if ($('input#'+idselector+'_'+st).attr("data-type") === "uncheck") 
 	{
		$('input#pilihan_'+st).prop("checked", false);
		$('input#'+idselector+'_'+st).attr("data-type", "check");
	} 
	else 
	{
		$('input#pilihan_'+st).prop("checked", true);
		$('input#'+idselector+'_'+st).attr("data-type", "uncheck");
	}

}
</script>
