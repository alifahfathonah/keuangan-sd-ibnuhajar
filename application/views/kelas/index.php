<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="<?=site_url()?>kelas">Kelas</a> <span class="divider">/</span>
			</li>
			<li>
				Data Kelas
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Data Kelas</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
						<div style="width:60%;text-align:right;float:left">
							<div style="float:left;">
								<a href="<?=site_url()?>kelas/add" class="btn btn-primary btn-mini"><i class="icon-plus-sign icon-white"></i>&nbsp;Tambah Kelas</a>
							</div>
							<input class="input-xlarge focused"  style="float:right;" id="focusedInput" type="text" placeholder="Search Class">

						</div>

						<div id="isi" style="width:100%;float:left"></div>
							     
					</div>
				</div><!--/span-->
			
			</div>
</div> 
<script>
$(document).ready(function(){
	$('#isi').load('<?=site_url()?>kelas/dataKelas');
	$('#focusedInput').keyup(function(){
		var x=$(this).val();
		$('#isi').load('<?=site_url()?>kelas/dataKelas/'+x);
	});

	$('#Yes').click(function(){
		var va=$('#iddd').val();
		location.href="<?php echo site_url();?>kelas/delete/"+va;
	});
});

function del(id)
{
	$('#myModalConfirm').modal('show');
	$('#isiModalConfirm').html('<h3>Apakah Anda Yakin Mengahpus Data Kelas Ini ?</h3>');
	$('#iddd').val(id);
}
</script>