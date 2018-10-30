			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Pembagian Kelas</a>
					</li>
				</ul>
			</div>
			<div class="row-fluid sortable ui-sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-edit"></i> Pembagian Kelas</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						<div class="box-content">
							<ul class="nav nav-tabs" id="myTab">
								<li class="active"><a href="#info">Data Kelas Pembagian</a></li>
								<!-- <li class="active" ><a href="#custom">Kelas Tidak Aktif</a></li> -->
								<!-- <li class=""><a href="#add">Tambah Kelas Aktif</a></li> -->
								
							</ul>
							 
							<div id="myTabContent" class="tab-content" style="min-height:600px;">
								<div class="tab-pane active" id="info">
									<div class="row-fluid">
										
									
									<?
									if(count($dd)!=0)
									{
										foreach ($dd as $k => $v) 
										{
											$bg='';
											// if($tabb!='utama')
											// {
												if($v->idkelas==$id and $v->id_ajaran==$idajaran)
													$bg=';background:#c7e3ff';
												else
													$bg='';
											// }
											// else
											// {
											// 		$bg=';background:#c7e3ff';
											// }
											// echo  $tabb;
												// $ta
									?>
										<div class="span2 menupembagian" style="float:left;border:1px solid #428eee;margin-top:5px;margin-left:25px;margin-bottom:5px;text-align:center;width:125px;cursor:pointer<?=$bg?>" onclick="det('<?=$v->namakelas?>','<?=$v->id_ajaran?>','<?=$v->idkelas?>')">
											<span class="icon32 icon-blue icon-book"></span>
											<h4>
												<?=$v->namakelas?>
											</h4>
											<h5>
												<?=$v->tahunajaran?>
											</h5>
										</div>
										<div  style="ext-align:center;float:left;height:49px;margin-top:5px;">
											<div style="height:50%;float:float;width:100%;padding:5px 0px 5px 3px;border:1px solid #428eee;cursor:pointer;">
											<?

											if($v->idkelas==$id)
											{
											?>
												<span class="icon icon-red icon-search" onclick="deta('<?=str_replace(' ', '%20', $v->namakelas)?>','<?=$v->id_ajaran?>','<?=$v->idkelas?>')"></span>
											<?
											}
											else
											{
											?>
												<span class="icon icon-color icon-search" onclick="det('<?=str_replace(' ', '%20', $v->namakelas)?>','<?=$v->id_ajaran?>','<?=$v->idkelas?>')"></span>
											<?
											}
											?>
											</div>											
											<div style="height:50%;float:float;width:100%;padding:5px 0px 5px 3px;border:1px solid #428eee;border-top:0px;cursor:pointer;">
											<?

											if($v->idkelas==$id)
											{
											?>
												<span class="icon icon-red icon-add" onclick="addkelas('<?=$v->idkelas?>','<?=$v->id_ajaran?>')"></span>
											<?
											}
											else
											{
											?>
												<span class="icon icon-color icon-add" onclick="det('<?=str_replace(' ', '%20', $v->namakelas)?>','<?=$v->id_ajaran?>','<?=$v->idkelas?>')"></span>
											<?
											}
											?>
												
											</div>
										</div>
									<?
										}
									}
									?>
										</div>
										<div style="width:100%;text-align:right;float:left;margin-top:20px;" >
											<div class="span7" id="data"></div>
											<div class="span5" id="datasiswa">
											<?
											if($tabb=='detailsubkelas')
											{
												$dd['id']=$id;
												$dd['det']=$sub;
												$dd['subkelasid']=$subkelasid;
												$dd['idajaran']=$idajaran;
												$this->load->view('kelas/pembagian-add-siswa',$dd);
											}
											?>
											</div>
										</div>
										
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	<script type="text/javascript">
	
	$('#data').load('<?=site_url()?>kelas/datapembagiankelas/t/<?=$namakelas?>/<?=$idajaran?>');
	function datasiswa(idpembagian)
	{
		$('#datasiswa').load('<?=site_url()?>kelas/datasiswaperkelas/'+idpembagian);
	}

	function removesiswa(id)
	{
		$('#myModalConfirm').modal('show');
		$('#isiModalConfirm').html('<h3>Yakin ingin Menghapus Siswa ini ??</h3>');
		$('#iddd').val(id)
	}

	$(document).ready(function(){
		$('#Yes').click(function(){
			var va=$('#iddd').val();
			$.ajax({
				url : '<?=site_url()?>kelas/hapusdatasiswa/'+va,
				success : function(aa)
				{
					if(aa!=0)
					{
						var x=(aa.trim()).split('-');
						$('#datasiswa').load('<?=site_url()?>kelas/datasiswaperkelas/'+x[0]);
						$('#jlhsiswa_'+x[0]).text(x[1] +' Siswa');
					}
				}
			});
			// alert(va);
			// location.href="<?php echo site_url();?>kelas/delete/"+va;
		});
	});

	function det(namakelas,idajaran,idkelas)
	{
		location.href='<?=site_url()?>kelas/pembagiankelas/'+idkelas+'/'+idajaran;
	}
	function deta(namakelas,idajaran,idkelas)
	{
		var nk=namakelas.replace(/ /g,'%20');
		$('#data').load('<?=site_url()?>kelas/datapembagiankelas/t/'+namakelas+'/'+idajaran+'/'+idkelas);
	}
	function addkelas(idkelas,idajaran)
	{
		
		$('#data').load('<?=site_url()?>kelas/pembagianform/'+idkelas+'/'+idajaran);
	}

	function editkelas(idkelas,idajaran,idpembagian)
	{
		$('#formPembagianModal').modal('show');
		$('#isiPembagianModal').load('<?=site_url()?>kelas/pembagianform/'+idkelas+'/'+idajaran+'/'+idpembagian);
	}

	function hapuskelas(idpembagian,idkelas)
	{
		var c=confirm('Yakin ingin Menghapus Data Pembagian Kelas ini ??');
		if(c)
		{
			location.href='<?=site_url()?>kelas/pembagiankelashapus/'+idpembagian+'/'+idkelas;
		}
	}

	function simpaneditpembagian()
	{
		$('#fform-action').submit();
	}
	</script>
	<style type="text/css">
	.menupembagian:hover
	{
		background:#c7e3ff;
	}
	</style>

		<div class="modal hide fade" id="formPembagianModal">
			<!-- <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3 id="headerPesan">Form Pembagian Kelas</h3>
			</div> -->
			<div class="modal-body">
				<h3 id="isiPembagianModal"></h3>
				<input type="hidden" name="iddd" id="iddd">
			</div>
			<div class="modal-footer">
				<a href="#" id="YesPembagian" onclick="simpaneditpembagian()" class="btn btn-primary">Yes</a>
				<a href="#" class="btn" data-dismiss="modal">Cancel</a>
			</div>
		</div>