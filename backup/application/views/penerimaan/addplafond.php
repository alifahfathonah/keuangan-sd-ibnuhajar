	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#"><?=$title.' '.$jenisP->row('jenis')?> </a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> <?=$title.' '.$jenisP->row('jenis')?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>

					<div class="box-content" style="background:#fff">
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
						<div style="width:100%;text-align:left;" id="isi">
							<form class="form-horizontal" action="<?=site_url()?>penerimaan/updatePlafond/<?=$jenisP->row('id')?>" method="post">
								  <fieldset>
									
									<div class="control-group">
									  <label class="control-label" for="typeahead">Jenis Penerimaan </label>
									  <div class="controls">
										<label class="control-label" style="text-align:left;font-weight:bold" for="typeahead"><?=$jenisP->row('jenis')?> </label>
									  </div>
									</div>
								<?
								if($jenisP->row('id')==3 || $jenisP->row('id')==4)
								{
									$penerimaan=$this->pm->getJenisPembayaranByParent($jenisP->row('id'));
									foreach ($penerimaan->result() as $v) 
									{
										# code...
									
								?>
									<div class="control-group">
									  <label class="control-label" for="date01"><?=$v->jenis?></label>
									  <div class="controls">
										<input type="text" name="jumlah[<?=$v->id?>]" id="jumlah" class="input-xlarge datepicker hasDatepicker" value="<?=($jenisP->row('id')==4 ? $v->jumlah2 : $v->jumlah)?>">
									  </div>
									</div>
								<?
									}
								}
								else
								{
								?>       
									<div class="control-group">
									  <label class="control-label" for="date01">Jumlah Plafond</label>
									  <div class="controls">
										<input type="text" name="jumlah[]" id="jumlah" class="input-xlarge datepicker hasDatepicker" value="<?=$jenisP->row('jumlah')?>">
									  </div>
									</div>         
								<?
								}

								?>	
									<div class="form-actions">
									  <button type="submit" class="btn btn-primary">Save changes</button>
									  <a href="<?=site_url()?>penerimaan" type="reset" class="btn">Cancel</a>
									</div>
								  </fieldset>
								</form>
						</div>
					</div>
				</div>
			</div>
	</div>
	<script>
	$(document).ready(function(){
		$('#jumlah').formatCurrency({ symbol:'' });
		$('input#jumlah').each(function(){
			$(this).formatCurrency({symbol:''});
			$(this).keyup(function(){
				$(this).formatCurrency({symbol:''});
			});

		});
	});

	</script>