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
						<h2><i class="icon-user"></i> Laporan Data Pembayaran</h2>
						<div class="box-icon">
						
						</div>
					</div>

					<div class="box-content" style="background:#fff">
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
							<a data-rel="tooltip" class="well span3 top-block" href="<?=site_url()?>laporan/perkelas" data-original-title="Data Per Kelas">
								<span class="icon32 icon-color icon-book"></span>
								<div>Data Per Kelas</div>
								
								
							</a>
							<a data-rel="tooltip" class="well span3 top-block" href="<?=site_url()?>laporan/persiswa" data-original-title="Data Per Siswa">
								<span class="icon32 icon-color icon-book-empty"></span>
								<div>Data Per Siswa</div>
								
								
							</a>

							<a data-rel="tooltip" class="well span3 top-block" href="<?=site_url()?>laporan/tagihansms" data-original-title="Tagihan Untuk SMS">
								<span class="icon32 icon-color icon-book"></span>
								<div>Tagihan Untuk SMS</div>								
							</a>
						</div>
					</div>
				</div>
			</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){

	});
</script>