	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Laporan Data Pembayaran</a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Tagihan Untuk SMS</h2>
						<div class="box-icon">
						
						</div>
					</div>

					<div class="box-content" style="background:#fff">
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
									  <label class="control-label" for="date01">Kelas</label>
									  <div class="controls">
										<select name="kelas" id="datakelas" data-rel="chosen" data-placeholder="Kelas">
											<option selected></option>
											<?
											$k=array();
											$kel=$this->km->getKelasAktif($k,null,'t');
											foreach($kel->result() as $kl)
											{
												echo '<option value="'.$kl->idkelas.'|'.$kl->id_ajaran.'|'.str_replace(' ', '%20', $kl->namakelasaktif).'">'.$kl->namakelas.' : '.$kl->namakelasaktif.'</option>';
											}
											?>

											<?
											$k=array();
											$kel=$this->km->getKelasAktif($k,null,'f');
											foreach($kel->result() as $kl)
											{
												echo '<option value="'.$kl->idkelas.'|'.$kl->id_ajaran.'|'.str_replace(' ', '%20', $kl->namakelasaktif).'">'.$kl->namakelas.' : '.$kl->namakelasaktif.'</option>';
											}
											?>
										</select>
									  </div>
									</div>	
								</div>
								<div class="span4">
									<div class="control-group">
									  <label class="control-label" for="date01">Bulan</label>
									  <div class="controls">
										<select name="bulan" id="bulan" data-rel="chosen" data-placeholder="Bulan">
											<option selected></option>
											<?
											for ($i=1; $i <=12 ; $i++) 
											{ 
												if(date('n')==$i)
													echo '<option selected="selected" value="'.$i.'">'.getBulan($i).'</option>';
												else
													echo '<option value="'.$i.'">'.getBulan($i).'</option>';
											}
											?>
										</select>
									  </div>
									</div>
								</div>
								<div class="span4">
									<div class="control-group">
									  <label class="control-label" for="date01">Tahun</label>
									  <div class="controls">
										<select name="tahun" id="tahun" data-rel="chosen" data-placeholder="Tahun">
											<option selected></option>
											<?
											for ($i=(date('Y')-2); $i <=date('Y') ; $i++) 
											{ 
												if(date('Y')==$i)
													echo '<option selected="selected" value="'.$i.'">'.($i).'</option>';
												else
													echo '<option value="'.$i.'">'.($i).'</option>';
											}
											?>
										</select>
									  </div>
									</div>
								</div>
							</div>
								
							<div id="datasms"></div>
						</div>
					</div>
				</div>
			</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		$('#datasms').load('<?=site_url()?>laporan/datasms');
		$('#datakelas').change(function(){
			var idkelas=$(this).val();
			$('#datasms').load('<?=site_url()?>laporan/datasms/'+idkelas+'/'+bulan+'/'+tahun);
		});
		$('#bulan').change(function(){
			var idkelas=$('#datakelas').val();
			var bulan=$(this).val();
			var tahun=$('#tahun').val();
			$('#datasms').load('<?=site_url()?>laporan/datasms/'+idkelas+'/'+bulan+'/'+tahun);
		});		
		$('#tahun').change(function(){
			var idkelas=$('#datakelas').val();
			var tahun=$(this).val();
			var bulan=$('#bulan').val();
			$('#datasms').load('<?=site_url()?>laporan/datasms/'+idkelas+'/'+bulan+'/'+tahun);
		});
	});
</script>
<style type="text/css">
	#datakelas_chzn
	{
		width:300px !important;
	}
	.chzn-drop, .chzn-result
	{
		width:298px !important;
	}
	.chzn-search input
	{
		width:250px !important;
	}
	.table th, .table td
	{
		font-size: 11px !important
	}
</style>