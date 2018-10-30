<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="<?=site_url()?>config/tahunajaran">Tahun Ajaran</a>
			</li>

		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Tahun Ajaran</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						
						<table class="table table-bordered table-hovered" style="width:50%;float:left">
							<thead>
								<tr>
									<th style="text-align:center">No</th>
									<th style="text-align:center">Tahun Ajaran</th>
									<th style="text-align:center">Action</th>
								</tr>	
							</thead>
							<tbody>
							<?php
								if(count($data)!=0)
								{
									for($i=0;$i<count($data);$i++)
									{
										echo '<tr>
											<td style="text-align:center">'.($i+1).'</td>
											<td style="text-align:center">'.$data[$i]->tahunajaran.'</td>
											<td style="text-align:center">
												<a class="btn btn-info  btn-mini" href="#" onclick="edit(\''.$data[$i]->id.'\')">
													<i class="icon-edit icon-white"></i>  											                                            
												</a>
											</td>
										</tr>';
									}
								}
							?>
							</tbody>
						</table>
						<div style="width:45%;float:right;text-align:right;margin-bottom:10px;">
							<h3>Tambah Tahun Ajaran</h3>	
							<form id="fform-action" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>config/addajaran" method="post" enctype="multipart/form-data">
								<div class="">
														
									<div class="control-group">
									  <label class="control-label" for="typeahead">Tahun Ajaran</label>
									  <div class="controls">
										<input type="text" name="tahunajaran" class="span6 typeahead" id="tahunajaran" style="width:100%;" required>
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
	$.ajax({
		url : '<?=site_url()?>config/editajaran/'+id,
		type : 'POST',
		success : function(a)
		{
			$('#myModalConfirm').modal('show');
			$('#headerPesan').text('Edit Tahun Ajaran');
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