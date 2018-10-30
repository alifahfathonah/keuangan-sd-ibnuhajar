<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="<?=site_url()?>config/jenispenerimaan">Jenis Penerimaan</a>
			</li>

		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Jenis Penerimaan</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						<div class="box-content">
						<ul class="nav nav-tabs" id="nav-tabs">
							<?
							foreach ($data as $k => $v) 
							{
								echo '<li class="'.($jenisp==null ? 'active' : (str_replace('%20',' ',strtok($jenisp,'-'))==$v->kategori) ? 'active' : '').'"><a href="'.site_url().'config/jenispenerimaan/'.$v->kategori.'-'.$v->id.'">'.$v->kategori.'</a></li>';
								# code...
							}
							?>
						</ul>
						 
						<div id="" class="tab-content" style="width:64%;float:left">
							<?
							if(count($jenis)!=0)
							{

							?>
								<table class="table table-bordered table-hovered" style="width:100%;float:left">
									<thead>
										<tr>
											<th style="text-align:center">No</th>
											<th style="text-align:center">Jenis Penerimaan</th>
											<th style="text-align:center">Kode Akun</th>
											<th style="text-align:center">Action</th>
										</tr>	
									</thead>
									<tbody>
									<?php
										if(count($jenis)!=0)
										{
											for($i=0;$i<count($jenis);$i++)
											{
												// $pad=strlen(strtok($jenis[$i]->kode_akun,'0'));
												echo '<tr>
													<td style="text-align:left;padding-left:10px !important;">'.($i+1).'</td>
													<td style="text-align:left;padding-left:10px !important">'.$jenis[$i]->jenis.'</td>
													<td style="text-align:left;padding-left:10px !important">'.$jenis[$i]->kode_akun.'</td>
													<td style="text-align:center">
														<a class="btn btn-info  btn-mini" href="#" onclick="edit(\''.$jenis[$i]->id.'\')">
															<i class="icon-edit icon-white"></i>  											                                            
														</a>
														<a class="btn btn-danger  btn-mini" href="#" onclick="hapus(\''.$jenis[$i]->id.'\')">
															<i class="icon-trash icon-white"></i>  											                                            
														</a>
													</td>
												</tr>';
											}
										}
									?>
									</tbody>
								</table>
							<?
							// echo '<pre>';
							// 			print_r($this->db->database);
							// 			echo '</pre>';
							}
							?>
						</div>
							
						<div style="width:35%;float:right;text-align:left;margin-bottom:10px;">
							<h3>Tambah Jenis Penerimaan</h3>	
							<form style="width:100% !important" class="form-horizontal" action="<?=site_url()?>config/addkodeakun" method="post" enctype="multipart/form-data">
								<div class="">
														
									<div class="control-group">
									  <label class="control-label" for="typeahead">Kode Akun</label>
									  <div class="controls">
									  <?
									 //  	$CI = &get_instance();
										// $CI->load->database();
									  // $DB2 = $this->load->database('');
									  // if(strpos($this->db->database, 'sd')==='false')
									  // {
									  // 		$DB2 = $this->load->database('secondDatabase', TRUE);
									  // }
									  $akun=$this->db->query('select * from t_kode_akun order by kode_akun');
									  $ak=$akc=array();
									  foreach ($akun->result() as $k => $v) 
									  {
									  		$ak[$v->id_parent][$v->kode_akun]=$v;
									  		if($v->id_parent!=0)
									  		{
									  			$left=substr($v->kode_akun, 0,1);
									  			$akc[$left][$v->kode_akun]=$v;
									  		}
									  }
									  ?>
										<!-- <input type="text" name="kodeakun" class="span6 typeahead" id="kodeakun" style="width:100%;" required> -->
										<select name="kodeakun" data-placeholder="Kode Akun" id="selectError2" data-rel="chosen">
											<option value=""></option>
											<?
											foreach ($ak[0] as $k => $v) 
											{
												echo '<optgroup label="'.$v->kode_akun.'-'.$v->nama_akun.'">';
												$pe=strtok($v->kode_akun, '0');
												foreach ($akc[$pe] as $ka => $va) 
												{
													echo '<option value="'.$va->kode_akun.'">'.$va->kode_akun.'-'.$va->nama_akun.'</option>';
												}
												echo '</optgroup>';	# code...
											}
											?>

									  </select>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Jenis Penerimaan</label>
									  <div class="controls">
										<input type="text" name="jenispenerimaan" class="span6 typeahead" id="namaakun" style="width:100%;" required>
										<input type="hidden" name="idparent" class="span6 typeahead" id="idparent" value="0" style="width:100%;">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Kategori Penerimaan</label>
									  <div class="controls">
										<select id="selectError" name="kategoripenerimaan" data-rel="chosen">
											<option></option>
											<option value="sekolah">Penerimaan Sekolah</option>
											<option value="unit bisnis">Penerimaan Unit Bisnis</option>
										  </select>
									  </div>
									</div>
									
							
									
									<div class="form-actions" style="text-align:center">
									  <button type="submit" class="btn btn-primary">Save</button>
									</div> 
								</div>
							</form>	
						</div>

					</div>
				</div><!--/span-->
			
			</div>
</div> 
<script type="text/javascript">
function edit(id)
{
	// $('#kodeakunedit').focus();
	$.ajax({
		url : '<?=site_url()?>config/editjenispenerimaan/'+id,
		type : 'POST',
		success : function(a)
		{
			$('#myModalConfirm').modal('show');
			$('#headerPesan').text('Edit Jenis Penerimaan');
			$('#isiModalConfirm').html(a);
		}
	});
}

function hapus(id)
{
	// $('input#kodeakunadd').focus();
	// $.ajax({
	// 	url : '<?=site_url()?>config/addkodeakun/'+id,
	// 	type : 'POST',
	// 	success : function(a)
	// 	{
	// 		$('#myModalConfirm').modal('show');
	// 		$('#headerPesan').text('Add Kode Akun');
	// 		$('#isiModalConfirm').html(a);
	// 	}
	// });
	var c=confirm('Yakin ingin menghapus Jenis Penerimaan ini ?');
	if(c)
	{
		
	}
}

$(document).ready(function(){
	$('#Yes').click(function(){
		$('#fform-action-edit').submit();
		//location.href='<?=site_url()?>config/tahunajaran';
	});
	// $('.chzn-done').chosen();
});
</script>
<style type="text/css">
	ul#nav-tabs li a
	{
		color : #369bd7 !important;
		cursor: pointer;
	}

	ul#nav-tabs li.active a
	{
		color : #000 !important;
	}
	.table th, .table td
	{
		padding:2px !important;
	}
</style>