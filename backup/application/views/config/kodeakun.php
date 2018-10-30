<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="<?=site_url()?>config/kodeakun">Kode Akun</a>
			</li>

		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Kode Akun</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						<div class="box-content">
						<ul class="nav nav-tabs" id="nav-tabs">
							<?
							$kodeakun=($kodeakun==null ? 1 : $kodeakun);
							foreach ($data as $k => $v) 
							{
								echo '<li class="'.($kodeakun==null ? 'active' : (substr($kodeakun,0,1)==substr($v->kode_akun,0,1) ? 'active' : '')).'"><a href="'.site_url().'config/kodeakun/'.$v->kode_akun.'">'.$v->kode_akun.'-'.$v->nama_akun.'</a></li>';
								# code...
							}
							?>
						</ul>
						 
						<div id="" class="tab-content" style="width:64%;float:left">
							<?
							if(count($kode)!=0)
							{

							?>
								<table class="table table-bordered table-hovered" style="width:100%;float:left">
									<thead>
										<tr>
											<th style="text-align:center">Kode Akun</th>
											<th style="text-align:center">Nama Akun</th>
											<th style="text-align:center">Action</th>
										</tr>	
									</thead>
									<tbody>
									<?php
										if(count($kode)!=0)
										{
											for($i=0;$i<count($kode);$i++)
											{
												$pad=strlen(strtok($kode[$i]->kode_akun,'0'));
												echo '<tr>
													<td style="text-align:left;padding-left:'.($pad*12).'px !important;">'.($kode[$i]->kode_akun).'</td>
													<td style="text-align:left;padding-left:'.($pad*12).'px !important">'.$kode[$i]->nama_akun.'</td>
													<td style="text-align:center">
														<a class="btn btn-info  btn-mini" href="#" onclick="edit(\''.$kode[$i]->kode_akun.'\')">
															<i class="icon-edit icon-white"></i>  											                                            
														</a>
														<a class="btn btn-success  btn-mini" href="#" onclick="addakun(\''.$kode[$i]->kode_akun.'\')">
															<i class="icon-plus-sign icon-white"></i>  											                                            
														</a>
													</td>
												</tr>';
											}
										}
									?>
									</tbody>
								</table>
							<?
							}
							?>
						</div>
							
						<div style="width:35%;float:right;text-align:right;margin-bottom:10px;">
							<h3>Tambah Kode Akun</h3>	
							<form style="width:100% !important" class="form-horizontal" action="<?=site_url()?>config/addkodeakun" method="post" enctype="multipart/form-data">
								<div class="">
														
									<div class="control-group">
									  <label class="control-label" for="typeahead">Kode Akun</label>
									  <div class="controls">
										<input type="text" name="kodeakun" class="span6 typeahead" id="kodeakun" style="width:100%;" required>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Nama Akun</label>
									  <div class="controls">
										<input type="text" name="namaakun" class="span6 typeahead" id="namaakun" style="width:100%;" required>
										<input type="hidden" name="idparent" class="span6 typeahead" id="idparent" value="0" style="width:100%;">
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
	$('#kodeakunedit').focus();
	$.ajax({
		url : '<?=site_url()?>config/editkodeakun/'+id,
		type : 'POST',
		success : function(a)
		{
			$('#myModalConfirm').modal('show');
			$('#headerPesan').text('Edit Kode Akun');
			$('#isiModalConfirm').html(a);
		}
	});
}

function addakun(id)
{
	$('input#kodeakunadd').focus();
	$.ajax({
		url : '<?=site_url()?>config/addkodeakun/'+id,
		type : 'POST',
		success : function(a)
		{
			$('#myModalConfirm').modal('show');
			$('#headerPesan').text('Add Kode Akun');
			$('#isiModalConfirm').html(a);
		}
	});
}

$(document).ready(function(){
	$('#Yes').click(function(){
		$('#fform-action-edit').submit();
		//location.href='<?=site_url()?>config/tahunajaran';
	});
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