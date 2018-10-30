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
									  <label class="control-label" for="typeahead">NIS</label>
									  <div class="controls">
										<input type="text" name="nis" class="span6 typeahead" id="nis" style="width:100%;" value="<?=$nis?>">
										<i style="font-size:10px">*Kosongkan Jika Belum ada</i>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Nama Siswa*</label>
									  <div class="controls">
										<input type="text" name="nama" class="span6 typeahead" id="nama" style="width:100%;" onblur="cek('nama')" value="<?=$nama?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Tempat Lahir</label>
									  <div class="controls">
										<input type="text" name="tempat" class="span6 typeahead" id="typeahead" style="width:100%;" value="<?=$tempat?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="date01">Tanggal Lahir</label>
									  <div class="controls">
										<input class="span6 typeahead datepicker" type="text" id="tgl" name="tgl" style="width:100%;" value="<?=$tgl?>">
									  </div>
									</div>
									<div class="control-group">
										<label class="control-label">Jenis Kelamin</label>
										<div class="controls">
										  <select name="kelamin" onchange="cek('kelamin')" id="kelamin" class="typeahead">
										  	<option value="" <?=(isset($id) ? '' : 'selected')?>>-Pilih Jenis Kelamin-</option>
										  	<option value="L" <?=($kelamin=='L' ? 'selected' : '')?>>Laki-laki</option>
										  	<option value="P" <?=($kelamin=='P' ? 'selected' : '')?>>Perempuan</option>
										  </select>
										</div>
									  </div>
									<div class="control-group">
									  <label class="control-label" for="fileInput">Foto</label>
									  <div class="controls">
										<div class="uploader" id="uniform-fileInput" onclick="BrowseServer( 'Images:/', 'fileInput' );">
											<input name="foto" class="input-file uniform_on" id="fileInput" type="text" size="19" style="opacity: 0;">
											<span class="filename" id="foto">No file selected</span>
											<span  class="action">Choose File</span></div>
											<br>*<i><small style="font-size:9px;">pilih gambar jika ingin diganti</small></i>
									  </div>
									</div> 
									<div class="control-group">
										<label class="control-label" for="selectError3">Tahun Masuk</label>
										<div class="controls">
										  <select id="selectError3" name="tahunmasuk" style="width:30%">
											<?php
												for($x=(date('Y')-6);$x<=(date('Y')+1);$x++)
												{
													if($masuk!='')
													{
														if($x==$masuk)
														{
																echo '<option value="'.$masuk.'" selected>'.$masuk.'</option>';
															
														}
														else
														{
																echo '<option value="'.$x.'">'.$x.'</option>';
															
														}
														
													}
													else
													{
														if($x==date('Y'))
														{
																echo '<option value="'.$x.'" selected>'.$x.'</option>';
															
														}
														else
														{
																echo '<option value="'.$x.'">'.$x.'</option>';
															
														}
													}
												}
											?>
										  </select>
										</div>
									  </div>
									  <div class="control-group">
										<label class="control-label" for="selectError3">Status</label>
										<div class="controls">
										  <select id="status" name="status" style="width:60%">
											
											<option value="w" <?=($status=='w' ? 'selected' : 'selected')?>>Waiting List</option>
											<option value="t" <?=($status=='t' ? 'selected' : '')?>>Siswa Aktif</option>
											<option value="f" <?=($status=='f' ? 'selected' : '')?>>Siswa Non Aktif</option>
										  </select>
										</div>
									  </div>
									<div class="control-group">
									  <label class="control-label" for="textarea2">Alamat</label>
									  <div class="controls">
										<textarea id="textarea2" rows="3" style=" width: 100%; height: 30px;" name="alamat"><?=$alamat?></textarea></div>
									  </div>
									
									
								 

								 
							</div>
							<div class="span5">
									<div class="control-group">
									  <label class="control-label" for="typeahead">Nama Ayah</label>
									  <div class="controls">
										<input type="text" name="ayah" class="span6 typeahead" id="typeahead" style="width:100%;" value="<?=$nama_ayah?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Nama Ibu</label>
									  <div class="controls">
										<input type="text" name="ibu" class="span6 typeahead" id="typeahead" style="width:100%;"  value="<?=$nama_ibu?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">No. Telp Ayah</label>
									  <div class="controls">
										<input type="text" name="telp_a" class="span6 typeahead" id="typeahead" style="width:100%;"  value="<?=$telp_ayah?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">No. Telp Ibu</label>
									  <div class="controls">
										<input type="text" name="telp_i" class="span6 typeahead" id="typeahead" style="width:100%;"  value="<?=$telp_ibu?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Pekerjaan Ayah</label>
									  <div class="controls">
										<input type="text" name="kerja_a" class="span6 typeahead" id="typeahead" style="width:100%;"  value="<?=$kerja_ayah?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Pekerjaan Ibu</label>
									  <div class="controls">
										<input type="text" name="kerja_i" class="span6 typeahead" id="typeahead" style="width:100%;"  value="<?=$kerja_ibu?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Pendidikan Terkhir Ayah</label>
									  <div class="controls">
										<input type="text" name="pendidikan_a" class="span6 typeahead" id="typeahead" style="width:100%;"  value="<?=$pendidikan_ayah?>">
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Pendidikan Terkhir Ibu</label>
									  <div class="controls">
										<input type="text" name="pendidikan_i" class="span6 typeahead" id="typeahead" style="width:100%;"  value="<?=$pendidikan_ibu?>">
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
										<button type="button" class="btn btn-primary" onclick="location.href='<?=site_url()?>siswa'">Back</button>
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
<script type="text/javascript" src="<?=base_url()?>media/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
// This is a check for the CKEditor class. If not defined, the paths must be checked.
function BrowseServer( startupPath, functionData )
{
	var finder = new CKFinder();
	finder.basePath = '<?=base_url()?>media/ckfinder/';
	finder.startupPath = startupPath;
	finder.selectActionFunction = SetFileField;
	finder.selectActionData = functionData;
	finder.removePlugins = 'basket';
	//finder.selectThumbnailActionFunction = ShowThumbnails;
	finder.popup();
}

function SetFileField( fileUrl, data )
{
	document.getElementById( data["selectActionData"] ).value = fileUrl;
	var f_name=fileUrl.split('/');
	var fn=f_name[(f_name.length)-1];
	$('#foto').text(fn);
	//document.getElementById( 'thumbnails' ).innerHTML ='<img src="' + fileUrl + '" />';
	//alert(fileUrl);
}
</script>
<script>
	$(document).ready(function(){
		$('#submit').click(function(){
			$('#myModalConfirm').modal('show');
			$('#isiModalConfirm').html('<h3>Apakah Data Siswa di atas Sudah Benar ??</h3>');

			$('#Yes').click(function(){
				//alert('Yes');
				$.ajax({
					url : '<?php echo site_url()?>siswa/prosessiswa/<?=(isset($id) ? $id : "null")?>',
					type : 'POST',
					data : $('form#fform-action').serialize(),
					success : function(a)
					{
						//alert(a);
						var status=$('#status').val();
						if(status=='w')
							location.href="<?php echo site_url()?>siswa/waitinglist";
						else	
							location.href="<?php echo site_url()?>siswa";
						//$('#form-action').submit();
					}
				});
			});
		});
	});
</script>