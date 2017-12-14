	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Transaksi Pengeluaran</a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Transaksi Pengeluaran</h2>
						<!-- <div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div> -->
					</div>

					<div class="box-content" style="background:#fff">
						<div class="row-fluid">
							<div class="span12">
								<legend>Data Pengeluaran</legend>
								<div class="box-content" style="margin-top:1px !important;padding-top:1px !important;">
									<ul class="nav nav-tabs" id="myTab">
										<li class="active"><a href="#info">Data Pengeluaran</a></li>
										<li><a href="#tambah">Tambah Pengeluaran</a></li>
										<li><a href="#pengajuan">Data Pengajuan</a></li>
										<li><a href="#jenis">Jenis Pengeluaran</a></li>
									</ul>
									 
									<div id="myTabContent" class="tab-content" style="min-height: 450px !important">
										<div class="tab-pane active" id="info">
											<div id="datapengeluaran"></div>
										</div>
										<div class="tab-pane" id="tambah">
											<div id="pengeluaranform"></div>
										</div>
										<div class="tab-pane" id="pengajuan">
											<div class="row-fluid">
												<div class="span8">
													<div id="datapengajuan"></div>
												</div>
												<div class="span4">
													<div id="formpengajuan"></div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="jenis">
											<div class="row-fluid">
												<div class="span7">
													<div id="datajenis"></div>
												</div>
												<div class="span5">
													<div id="formjenis"></div>
												</div>
											</div>
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
		
		$('#datapengeluaran').load('<?=site_url()?>pengeluaran/pengeluarandata');
		$('#datapengajuan').load('<?=site_url()?>pengeluaran/pengajuandata');
		$('#datajenis').load('<?=site_url()?>pengeluaran/jenisdata');
		$('#formjenis').load('<?=site_url()?>pengeluaran/jenisform/-1');
		$('#pengeluaranform').load('<?=site_url()?>pengeluaran/pengeluaranform/-1',function(){
			$('[data-rel="chosen"],[rel="chosen"]').chosen();
			$('#jumlah').keyup(function(){
				$(this).formatCurrency({ symbol:'' });
			});
		});
	});
	function editjenis(id)
	{
		$('#formjenis').load('<?=site_url()?>pengeluaran/jenisform/'+id);
	}
	function addjenis(id)
	{
		$('#formjenis').load('<?=site_url()?>pengeluaran/jenisform/'+id+'/child',function(){
			$('#jenis').focus();
		});
	}
	function hapusjenis(id)
	{
		// bootbox.confirm("<h3>Yakin Ingin Menghapus Data Jenis ini ?? </h3>", function(result) {
		var result=confirm('Yakin Ingin Menghapus Data Jenis ini ??');
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>pengeluaran/jenishapus/'+id,
							success : function(a)
							{
								alert(a);
								// tampilpesan(a);
								$('#datajenis').load('<?=site_url()?>pengeluaran/jenisdata');
								$('#formjenis').load('<?=site_url()?>pengeluaran/jenisform/-1');
							}
						});
					}
				//});
	}
</script>