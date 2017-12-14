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
						<div class="row-fluid">
							<form id="fform-action" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="span5">
														
									<div class="control-group">
									  <label class="control-label" for="typeahead">Nama Kelas*</label>
									  <div class="controls">
										<input type="text" name="namakelas" class="span6 typeahead" id="namakelas" style="width:100%;" onblur="cek('namakelas')" value="<?=$namakelas?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Kapasitas Kelas*</label>
									  <div class="controls">
										<input type="text" name="kapasitas" class="span6 typeahead" id="kapasitas" style="width:100%;" onblur="cek('kapasitas')" value="<?=$kapasitas?>">
									  </div>
									</div>

									
									
								 

								 
							</div>
							
						</div>
							<div class="form-actions" style="text-align:center">
									  <button type="button" class="btn btn-primary" id="submit">Save changes</button>
									  	<?
									  	if(isset($id))
									  	{
									  	?>
										<button type="reset" class="btn">Cancel</button>
										<button type="button" class="btn btn-primary" onclick="location.href='<?=site_url()?>kelas'">Back</button>
										<?
										}
										else
										{
										?>
										<button type="reset" class="btn">Cancel</button>

										<?
										}
										?>
									</div>
							</form>  
						</div>

					</div>
				</div><!--/span-->

			</div> 
<script>
	$(document).ready(function(){
		$('#submit').click(function(){
			$('#myModalConfirm').modal('show');
			$('#isiModalConfirm').html('<h3>Apakah Data Kelas Sudah Benar ??</h3>');

			$('#Yes').click(function(){
				//alert('Yes');
				$.ajax({
					url : '<?php echo site_url()?>kelas/proseskelas/<?=(isset($id) ? $id : "null")?>',
					type : 'POST',
					data : $('form#fform-action').serialize(),
					success : function(a)
					{
						//alert(a);
						location.href="<?php echo site_url()?>kelas";
						//$('#form-action').submit();
					}
				});
			});
		});
	});
</script>