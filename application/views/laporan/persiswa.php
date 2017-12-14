	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#"><?=$title?></a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> <?=$title?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>

					<div class="box-content" style="background:#fff">
						<div style="width:100%;text-align:right;">
							<button class="btn btn-mini btn-primary" onclick="cetakpdf()">
								<i class="icon icon-white icon-pdf"></i>&nbsp;Cetak PDF
							</button>
						</div>
						<script type="text/javascript">
						function cetakpdf()
						{
							var idsiswa=$('#siswa').val();
							var datakelas=$('#datakelas').val();
							if(idsiswa!='' && datakelas !='')
								location.href='<?=site_url()?>topdf/pembayaranPerSiswa/'+idsiswa+'/'+datakelas;
							else
							{
								$('#myModal').modal('show');
								$('#isiModal').html('Data Siswa dan Data Kelas Belum Dipilih');
							}
						}
						</script>
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
							<form class="form-horizontal">
							  
								
								
								<div class="control-group">
								  <label class="control-label" for="date01">Nama Siswa</label>
								  <div class="controls">
									<select name="siswa" id="siswa" data-rel="chosen" data-placeholder="Nama Siswa">
										<option selected></option>
										<?
										$l=array();
										$sis=$this->sm->getSiswa($l,null);
										foreach($sis->result() as $s)
										{
											echo '<option value="'.$s->nis.'">'.$s->nama.'</option>';
										}
										?>
									</select>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="date01">Kelas</label>
								  <div class="controls">
									<select name="kelas" id="datakelas" data-rel="chosen" data-placeholder="Kelas">
										<option selected></option>
										
									</select>
								  </div>
								</div>

								
								<fieldset>
									<legend>Data Pembayaran Siswa</legend>
									<div id="datas"></div>
							  	</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#siswa').change(function(){
			var id=$(this).val();
			//alert(id);
			$.ajax({
				url : '<?=site_url()?>siswa/getSiswaByIdJSON/'+id,
				type : 'POST',
				dataType : 'JSON',
				success:function(a)
				{
					//alert(a.nama);
					var n_ayah=a.nama_ayah;
					var n_ibu=a.nama_ibu;
					$('#datakelas')
				    .find('option')
				    .remove()
				    .end()
				    .append('<option value="" selected=""></option>')
				    .val('');
					$("#datakelas").trigger("liszt:updated");
					//alert(a.nis);
					$('#penyetor').val(n_ayah+' ; '+n_ibu);
					$.ajax({
						url : '<?=site_url()?>kelas/getKelasByNISJSON/'+a.nis+'/all',
						type : 'POST',
						dataType : 'JSON',
						success : function(b)
						{
							//alert(b.length);
							//alert(b);
							var toAppend = '';
							var idkelasaktif;
							var idjenis;
					        $.each(b,function(i,o){
					        	//alert(o.id);
					           	//$('#').val();


					           	toAppend += '<option value="'+o.id+'|'+o.tahunajaran+'">'+o.namakelas+'-'+o.namakelasaktif+'</option>';
					        	//toAppend += o.namakelas;
					        	idkelasaktif=o.id;
					        });

					        //$('#idkelasaktif').val(idkelasaktif);
					        //alert(toAppend);
					        if(b.length!=0)
					        {
						        $('#datakelas').append(toAppend);
						        $("#datakelas").trigger("liszt:updated");
						    }
						    else
						    	$('#datas').html('');
					       

						},
						error : function(c)
						{
							
						}
					});
				}
				
			});
		});

		$('#datakelas').change(function(){
			var idkelas=$(this).val();
			var idsiswa=$('#siswa').val();

			$('#datas').load('<?=site_url()?>laporan/getDataPerSiswa/'+idkelas+'/'+str_replace(' ','%20',idsiswa)+'');
			//alert(idsiswa);
		});
	});
</script>