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
							<form id="fform-action" class="form-horizontal" action="<?=site_url()?>kelas/addsiswakelas/<?=$cek->row('idkelas')?>_<?=$cek->row('namakelasaktif')?>/<?=$cek->row('id_ajaran')?>" method="post" enctype="multipart/form-data">
							<div class="span7">
														
									<div class="control-group">
									  <label class="control-label" for="typeahead">Kelas</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<?=$cek->row('namakelas')?> - <?=$cek->row('namakelasaktif')?>
										</label>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Tahun Ajaran</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<?=$cek->row('tahunajaran')?>
										</label>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Wali Kelas</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<?=$cek->row('nama_guru')?>
										</label>
									  </div>
									</div>
									
									<div class="control-group">
									  <label class="control-label" for="typeahead">Jumlah Siswa</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<?=$siswakelas->num_rows()?>
										</label>
									  </div>
									</div>
									
							 <?
							 	$l=array();
								$siswa=$this->sm->getSiswa($l,'null');
								$kaps=$cek->row('jlh_siswa');	  
								
								$sisa=$kaps-$siswakelas->num_rows;
								//echo $sisa;

								// if($sisa<5)
								// 	$sisa_kaps=$sisa;
								// else
									$sisa_kaps=8;

								for($x=1;$x<=$sisa_kaps;$x++)
								{
								?>
									<div class="control-group" style="margin-bottom:3px !important">
									  <label class="control-label" for="typeahead">Tambah Siswa</label>
									  <div class="controls">
										<select id="selectError_<?=$x?>" data-rel="chosen" name="namasiswa[]" data-placeholder="Pilih Nama Siswa">
											<option value=""></option>
											<?
											foreach($siswa->result() as $s)
											{
												echo '<option value="'.$s->nis.'">'.$s->nama.'</option>';
											}
											?>	
										</select>
										
										<div style="width:210px;float:right;">
											
											<label class="radio">
												<span class="radio" id="uniform-optionsRadios1">
													<span class="checked">
														<input type="radio" name="bayar_<?=$x?>[<?=$x?>]" id="optionsRadios1" value="3" style="opacity: 0;">
													</span>
												</span>
												<span style="font-size:9px !important">UTAB</span>
											</label>
											<label class="radio" style="margin-left:10px">
												<span class="radio" id="uniform-optionsRadios2">
													<span class="checked">
														<input type="radio" name="bayar_<?=$x?>[<?=$x?>]" id="optionsRadios2" value="4" style="opacity: 0;" checked="checked">
													</span>
												</span>
												<span style="font-size:9px !important">PPTAB</span>

											  </label>
											  <div style="float:right;">
											  	<button class="btn btn-large btn-round btn-mini" type="button" onclick="formdiskon(<?=$x?>)"><i class="icon icon-color icon-zoomin"></i>&nbsp;Diskon</button>
											  		<input type="hidden" name="diskon_<?=$x?>[<?=$x?>]" id="diskon_<?=$x?>">
											  		<input type="hidden" name="diskonspp_<?=$x?>[<?=$x?>]" id="diskonspp_<?=$x?>">
											  </div>
										</div>
									  </div>
									</div>
								<?
								}
								?>
									
								<div class="form-actions" style="text-align:center">
									  <button type="submit" class="btn btn-primary">Save changes</button>
										<button type="reset" class="btn" onclick="location.href='<?=site_url()?>kelas/aktif'">Back</button>
									</div> 
							</div>
							<div class="span5">
								<fieldset>
									<legend>Daftar Siswa Kelas <?=$cek->row('namakelas')?> - <?=$cek->row('namakelasaktif')?></legend>
									<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
										<thead>
											<tr>
												<th style="text-align:center;width:20px;">No</th>
												<th style="text-align:center;">NIS</th>
												<th style="text-align:center;width:200px;">Nama Siswa</th>
												<th style="text-align:center;">Action</th>
											</tr>
										</thead>
										<tbody>
										<?
											foreach($siswakelas->result() as $no => $s)
											{
												echo '<tr>
													<td style="text-align:center;">'.($no+1).'</td>
													<td style="text-align:center;">'.($s->nis_baru).'</td>
													<td style="text-align:left;">'.($s->nama).'</td>
													<td style="text-align:center;">
														<button class="btn btn-mini btn-danger" type="button" onclick="del(\''.$s->nis.'\')"><i class="icon-white icon-trash"></i></button>
													</td>
												</tr>';
											}
										?>
										</tbody>
									</table>
								</fieldset>
							</div>
							
						</div>
									
							</form>  
						</div>

					</div>
				</div><!--/span-->

			</div> 
