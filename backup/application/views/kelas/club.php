	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Club Ektrakulikuler</a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Club</h2>
						<!-- <div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div> -->
					</div>
					<?
					// echo '<pre>';
					// print_r($datatab['']);
					// echo '</pre>';
					?>
					<div class="box-content" style="background:#fff">
						<div class="row-fluid">
							<div class="span12">
								<legend>Club Ekstrakulikuler</legend>
								<div class="box-content" style="margin-top:1px !important;padding-top:1px !important;">
									<ul class="nav nav-tabs" id="myTab">
										<li class="active"><a href="#info">Data Tagihan Club</a></li>
										<li><a href="#data">Data Club</a></li>
										<!-- <li><a href="#rekap">Rekap Per Tanggal</a></li> -->
									</ul>
									 
									<div id="myTabContent" class="tab-content" style="min-height:400px">
										<div class="tab-pane active" id="info">
											<?=$this->load->view('kelas/club-data')?>
										</div>
										<div class="tab-pane" id="data">
											<div id="form"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript">
	jQuery(function($){
		// $('#isiModal').html('');
		$('#form').load('<?=site_url()?>club/form/-1');
		$('select#jenispenerimaan, select#club, select#bulan, select#tahun').change(function(){
			// $('#isiModal').html('');
			loaddata();
		});
		$('#adddriversiswa').click(function(){
			if($('#club').val()=='')
			{
				$('#myModal').modal('show');
				$('#isiModal').html('Nama Club Belum Dipilih');
			}
			else
			{
				$('#ModalTambahSiswa').modal('show');
				getid();
			}
		});
		$('#simpansiswa').click(function(){
			// $('#form-add-siswa').submit();
			$.ajax({
				url : '<?=site_url()?>club/addclubsiswa',
				type : 'POST',
				data : $('#form-add-siswa').serialize(),
				success : function(a){
					if(a==1)
					{
						var ps='Data Club Berhasil Ditambakan'
					}
					else
					{
						var ps='Data Club Gagal Ditambakan'
					}

					$('#myModal').modal('show');
					$('#isiModal').html(ps);
					// $('#form').load('<?=site_url()?>club/form/-1');
					loaddata();
				}
			});
		});
	});
	function hapusdatasiswa(nis,idclub,bulan,tahun)
	{
		var c=confirm('Yakin ingin Menghapus data ini?');
			if(c)
			{
				$.ajax({
					url : '<?=site_url()?>club/hapusdatasiswa/'+nis+'/'+idclub+'/'+bulan+'/'+tahun,
					success : function(a)
					{
						loaddata();
					}
				});
			}
	}

	function edit(id)
	{
		// $('#isiModal').html('<?=site_url()?>club/form/-1');
		$('#form').load('<?=site_url()?>club/form/'+id);
	}
	function simpan(id)
	{
		var c=confirm('Apakah Data Club sudah Benar?');
			if(c)
			{
				$.ajax({
					url : '<?=site_url()?>club/process/'+id,
					type : 'POST',
					data : $('#fform-action-club').serialize(),
					success : function(a)
					{
						if(a==1)
						{
							var ps='Data Club Berhasil Ditambakan'
						}
						else if(a==2)
						{
							var ps='Data Club Berhasil Di Perbaiki'
						}
						else
						{
							var ps='Data Club Gagal Ditambakan'
						}
						$('#myModal').modal('show');
						$('#isiModal').html(ps);
						$('#form').load('<?=site_url()?>club/form/-1');
					}
				});
			}
	}
	function pilihsemua(idselector)
	{	


	 	if ($('input#'+idselector).attr("data-type") === "uncheck") 
	 	{
			$('input#pilihan').prop("checked", false);
			$('input#'+idselector).attr("data-type", "check");
		} 
		else 
		{
			$('input#pilihan').prop("checked", true);
			$('input#'+idselector).attr("data-type", "uncheck");
		}

	}
</script>