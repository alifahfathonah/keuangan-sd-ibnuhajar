<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Penerimaan extends A {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('sistem')=='SD')
		{
			$this->load->database('default',true);
		}
		else
		{
			$this->db=$this->load->database('second',true);
		}
	}

	function index()
	{
		$data['title']='Transaksi Penerimaan';
		$data['isi']='penerimaan/index';
		$data['penerimaan']=$pn=$this->pm->getJenisPembayaranByParent(1);
		$pen=array();
		foreach($pn->result() as $p)
		{
			//echo $p->id.'<br>';
			$pe=$this->pm->getJenisPembayaranByParent($p->id);
			if($pe->num_rows!=0)
			{
				foreach($pe->result() as $pp)
				{
					//echo $pp->jenis.'-';
					$pen[$p->id][$pp->id]=$pp;
				}
			}

			$pen['lain'][]=$p;

		}
		$data['pen']=$pen;
		$this->load->view('index',$data);
	}

	function getTransaksi($nis=null,$idkelasaktif=null)
	{
		//02 1112 035
		//162272544
		$nis=str_replace('%20', ' ', $nis);

		$ka=$this->db->query("select *,tk.id as idk,th.id as ida from
								t_siswa_has_t_kelas as th
								inner join t_kelas as tk on (th.t_kelas_id=tk.id)
								inner join t_ajaran as taj on (taj.id=th.t_ajaran_id)
								where (th.t_siswa_nis='".$nis."') and th.status='t' and th.status_siswa_aktif='t' and th.id='".$idkelasaktif."';");

		$sis=$this->db->query('select * from t_siswa where nis like "%'.$nis.'%"');
		$idkelasaktif=$ka->row('ida');
		$tahunajaran=$ka->row('tahunajaran');
		list($ta1,$ta2)=explode('-', $tahunajaran);
		$data['penerimaan']=$pn=$this->pm->getJenisPembayaranByParent(1);
		$pen=array();
		// echo $nis.'-'.$idkelasaktif;
		foreach($pn->result() as $p)
		{
		
			$nn=$this->pm->getViewDataKewajiban($nis,$idkelasaktif,$p->id);
			if($nn->num_rows!=0)
			{
				$c=$nn->result();
				$n[$p->id]=$c[0];
				// echo $nn->row('h');
			}
			else
				$n[$p->id]=array();

			$pen['lain'][]=$p;

		}
		

			
		echo '<input type="hidden" id="datakelasbaru" name="kelas" value="'.$ka->row('idk').'">';
		echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:70%;;margin:0 auto;">
				<thead>
					<tr>
						<th style="text-align:center;" >Keterangan</th>
						<th style="text-align:center;" >Kewajiban</th>
						<th style="text-align:center;" >Pembayaran</th>
					</tr>
				</thead>
				<tbody>
					<input type="hidden" name="namasiswa" id="namasiswa" value="'.$nis.'">
					<input type="hidden" name="idkelasaktif" id="idkelasaktif" value="'.$idkelasaktif.'">';

				$lain=$pen['lain'];
				$tb='';
				$total=0;
				// echo '<pre>';
				// print_r($lain);
				// echo '</pre>';
				foreach($lain as $key=> $ut)
				{

						echo '<input type="hidden" name="idjenis" id="" value="'.$ut->id.'">';
						echo '<input type="hidden" name="idjj" id="idjj" value="'.$ut->jenis.'">';
						echo '<tr>
								<td style="width:50%">
									<div style="width:35%;float:left;">
									';
									if(count($n[$ut->id])!=0)
									{
										if($ut->id!=3 && $ut->id!=4 && $ut->id==10)
											echo '<span style="font-size:9px;font-style:italic">Rapel</span> <input type="checkbox" onclick="rapel(\''.$ut->id.'\',this.value)" id="rapel_'.$ut->id.'" name="rapel['.$ut->id.']">&nbsp;';
									}

							echo $ut->jenis;

						echo '	</div>
									<div style="width:65%;float:left">';
									$nilairapel=$jlh_kewajiban=$inputtext='';

									if(count($n[$ut->id])!=0)
									{
										$st_utab=$st_pptab=0;
										if(count($n[3])!=0)
										{
											$st_utab=1;
										}
										else if(count($n[4])!=0)
										{
											$st_pptab=1;
										}
										// echo $st_utab;
										if($n[$ut->id]->bulan!=7)
										{
												// echo '<pre>';
												// print_r($n[$ut->id]);
												// echo '</pre>';
												if($n[$ut->id]->sisa < 0)
													$jj=($n[$ut->id]->sudah_bayar+$n[$ut->id]->sisa);
												else
													$jj=$n[$ut->id]->sisa;

												if(($n[$ut->id]->wajib_bayar -  $n[$ut->id]->sudah_bayar) == 0)
												{
													if($n[$ut->id]->sisa>0)
													{
														$jj=0-$n[$ut->id]->sisa;
													}
												}

												$cekdiskon=$this->db->query('select * from t_diskon where id_kelas_aktif="'.$idkelasaktif.'" and nis="'.$nis.'" and id_jenis_pembayaran="'.$ut->id.'"');
												if($cekdiskon->num_rows!=0)
												{
													$jlh_diskon=0;
													if($cekdiskon->row('satuan_diskon')=='%')
													{
														$dis = $jj * ($cekdiskon->row('jumlah_diskon') / 100);
														$jlh_diskon = $jj - $dis;
													}
													else if($cekdiskon->row('satuan_diskon')=='rp')
													{
														$jlh_diskon = $jj - $cekdiskon->row('jumlah_diskon');
													}

													$jj = $jlh_diskon;
												}

												if($ut->id==18)
												{
													$wh=array('t_siswa_has_t_kelas_id'=>$idkelasaktif,'t_jenis_pembayaran_id'=>$ut->id ,'t_siswa_nis'=>$nis,'tahun'=>$n[$ut->id]->tahun,'bulan'=>$n[$ut->id]->bulan);
													// $wh=array('t_siswa_has_t_kelas_id'=>$idkelasaktif,'t_jenis_pembayaran_id'=>$ut->id ,'t_siswa_nis'=>$nis,'sisa_bayar !='=>0);
													$cekclub=$this->db->from('t_penerimaan_rutin')->where($wh)->like('keterangan','idclub')->order_by('tahun asc, (bulan*1) asc')->get();
													$biaya_club=0;
													$bclub=$inptxt='';
													$dtclub=array();
													// foreach ($cekclub->result() as $kc => $vc)
													// {
													// 	$dd=explode(':', $vc->keterangan);
													// 	$idclub=$dd[1];
													// 	$dtclub[$idclub][$vc->tahun][$vc->bulan]=$vc;
													// }
													foreach ($cekclub->result() as $kc => $vc)
													{
														# code...
														$dd=explode(':', $vc->keterangan);
														$idclub=$dd[1];
														$dataclub=$this->db->from('t_club')->where('id_club',$idclub)->get();
														echo $dataclub->row('nama_club').' : '.getBulanSingkat($vc->bulan).' '.$vc->tahun.'<br>';
														$biaya_club+=$vc->sisa_bayar;
														$bclub.=number_format($vc->sisa_bayar).'<br>';
														$inptxt.='<input type="text" name="transaksi[\'lain\']['.$ut->id.']['.$idclub.']" style="width:100%;margin:0px;padding:1px 3px;text-align:right;border:0px;border-bottom:1px dotted #888;font-size:11px;" placeholder="Rp." class="transaksi_'.$ut->jenis.' transaksi_'.$ut->id.'_'.$idclub.'" id="transaksi_lain" onkeyup="hitung(\'lain\')" value="0" autocomplete="off">';

														echo '<input type="hidden" name="idjjclub" id="idjjclub" value="'.$ut->id.'_'.$idclub.'">';
														echo '<input type="hidden" id="ketclub_'.$ut->id.'_'.$idclub.'" value="'.getBulan($vc->bulan).' '.$vc->tahun.'">';
													}
													$inputtext=$inptxt;
													$jlh_kewajiban=$bclub;
													$jj=$biaya_club;
												}
												else
												{
													echo getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
												}
												$vvvv=getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;



												echo '<input type="hidden" name="bulanspp['.$ut->id.']" value="'.$n[$ut->id]->bulan.'">';
												echo '<input type="hidden" name="tahunspp['.$ut->id.']" value="'.$n[$ut->id]->tahun.'">';
												echo '<input type="hidden" id="ket_'.$ut->jenis.'" value="'.$vvvv.'">';
												echo '<div id="rapelbulan_'.$ut->id.'" style="display:none">';

												$date1=date_create("".$n[$ut->id]->tahun."-".$n[$ut->id]->bulan."");
												$date2=date_create("".($n[$ut->id]->tahun+1)."-06");
												$diff=date_diff($date1,$date2);


												for($bi=1;$bi<=($diff->m);$bi++)
												{
													$bil=$n[$ut->id]->bulan+$bi;
													$bil_th=$n[$ut->id]->tahun;
													if($bil>12)
													{
														$bil=$bil-12;
														$bil_th=$n[$ut->id]->tahun+1;
													}
													echo '<div style="font-size:10px;">
															<input type="checkbox" class="bayarrapel_'.$ut->id.'" id="bayarrapel_'.$ut->id.'_'.$bil.'_'.$bil_th.'" name="bayarrapel['.$ut->id.']['.$bil_th.'_'.trim($bil).']" onclick="bayarrapel(\''.$ut->id.'\',\''.$bil.'\',\''.$bil_th.'\')">&nbsp;'.getBulanSingkat($bil).' '.$bil_th.'</div>';

													$nilairapel.='<div id="nilairapel_'.$ut->id.'_'.$bil.'_'.$bil_th.'" class="nilairapel_'.$ut->id.'" style="text-align:right;width:100%;font-size:10px;margin:1px 0 !important;display:none">'.number_format($jj).'&nbsp;&nbsp;</div>';
												}
												// echo '<pre>';
												// print_r($diff);
												// echo '</pre>';
												// echo '<input type="hidden" name="">';
												echo '</div>';
										// 	}
										}
										else if($n[$ut->id]->bulan==7)
										{
											//.'-'.$st_utab.'-'.$st_pptab
											// echo $ta1.'-';
											if($ta1>=2017)
											{
												if($st_pptab==1)
												{
													echo getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
													$vvvv=getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
													if($n[$ut->id]->sisa < 0)
														$jj=($n[$ut->id]->sudah_bayar+$n[$ut->id]->sisa);
													else
														$jj=$n[$ut->id]->sisa;
													echo '<input type="hidden" name="bulanspp['.$ut->id.']" value="'.$n[$ut->id]->bulan.'">';
													echo '<input type="hidden" name="tahunspp['.$ut->id.']" value="'.$n[$ut->id]->tahun.'">';
													echo '<input type="hidden" id="ket_'.$ut->jenis.'" value="'.$vvvv.'">';
													
												}
												else if($n[$ut->id]->sisa > 0)
												{
													// if($st_utab==1)
													// {
														// echo $ut->id.'-'.getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
														echo getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
														$vvvv=getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
														if($n[$ut->id]->sisa < 0)
															$jj=($n[$ut->id]->sudah_bayar+$n[$ut->id]->sisa);
														else
															$jj=$n[$ut->id]->sisa;
														echo '<input type="hidden" name="bulanspp['.$ut->id.']" value="'.$n[$ut->id]->bulan.'">';
														echo '<input type="hidden" name="tahunspp['.$ut->id.']" value="'.$n[$ut->id]->tahun.'">';
														echo '<input type="hidden" id="ket_'.$ut->jenis.'" value="'.$vvvv.'">';
													// }
													// else
													// 	echo $st_utab;
												}
											}
										}
										else
										{
											//Bagian di edit
											if($ut->id!=10)
											{
												echo getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
												$vvvv=getBulan($n[$ut->id]->bulan).' '.$n[$ut->id]->tahun;
												if($n[$ut->id]->sisa < 0)
													$jj=($n[$ut->id]->sudah_bayar+$n[$ut->id]->sisa);
												else
													$jj=$n[$ut->id]->sisa;
												echo '<input type="hidden" name="bulanspp['.$ut->id.']" value="'.$n[$ut->id]->bulan.'">';
												echo '<input type="hidden" name="tahunspp['.$ut->id.']" value="'.$n[$ut->id]->tahun.'">';
												echo '<input type="hidden" id="ket_'.$ut->jenis.'" value="'.$vvvv.'">';
											}
										}
									}
									else
									{
										// echo $ta1;
										// $cek=$this->pm->cekPenerimaanRutinLain($bulan,$idjenis,$nis,$tahun=null);
										$jj=0;
										echo '<input type="hidden" name="bulanspp['.$ut->id.']" value="0">';
										echo '<input type="hidden" name="tahunspp['.$ut->id.']" value="0">';
										echo '<input type="hidden" id="ket_'.$ut->jenis.'" value="">';
									}
									$total+=($jj < 0 ? 0 :$jj);

						if($ut->id!=18)
						{
							$jlh_kewajiban=number_format(($jj < 0 ? 0 :$jj));
							$inputtext='<input type="text" name="transaksi[\'lain\']['.$ut->id.']" style="width:100%;margin:0px;padding:1px 3px;text-align:right;border:0px;border-bottom:1px dotted #888;font-size:11px;" placeholder="Rp." class="transaksi_'.$ut->jenis.'" id="transaksi_lain" onkeyup="hitung(\'lain\')" value="0" autocomplete="off">';
						}


						echo '</div>
								</td>
								<td style="width:25%;text-align:right;vertical-align:top">
								<span class="wajibb" id="wajib_'.$ut->id.'">'.$jlh_kewajiban.'</span>
								<br>'.$nilairapel.'
								<div style="font-size:11px;text-align:right;padding-right:4px;display:none" id="total_'.$ut->id.'">Total : <span id="totot_'.$ut->id.'">0</span></div>
								</td>
								<td style="width:25%">'.$inputtext.'</td>
						</tr>';
											//}


				}
				echo '</tbody>
					</thead>
				</table>
				<div style="width:100%;float:left;">
					<table class="table table-striped table-bordered bootstrap-datatable" style="width:70%;margin:0 auto;">
						<thead>
							<input type="hidden" name="jumlah[3]" id=jlh1_3" value="0">
							<input type="hidden" name="jumlah[4]" id="jlh2_4"  value="0">
							<input type="hidden" name="jumlah[\'lain\']" id="jlh3_lain"  value="0">
							<tr>
								<th style="text-align:right;font-weight:bold;width:50%">Jumlah</th>
								<th style="text-align:right;font-weight:bold;width:25%;padding-right:15px" id="totalsemua">'.number_format($total).'</th>
								<th style="width:25%;text-align:right;font-weight:bold" id="jlh3">0</th>
							</tr>
							<tr>
								<th style="text-align:right;font-weight:bold;font-size:17px;" colspan="2">T O T A L</th>
								<th style="width:25%;text-align:right;font-weight:bold;font-size:17px;" id="total">0</th>
							</tr>
							<tr>
								<td style="text-align:right;font-weight:bold;font-style:italic;" colspan="3">Terbilang :
									<div style="width:40%;float:left;text-align:left">
										Catatan :<br>
										<textarea style="width:100%;height:40px;" name="catatan" id="catatan"></textarea>
										<input type="hidden" name="catatanrapel" id="catatanrapel">
									</div>
									<div style="width:55%;float:right;text-align:left;">
										Terbilang :
										<span id="terbilang"></span>
									</div>
								</td>
							</tr>
						</thead>

					</table>

			</div>';
	}

	function addplafond()
	{
		if($_POST['jenispenerimaan']!='')
		{
			$jenis=$this->input->post('jenispenerimaan');
			$data['title']='Data Plafond Penerimaan';
			$data['isi']='penerimaan/addplafond';
			$data['jenisP']=$this->pm->getJenisPembayaranByID($_POST['jenispenerimaan']);
			$this->load->view('index',$data);

		}
		else
		{
			$this->session->set_flashdata('pesan','Jenis Penerimaan Belum Dipilih');
			redirect('penerimaan','location');
		}

	}

	function updatePlafond($id)
	{
		if(!empty($_POST))
		{
			$jj=$_POST['jumlah'];
			$jlh=0;
			if($id==4)
			{
				foreach($jj as $idx => $j)
				{
					$jumlah=str_replace(',', '', $j);

					if($jumlah=='')
						$jumlah=0;

					$pl=$this->pm->getJenisPembayaranByID($idx);
					if($pl->num_rows!=0)
						$ll=$pl->row('jumlah');
					else
						$ll=0;

					$this->pm->updateJumlahJenisPembayaran($idx,$ll,$jumlah);
					$jlh+=$jumlah;
				}
				$this->pm->updateJumlahJenisPembayaran($id,$jlh,$jlh);
			}
			else
			{
				foreach($jj as $idx => $j)
				{
					$jumlah=str_replace(',', '', $j);
					if($jumlah=='')
						$jumlah=0;

					$pl=$this->pm->getJenisPembayaranByID($idx);
					if($pl->num_rows!=0)
						$ll=$pl->row('jumlah2');
					else
						$ll=0;

					$this->pm->updateJumlahJenisPembayaran($idx,$jumlah,$ll);
					$jlh+=$jumlah;
				}
				$this->pm->updateJumlahJenisPembayaran($id,$jlh,$jlh);
			}

			$this->session->set_flashdata('pesan','Data Plafond Penerimaan Berhasil Di Edit');
			//redirect('penerimaan','location');
		}
		else
		{
			$this->session->set_flashdata('pesan','Data Plafond Penerimaan Gagal Di Edit');
		}
		redirect('penerimaan','location');
	}

	function transaksi($jenis)
	{
		$data['title']='Transaksi Penerimaan '.ucwords($jenis);
		$data['isi']='penerimaan/transaksi';
		$data['penerimaan']=$pn=$this->pm->getJenisPembayaranByParent(1);
		$pen=array();
		foreach($pn->result() as $p)
		{
			//echo $p->id.'<br>';
			$pe=$this->pm->getJenisPembayaranByParent($p->id);
			if($pe->num_rows!=0)
			{
				foreach($pe->result() as $pp)
				{
					//echo $pp->jenis.'-';
					$pen[$p->id][$pp->id]=$pp;
				}

			}

			$pen['lain'][]=$p;

		}
		$data['pen']=$pen;
		$data['jenis']=$jenis;
		$this->load->view('index',$data);
	}

	function simpantransaksi()
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		$r_wajib_bayar=0;
		if(isset($_POST['rapel']))
		{
			foreach ($_POST['rapel'] as $k => $v)
			{
				if($v=='on')
				{
					$r_trans=str_replace(',', '', $_POST['transaksi']["'lain'"][$k]);
					$rapel['wajib_bayar']=$r_wajib_bayar=$r_trans/(count($_POST['bayarrapel'][$k])+1);
					$rapel['t_siswa_nis'] = $_POST['siswa'];
					$rapel['t_siswa_has_t_kelas_id'] = $_POST['idkelasaktif'];
					$rapel['t_jenis_pembayaran_id'] = $k;
					$rapel['sudah_bayar']=$r_wajib_bayar;
					$rapel['sisa_bayar']=0;
					// $rapel['penerima']=0;
					// $r_keterangan=' ';
					foreach ($_POST['bayarrapel'][$k] as $kv => $vv)
					{
						$rapel['id']=generate_id();
						list($r_tahun,$r_bulan)=explode('_', $kv);
						$rapel['tahun']=$r_tahun;
						$rapel['bulan']=$r_bulan;
						$bulan_tahun_tagihan=$r_tahun;
						$r_keterangan='Pembayaran Rapel untuk bulan '.getBulan($r_bulan).' '.$r_tahun;
						$rapel['ket']=$r_keterangan;
						$cek_r=$this->db->query('select * from t_penerimaan_rutin where t_siswa_has_t_kelas_id="'.$_POST['idkelasaktif'].'" and bulan='.$r_bulan.' and tahun='.$r_tahun.' and t_jenis_pembayaran_id="'.$k.'"');
						if($cek_r->num_rows!=0)
						{
							foreach ($cek_r->result() as $kc => $vc)
							{
								# code...
								$rapel['id']=$vc->id;
								$this->pm->updatepenerimaanrutin($rapel);
							}
							// echo 'Bulan '.$r_bulan.' Udah Ada<br>';
							// echo '<pre>';
							// print_r($rapel);
							// echo '</pre>';
						}
						else
							$this->pm->addpenerimaanrutin($rapel);
							// echo $r_bulan;

						$r_ins=array(
							't_jenis_pembayaran_id'=>$k,
							't_siswa_has_t_kelas_id'=>$_POST['idkelasaktif'],
							'id'=>abs(crc32(sha1(md5(rand())))),
							'jumlah'=>$r_wajib_bayar,
							'tgl_transaksi'=>$_POST['tgl_transaksi'].' '.date('H:i:s'),
							't_user_id'=>$this->session->userdata('iduser'),
							'penyetor'=>$_POST['penyetor'],
							'id_parent_jenis_pembayaran'=>$k,
							'keterangan'=>$r_bulan,
							'catatan'=>$_POST['catatan'],
							'penerima'=>$_POST['penerima'],
							'bulan_tahun_tagihan'=>$bulan_tahun_tagihan
						);
						$this->db->insert('t_pembayaran',$r_ins);
					}
				}
				// echo '<pre>';
				// print_r($rapel);
				// echo '</pre>';
			}

		}
		if(!empty($_POST))
		{
			$cekfield="SHOW COLUMNS FROM `t_pembayaran` LIKE 'catatan';";
			$cf=$this->db->query($cekfield);
			if($cf->num_rows==0)
			{
				$this->db->query("ALTER TABLE  `t_pembayaran` ADD  `catatan` TEXT NULL ;");
			}

			$siswa=$this->input->post('siswa');
			$kelas=$this->input->post('kelas');
			$penyetor=$this->input->post('penyetor');
			$bulanspp=$this->input->post('bulanspp');
			$tahunspp=$this->input->post('tahunspp');
			$transaksi=$this->input->post('transaksi');
			$idkelasaktif=$this->input->post('idkelasaktif');
			$jumlah=$this->input->post('jumlah');
			$bulan_tahun_tagihan=$this->input->post('tahunspp');
			$simpan['catatan']=$catatan=$this->input->post('catatan');

			$ki=$this->db->query('select *,tsa.id as id_t from t_siswa_has_t_kelas as tsa
									inner join t_ajaran as ta on (ta.id=tsa.t_ajaran_id)
									where tsa.t_kelas_id="'.$kelas.'" and tsa.t_siswa_nis="'.$siswa.'" and tsa.status_siswa_aktif="t" and tsa.status="t"');

			$tahunajaran=$ki->row('tahunajaran');
			list($ta1,$ta2)=explode('-', $tahunajaran);
			$simpan['nis']=$siswa;
			$simpan['id_kelas']=$kelas;
			$simpan['penyetor']=$penyetor;
			$simpan['idkelasaktif']=$idkelasaktif;
			$simpan['kelas_aktif']=$kelas_id=$ki->row('id_t');
			$simpan['tgl_transaksi']=$tgl_transaksi=$this->input->post('tgl_transaksi');
			$simpan['iduser']= $iduser = $this->session->userdata('iduser');

			foreach($transaksi as $idtr => $tr)
			{
				foreach($tr as $idt=> $t)
				{
					if($t!=0 && !empty($t))
					{
						$simpan['tr_id']=$transaksi_id=abs(crc32(md5(sha1(rand()))));
						if(isset($_POST['rapel']))
						{
							// if($_POST['raple'])
							if($idt==10)
								$simpan['jumlah']=$jlh=$r_wajib_bayar;
							else
								$simpan['jumlah']=$jlh=str_replace(',', '', $t);
								// $simpan['jumlah']=$jlh=$r_wajib_bayar;
						}
						else
							$simpan['jumlah']=$jlh=str_replace(',', '', $t);

						$simpan['t_jenis_pembayaran_id']=$idt;
						$simpan['id_parent_jenis_pembayaran'] =$idtr;
						$simpan['keterangan']='';
						$simpan['bulan_tahun_tagihan']=$bulan_tahun_tagihan[$idt];
						if(isset($bulanspp[$idt]))
						{
							$simpan['keterangan']=$bulanspp[$idt];
						}

						$simpan['total']=str_replace(',', '', $t);
						if($idt!=3 && $idt!=4)
						{


							$bulan=isset($bulanspp[$idt]) ? $bulanspp[$idt] : '';

							if($idt!=18)
							{
								$cekc=$this->db->query('select * from t_penerimaan_rutin
														where t_siswa_nis="'.$siswa.'"
														and t_siswa_has_t_kelas_id="'.$kelas_id.'" and t_jenis_pembayaran_id="'.$idt.'" and bulan="'.$bulan.'"');
								if($cekc->num_rows!=0)
								{
									$simpan['total']=str_replace(',', '', $t);
									$wb=$cekc->row('wajib_bayar');
									$sb=$jlh+$cekc->row('sudah_bayar');
									$sisa=$wb-$sb;
									$upd=array(
										'sisa_bayar'=>$sisa,
										'wajib_bayar'=>$wb,
										'sudah_bayar'=>$sb
										// 'keterangan' => 'penyebab eror'
									);
									$this->db->where('id',$cekc->row('id'));
									$this->db->update('t_penerimaan_rutin',$upd);
								}
							}
							else
							{
								// $$simpan['jumlah']=$jlh=str_replace(',', '', $t);
								foreach ($t as $kt => $vt)
								{
									# code...
									$wh=array('t_siswa_has_t_kelas_id'=>$kelas_id , 'bulan'=>$bulanspp[$idt], 'tahun'=>$tahunspp[$idt],'t_siswa_nis'=>$siswa);
									$cekc=$this->db->from('t_penerimaan_rutin')->where($wh)->like('keterangan',$kt)->get()->result();
									// echo '<pre>';
									// print_r($cekc->result());
									// echo '</pre>';
									if(count($cekc)!=0)
									{
										$simpan['total']=$jlh=str_replace(',', '', $vt);
										$wb=$cekc[0]->wajib_bayar;
										$sb=$jlh+$cekc[0]->sudah_bayar;
										$sisa=$wb-$sb;
										$updd=array(
											'sisa_bayar'=>$sisa,
											'wajib_bayar'=>$wb,
											'sudah_bayar'=>$sb
											// 'keterangan' => 'penyebab eror'
										);
										$this->db->where('id',$cekc[0]->id);
										$this->db->update('t_penerimaan_rutin',$updd);

										$simpan['jumlah']=str_replace(',', '', $vt);
										$simpan['tr_id']=abs(crc32(md5(sha1(rand()))));
										$simpan['catatan']='idclub:'.$kt;
										$this->pm->saveTransaksi($simpan);
									}
								}
							}


						}
						else
						{
							// $simpan['total']=$transaksi[$idtr][$idt];

							$cekc=$this->db->query('select * from t_record_pembayaran_siswa
													where t_siswa_nis="'.$siswa.'"
													and t_kelas_aktif_id="'.$kelas_id.'" and t_jenis_pembayaran_id="'.$idt.'"');

							if($cekc->num_rows!=0)
							{
								$wb=$cekc->row('wajib_bayar');
								$sb=$jlh+$cekc->row('sudah_bayar');
								$sisa=$wb-$sb;
								$upd=array(
									'sisa'=>$sisa,
									'wajib_bayar'=>$wb,
									'sudah_bayar'=>$sb
								);
								$this->db->where('id',$cekc->row('id'));
								$this->db->update('t_record_pembayaran_siswa',$upd);


									// if($ta1<2017)
									// {
									if($idt==3)
									{
										$cekcc=$this->db->query('select * from t_penerimaan_rutin
																where t_siswa_nis="'.$siswa.'"
																and t_siswa_has_t_kelas_id="'.$kelas_id.'" and t_jenis_pembayaran_id="10" and bulan="7"');
										//Bagian di edit
										if($cekcc->num_rows!=0)
										{
											if($cekcc->row('wajib_bayar')<=$sb)
											{
												$wbc=$cekcc->row('sisa_bayar');
												// $sisac=$wbc-$sbc;
												$updc=array(
													'sisa_bayar'=>0,
													'sudah_bayar'=>$wbc
												);
												$this->db->where('id',$cekcc->row('id'));
												$this->db->update('t_penerimaan_rutin',$updc);

												$cekek=$this->db->query('select * from t_pembayaran where t_jenis_pembayaran_id=10 and t_siswa_has_t_kelas_id="'.$kelas_id.'" and keterangan=7');
												if($cekek->num_rows==0)
												{
													$ins=array(
														't_jenis_pembayaran_id'=>10,
														't_siswa_has_t_kelas_id'=>$kelas_id,
														'id'=>abs(crc32(sha1(md5(rand())))),
														'jumlah'=>$cekcc->row('wajib_bayar'),
														'tgl_transaksi'=>$tgl_transaksi,
														't_user_id'=>$this->session->userdata('iduser'),
														'penyetor'=>$penyetor,
														'id_parent_jenis_pembayaran'=>10,
														'keterangan'=>7,
														'catatan'=>$catatan,
														'penerima'=>$_POST['penerima'],
														'bulan_tahun_tagihan'=>$bulan_tahun_tagihan[$idt]
													);
													$this->db->insert('t_pembayaran',$ins);
												}
											}
										}
									}
									else if($idt==4)
									{
										if($ta1<2017)
										{
											$cekcc=$this->db->query('select * from t_penerimaan_rutin
																where t_siswa_nis="'.$siswa.'"
																and t_siswa_has_t_kelas_id="'.$kelas_id.'" and t_jenis_pembayaran_id="10" and bulan="7"');
										//Bagian di edit
											if($cekcc->num_rows!=0)
											{
												if($cekcc->row('wajib_bayar')<=$sb)
												{
													$wbc=$cekcc->row('sisa_bayar');
													// $sisac=$wbc-$sbc;
													$updc=array(
														'sisa_bayar'=>0,
														'sudah_bayar'=>$wbc
													);
													$this->db->where('id',$cekcc->row('id'));
													$this->db->update('t_penerimaan_rutin',$updc);

													$cekek=$this->db->query('select * from t_pembayaran where t_jenis_pembayaran_id=10 and t_siswa_has_t_kelas_id="'.$kelas_id.'" and keterangan=7');
													if($cekek->num_rows==0)
													{
														$ins=array(
															't_jenis_pembayaran_id'=>10,
															't_siswa_has_t_kelas_id'=>$kelas_id,
															'id'=>abs(crc32(sha1(md5(rand())))),
															'jumlah'=>$cekcc->row('wajib_bayar'),
															'tgl_transaksi'=>$tgl_transaksi,
															't_user_id'=>$this->session->userdata('iduser'),
															'penyetor'=>$penyetor,
															'id_parent_jenis_pembayaran'=>10,
															'keterangan'=>7,
															'catatan'=>$catatan,
															'penerima'=>$c_POST['penerima'],
															'bulan_tahun_tagihan'=>$bulan_tahun_tagihan[$idt]
														);
														$this->db->insert('t_pembayaran',$ins);
													}
												}
											}
										}
									}
								// }
							}

						}

						if($idt!=18)
							$this->pm->saveTransaksi($simpan);
					}
				}
			}
			$this->session->set_flashdata('pesan','Data Transaksi Berhasil Ditambahkan');
			redirect('penerimaan/transaksi/rutin','location');
		}
	}

	function rutin($idjenis)
	{
		$data['title']='Data Penerimaan Rutin';
		$data['isi']='penerimaan/rutin';
		$data['jenisP']=$this->pm->getJenisPembayaranByID($idjenis);
		$data['idjenis']=$idjenis;
		$this->load->view('index',$data);
	}

	function penerimaanRutin($idjenis)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		$x=0;
		if(!empty($_POST))
		{
			$data['t_jenis_pembayaran_id']=$idjenis;
			$sis=$this->input->post('siswa');
			$ket=$this->input->post('ket');
			$data['bulan']=$bulan=$this->input->post('bulan');
			$data['tahun']=$tahun=$this->input->post('tahun');
			$kelas=$this->input->post('kelas');
			if($idjenis!=13)
			{
				list($idkls,$idajaran,$thnaj)=explode('|', str_replace('%20', ' ', $kelas));
				$data['jlh']=$this->input->post('jumlah');
				$data['wajib_bayar']=$wajibbayar=str_replace(',','', $this->input->post('jumlah'));
				$dkls=$this->input->post('kelas');
			}
			else
			{
				$data['jemputan']=$this->input->post('jemputan');
				$data['driver']=$this->input->post('driver');
				$wajibbayar=str_replace(',','', $this->input->post('jemputan'));
			}
			foreach($sis as $idx=> $s)
			{
				$xx=str_replace("'", '', $idx);
				// echo $xx.'-';
				if(!empty($s))
				{

					if($idjenis==13)
					{
						$kk=$this->km->getKelasAktifByNIS($xx,'t');

						if($bulan<=12 && $bulan>=7)
						{
							$thn_aj=$tahun.'-'.($tahun+1);
						}
						else
						{
							$thn_aj=($tahun-1).'-'.$tahun;
						}
						// $getTa=$this->db->query('select * from t_ajaran where tahunajaran="'.$thn_aj.'"');
						$idsiswa=$xx;
						$data['sis'][$xx]=$xx;
						$data['t_siswa_nis']=$xx;
						$idrutin = abs(crc32(md5(sha1(rand()))));
						$data['id']=$idrutin;
						$data['t_siswa_has_t_kelas_id']=$kk->row('id');
						$data['sudah_bayar']=$sudah=0;
						$data['sisa_bayar']=$wajibbayar[$idx]-$sudah;
						$data['wajib_bayar']=$wajibbayar[$idx];
						$data['ket']=$ket[$idx];
						$data['jumlah_diskon']=0;
						$data['kk']=$kk->result();
						$data['cek']=$cek=$this->db->query('select * from t_penerimaan_rutin where t_jenis_pembayaran_id="'.$idjenis.'" and t_siswa_nis="'.$idsiswa.'" and bulan="'.$bulan.'" and tahun="'.$tahun.'" and t_siswa_has_t_kelas_id="'.$kk->row('id').'"');
					}
					else
					{
						$kk=$this->db->query('select * from v_kelas_aktif where nis="'.$xx.'" and status_siswa_aktif="t" and st_aktif="t" and id_ajaran="'.$idajaran.'"');
						// $kk=$this->km->getKelasAktifByNIS($s,'t');
						if($xx==0)
						{
							$data['sis'][$xx]=$s;
							$data['t_siswa_nis']=$s;
							$idsiswa=$s;
						}
						else
						{
							// $kk=$this->km->getKelasAktifByNIS($xx,'all');
							$data['sis'][$xx]=$xx;
							$data['t_siswa_nis']=$xx;
							$idsiswa=$xx;
						}
						$data['kls'][$xx]=$kk->row('id');

						//echo 'id siswa : '.$xx.'<br>';
						// echo 'id kelas : '.$kk->row('id').'<br>';
						$idrutin = abs(crc32(md5(sha1(rand()))));
						$data['id']=$idrutin;
						$data['ket']='';
						$data['t_siswa_has_t_kelas_id']=$kk->row('id');
						$data['sudah_bayar']=$sudah=0;
						$data['jumlah_diskon']=0;
						$data['sisa_bayar']=$wajibbayar-$sudah;

						$cek=$this->db->query('select * from t_penerimaan_rutin where t_jenis_pembayaran_id="'.$idjenis.'" and t_siswa_nis="'.$idsiswa.'" and bulan="'.$bulan.'" and tahun="'.$tahun.'" and t_siswa_has_t_kelas_id="'.$kk->row('id').'"');
						$y=1;
					}

					if($cek->num_rows==0)
					{
						$this->pm->addpenerimaanrutin($data);
						$x=1;
					}
					else
					{
						$data['id']=$cek->row('id');
						$this->pm->updatepenerimaanrutin($data);
						$x=0;
						// echo 'Update';
					// echo '<pre>';
					// print_r($data);
					}

					// echo $x.'-'.$y.'-'.$kk->row('id').'<br>';

				}
				//echo '<hr>';
			}
			if($x==1)
				$this->session->set_flashdata('pesan','Data Penerimaan Rutin Berhasil Ditambahkan');
			else
				$this->session->set_flashdata('pesan','Data Penerimaan Rutin Berhasil Di Update');
			redirect('penerimaan/rutin/'.$idjenis,'location');
			//
		}
	}
	function hapusdatajemputan($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('t_penerimaan_rutin');
	}
	function getDataKewajiban($nis,$idkelas,$idjenis,$bulan)
	{
		$nis=str_replace('%20', ' ', $nis);
		$x=$this->pm->getDataKewajiban($nis,$idkelas,$idjenis,$bulan);
		$json = $x->result();
		$a=json_encode($json);
		echo str_replace(array('[',']'),'',$a);
		//echo $a;
	}

	function getDataPenerimaanRutin($bulan,$idjenis,$nis,$idkelasaktif)
	{
		$nis=str_replace('%20', ' ', $nis);
		$x=$this->pm->cekPenerimaanRutin($bulan,$idjenis,$nis,$idkelasaktif);
		$json = $x->result();
		$a=json_encode($json);
		echo str_replace(array('[',']'),'',$a);
	}

	function kwitansi()
	{
		//echo 'Kwitansi';
	}

	function editp($tahunajaran)
	{
		$kelas1=11045000;
		$kelas2=2650000;
		$kelas3=2685000;
		$kelas4=2685000;
		$kelas5=2685000;
		$kelas6=2975000;

		$ta=$this->db->query('select * from t_ajaran where tahunajaran="'.$tahunajaran.'"');
		$idta=$ta->row('id');
		$sq="select *,ts.id as idts,tk.id as idtk from t_siswa_has_t_kelas as ts
				inner join t_kelas as tk on (tk.id=ts.t_kelas_id)
				inner join t_siswa as s on (s.nis=ts.t_siswa_nis)
				where ts.status='t' and ts.status_siswa_aktif='t' and ts.t_ajaran_id='".$idta."'
				order by tk.id,s.nama";
		echo '<table border=1 cellpadding=4 cellspacing=0>';
		$q=$this->db->query($sq);
		foreach ($q->result() as $k => $v)
		{

				if($v->idtk==1)
				{
					$d['t_jenis_pembayaran_id']=3;
					$d['sisa']=$kelas1;
				}
				else
				{
					$d['t_jenis_pembayaran_id']=4;
					if($v->idtk==2)
						$d['sisa']=$kelas2;
					else if($v->idtk==3)
						$d['sisa']=$kelas3;
					else if($v->idtk==4)
						$d['sisa']=$kelas4;
					else if($v->idtk==5)
						$d['sisa']=$kelas5;
					else if($v->idtk==6)
						$d['sisa']=$kelas6;
				}

			$pemb=$this->db->query('select * from t_record_pembayaran_siswa where t_siswa_nis="'.$v->nis.'" and t_kelas_aktif_id="'.$v->idts.'"');
			if($pemb->num_rows!=0)
			{
				$pp=$pemb->row('sisa');
				// $this->db->query('update t_record_pembayaran_siswa set sudah_bayar=0, wajib_bayar="'.$d['sisa'].'", sisa="'.$d['sisa'].'" where id="'.$pemb->row('id').'"');
			}
			else
			{
				$pp=0;

				$d['sudah_bayar']=0;
				$d['wajib_bayar']=$d['sisa'];
				$d['id']=$v->idts;
				// $d['t_kelas_aktif_id']=$v->idts;
				$d['nis']=$v->nis;
				// $this->pm->createRecordPembayaran($d);
			}

			$rutin=$this->db->query('select * from t_penerimaan_rutin where t_siswa_nis="'.$v->nis.'" and t_siswa_has_t_kelas_id="'.$v->idts.'"');
			if($rutin->num_rows!=0)
			{
				$spp=$rutin->row('sisa_bayar');
				// $this->db->query('update t_penerimaan_rutin set sudah_bayar=0, wajib_bayar=375000, sisa_bayar=375000 where id="'.$rutin->row('id').'"');
			}
			else
			{
				$spp=-1;
				$d['t_jenis_pembayaran_id']=10;
				$d['sisa_bayar']=375000;

				$d['bulan']=7;
				$d['sudah_bayar']=0;
				$d['tahun']=date('Y');
				$d['ket']='';
				$d['wajib_bayar']=375000;
				$d['id']=abs(crc32(sha1(md5(rand()))));
				$d['t_siswa_has_t_kelas_id']=$v->idts;
				$d['t_siswa_nis']=$v->nis;
				// $this->pm->addpenerimaanrutin($d);
			}
			echo '<tr>';
				echo '<td>';
					echo ($k+1);

				echo '</td>';
				echo '<td>';
					echo $v->idts;
				echo '</td>';
				echo '<td>';
					echo $v->nis;
				echo '</td>';
				echo '<td>';
					echo $v->idtk.'-';
					echo $v->namakelas;
				echo '</td>';
				echo '<td>';
					echo $v->nama;
				echo '</td>';
				echo '<td style="text-align:right;">';
					echo number_format($pp);
				echo '</td>';
				echo '<td style="text-align:right;">';
					echo number_format($spp);
				echo '</td>';
			echo '</tr>';

		}
		echo '</table>';
	}

	function datautab($tahunajaran)
	{
		$ta=$this->db->query('select * from t_ajaran where tahunajaran="'.$tahunajaran.'"');
		$idta=$ta->row('id');
		$q="select * from t_record_pembayaran_siswa as tc
				inner join t_siswa as ts on (tc.t_siswa_nis=ts.nis)
				inner join t_siswa_has_t_kelas as tsk on (tsk.id=tc.t_kelas_aktif_id)
				where tsk.t_ajaran_id=".$idta."
					and tc.t_jenis_pembayaran_id=3
					and tsk.status='t'
					and tsk.status_siswa_aktif='t'
				order by ts.nis;";
		$qry=$this->db->query($q);

		echo '<table border=1 cellpadding=4 cellspacing=0 style="font-size:11px;">';
		foreach ($qry->result() as $k => $v)
		{
			echo '<tr>';
				echo '<td>'.($k+1).'</td>';
				echo '<td>'.$v->nis.'</td>';
				echo '<td>'.$v->nama.'</td>';
				echo '<td>'.rupiah($v->sisa).'</td>';
			echo '</tr>';
		}
		echo '</table>';


	}

	function penerimaanharian($tgl=null)
	{
		if($tgl==null)
		{
			$th=date('Y');
			$tg=date('Y-m-d');
		}
		else
		{
			list($t,$b,$th)=explode('-', $tgl);
			$tg=$th.'-'.$b.'-'.$t;
		}
		$data['tgl']=$tg;
		if($th>=2017)
		{
			$gr=$this->db->query('select tp.*,tp.jumlah as jlh,sum(tp.jumlah) as jumlah_2,tj.*
			from t_pembayaran as tp
			inner join t_jenis_pembayaran as tj on (tj.id=tp.t_jenis_pembayaran_id)
			where tp.tgl_transaksi like "%'.$tg.'%"
			group by tp.t_jenis_pembayaran_id,tp.t_siswa_has_t_kelas_id,tp.keterangan;');

		}
		else {
			# code...
			$gr=$this->db->query('select tp.*,tp.jumlah as jlh,sum(tp.jumlah) as jumlah_2,tj.*
			from t_pembayaran as tp
			inner join t_jenis_pembayaran as tj on (tj.id=tp.t_jenis_pembayaran_id)
			where tp.tgl_transaksi like "%'.$tg.'%" and (tp.keterangan!=7 or tp.t_jenis_pembayaran_id!=10 )
			group by tp.t_jenis_pembayaran_id,tp.t_siswa_has_t_kelas_id,tp.keterangan;');
		}
											// where tp.tgl_transaksi like "%'.$tg.'%" and (tp.keterangan!=7 or tp.t_jenis_pembayaran_id!=10 )

		$g='';
		$total=0;
		if($gr->num_rows!=0)
		{
			foreach ($gr->result() as $k => $v)
			{
				$dt[$v->jenis][]=$v->jumlah_2;
				// $total+=$v->total;
			}

			$total=0;
			foreach ($dt as $k => $v)
			{
				$jlh=array_sum($dt[$k]);
				$jenis[$k]=$jlh;
				// echo $k.'-'.$jlh.'<br>';
				$total+=$jlh;
				$g.='["'.$k.'", '.$jlh.'],';
			}

			// echo $total;

			// echo '<pre>';
			// print_r($dt);
			// echo '</pre>';
		}

		$data['g']=$g.'["Total",'.$total.']';

		$this->load->view('penerimaan/grafik',$data);
	}

	function hapusdatasiswadriver()
	{
		if(!empty($_POST))
		{
			$nis=$_POST['n'];
			$iddriver=$_POST['id'];
			$bln=$_POST['bl'];
			$thn=$_POST['th'];
			$cekdatapembayaran=$this->db->query('select * from t_penerimaan_rutin where t_jenis_pembayaran_id="13" and bulan="'.$bln.'" and tahun="'.$thn.'" and t_siswa_nis like "%'.$nis.'%"');
			if($cekdatapembayaran->num_rows!=0)
			{
				$this->db->query('delete from t_penerimaan_rutin where id="'.$cekdatapembayaran->row('id').'"');
			}
			$cekdatadaftar=$this->db->query('select * from t_driver_siswa where id_driver="'.$iddriver.'" and nis="'.$nis.'"');
			$this->db->query('update t_driver_siswa set biaya=1 where id="'.$cekdatadaftar->row('id').'"');
		}
	}
}
