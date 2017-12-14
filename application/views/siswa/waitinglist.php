<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="<?=site_url()?>siswa/waitinglist">Data Waiting List</a><span class="divider">/</span>
			</li>
			<li>
				Data Waiting List
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Data Waiting List</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
						<div style="width:100%;text-align:right"><input class="input-xlarge focused" id="focusedInput" type="text" placeholder="Search Name"></div>

							<div id="isi"></div>
							<!--<table class="table table-striped table-bordered bootstrap-datatable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
						  <thead>
							  <tr role="row"><th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Username: activate to sort column descending" style="width: 207px;">Username</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Date registered: activate to sort column ascending" style="width: 187px;">Date registered</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 98px;">Role</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 99px;">Status</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 387px;">Actions</th></tr>
						  </thead>   
						  
					  <tbody role="alert" aria-live="polite" aria-relevant="all">
					  		<tr class="odd">
								<td class=" sorting_1">Abdullah</td>
								<td class="center ">2012/02/01</td>
								<td class="center ">Staff</td>
								<td class="center ">
									<span class="label label-important">Banned</span>
								</td>
								<td class="center ">
									<a class="btn btn-success" href="#">
										<i class="icon-zoom-in icon-white"></i>  
										View                                            
									</a>
									<a class="btn btn-info" href="#">
										<i class="icon-edit icon-white"></i>  
										Edit                                            
									</a>
									<a class="btn btn-danger" href="#">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
								</td>
							</tr>
						</tbody></table>-->       
					</div>
				</div><!--/span-->
			
			</div>
</div> 
<script>
$(document).ready(function(){
	$('#isi').load('<?=site_url()?>siswa/wl');
	$('#focusedInput').keyup(function(){
		var x=$(this).val();
		$('#isi').load('<?=site_url()?>siswa/wl/'+x);
	});

	$('#Yes').click(function(){
		var va=$('#iddd').val();
		location.href="<?php echo site_url();?>siswa/delete/"+va+'/w';
	});
});

function del(id)
{
	$('#myModalConfirm').modal('show');
	$('#isiModalConfirm').html('<h3>Apakah Anda Yakin Mengahpus Data Ini ?</h3>');
	$('#iddd').val(id);
}
</script>