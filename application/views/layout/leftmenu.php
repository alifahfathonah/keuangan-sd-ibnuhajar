<!-- left menu starts -->
			<div class="span2 main-menu-span" >
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu" >
						<li class="nav-header hidden-tablet" style="cursor:pointer" onclick="location.href='<?=base_url()?>'"><i class="icon-home"></i> Dashboard</li>
						<li class="nav-header hidden-tablet">Siswa</li>
						<li><a class="ajax-link" href="<?=site_url()?>siswa/add"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Pendaftaran Baru</span></a></li>
						<li>
							<a  class="ajax-link" href="<?=site_url()?>siswa/waitinglist"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Data Waiting List</span></a>
						</li>
						<li>
							<a  class="ajax-link" href="<?=site_url()?>siswa"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Data Siswa</span></a>
						</li>

						<li class="nav-header hidden-tablet">Kelas</li>
						<li><a class="ajax-link" href="<?=site_url()?>kelas"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Data Kelas</span></a></li>
						<li><a class="ajax-link" href="<?=site_url()?>kelas/aktif"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Kelas Aktif</span></a></li>
						<li><a class="ajax-link" href="<?=site_url()?>kelas/pembagiankelas"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Pembagian Kelas</span></a></li>
						<li><a class="ajax-link" href="<?=site_url()?>club"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Data Club</span></a></li>
						
						
						<li class="nav-header hidden-tablet">Transaksi</li>
						<li><a class="ajax-link" href="<?=site_url()?>penerimaan"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Penerimaan</span></a></li>
						<li><a class="ajax-link" href="<?=site_url()?>tabungan"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Tabungan Siswa</span></a></li>

						<li><a class="ajax-link" href="<?=site_url()?>penerimaan/piutang"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Piutang Siswa</span></a></li>
						<?
						//echo $this->session->userdata('idlevel');
						if($this->session->userdata('idlevel')==0)
						{
						?>
						<li><a class="ajax-link" href="<?=site_url()?>pengeluaran"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Pengeluaran</span></a></li>
						<?
						}

						if($this->session->userdata('idlevel')==0)
						{
						?>
						<li class="nav-header hidden-tablet">Laporan</li>
						<li><a class="ajax-link" href="<?=site_url()?>laporan/tagihan"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Pembayaran</span></a></li>
						<li><a class="ajax-link" href="<?=site_url()?>laporan/jurnal"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Jurnal</span></a></li>
						<li><a class="ajax-link" href="<?=site_url()?>laporan/bukubesar"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Buku Besar</span></a></li>
						<li><a class="ajax-link" href="<?=site_url()?>laporan/laporankeuangan"><i class="icon-inbox icon-white"></i><span class="hidden-tablet"> Laporan Keuangan</span></a></li>

						<li class="nav-header hidden-tablet">Pengaturan</li>
						<li>
							<a class="ajax-link" href="<?=site_url()?>config/tahunajaran"><i class="icon-wrench icon-white"></i><span class="hidden-tablet"> Tahun Ajaran</span></a>
						</li>
						<li>
							<a class="ajax-link" href="<?=site_url()?>config/driver"><i class="icon-wrench icon-white"></i><span class="hidden-tablet"> Data Driver</span></a>
						</li>
						<li>
							<a class="ajax-link" href="<?=site_url()?>config/kodeakun"><i class="icon-wrench icon-white"></i><span class="hidden-tablet"> Kode Akun</span></a>
						</li>
						<!--<li>
							<a class="ajax-link" href="<?=site_url()?>config/jenispenerimaan"><i class="icon-wrench icon-white"></i><span class="hidden-tablet"> Jenis Penerimaan</span></a>
						</li>-->
						<?
						}
						?>
						
					</ul>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends --> 
