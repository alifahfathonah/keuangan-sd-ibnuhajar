
	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="<?=site_url()?>laporan/jurnal">Jurnal</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Rekapitulasi Penerimaan <?=ucwords($jenis)?></a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Rekapitulasi Penerimaan  <?=ucwords($jenis)?></h2>
						<div class="box-icon">
							
						</div>
					</div>

					<div class="box-content" style="background:#fff">
						<div style="width:100%;text-align:right">
							<button class="btn btn-success" type="button" style="float:right;margin:2px 5px;" id="download"><i class="icon-download-alt icon-white"></i> Download Excel</button>
							<button class="btn btn-primary" type="button" style="float:right;margin:2px 5px;" id="klik">Klik</button>
							<?
							if($jenis=='harian')
							{
								if($this->session->flashdata('tanggal'))
									$tg=$this->session->flashdata('tanggal');
								else
									$tg=date('Y-m-d');
							?>
							<select name="jenis" id="jenis" style="text-align:left !important;margin:3px 5px !important;">
								<option value="all">-:Semua Penerimaan:-</option>
								<?
								$jen=$this->db->query('select * from t_jenis_pembayaran where id_parent!=0 and status="t" order by jenis');
								if($jen->num_rows!=0)
								{
									foreach ($jen->result() as $k => $v) 
									{
										echo '<option value="'.$v->id.'">'.$v->jenis.'</option>';
									}
								}
								?>								
								<option value="tabungan">Tabungan</option>
								<option value="infaq">Infaq</option>
							</select>
								<input class="typeahead datepicker" type="text" id="tgl" name="tgl" style="width:150px;" value="<?=$tg?>" readonly>

							<?
							}
							else
							{
							?>
							<select name="jenis" id="jenis" style="text-align:left !important;margin:0px 3px 3px 5px !important;">
								<option value="all">-:Semua Penerimaan:-</option>
								<?
								$jen=$this->db->query('select * from t_jenis_pembayaran where id_parent!=0 and status="t" order by jenis');
								if($jen->num_rows!=0)
								{
									foreach ($jen->result() as $k => $v) 
									{
										echo '<option value="'.$v->id.'">'.$v->jenis.'</option>';
									}
								}
								?>								
							</select>
								<select name="bulan" id="bulan" data-rel="chosen" data-placeholder="Bulan" style="width:100px !important;text-align:center !important;">
									<option selected></option>
									<?
									for($b=1;$b<=12;$b++)
									{
										if(date('n')==$b)
											echo '<option selected value="'.$b.'">'.getBulan($b).'</option>';
										else	
											echo '<option value="'.$b.'">'.getBulan($b).'</option>';
									}
									?>
								</select>
								<select name="tahun" id="tahun" data-rel="chosen" data-placeholder="Tahun" style="width:100px !important;text-align:center !important;">
									<option selected></option>
									<?
									for($t=(date('Y')-4);$t<=date('Y');$t++)
									{
										if(date('Y')==$t)
											echo '<option selected value="'.$t.'">'.$t.'</option>';
										else
											echo '<option value="'.$t.'">'.$t.'</option>';
									}
									?>
								</select>	

							<?	
							}
							?>
							
						</div>
						<div id="isijurnal" style="float:left;width:100%;margin-top:30px;"></div>
						
					</div>
				</div>
			</div>
	</div>
<script type="text/javascript">
	

	$(document).ready(function(){
		var jenis='<?=$jenis?>';
		if(jenis=='harian')
		{
			var jns=$('#jenis').val();
			var tgll=$('#tgl').val();
			$('#isijurnal').load('<?=site_url()?>laporan/isijurnal/<?=$jenis?>-'+jns+'/'+tgll);
			$('#klik').click(function(){
				var jns=$('#jenis').val();
				var tgl=$('#tgl').val();
				$('#isijurnal').load('<?=site_url()?>laporan/isijurnal/<?=$jenis?>-'+jns+'/'+tgl);
			});

			$('#download').click(function(){
				var tgl=$('#tgl').val();
				var jns=$('#jenis').val();
				location.href='<?=site_url()?>topdf/jurnal/<?=$jenis?>-'+jns+'/'+tgl;
			});
		}
		else
		{
			var tgll=$('#tahun').val()+'-'+$('#bulan').val();
			var jns=$('#jenis').val();
			$('#isijurnal').load('<?=site_url()?>laporan/isijurnal/<?=$jenis?>-'+jns+'/'+tgll);
			$('#klik').click(function(){
				var tgl=$('#tahun').val()+'-'+$('#bulan').val();
				var jns=$('#jenis').val();
				$('#isijurnal').load('<?=site_url()?>laporan/isijurnal/<?=$jenis?>-'+jns+'/'+tgl);
			});

			$('#download').click(function(){
				var tgl=$('#tahun').val()+'-'+$('#bulan').val();
				var jns=$('#jenis').val();
				location.href='<?=site_url()?>topdf/jurnal/<?=$jenis?>-'+jns+'/'+tgl;
			});	
		}

		// $('#Yes').click(function(){

		// 	location
		// });
	});

	function verifikasi(tgl_transaksi,idjenis,idkelasaktif,namasiswa,status)
	{
		var nama=namasiswa.replace(/%20/g,' ');
		// $('#myModalConfirm').modal('show');
		// $('#isiModalConfirm').html('Apakah benar ingin mem-Verifikasi Pembayaran <br>atas Nama : <u>'+nama+'</u>');
		if(status=='sudah')
			var s=confirm('Apakah benar ingin mem-Verifikasi Pembayaran atas Nama : '+nama+'?');
		else
			var s=confirm('Apakah benar ingin membatalkan Verifikasi Pembayaran atas Nama : '+nama+'?');
		
		if(s)
		{
			// alert('OK');
			location.href='<?=site_url()?>laporan/verifikasipembayaran/'+tgl_transaksi+'/'+idjenis+'/'+idkelasaktif+'/'+nama+'/'+status;
		}
	}

	function hapus(tgl_transaksi,idjenis,idkelasaktif,namasiswa)
	{
		var nama=namasiswa.replace(/%20/g,' ');
		var s=confirm('Yakin Menghapus Transaksi Pembayaran ini ?');
		if(s)
		{
			location.href='<?=site_url()?>laporan/hapuspembayaran/'+tgl_transaksi+'/'+idjenis+'/'+idkelasaktif+'/'+nama;
		}
	}
	function edit()
	{
		$.ajax({
			url : '<?=site_url()?>laporan/simpaneditransaksi',
			type : 'POST',
			data : $('form#simpaneditransaksi').serialize(),
			success : function(a)
			{
				var xx=a.trim();
				var dt=xx.split('--');
				// alert(a);
				$('#isijurnal').load('<?=site_url()?>laporan/isijurnal/'+dt[0]+'/'+dt[1]);
				$('#modalEdit').modal('hide');
			}
		});
	}
</script>
		<div class="modal hide fade" id="modalEdit">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Edit Transaksi</h3>
			</div>
			<div class="modal-body" id="isibody" >
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-primary" data-dismiss="modal">Batal</a>
				<a href="javascript:edit()" class="btn btn-primary" >Edit</a>
			</div>

		</div>