<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('a.php');
class Topdf extends A {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');

		if($this->session->userdata('sistem')=='SD')
		{
			$this->load->database('default',true);
		}
		else
		{
			$this->db=$this->load->database('second',true);
		}
		//$this->load->model('kelas_aktif',km);
		if($this->session->userdata('logged')!='TRUE')
			redirect('login','location');
	} 
	function penarikantabungan($nis_idtabungan,$jumlah,$tgl)
	{
		$nis_idtabungan=str_replace('%20', ' ', $nis_idtabungan);
		list($nis,$idtabungan)=explode('_', $nis_idtabungan);
		$wh='nis = "'.$nis.'" or nis_baru="'.$nis.'"';
		$siswa=$this->db->from('t_siswa')->where($wh)->get()->result();

		$kelas=$this->db->from('t_tabungan')->where('id',$idtabungan)->get()->result();
		$d1=explode('__', $kelas[0]->kelas);
		$d2=explode('_', $d1[1]);
		$kls=$d2[1];

		echo '<div style="width:800px;height:400px;float:left;">
				<div style="width:30%;float:left;height:80px;">
					<img src="'.base_url().'media/img/logo-2.png" style="height:80px;">
				</div>
				<div style="width:70%;text-align:right;float:right;font-weight:bold;font-family:verdana;line-height:20px;font-size:13px;">
					Jalan Katulampa RT. 03 RW. 01, Desa Parung Banteng 
					<br>
					Katulampa, Bogor Timur, Kota Bogor
					<br>
					Telp : 0251 - 8374544, HP : 085 100 282 111

				</div>
				<div style="width:100%;float:left;padding:5px;letter-spacing:-2px;font-family:verdana;font-weight:bold;background:#369bd7;margin:10px 0;text-align:center;color:white;font-size:30px;">BUKTI PENARIKAN TABUNGAN</div>
			
			';
		if($_POST['jenistarik']==1)
			$jenis='Tabungan Harian';
		elseif($_POST['jenistarik']==2)
			$jenis='Tabungan Tak Lain';
		elseif($_POST['jenistarik']==3)
			$jenis='Infaq';


		echo '<div style="width:49%;;float:left;font-weight:bold;font-size:14px;">
				
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Nama Siswa</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;">'.$siswa[0]->nama.'</div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Kelas</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;">'.$kls.'</div>	
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Jumlah Penarikan</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;">'.number_format($jumlah).'</div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Jenis Penarikan</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;">'.$jenis.'</div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Terbilang</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;"></div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;font-style:italic">'.ucwords(terbilang($jumlah)).' Rupiah</div>				
				</div>
			</div>	';
		echo '<div style="width:100%;float:left;margin:5px;padding:5px;font-size:14px;">
				<div style="width:45%;float:left;border:1px solid #888;border:2px solid #111;padding:10px;">
					Keterangan : 
					<br>
					'.(isset($_POST['keterangan']) ? $_POST['keterangan'] : '').'
				</div>

				<div style="width:45%;float:right;padding:10px;text-align:center;font-weight:bold">
					<div>Bogor, '.tgl_indo($tgl).'</div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penarik,

						<br>
						<br>
						<br>
						<br>
						'.(isset($_POST['penarik']) ? $_POST['penarik'] : '').'
					</div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Petugas,
						<br>
						<br>
						<br>
						<br>
						'.(isset($_POST['petugas']) ? $_POST['petugas'] : (!empty($_POST['petugas']) ? $_POST['petugas'] : $this->session->userdata('nama') )).'
					</div>
				</div>
			</div>';
		echo '</div>';

	}
	function kwitansi()
	{
?>
		<div style="width:800px;height:400px;float:left;">
			<div style="width:30%;float:left;height:80px;">
				<img src="<?=base_url()?>media/img/logo-2.png" style="height:80px;">
			</div>
			<div style="width:70%;text-align:right;float:right;font-weight:bold;font-family:verdana;line-height:20px;font-size:13px;">
				Jalan Katulampa RT. 03 RW. 01, Desa Parung Banteng 
				<br>
				Katulampa, Bogor Timur, Kota Bogor
				<br>
				Telp : 0251 - 8374544, HP : 085 100 282 111

			</div>
			<? $post=$_POST; 
				//print_r($post);
				//Array ( [idsiswa] => 02 1213 008 [idkelas] => 3 [penyetor] => Ahmad Mudzakir Roji, ST ; Vitta Avianti, SEjenis_UTAB=0 [jenis_PPTAB] => 22,222 [jenis_Seragam] => 0 [jenis_SPP] => 0 [jenis_Catering] => 0 [jenis_Jemputan] => 0 
				//$siswa=$this->sm->getSiswaById($_POST['idsiswa'])->result();
				$sis=$this->db->query('select * from v_kelas_aktif where idkelas="'.$_POST['idkelas'].'" and nis="'.$_POST['idsiswa'].'" and st_aktif="t" and status_siswa_aktif="t" order by tahunajaran desc limit 1')->result();
			?>
			<div style="width:100%;float:left;padding:5px;letter-spacing:-2px;font-family:verdana;font-weight:bold;background:#369bd7;margin:10px 0;text-align:center;color:white;font-size:30px;">BUKTI SETORAN UANG SEKOLAH</div>

			<div style="width:49%;;float:left;font-weight:bold;font-size:14px;">
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Tanggal</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;" id="tgl"><?=tgl_indo($_POST['tgl_transaksi'])?></div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Nama Siswa</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=$sis[0]->nama?></div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Kelas</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=($sis[0]->namakelas)?></div>	
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Nama Orang Tua/Wali</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=$_POST['penyetor']?></div>				
				</div>
			</div>			

			<div style="width:49%;;float:left;font-size:14px;">
			
				<div style="width:59%;float:left;margin:3px 3px 3px 5px;font-weight:bold;">Untuk Pembayaran :</div>	
				<div style="width:5px;float:left;margin:3px 3px 3px 5px;font-weight:bold;"></div>	
				<div style="width:35%;float:right;margin:3px 3px 3px 5px;">&nbsp;</div>				
			<?
			// echo '<pre>';
			// print_r($post);
			// echo '</pre>';
			$keterangantr='';
			foreach ($post as $k => $vs) 
			{	
				$ff=explode('_', $k);
				//echo $ff[0];
				if($ff[0]=='jenis')
				{
					if($ff[1]=='UTAB')
						$v=$ff[1].'';
					else if($ff[1]=='PPTAB')
						$v=$ff[1].'';
					else
						$v=$ff[1];

					if($vs!=0)
						$kkt=$_POST['ket_'.$ff[1]];
					else
						$kkt='';

					if($vs!=0)
					{
						$vss=$vs;
						$keterangantr=$v.' '.$kkt;
						$valuenya=$vs;
						$catrap=$v.' '.strtok($kkt, ' ');
						if($_POST['catatanrapel']!='')
						{
							$cp=explode(';', $_POST['catatanrapel']);
							if($v=='SPP')
								$valcp=(float)str_replace(',', '', $valuenya) / (count($cp));
							else
								$valcp=(float)str_replace(',', '', $valuenya);

							$vsss=number_format($valcp);
							foreach ($cp as $kc => $vc) 
							{
								if($vc!='')
								{
									list($idrap,$blrap,$thrap)=explode('_', $vc);
									
									if($v=='SPP')
									{
										$catrap.='<br>SPP '.getBulan($blrap).' '.$thrap;
										$vsss.='<br>'.number_format($valcp);
									}
									
								}
							}
							$keterangantr=$catrap;
							$vss=$vsss;
						}
						// else
						// {

						// }
						if(strtolower($v) != 'club')
						{

			?>
							<div style="width:100%;float:left">
								<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp;</div>	
								<div style="width:60%;float:left;margin:3px 0 3px ;"><?=($keterangantr)?> </div>	
								<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;font-weight:bold;">:</div>				
								<div style="width:25%;float:right;text-align:right;margin:3px 0 3px ;font-weight:bold;"><?=$vss?></div>				
							</div>
			<?
						}
					}
				}
				else if($ff[0]=='jenisclub')
				{
					// $dtc=explode('_', $k);
					$idclub=$ff[1];

					if($vs!=0)
						$kkt=$_POST['ketclub_'.$idclub];
					else
						$kkt='';

					$club=$this->db->from('t_club')->where('id_club',$idclub)->get()->result();
					echo '<div style="width:100%;float:left">
						<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp;</div>	
						<div style="width:60%;float:left;margin:3px 0 3px ;">Club : '.$club[0]->nama_club.' '.$kkt.'</div>	
						<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;font-weight:bold;">:</div>				
						<div style="width:25%;float:right;text-align:right;margin:3px 0 3px ;font-weight:bold;">'.($vs).'</div>				
					</div>';
				} 
			}
			?>
			<!--<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">SPP Bulan</div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 0 3px ;">&nbsp</div>				

				<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">PPTAB Murid Lama </div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 0 3px ;">&nbsp</div>				

				<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">Seragam </div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 3px 3px x;">&nbsp</div>				
				-->
				<div style="width:5%;float:left;margin:10px 0 5px;">&nbsp</div>	
				<div style="width:45%;float:left;text-align:center;margin:10px 0 5px;font-weight:bold;">Jumlah </div>	
				<div style="width:2px;float:left;text-align:left;margin:10px 0 5px;font-weight:bold;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:10px 0 5px;border-top:1px solid #ccc;font-weight:bold;"><?=$_POST['total']?></div>				
	
			</div>

			<div style="width:100%;float:left;margin:5px;padding:5px;font-size:14px;">
				<div style="width:45%;float:left;border:1px solid #888;border:2px solid #111;padding:10px;">
					Catatan : 
					<br>
					<?=$_POST['catatan']?>
				</div>

				<div style="width:45%;float:right;padding:10px;text-align:center;font-weight:bold">
					<div>Bogor, <?=tgl_indo($_POST['tgl_transaksi'])?></div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penyetor,

						<br>
						<br>
						<br>
						<br>
						<?=$_POST['penyetor']?>
					</div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penerima,
						<br>
						<br>
						<br>
						<br>
						<?=$_POST['penerima']?>
					</div>
				</div>
			</div>
			<div style="width:100%;float:left;margin:5px;border:2px solid #111;background:#ccc;padding:5px;font-size:14px;">
				Terbilang : <br>
				<?
				$total=str_replace(',', '', $_POST['total']);
				echo ucwords(Terbilang($total)).' Rupiah';
				?>
			</div>
			<div style="text-align:right;width:900px;float:left;padding-bottom:20px;"><i>Halaman 1 : Untuk Orang Tua/Wali</i></div>
			<div style="width:900px;float:left;"><i></i></div>
		</div>
		<!-- ---------------------------------------------------------------------- -->
		<div style="width:800px;height:400px;float:left;margin-top:950px;">
			<div style="width:30%;float:left;height:80px;">
				<img src="<?=base_url()?>media/img/logo-2.png" style="height:80px;">
			</div>
			<div style="width:70%;text-align:right;float:right;font-weight:bold;font-family:verdana;line-height:20px;font-size:13px;">
				Jalan Katulampa RT. 03 RW. 01, Desa Parung Banteng 
				<br>
				Katulampa, Bogor Timur, Kota Bogor
				<br>
				Telp : 0251 - 8374544, HP : 085 100 282 111

			</div>
			<? $post=$_POST; 
				//print_r($post);
				//Array ( [idsiswa] => 02 1213 008 [idkelas] => 3 [penyetor] => Ahmad Mudzakir Roji, ST ; Vitta Avianti, SEjenis_UTAB=0 [jenis_PPTAB] => 22,222 [jenis_Seragam] => 0 [jenis_SPP] => 0 [jenis_Catering] => 0 [jenis_Jemputan] => 0 
				//$siswa=$this->sm->getSiswaById($_POST['idsiswa'])->result();
				$sis=$this->db->query('select * from v_kelas_aktif where idkelas="'.$_POST['idkelas'].'" and nis="'.$_POST['idsiswa'].'" and st_aktif="t" and status_siswa_aktif="t" order by tahunajaran desc limit 1')->result();
			?>
			<div style="width:100%;float:left;padding:5px;letter-spacing:-2px;font-family:verdana;font-weight:bold;background:#369bd7;margin:10px 0;text-align:center;color:white;font-size:30px;">BUKTI SETORAN UANG SEKOLAH</div>

			<div style="width:49%;;float:left;font-weight:bold;font-size:14px;">
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Tanggal</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;" id="tgl"><?=tgl_indo($_POST['tgl_transaksi'])?></div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Nama Siswa</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=$sis[0]->nama?></div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Kelas</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=($sis[0]->namakelas)?></div>	
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Nama Orang Tua/Wali</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=$_POST['penyetor']?></div>				
				</div>
			</div>			

			<div style="width:49%;;float:left;font-size:14px;">
			
				<div style="width:59%;float:left;margin:3px 3px 3px 5px;font-weight:bold;">Untuk Pembayaran :</div>	
				<div style="width:5px;float:left;margin:3px 3px 3px 5px;font-weight:bold;"></div>	
				<div style="width:35%;float:right;margin:3px 3px 3px 5px;">&nbsp;</div>				
			<?
			// echo '<pre>';
			// print_r($post);
			// echo '</pre>';
			$keterangantr='';
			foreach ($post as $k => $vs) 
			{	
				$ff=explode('_', $k);
				//echo $ff[0];
				if($ff[0]=='jenis')
				{
					if($ff[1]=='UTAB')
						$v=$ff[1].'';
					else if($ff[1]=='PPTAB')
						$v=$ff[1].'';
					else
						$v=$ff[1];

					if($vs!=0)
						$kkt=$_POST['ket_'.$ff[1]];
					else
						$kkt='';

					if($vs!=0)
					{
						$vss=$vs;
						$keterangantr=$v.' '.$kkt;
						$valuenya=$vs;
						$catrap=$v.' '.strtok($kkt, ' ');
						if($_POST['catatanrapel']!='')
						{
							$cp=explode(';', $_POST['catatanrapel']);
							if($v=='SPP')
								$valcp=(float)str_replace(',', '', $valuenya) / (count($cp));
							else
								$valcp=(float)str_replace(',', '', $valuenya);

							$vsss=number_format($valcp);
							foreach ($cp as $kc => $vc) 
							{
								if($vc!='')
								{
									list($idrap,$blrap,$thrap)=explode('_', $vc);
									
									if($v=='SPP')
									{
										$catrap.='<br>SPP '.getBulan($blrap).' '.$thrap;
										$vsss.='<br>'.number_format($valcp);
									}
									
								}
							}
							$keterangantr=$catrap;
							$vss=$vsss;
						}
						// else
						// {

						// }
						if(strtolower($v) != 'club')
						{

			?>
							<div style="width:100%;float:left">
								<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp;</div>	
								<div style="width:60%;float:left;margin:3px 0 3px ;"><?=($keterangantr)?> </div>	
								<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;font-weight:bold;">:</div>				
								<div style="width:25%;float:right;text-align:right;margin:3px 0 3px ;font-weight:bold;"><?=$vss?></div>				
							</div>
			<?
						}
					}
				}
				else if($ff[0]=='jenisclub')
				{
					// $dtc=explode('_', $k);
					$idclub=$ff[1];

					if($vs!=0)
						$kkt=$_POST['ketclub_'.$idclub];
					else
						$kkt='';

					$club=$this->db->from('t_club')->where('id_club',$idclub)->get()->result();
					echo '<div style="width:100%;float:left">
						<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp;</div>	
						<div style="width:60%;float:left;margin:3px 0 3px ;">Club : '.$club[0]->nama_club.' '.$kkt.'</div>	
						<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;font-weight:bold;">:</div>				
						<div style="width:25%;float:right;text-align:right;margin:3px 0 3px ;font-weight:bold;">'.($vs).'</div>				
					</div>';
				} 
			}
			?>
			<!--<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">SPP Bulan</div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 0 3px ;">&nbsp</div>				

				<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">PPTAB Murid Lama </div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 0 3px ;">&nbsp</div>				

				<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">Seragam </div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 3px 3px x;">&nbsp</div>				
				-->
				<div style="width:5%;float:left;margin:10px 0 5px;">&nbsp</div>	
				<div style="width:45%;float:left;text-align:center;margin:10px 0 5px;font-weight:bold;">Jumlah </div>	
				<div style="width:2px;float:left;text-align:left;margin:10px 0 5px;font-weight:bold;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:10px 0 5px;border-top:1px solid #ccc;font-weight:bold;"><?=$_POST['total']?></div>				
	
			</div>

			<div style="width:100%;float:left;margin:5px;padding:5px;font-size:14px;">
				<div style="width:45%;float:left;border:1px solid #888;border:2px solid #111;padding:10px;">
					Catatan : 
					<br>
					<?=$_POST['catatan']?>
				</div>

				<div style="width:45%;float:right;padding:10px;text-align:center;font-weight:bold">
					<div>Bogor, <?=tgl_indo($_POST['tgl_transaksi'])?></div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penyetor,

						<br>
						<br>
						<br>
						<br>
						<?=$_POST['penyetor']?>
					</div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penerima,
						<br>
						<br>
						<br>
						<br>
						<?=$_POST['penerima']?>
					</div>
				</div>
			</div>
			<div style="width:100%;float:left;margin:5px;border:2px solid #111;background:#ccc;padding:5px;font-size:14px;">
				Terbilang : <br>
				<?
				$total=str_replace(',', '', $_POST['total']);
				echo ucwords(Terbilang($total)).' Rupiah';
				?>
			</div>
			<div style="text-align:right;float:left;width:900px;padding-bottom:20px;"><i>Halaman 2 : Arsip</i></div>
			<div style="width:900px;padding:0px;float:left;"><i></i></div>
		</div>

		<!-------------------------------------------------------------------------->
		<div style="width:800px;height:400px;float:left;margin-top:950px;">
			<div style="width:30%;float:left;height:80px;">
				<img src="<?=base_url()?>media/img/logo-2.png" style="height:80px;">
			</div>
			<div style="width:70%;text-align:right;float:right;font-weight:bold;font-family:verdana;line-height:20px;font-size:13px;">
				Jalan Katulampa RT. 03 RW. 01, Desa Parung Banteng 
				<br>
				Katulampa, Bogor Timur, Kota Bogor
				<br>
				Telp : 0251 - 8374544, HP : 085 100 282 111

			</div>
			<? $post=$_POST; 
				//print_r($post);
				//Array ( [idsiswa] => 02 1213 008 [idkelas] => 3 [penyetor] => Ahmad Mudzakir Roji, ST ; Vitta Avianti, SEjenis_UTAB=0 [jenis_PPTAB] => 22,222 [jenis_Seragam] => 0 [jenis_SPP] => 0 [jenis_Catering] => 0 [jenis_Jemputan] => 0 
				//$siswa=$this->sm->getSiswaById($_POST['idsiswa'])->result();
				$sis=$this->db->query('select * from v_kelas_aktif where idkelas="'.$_POST['idkelas'].'" and nis="'.$_POST['idsiswa'].'" and st_aktif="t" and status_siswa_aktif="t" order by tahunajaran desc limit 1')->result();
			?>
			<div style="width:100%;float:left;padding:5px;letter-spacing:-2px;font-family:verdana;font-weight:bold;background:#369bd7;margin:10px 0;text-align:center;color:white;font-size:30px;">BUKTI SETORAN UANG SEKOLAH</div>

			<div style="width:49%;;float:left;font-weight:bold;font-size:14px;">
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Tanggal</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;" id="tgl"><?=tgl_indo($_POST['tgl_transaksi'])?></div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Nama Siswa</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=$sis[0]->nama?></div>				
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Kelas</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=($sis[0]->namakelas)?></div>	
				</div>
				<div style="width:100%;float:left;">
					<div style="width:39%;float:left;margin:3px 3px 3px 5px;">Nama Orang Tua/Wali</div>	
					<div style="width:5px;float:left;margin:3px 3px 3px 5px;">:</div>	
					<div style="width:50%;float:right;margin:3px 3px 3px 5px;"><?=$_POST['penyetor']?></div>				
				</div>
			</div>			

			<div style="width:49%;;float:left;font-size:14px;">
			
				<div style="width:59%;float:left;margin:3px 3px 3px 5px;font-weight:bold;">Untuk Pembayaran :</div>	
				<div style="width:5px;float:left;margin:3px 3px 3px 5px;font-weight:bold;"></div>	
				<div style="width:35%;float:right;margin:3px 3px 3px 5px;">&nbsp;</div>				
			<?
			// echo '<pre>';
			// print_r($post);
			// echo '</pre>';
			$keterangantr='';
			foreach ($post as $k => $vs) 
			{	
				$ff=explode('_', $k);
				//echo $ff[0];
				if($ff[0]=='jenis')
				{
					if($ff[1]=='UTAB')
						$v=$ff[1].'';
					else if($ff[1]=='PPTAB')
						$v=$ff[1].'';
					else
						$v=$ff[1];

					if($vs!=0)
						$kkt=$_POST['ket_'.$ff[1]];
					else
						$kkt='';

					if($vs!=0)
					{
						$vss=$vs;
						$keterangantr=$v.' '.$kkt;
						$valuenya=$vs;
						$catrap=$v.' '.strtok($kkt, ' ');
						if($_POST['catatanrapel']!='')
						{
							$cp=explode(';', $_POST['catatanrapel']);
							if($v=='SPP')
								$valcp=(float)str_replace(',', '', $valuenya) / (count($cp));
							else
								$valcp=(float)str_replace(',', '', $valuenya);

							$vsss=number_format($valcp);
							foreach ($cp as $kc => $vc) 
							{
								if($vc!='')
								{
									list($idrap,$blrap,$thrap)=explode('_', $vc);
									
									if($v=='SPP')
									{
										$catrap.='<br>SPP '.getBulan($blrap).' '.$thrap;
										$vsss.='<br>'.number_format($valcp);
									}
									
								}
							}
							$keterangantr=$catrap;
							$vss=$vsss;
						}
						// else
						// {

						// }
						if(strtolower($v) != 'club')
						{

			?>
							<div style="width:100%;float:left">
								<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp;</div>	
								<div style="width:60%;float:left;margin:3px 0 3px ;"><?=($keterangantr)?> </div>	
								<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;font-weight:bold;">:</div>				
								<div style="width:25%;float:right;text-align:right;margin:3px 0 3px ;font-weight:bold;"><?=$vss?></div>				
							</div>
			<?
						}
					}
				}
				else if($ff[0]=='jenisclub')
				{
					// $dtc=explode('_', $k);
					$idclub=$ff[1];

					if($vs!=0)
						$kkt=$_POST['ketclub_'.$idclub];
					else
						$kkt='';

					$club=$this->db->from('t_club')->where('id_club',$idclub)->get()->result();
					echo '<div style="width:100%;float:left">
						<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp;</div>	
						<div style="width:60%;float:left;margin:3px 0 3px ;">Club : '.$club[0]->nama_club.' '.$kkt.'</div>	
						<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;font-weight:bold;">:</div>				
						<div style="width:25%;float:right;text-align:right;margin:3px 0 3px ;font-weight:bold;">'.($vs).'</div>				
					</div>';
				} 
			}
			?>
			<!--<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">SPP Bulan</div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 0 3px ;">&nbsp</div>				

				<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">PPTAB Murid Lama </div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 0 3px ;">&nbsp</div>				

				<div style="width:5%;float:left;margin:3px 0 3px ;">&nbsp</div>	
				<div style="width:45%;float:left;margin:3px 0 3px ;">Seragam </div>	
				<div style="width:2px;float:left;text-align:left;margin:3px 0 3px ;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:3px 3px 3px x;">&nbsp</div>				
				-->
				<div style="width:5%;float:left;margin:10px 0 5px;">&nbsp</div>	
				<div style="width:45%;float:left;text-align:center;margin:10px 0 5px;font-weight:bold;">Jumlah </div>	
				<div style="width:2px;float:left;text-align:left;margin:10px 0 5px;font-weight:bold;">:</div>				
				<div style="width:48%;float:right;text-align:right;margin:10px 0 5px;border-top:1px solid #ccc;font-weight:bold;"><?=$_POST['total']?></div>				
	
			</div>

			<div style="width:100%;float:left;margin:5px;padding:5px;font-size:14px;">
				<div style="width:45%;float:left;border:1px solid #888;border:2px solid #111;padding:10px;">
					Catatan : 
					<br>
					<?=$_POST['catatan']?>
				</div>

				<div style="width:45%;float:right;padding:10px;text-align:center;font-weight:bold">
					<div>Bogor, <?=tgl_indo($_POST['tgl_transaksi'])?></div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penyetor,

						<br>
						<br>
						<br>
						<br>
						<?=$_POST['penyetor']?>
					</div>
					<div style="width:50%;float:left;text-align:center;margin-top:5px;">
						Penerima,
						<br>
						<br>
						<br>
						<br>
						<?=$_POST['penerima']?>
					</div>
				</div>
			</div>
			<div style="width:100%;float:left;margin:5px;border:2px solid #111;background:#ccc;padding:5px;font-size:14px;">
				Terbilang : <br>
				<?
				$total=str_replace(',', '', $_POST['total']);
				echo ucwords(Terbilang($total)).' Rupiah';
				?>
			</div>
			<div style="text-align:right;float:left;width:900px;padding-bottom:20px;"><i>Halaman 3 : Arsip</i></div>
			<div style="width:900px;padding:0px;float:left;"><i></i></div>
		</div>
<?php
	}

	function pembayaranPerSiswa($idsiswa,$idkelas)
	{
		$nis=str_replace('%20', ' ', $idsiswa);
		$idkelas=str_replace('%7C', '|', $idkelas);
		//echo $idsiswa.'-'.$idkelas;
		list($idkelasaktif,$ajaran)=explode('|', $idkelas);
		$siswa=$this->sm->getSiswaById($nis)->result();
		$kelas=$this->km->getKelasAktifByNIS($nis,'all')->result();

		ob_start();
		$pdf = new TCPDF('P', PDF_UNIT, 'F4', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Data Pembarayan Siswa');
		$pdf->SetTitle('Data Pembarayan Siswa : '.$siswa[0]->nama.'');
		$pdf->SetSubject('Data Pembarayan Siswa : '.$siswa[0]->nama.'');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData('', '', 'Data Pembarayan Siswa Tahun Ajaran '.$ajaran.'', '', '');

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(5, 20, 5);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(5);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('times', 'B', 10);

		// add a page
		$pdf->AddPage();
		$tbl='<table border="0" cellpadding="4">
			<tr>
				<th style="width:15%;">Nama</th>
				<th style="width:20px;">:</th>
				<th style="width:70%;">'.$siswa[0]->nama.'</th>
			</tr>
			<tr>
				<th style="width:15%;">Kelas</th>
				<th style="width:20px;">:</th>
				<th style="width:70%;">'.$kelas[0]->namakelas.'-'.$kelas[0]->namakelasaktif.'</th>
			</tr>
			<tr>
				<th style="width:15%;">Nama Orang Tua</th>
				<th style="width:20px;">:</th>
				<th style="width:70%;">'.$siswa[0]->nama_ayah.', '.$siswa[0]->nama_ibu.'</th>
			</tr>			
			<tr>
				<th style="width:15%;">Alamat</th>
				<th style="width:20px;">:</th>
				<th style="width:70%;">'.$siswa[0]->alamat.'</th>
			</tr>
		</table>';


		$pdf->writeHTML($tbl, true, false, false, false, '');

		$pdf->SetFont('times', '', 10);
		$tbl2='<table style="width:100%;margin:10px 0 5px;" border="1" cellpadding="4">
					<tr>
						<th style="font-weight:bold;text-align:center;width:30px">No</th>
						<th style="font-weight:bold;text-align:center;width:30%">Keterangan</th>
						<th style="font-weight:bold;text-align:center;width:150px;">Jumlah Yang Harus Dibayar</th>
						<th style="font-weight:bold;text-align:center;width:170px;">Pembayaran</th>
						<th style="font-weight:bold;text-align:center;width:150px;">Sisa Pembayaran</th>
					</tr>';

		$jen=$this->pm->getJenisPembayaranByParent(1);
			foreach($jen->result() as $no=> $j)
			{
				if($j->id==3 || $j->id==4)
				{
					$nn=$this->pm->getrecordpembayaranby_idkelasaktif_nis_idjenis($j->id,$nis,$idkelasaktif);
					$vp=$this->pm->getpembayaranby_idkelasaktif_nis_idjenis($j->id,$nis,$idkelasaktif);
					$c=$vp->result();
					//echo '<pre>';
					//print_r($c);
					$bayar='';
					$jj=0;
					for ($i=0; $i < count($c) ; $i++) 
					{ 
						$bayar.=tgl_indo2($c[$i]->tgl_transaksi);
						$bayar.=' : '.rupiah($c[$i]->jumlah).'<br>';
						$jj+=$c[$i]->jumlah;
					}

					if($jj!=0)
					{
						$bayar.='<b>Jumlah : '.rupiah($jj).'</b>';
					}
					$tbl2.='<tr>
						<td style="text-align:center;">'.($no+1).'</td>
						<td style="text-align:left;">'.($j->jenis).'</td>
						<td style="text-align:right;">'.(rupiah($nn->num_rows!=0 ? $nn->row('wajib_bayar') : 0)).'</td>
						<td style="text-align:right;">'.$bayar.'</td>
						<td style="text-align:right;">'.(rupiah($nn->num_rows!=0 ? $nn->row('sisa') : 0)).'</td>
					</tr>';	
				}
				
			}

		$tbl2.='</table>';


		$pdf->writeHTML($tbl2, true, false, false, false, '');

		$tbl3='<table border="1" style="width:100%" cellpadding="4">

					<tr>
						<th style="text-align:center;width:117px;font-weight:bold;">Bulan</th>';
		
		foreach($jen->result() as $no=> $j)
		{
			if($j->id!=3 && $j->id!=4)
			{
				$tbl3.= '<th style="text-align:center;width:21%;font-weight:bold;">'.$j->jenis.'</th>';
			}
		}
		$tbl3.='</tr>';
		$aj=explode('-', $ajaran);
		for($b=7;$b<=18;$b++)
		{
			if($b>12)
			{
				$c=$b-12;
				$y=$aj[1];
			}
			else
			{	
				$c=$b;
				$y=$aj[0];
			}
			$tbl3.='<tr>
				<td>'.getBulan($c).' '.$y.'</td>';

				foreach($jen->result() as $no=> $jj)
				{
					if($jj->id!=3 && $jj->id!=4)
					{
						$nn=$this->pm->cekPenerimaanRutin($c,$jj->id,$nis,$idkelasaktif,$y);
						$by=$this->pm->getpembayaranby_idkelasaktif_nis_idjenis_bulan_tahun($jj->id,$nis,$idkelasaktif,$c,$y);
						$byr=$by->result();

						$tgl_byr='';
						$jlh_byr=0;
						for ($j=0; $j < count($byr); $j++) 
						{ 
							$tgl_byr.=tgl_indo2($byr[$j]->tgl_transaksi).' : ';
							$tgl_byr.='<b>'.rupiah($byr[$j]->jumlah).'</b><br>';
							$jlh_byr+=$byr[$j]->jumlah;
						}

						if($jlh_byr!=0)
						{
							$tgl_byr.='Jumlah : '.rupiah($jlh_byr);
						}
						else
						{
							if($nn->num_rows!=0)
							{
								$tgl_byr.='<span style="color:red">Kewajiban : '.rupiah($nn->row('wajib_bayar')).'</span>';
							}

							$njen=strtolower($jj->jenis);
							${"$njen"}[]=($nn->num_rows!=0 ? $nn->row('wajib_bayar') : 0);
						}
						$tbl3.='<td style="text-align:right;">';
						//print_r($byr);
						$tbl3.=$tgl_byr;
						$tbl3.='</td>';
					}
				}

			$tbl3.= '</tr>';
		}	
		$tbl3.='<tr>';
		$tbl3.= '<th style="text-align:right;width:117px;font-weight:bold;">Jumlah Kewajiban</th>';
		foreach($jen->result() as $no=> $j)
		{
			if($j->id!=3 && $j->id!=4)
			{
				$njen=strtolower($j->jenis);
				$tbl3.= '<th style="text-align:right;width:21%;font-weight:bold;">'.rupiah(array_sum(${"$njen"})).'</th>';
			}
		}
		$tbl3.='</tr>';
		$tbl3.='</table>';

		$pdf->writeHTML($tbl3, true, false, false, false, '');

		$pdf->Output('Data Pembayaran Siswa '.$siswa[0]->nama.'', 'I');
	}

	function pembayaranPerKelas($idjenis,$idkelasaktif)
	{
		$idkelasaktif=str_replace('%7C', '|', $idkelasaktif);
		$idk=explode('|', $idkelasaktif);
		$namakelasaktif=str_replace('%20', ' ', $idk[2]);
		// $data=$this->km->getKelasAktifByNameNAjaran($idk[0],$idk[2],$idk[1])->result();
		$siswa=$this->km->getSiswaByNamaKelas($idk[0],$namakelasaktif,$idk[1],'t')->result();
		$jenis=$this->pm->getJenisPembayaranByID($idjenis)->result();
		$ajaran=$this->km->getTahunAjaranById($idk[1])->result();
		$tahun=explode('-', $ajaran[0]->tahunajaran);

		//echo $idjenis.'-'.$idkelasaktif;
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// for($i=0;$i<count($data);$i++)
		// {
		// 	$datasiswa[$data[$i]->nis]=$data[$i];
		// }


		ob_start();
		$pdf = new TCPDF('L', PDF_UNIT, 'F4', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Data Pembarayan '.$jenis[0]->jenis.'');
		$pdf->SetTitle('Data Pembarayan '.$jenis[0]->jenis.' - Kelas '.$namakelasaktif.'');
		$pdf->SetSubject('Data Pembarayan '.$jenis[0]->jenis.' - Kelas '.$namakelasaktif.'');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData('', '', 'Data Pembarayan '.$jenis[0]->jenis.' Tahun Ajaran '.$ajaran[0]->tahunajaran.'', '', '');

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(5, 20, 5);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(5);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();

		$pdf->Write(0, 'Kelas '.$namakelasaktif.'', '', 0, 'L', true, 0, false, false, 0);

		$pdf->SetFont('times', '', 8);

		// -----------------------------------------------------------------------------

		

		$x=1;
		$tbl='';
		$idj=explode('-', $idjenis);
		if($idj[0]!=3 && $idj[0]!=4 && $idj[0]!=9)
		{
			$tbl = '<table cellspacing="0" cellpadding="3" border="1">
				<tr>
					<th style="text-align:center;width:3%" rowspan="2">No</th>
					<th style="text-align:center;width:8%" rowspan="2">NIS</th>
					<th style="text-align:center;width:14%" rowspan="2">Nama Siswa</th>
					<th style="text-align:center;width:67%" colspan="12">Tahun '.$tahun[0].'/'.$tahun[1].' </th>
					<th style="text-align:center;width:8%" rowspan="2">Sub Total</th>
				</tr><tr>';

				for($b=7;$b<=18;$b++)
				{
					if($b>12)
					{
						$c=$b-12;
						$y=substr($tahun[1],2,2);
					}
					else
					{	
						$c=$b;
						$y=substr($tahun[0],2,2);
					}
					$tbl.='<td style="text-align:center;">'.getBulanSingkat($c).' \''.$y.'</td>';
				}
				

				$tbl.='</tr>';
				$alltotal=0;
				foreach($siswa as $no=> $s)
				{
					$tbl.='<tr>
						<td style="font-size:10px;width:10px">'.($no+1).'</td>
						<td style="font-size:10px;width:70px">'.($s->nis_baru).'</td>
						<td style="font-size:10px;width:100px;">'.($s->nama).'</td>';

						
						

							$totaltagihan=0;
							for($b=7;$b<=18;$b++)
							{
								if($b>12)
								{
									$c=$b-12;
									$y=substr($aj[1], -2,4);
									$thh=$aj[1];
								}
								else
								{	
									$c=$b;
									$y=substr($aj[0], -2,4);
									$thh=$aj[0];
								}

								$by=$this->db->query('select * from v_pembayaran where nis="'.$s->nis.'" and idjenis="'.$idjenis.'" and idkelasaktif="'.$s->id.'" and keterangan="'.$c.'" and thn="'.$thh.'"');
								$cekrutin=$this->db->select('*')
												->from('t_penerimaan_rutin')
												->where('t_siswa_nis',$s->nis)
												->where('t_jenis_pembayaran_id',$idjenis)
												->where('t_siswa_has_t_kelas_id',$s->id)
												->where('bulan',$c)
												->where('tahun',$thh)
												->get();
								if($cekrutin->num_rows!=0)
								{
									$sisa=$cekrutin->row('sisa_bayar');
								}
								else
									$sisa=0;

								if($by->num_rows()!=0)
								{
									$j=$by->row('jumlah');
									$js=$j-$sisa;
									$jj=tgl_indo2($by->row('tgl_transaksi'));
									
									if($sisa>0)
										$jj.='<br><span style="color:red">'.rupiah($sisa).'-</span>';	


										//$js=$js;
									$totaltagihan+=$sisa;
								}
								else
								{	
									if($sisa==0)
										$jj='<span style="color:red">'.rupiah($sisa).'</span>';
									else	
										$jj='<span style="color:red">'.rupiah($sisa).'</span>';

									$totaltagihan+=$sisa;
								}
								$tbl.='<td style="text-align:right;font-size:10px;">'.($jj).'</td>';
							
							}	
							$tbl.='<td style="text-align:right;font-size:10px;color:red">'.rupiah($totaltagihan).'</td>';
							
					$tbl.='</tr>';

					$alltotal+=$totaltagihan;
				}
			$tbl.='<tr>
					<th colspan="15" style="text-align:right;font-size:10px;">T O T A L</th>
					<th style="text-align:right;font-size:10px;"">'.rupiah($alltotal).'</th>
				</tr>';

			
			$tbl.='</table>';
		}
		else if($idjenis==3 || $idjenis==4 || $idjenis==9)
		{
			//$idkelas,$idajaran
			$pemb=$this->pm->getJenisPembayaranByID($idjenis);
			$nis_sis=$disc=array();
			$alltotal=0;
			$gc=array();
			foreach($siswa as $no=> $s)
			{

				

				$v=$this->pm->getrecordpembayaranby_idkelasaktif_nis_idjenis($idjenis,$s->nis,$s->id);
				if($v->num_rows!=0)
				{
					$data[$s->nis][$idjenis]=$v->row('nama').'|'.$v->row('wajib_bayar').'|'.$v->row('sisa');
					$nis_sis[$s->nis]=$s->nis_baru;
					$disc[$s->nis]=$v->row('jumlah_diskon');
				}
				else
				{	
					$data[$s->nis][$idjenis]=$s->nama.'|0|0';
					$nis_sis[$s->nis]=$s->nis_baru;
					$disc[$s->nis]=0;
				}

				$vp=$this->pm->getpembayaranby_idkelasaktif_nis_idjenis($idjenis,$s->nis,$s->id);
				$cou=1;
				if($vp->num_rows!=0)
				{
					foreach($vp->result() as $vv)
					{
						$datas[$s->nis][]=$vv->tgl_transaksi.'|'.$vv->jumlah;
						$nis_sis[$s->nis]=$s->nis_baru;
						// $disc[$s->nis]=$vv->jumlah_diskon;
						$cou++;
					}
				}
				else
				{
					$datas[$s->nis][]='0|0';
					// $disc[$s->nis]=0;
					$nis_sis[$s->nis]=$s->nis_baru;
				}

				$gc[]=$cou;
			}
			//print_r($gc);
			if(count($gc)!=0)
			{	
				$m=array_filter($gc);
				$max=max($m);
			}
			else
				$max=1;
			//echo $max;
			$tbl.='<table border="1px" cellpadding="2" cellspacing="2">
					<thead>
						<tr>
							<th style="text-align:center;font-size:10px;" rowspan="2" style="width:30px">No</th>
							<th style="text-align:center;font-size:10px;" rowspan="2">NIS</th>
							<th style="text-align:left;font-size:10px;" rowspan="2">Nama Siswa</th>
							<th style="text-align:left;font-size:10px;" rowspan="2">'.$pemb->row('jenis').'</th>
							<th style="text-align:left;font-size:10px;" colspan="'.$max.'">Pembayaran</th>
							<th style="text-align:center;font-size:10px;" rowspan="2">Sisa Pembayaran</th>
							
						</tr>
						<tr>';
						for($xi=1;$xi<=$max;$xi++)
						{
							$tbl.= '<th style="text-align:center;font-size:10px;">Tahap '.($xi).'</th>';
						}

			$tbl.= '</tr>';
			
			$no=1;
			foreach ($data as $key => $value) 
			{
				$ss=explode('|', $value[$idjenis]);
				$tbl.= '<tr>';
				$tbl.= '<td style="text-align:center;font-size:10px;">'.($no).'</td>';
				$tbl.= '<td style="text-align:left;font-size:10px;">'.($nis_sis[$key]).'</td>';
				$tbl.= '<td style="text-align:left;font-size:10px;">'.($ss[0]).'</td>';
				$tbl.= '<td style="text-align:right;font-size:10px;">'.rupiah($ss[1]).'</td>';
				
				//ksort($datas);
				//foreach ($datas[$key] as $kk => $vv) 
				for($o=0;$o<$max;$o++)
				{
					if(isset($datas[$key][$o]))
					{
						$vk=explode('|', $datas[$key][$o]);
						if($vk[0]=='0')
							$tgl='-';
						else
							$tgl=tgl_indo2($vk[0]);

						$jlh=$vk[1];
					}
					else
					{
						$jlh=0;
						$tgl='-';
					}


					$tbl.= '<td style="text-align:right;font-size:10px;">'.$tgl.'<br><b>'.rupiah($jlh).'</b></td>';
				}
				
				$tbl.= '<td style="text-align:right;font-size:10px;">'.rupiah($ss[2]).'</td>';
				$tbl.='</tr>';			
				$no++;	
				// echo '<pre>';
				// print_r($disc);
				// echo '</pre>';
			}

			$tbl.='</table>';
		}

		$pdf->writeHTML($tbl, true, false, false, false, '');

		$pdf->Output('Data Pembayaran Per Kelas.pdf', 'I');
	}

	function createPDF()
	{
		ob_start();
		$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 048');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 20);

		// add a page
		$pdf->AddPage();

		$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------

		$tbl = '<table cellspacing="0" cellpadding="1" border="1">
		    <tr>
		        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3</td>
		        <td>COL 2 - ROW 1</td>
		        <td>COL 3 - ROW 1</td>
		    </tr>
		    <tr>
		    	<td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
		    	<td>COL 3 - ROW 2</td>
		    </tr>
		    <tr>
		       <td>COL 3 - ROW 3</td>
		    </tr>

		</table>';

		$pdf->writeHTML($tbl, true, false, false, false, '');

		$pdf->Output('example_048.pdf', 'I');
	}
//-----------------------------------------------------------------
	function jurnal($jenis,$date)
	{
		list($jns,$ket)=explode('-', $jenis);
		$data['jenis']=$jns;
		// $data['tr']=$tr=$this->lm->getTransaksiJurnal($date)->result();
		
		if($jns=='harian')
		{

			// $data['tr']=$tr=$this->db->query('select * from v_pembayaran where tgl_transaksi like "%'.$date.'%" group by idjenis,tgl_transaksi,nama,keterangan order by nama')->result();
			$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where tgl_transaksi like "%'.$date.'%" group by idjenis,tgl_transaksi,nama,keterangan order by nama')->result();
			
			if($ket!='all')
				$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where tgl_transaksi like "%'.$date.'%" and idjenis="'.$ket.'" group by idjenis,tgl_transaksi,nama,keterangan order by nama')->result();			
				// $data['tr']=$tr=$this->db->query('select * from v_pembayaran where tgl_transaksi like "%'.$date.'%" and idjenis="'.$ket.'" group by idjenis,tgl_transaksi,nama,keterangan order by nama')->result();			

			$data['date']='Harian : Tanggal '.$date;

		}
		else
		{
			list($thn,$bln)=explode('-', $date);
			$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where month(tgl_transaksi)='.$bln.' and year(tgl_transaksi)='.$thn.' group by idjenis,tgl_transaksi,nama,keterangan order by tgl_transaksi,nama')->result();
			// $data['tr']=$tr=$this->db->query('select * from v_pembayaran where month(tgl_transaksi)='.$bln.' and year(tgl_transaksi)='.$thn.' group by idjenis,tgl_transaksi,nama,keterangan order by tgl_transaksi,nama')->result();
			
			if($ket!='all')
				$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where month(tgl_transaksi)='.$bln.' and year(tgl_transaksi)='.$thn.' and idjenis="'.$ket.'" group by idjenis,tgl_transaksi,nama,keterangan order by tgl_transaksi,nama')->result();
				// $data['tr']=$tr=$this->db->query('select * from v_pembayaran where month(tgl_transaksi)='.$bln.' and year(tgl_transaksi)='.$thn.' and idjenis="'.$ket.'" group by idjenis,tgl_transaksi,nama,keterangan order by tgl_transaksi,nama')->result();

		
			$data['date']='Bulanan : '.getBulan($bln).'-'.$thn;
		}

		$j=count($tr);

		$k=array();

		for($t=0;$t<$j;$t++)
		{
			$k[$tr[$t]->nis][]=$tr[$t];
		}
		$trr=$k;
		$data['trr']=$trr;
		$this->load->view('laporan/jurnalexcel',$data);
		/*$this->load->library(array('Classes/PHPExcel','Classes/PHPExcel/IOFactory'));
		
		$objPHPExcel = new PHPExcel();
 
                // Set properties
        $objPHPExcel->getProperties()
                  	->setCreator("Keuangan SD Ibnu Hajar") //creator
                    ->setTitle("Jurnal Penerimaan Harian ".tgl_indo($date)."");  //file title
 
        $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
        $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
        $objget->setTitle(tgl_indo2($date)); //sheet title
        $objset->setCellValue('A1',"Jurnal Penerimaan Harian ".tgl_indo($date).""); //insert cell value
        $objget->getStyle('A1')->getFont()->setBold(true)  // set font weight
                ->setSize(12);    //set font size
 
        //table header
        $jlh=count($tr);
        $cols = array("A","B","C","D","E");
        $val = array("No","Tanggal","Keterangan","Jumlah","Status");
        for ($a=0;$a<count($cols);$a++) 
        {
            $objset->setCellValue($cols[$a].'3', $val[$a]);
                        //set borders
            $objget->getStyle($cols[$a].'3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objget->getStyle($cols[$a].'3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objget->getStyle($cols[$a].'3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objget->getStyle($cols[$a].'3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
 
            //set alignment
            $objget->getStyle($cols[$a].'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //set font weight
            $objget->getStyle($cols[$a].'3')->getFont()->setBold(true) ;
        }
                
		for ($b=0;$b<$jlh;$b++) 
        {
            $objset->setCellValue($cols[0].($b+4), ($b+1));
            $objset->setCellValue($cols[1].($b+4), (tgl_indo($tr[$b]->tgl_transaksi)));
            $objset->setCellValue($cols[2].($b+4), ('Penerimaan '.$tr[$b]->jenis.' Atas Nama Siswa : '.$tr[$b]->nama));
            $objset->setCellValue($cols[3].($b+4), number_format($tr[$b]->jumlah));
            $objset->setCellValue($cols[4].($b+4), ($tr[$b]->status_pembayaran));
                        //set borders
             $objget->getStyle($cols[0].($b+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $objget->getStyle($cols[1].($b+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $objget->getStyle($cols[3].($b+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            for($xx=0;$xx<count($cols);$xx++)
            {
	            $objget->getStyle($cols[$xx].($b+4))->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objget->getStyle($cols[$xx].($b+4))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objget->getStyle($cols[$xx].($b+4))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	            $objget->getStyle($cols[$xx].($b+4))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
         	}
         }
               //taruh baris data disini
 
                //simpan dalam file sample.xls
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
        $objWriter->save('media/files/Jurnal Penerimaan Harian '.tgl_indo($date).'.xls');
        //$this->session->set_flashdata('pesan','Data ');
        $this->load->helper('download');
        $data = file_get_contents('media/files/Jurnal Penerimaan Harian '.tgl_indo($date).'.xls'); // Read the file's contents
		$name = 'Jurnal Penerimaan Harian '.tgl_indo($date).'.xls';

		force_download($name, $data);*/
	}
}