<script>
	$(document).ready(function(){
		$('#myModalUP').modal('show');
	});

	function formdiskon(x)
	{
		var html='<form class="form-horizontal">\
						  <fieldset>\
							<div class="control-group">\
							  <label class="control-label" for="date01">Diskon</label>\
							  <div class="controls">\
							  	<select name="jenisdiskon" id="jenisdiskon" style="width:60px !important"><option value="rp">Rp</option><option value="%">%</option></select>\
								<input type="text" class="input-medium datepicker hasDatepicker" name="jlhdiskon" id="jlhdiskon">\
							  </div>\
							</div>\
							<div class="control-group">\
							  <label class="control-label" for="date01">Diskon SPP</label>\
							  <div class="controls">\
							  	<select name="jenisdiskonspp" id="jenisdiskonspp" style="width:60px !important"><option value="rp">Rp</option><option value="%">%</option></select>\
								<input type="text" class="input-medium datepicker hasDatepicker" name="jlhdiskonspp" id="jlhdiskonspp">\
							  </div>\
							</div>\
						</fieldset>\
					</form>';
		$('#headerPesan').text('Form Diskon');
		$('#myModalConfirm').modal('show');
		$('#isiModalConfirm').html(html);
		$('#Yes').click(function(){
			var jlhdiskon=$('#jlhdiskon').val();
			var jenisdiskon=$('#jenisdiskon').val();
			$('#diskon_'+x).val(jenisdiskon+'_'+jlhdiskon);
			var jlhdiskonspp=$('#jlhdiskonspp').val();
			var jenisdiskonspp=$('#jenisdiskonspp').val();
			$('#diskonspp_'+x).val(jenisdiskonspp+'_'+jlhdiskonspp);
			// alert(jlhdiskon+' - '+jenisdiskon);
		});
	}

	function del(nis)
	{
		var idkelas='<?=$cek->row('idkelas')?>';
		var idajaran='<?=$cek->row('id_ajaran')?>';
		$('#headerPesan').text('Pesan');
		$('#myModalConfirm').modal('show');
		$('#isiModalConfirm').html('<h3>Yakin Ingin Menghapus Data Siswa Ini ?</h3>');
		$('#Yes').click(function(){
			$.ajax({
					url : '<?php echo site_url()?>kelas/delsiswakelas/'+nis+'/'+idkelas+'/'+idajaran,
					success : function(a)
					{
						//alert(a);
						location.href="<?php echo site_url()?>kelas/addsiswakelas/<?=$cek->row('idkelas')?>_<?=$cek->row('namakelasaktif')?>/<?=$cek->row('id_ajaran')?>";
						//$('#form-action').submit();
					}
				});
		});

	}
</script>
		<div class="modal hide fade" id="myModalUP">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Pesan</h3>
			</div>
			<div class="modal-body">
				<h3 id="isiModalUP">
				<?
				$utab=$this->db->query('select * from t_jenis_pembayaran where id=3')->result();
				$pptab=$this->db->query('select * from t_jenis_pembayaran where id=4')->result();
				?>
				Total Dana UTAB dan PPTAB yang akan digunakan adalah sebesar :
				<br>
				<pre>
UTAB	:	Rp. <?=rupiah($utab[0]->jumlah2)?>

PPTAB 	:	Rp. <?=rupiah($pptab[0]->jumlah2)?>
</pre>
				</h3>
				<div class="row-fluid">
					<div class="span6">
						<form action="<?=site_url()?>penerimaan/addplafond" method="post">
							<input type="hidden" name="jenispenerimaan" value="3">
							<button type="submit" class="btn btn-xs btn-primary">
								Klik Untuk Rubah Data UTAB
							</button>
						</form>		

					</div>
					<div class="span6">

						<form action="<?=site_url()?>penerimaan/addplafond" method="post">
							<input type="hidden" name="jenispenerimaan" value="4">
							<button type="submit" class="btn btn-xs btn-primary">
								Klik Untuk Rubah Data PPTAB
							</button>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-primary" data-dismiss="modal">OK</a>
			</div>
		</div>