<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Laporan extends A {

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

		$this->load->helper('fungsi_rupiah');
		if($this->session->userdata('logged')!='TRUE')
			redirect('login','location');
	}

	function tagihan()
	{
		$data['title']='Data Pembayaran Keuangan';
		$data['isi']='laporan/tagihan';
		$this->load->view('index',$data);
	}

	function perkelas()
	{
		$data['title']='Report Keuangan Per Kelas';
		$data['isi']='laporan/perkelas';
		$this->load->view('index',$data);
	}

	function persiswa()
	{
		$data['title']='Report Keuangan Per Siswa';
		$data['isi']='laporan/persiswa';
		$this->load->view('index',$data);
	}

	//---------------------------------
	function getDataPerSiswa($idkel,$nis=null)
	{
		//1476132073|2014-2015
		//02 1112 035
		$nis=str_replace('%20', ' ', $nis);
		$idk=str_replace('%7C', '|',$idkel);
		$idk=explode('|', $idk);
		$idkelas=$idk[0];
		$idajaran=$idk[1];
		echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:80%">
				<thead>
					<tr>
						<th style="text-align:center;">No</th>
						<th style="text-align:center;">Keterangan</th>
						<th style="text-align:center;width:100px;">Jumlah Yang Harus Dibayar</th>
						<th style="text-align:center;width:200px;">Pembayaran</th>
						<th style="text-align:center;width:100px;">Sisa Pembayaran</th>
					</tr>
				</thead>
				<tbody>';
			$jen=$this->pm->getJenisPembayaranByParent(1);
			foreach($jen->result() as $no=> $j)
			{
				$dis='';
				$disc=0;
				if($j->id==3 || $j->id==4)
				{
					$nn=$this->pm->getrecordpembayaranby_idkelasaktif_nis_idjenis($j->id,$nis,$idkelas);
					$vp=$this->pm->getpembayaranby_idkelasaktif_nis_idjenis($j->id,$nis,$idkelas);
					$c=$vp->result();
					//echo '<pre>';
					//print_r($c);
					$cekdiskon = $this->db->query('select * from t_diskon where id_kelas_aktif="'.$idkelas.'" and nis="'.$nis.'" and id_jenis_pembayaran="'.$j->id.'"');
					if($cekdiskon->num_rows!=0)
					{
						$jj=($nn->num_rows!=0 ? $nn->row('wajib_bayar') : 0);
						$dis .= '<span style="font-size:9px !important">diskon</span>&nbsp;&nbsp;&nbsp;';
						if($cekdiskon->row('satuan_diskon')=='%')
						{
							$dics = $jj * ($cekdiskon->row('jumlah_diskon') / 100);
							// $jlh_diskon = $jj - $dics;
							$dis.='-<span style="color:blue">'.rupiah($disc).'</span>';
							// $diskon=$dic
						}
						else if($cekdiskon->row('satuan_diskon')=='rp')
						{
							$disc = $cekdiskon->row('jumlah_diskon');
							$dis.='-<span style="color:blue">'.rupiah($disc).'</span>';
						}
					}

					$bayar='';
					$jj=0;
					for ($i=0; $i < count($c) ; $i++)
					{

						$bayar.='<div style="width:50%;float:left;">'.tgl_indo2($c[$i]->tgl_transaksi).'</div>';
						$bayar.='<div style="width:50%;float:right;">'.rupiah($c[$i]->jumlah).'</div>';
						$jj+=$c[$i]->jumlah;
					}
					if($jj!=0)
					{
						$bayar.='<div style="width:50%;float:left;font-weight:bold;border-top:1px dotted #eee;">Jumlah</div>';
						$bayar.='<div style="width:50%;float:right;font-weight:bold;border-top:1px dotted #eee;">'.rupiah($jj).'</div>';
					}
					echo '<tr>
						<td style="text-align:center;">'.($no+1).'</td>
						<td style="text-align:left;">'.($j->jenis).'</td>
						<td style="text-align:right;">'.(rupiah($nn->num_rows!=0 ? $nn->row('wajib_bayar') : 0)).'<br>'.$dis.'</td>
						<td style="text-align:right;">'.$bayar.'</td>
						<td style="text-align:right;">'.(rupiah($nn->num_rows!=0 ? ($nn->row('sisa')-$disc) : 0)).'</td>
					</tr>';
				}
			}

		echo '</tbody>
		</table>';

		echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
				<thead>
					<tr>
						<th style="text-align:center;width:70px;">Bulan</th>';

		foreach($jen->result() as $no=> $j)
		{
			if($j->id!=3 && $j->id!=4)
			{
				echo '<th style="text-align:center;width:20%;font-weight:bold">'.$j->jenis.'</th>';
			}
		}

		echo '</tr>
				</thead>
		<tbody>';


		//$ta=$this->km->getTahunAjaranById($idajaran);
		$aj=explode('-', $idajaran);
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
			echo '<tr>
				<td>'.getBulan($c).' '.$y.'</td>';

				foreach($jen->result() as $no=> $jj)
				{
					if($jj->id!=3 && $jj->id!=4)
					{
						$nn=$this->pm->cekPenerimaanRutin($c,$jj->id,$nis,$idkelas,$y);
						// if($jj->id==13)
						// 	$by=$this->pm->getpembayaranby_idkelasaktif_nis_idjenis_bulan_tahun($jj->id,$nis,$idkelas,$c,200);
						// else
						$by=$this->pm->getpembayaranby_idkelasaktif_nis_idjenis_bulan_tahun($jj->id,$nis,$idkelas,$c,$y);
						$byr=$by->result();
						// echo $j->id.'-'.$nis.'-'.$idkelas.'<br>';
						$tgl_byr='';
						$jlh_byr=0;
						for ($j=0; $j < count($byr); $j++)
						{
							$tgl_byr.='<div style="width:50%;float:left;">'.tgl_indo2($byr[$j]->tgl_transaksi).'</div>';
							$tgl_byr.='<div style="width:50%;float:right;">'.rupiah($byr[$j]->jumlah).'</div>';
							$jlh_byr+=$byr[$j]->jumlah;
						}

						if($jlh_byr!=0)
						{
							$tgl_byr.='<div style="width:50%;float:left;font-weight:bold;border-top:1px dotted #eee;">Jumlah</div>';
							$tgl_byr.='<div style="width:50%;float:right;font-weight:bold;border-top:1px dotted #eee;">'.rupiah($jlh_byr).'</div>';
						}
						else
						{
							$tgl_byr.='<div style="width:50%;float:left;color:red;text-align:right">'.($nn->num_rows!=0 ? 'Kewajiban ' : '').'</div>';
							$tgl_byr.='<div style="width:50%;float:right;color:red">'.(rupiah($nn->num_rows!=0 ? $nn->row('wajib_bayar') : 0)).'</div>';
							$njen=strtolower($jj->jenis);
							${"$njen"}[]=($nn->num_rows!=0 ? $nn->row('wajib_bayar') : 0);
						}
						echo '<td style="text-align:right;width:18%">';
						//print_r($byr);
						echo $tgl_byr;
						echo '</td>';
					}
				}

			echo '</tr>';
		}
			echo '<tr>';
			echo '<td style="text-align:right">Jumlah Kewajiban</td>';
			foreach($jen->result() as $no=> $j)
			{
				if($j->id!=3 && $j->id!=4)
				{
					$njen=strtolower($j->jenis);
					if(isset(${"$njen"}))
					{

						echo '<th style="text-align:right;width:20%;font-weight:bold">'.rupiah(array_sum(${"$njen"})).'</th>';
					}
					else
						echo '<th style="text-align:right;width:20%;font-weight:bold">-</th>';

				}
			}
			echo '</tr>';

		echo '</tbody></table>';
	}

	function getDataPerKelas($idkelas,$idajaran,$namakelasaktif,$idjenis)
	{
		$namakelasaktif=str_replace('%20', ' ', $namakelasaktif);
		$siswa=$this->km->getSiswaByNamaKelas($idkelas,$namakelasaktif,$idajaran,'t');

		$ta=$this->km->getTahunAjaranById($idajaran);
		$aj=explode('-', $ta->row('tahunajaran'));

		if($idjenis!=3 && $idjenis!=4 && $idjenis!=9)
		{
			echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
					<thead>
						<tr>
							<th style="text-align:center;font-size:11px;" rowspan="2">No</th>
							<th style="text-align:center;font-size:11px;" rowspan="2">NIS</th>
							<th style="text-align:left;font-size:11px;" rowspan="2">Nama Siswa</th>
							<th style="text-align:center;font-size:11px;" colspan="12">Tahun '.$aj[0].'/'.$aj[1].' </th>
							<th style="text-align:left;font-size:11px;" rowspan="2">Total<br>Tagihan</th>
						</tr>
						<tr>';
						for($b=7;$b<=18;$b++)
						{
							if($b>12)
							{
								$c=$b-12;
								$y=substr($aj[1], -2,4);
							}
							else
							{
								$c=$b;
								$y=substr($aj[0], -2,4);
							}
							echo '<th>'.getBulanSingkat($c).'\''.$y.'</th>';
						}
			echo '</tr>
					</thead>
					<tbody>';
			$alltotal=0;
			foreach($siswa->result() as $no=> $s)
			{
				echo '<tr>
					<td style="font-size:11px;width:10px">'.($no+1).'</td>
					<td style="font-size:11px;width:70px">'.($s->nis_baru).'</td>
					<td style="font-size:11px;width:100px;">'.($s->nama).'</td>';




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
							echo '<td style="text-align:right;font-size:11px;">'.($jj).'</td>';

						}
						echo '<td style="text-align:right;font-size:11px;color:red">'.rupiah($totaltagihan).'</td>';

				echo '</tr>';

				$alltotal+=$totaltagihan;
			}
			echo '<tr>
				<th colspan="15" style="text-align:right;font-size:11px;">T O T A L</th>
				<th style="text-align:right;font-size:11px;"">'.rupiah($alltotal).'</th>
			</tr>';

			echo '</tbody></table>';
		}
		else if($idjenis==3 || $idjenis==4 || $idjenis==9)
		{
			//$idkelas,$idajaran
			$pemb=$this->pm->getJenisPembayaranByID($idjenis);
			$nis_sis=$disc=array();
			$alltotal=0;
			$gc=array();
			foreach($siswa->result() as $no=> $s)
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
			echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
					<thead>
						<tr>
							<th style="text-align:center;font-size:11px;" rowspan="2">No</th>
							<th style="text-align:center;font-size:11px;" rowspan="2">NIS</th>
							<th style="text-align:left;font-size:11px;" rowspan="2">Nama Siswa</th>
							<th style="text-align:left;font-size:11px;" rowspan="2">'.$pemb->row('jenis').'</th>
							<th style="text-align:left;font-size:11px;" colspan="'.$max.'">Pembayaran</th>
							<th style="text-align:center;font-size:11px;" rowspan="2">Sisa Pembayaran</th>

						</tr>
						<tr>';
						for($xi=1;$xi<=$max;$xi++)
						{
							echo '<th style="text-align:center;font-size:11px;">Tahap '.($xi).'</th>';
						}

			echo '</tr>
					</thead>
					<tbody>';

			$no=1;
			foreach ($data as $key => $value)
			{
				$ss=explode('|', $value[$idjenis]);
				echo '<tr>';
				echo '<td style="text-align:center;font-size:11px;">'.($no).'</td>';
				echo '<td style="text-align:left;font-size:11px;">'.($nis_sis[$key]).'</td>';
				echo '<td style="text-align:left;font-size:11px;">'.($ss[0]).'</td>';
				echo '<td style="text-align:right;font-size:11px;">'.rupiah($ss[1]).'</td>';

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


					echo '<td style="text-align:right;font-size:11px;">'.$tgl.'<br><b>'.rupiah($jlh).'</b></td>';
				}
				$alltotal+=$ss[2];
				echo '<td style="text-align:right;font-size:11px;">'.rupiah($ss[2]).'</td>';
				echo '</tr>';
				$no++;
				// echo '<pre>';
				// print_r($disc);
				// echo '</pre>';
			}
			echo '<tr>
				<th colspan="'.($max+4).'" style="text-align:right;font-size:11px;">T O T A L</th>
				<th style="text-align:right;font-size:11px;"">'.rupiah($alltotal).'</th>
			</tr>';

			echo '</tbody>';
			echo '</html>';
		}
	}
	//---------------------------------------------------------------------------------
	function jurnal($date=null)
	{
		if($date==null)
			$date=date('Y-m-d');


		$data['date']=$date;
		$data['title']='Jurnal';
		$data['isi']='laporan/jurnal';
		$this->load->view('index',$data);
	}

	function datajurnal($jenis,$date=null)
	{
		if($date==null)
		{
			if($jenis=='harian')
				$date=date('Y-m-d');
			else
				$date==date('Y-m');
		}

		$data['jenis']=$jenis;
		$data['date']=$date;
		$data['title']='Jurnal '.ucwords($jenis).'';
		$data['isi']='laporan/datajurnal';
		$this->load->view('index',$data);
	}

	function isijurnal($jenis,$date)
	{
		list($jns,$ket)=explode('-', $jenis);
		$data['jenis']=$jns;

		// $data['tr']=$tr=$this->lm->getTransaksiJurnal($date)->result();

		if($jns=='harian')
		{
			$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where tgl_transaksi like "%'.$date.'%" and status_siswa_aktif="t" group by idjenis,tgl_transaksi,nama,keterangan order by nama')->result();

			if($ket=='tabungan')
			{
				$data['tr']=$tr=$this->db->query('select * from t_tabungan as tt inner join t_tabungan_detail as tb on (tt.id=tb.id_tab) where tt.nama_siswa not like "%infaq%"')->result();
			}

			if($ket!='all')
				$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where tgl_transaksi like "%'.$date.'%" and status_siswa_aktif="t" and idjenis="'.$ket.'" group by idjenis,tgl_transaksi,nama,keterangan order by nama')->result();

		}
		else
		{
			list($thn,$bln)=explode('-', $date);
			$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where month(tgl_transaksi)='.$bln.' and year(tgl_transaksi)='.$thn.' and status_siswa_aktif="t" group by idjenis,tgl_transaksi,nama,keterangan order by tgl_transaksi,nama')->result();

			if($ket!='all')
				$data['tr']=$tr=$this->db->query('select *,sum(jumlah) as jumlah_2 from v_pembayaran where month(tgl_transaksi)='.$bln.' and year(tgl_transaksi)='.$thn.' and idjenis="'.$ket.'" and status_siswa_aktif="t" group by idjenis,tgl_transaksi,nama,keterangan order by tgl_transaksi,nama')->result();

		}

		$j=count($tr);

		$k=array();

		for($t=0;$t<$j;$t++)
		{
			$k[$tr[$t]->nis][]=$tr[$t];
		}
		// echo '<pre>';
		// print_r($k);
		// echo '</pre>';
		$trr=$k;
		?>
					<table class="table table-striped table-bordered bootstrap-datatable">
							<thead>
								<tr>
									<th style="width:30px;text-align:center">No</th>
									<th style="width:130px;text-align:center">Tanggal</th>
									<th>Transaksi</th>
									<th>Nama Siswa / Kelas</th>
									<th>Jumlah</th>
									<th style="width:150px;">Status</th>
									<th style="width:150px;">Action</th>
								</tr>
							</thead>
							<?
								$k=count($trr);
								$jlhhh=0;
								if($k!=0)
								{
									$no=1;
									foreach($trr as $i =>$v)
									{
										// if($v[0]->idjenis!=10 && $v[0]->keterangan!='7')
										// {
											echo '<tr>';
											echo '<td style="text-align:center">'.($no).'</td>';
											echo '<td style="text-align:center">'.(tgl_indo($v[0]->tgl_transaksi)).'</td>';
											echo '<td style="text-align:left">Penerimaan Pembayaran :<br>';
											$c=count($v);
											$jlh='&nbsp;<br>';
											for($j=0;$j<$c;$j++)
											{
												// if($v[$j]->keterangan!=7 || $v[$j]->idjenis!=10)
												// {
													if($v[$j]->keterangan!=0)
														$bb=' -- Bulan : '.getBulan($v[$j]->keterangan).' '.$v[$j]->thn.'';
													else
														$bb=' '.$v[$j]->thn.'';

													echo '<div style="padding-left:20px;">
														<i class="icon icon-trash icon-color" style="cursor:pointer;display:none;" id="hapussatu" onclick="hapussatu(\''.$v[$j]->idjenis.'\',\''.$v[$j]->idp.'\',\''.$v[$j]->idkelasaktif.'\',\''.str_replace(' ', '%20', $v[$j]->nis).'\',\''.strtok($v[$j]->tgl_transaksi, ' ').'\')"></i>
														<i class="icon icon-edit icon-color" style="cursor:pointer;display:none;" id="editsatu" onclick="editsatu(\''.$v[$j]->idjenis.'\',\''.$v[$j]->idp.'\',\''.$v[$j]->idkelasaktif.'\',\''.str_replace(' ', '%20', $v[$j]->nis).'\',\''.strtok($v[$j]->tgl_transaksi, ' ').'\')"></i>
														'.$v[$j]->jenis.$bb.'

														</div>';
													$jlh.='<div style="text-align:right;">'.number_format($v[$j]->jumlah_2).'</div>';

													$jlhhh+=$v[$j]->jumlah_2;
												}
											// }
											echo '</td>';
											echo '<td style="text-align:left">'.$v[0]->nama.'<br>Kelas '.$v[0]->t_kelas_id.'</td>';
											echo '<td style="text-align:right">'.$jlh.'</td>';

											if($v[0]->status_pembayaran==='sudah')
												$st='<span class="label label-success"><i class="icon-ok icon-white"></i> Sudah Diverifikasi</span>';
											else
												$st='<span class="label label-important"><i class="icon-remove icon-white"></i> Belum Diverifikasi</span>';

											echo '<td style="text-align:center">'.$st.'</td>';
											echo '<td style="text-align:center">
												<button type="button" class="btn btn-danger" onclick="hapus(\''.$v[0]->tgl_transaksi.'\',\''.$v[0]->idjenis.'\',\''.$v[0]->idkelasaktif.'\',\''.addslashes($v[0]->nama).'\')">
													<i class="icon-white icon-trash"></i>
												</button>';

											if($v[0]->status_pembayaran=='sudah')
											{
												echo '<button type="button" class="btn btn-primary" onclick="verifikasi(\''.$v[0]->tgl_transaksi.'\',\''.$v[0]->idjenis.'\',\''.$v[0]->idkelasaktif.'\',\''.addslashes($v[0]->nama).'\',\'f\')">
													<i class="icon-white icon-remove"></i>
												</button>';
											}
											else
											{
												echo '<button type="button" class="btn btn-success" onclick="verifikasi(\''.$v[0]->tgl_transaksi.'\',\''.$v[0]->idjenis.'\',\''.$v[0]->idkelasaktif.'\',\''.addslashes($v[0]->nama).'\',\'sudah\')">
													<i class="icon-white icon-ok"></i>
												</button>';
											}

											echo '</td>';
											echo '</tr>';
											$no++;
										// }
									}
								}
							?>
							</tbody>
							<thead>
								<tr>
									<th style="width:30px;text-align:right" colspan="4">Total Penerimaan Harian</th>
									<th style="text-align:right"><?=rupiah($jlhhh)?></th>
									<th style="width:150px;"></th>
									<th style="width:150px;"></th>
								</tr>
							</thead>
						</table>
						<script type="text/javascript">
							$(document).keypress(function(e){
								// alert(e.which);

								if(e.which==100)
								{
									$('i#hapussatu').each(function(ii){
										$(this).css({'display':'block','float':'left'});
									});
								}
								if(e.which==101)
								{
									$('i#editsatu').each(function(ii){
										$(this).css({'display':'block','float':'left'});
									});
								}
							});
							function hapussatu(idj,idp,idka,n,tanggal)
							{
								$.ajax({
									url : '<?=site_url()?>laporan/hapussatu',
									data : {idjenis : idj, idtr:idp, idkelasaktif:idka,nis:n,tgl:tanggal},
									type : 'POST',
									success : function(a)
									{
										// alert(a);
										$('#isijurnal').load('<?=site_url()?>laporan/isijurnal/<?=$jenis?>/<?=$date?>');
									}

								});
							}

							function editsatu(idj,idp,idka,n,tanggal)
							{
								// idjenis : idj, idtr:idp, idkelasaktif:idka,nis:n,tgl:tanggal},
								// $('#isijurnal').load('<?=site_url()?>laporan/isijurnal/<?=$jenis?>/<?=$date?>');
								$('#modalEdit').modal();
								$('#isibody').load('<?=site_url()?>laporan/datatransaksi/'+idj+'/'+idp+'/'+idka+'/'+n+'/'+tanggal+'/<?=$jenis?>/<?=$date?>',function(){
										$( "input#tglbaru" ).datepicker({
												showOn: "button",
												buttonImage: "<?=base_url()?>media/img/calendar146.png",
												buttonImageOnly: true,
												dateFormat:'yy-mm-dd',
												changeMonth: true,
												changeYear: true,
												onClose: function( selectedDate )
												{

										    	}
										});
								});
							}
						</script>
	<?
	}
	function datatransaksi($idj,$idp,$idka,$n,$tanggal,$jenis,$date)
	{
		// echo $idj.'<br>';
		// echo $idp.'<br>';
		// echo $idka.'<br>';
		// echo $n.'<br>';
		// echo $tanggal.'<br>';
		$nis=str_replace('%20', ' ', $n);
		$d=$this->db->query('select * from t_pembayaran where id="'.$idp.'"');
	?>
	<form action="<?=site_url()?>laporan/simpaneditransaksi" method="POST" class="form-horizontal" id="simpaneditransaksi">
		<div class="control-group">
			<label class="control-label" for="typeahead">Tanggal Transaksi Awal</label>
			<div class="controls">
				<input type="text" name="tglawal" class="span2 typeahead" readonly id="nis" style="width:40%;" value="<?=$tanggal?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="typeahead">Tanggal Transaksi Edit</label>
			<div class="controls">
				<input type="text" name="tglbaru" class="span6 typeahead" id="tglbaru" style="width:40%;float:left" value="">
			</div>
		</div>
		<input type="hidden" name="jenis" value="<?=$jenis?>">
		<input type="hidden" name="date" value="<?=$date?>">
		<input type="hidden" name="idj" value="<?=$idj?>">
		<input type="hidden" name="idp" value="<?=$idp?>">
		<input type="hidden" name="idka" value="<?=$idka?>">
		<input type="hidden" name="n" value="<?=$nis?>">
		<input type="hidden" name="tanggal" value="<?=$tanggal?>">
	</form>

	<?
	}
	function simpaneditransaksi()
	{
		if(!empty($_POST))
		{
			$this->db->query('update t_pembayaran set tgl_transaksi="'.$_POST['tglbaru'].'" where id="'.$_POST['idp'].'"');
			echo $_POST['jenis'].'--'.$_POST['date'];
		}
	}
	function hapussatu()
	{
		$idjenis=$_POST['idjenis'];
		$idtr=$_POST['idtr'];
		$idkelasaktif=$_POST['idkelasaktif'];
		$nis=str_replace('%20', ' ', $_POST['nis']);
		$tgl=$_POST['tgl'];
		// echo $idjenis.'--'.$idtr.'--'.$idkelasaktif.'--'.$nis.'--'.$tgl;
		// $idjenis=$_POST['idjenis'];
		$cekpembayaran=$this->db->query('select * from t_pembayaran where t_siswa_has_t_kelas_id="'.$idkelasaktif.'" and tgl_transaksi like "%'.$tgl.'%" and t_jenis_pembayaran_id="'.$idjenis.'"');

		$ygdibayar=0;
		if($cekpembayaran->num_rows!=0)
		{
			$ygdibayar=$cekpembayaran->row('jumlah');
			$bulan=$cekpembayaran->row('keterangan');
			$this->db->query('delete from t_pembayaran where id="'.$cekpembayaran->row('id').'"');


			$cekrutin = $this->db->query('select * from t_penerimaan_rutin where t_siswa_nis="'.$nis.'" and t_siswa_has_t_kelas_id="'.$idkelasaktif.'" and t_jenis_pembayaran_id="'.$idjenis.'" and bulan="'.$bulan.'"');

			if($cekrutin->num_rows!=0)
			{
				// $sudah_bayar=$cekrutin->row('wajib_bayar')-$cekrutin->row('sudah_bayar');
				$sudah_bayar=0;
				// $sisa_bayar=$cekrutin->row('wajib_bayar')-$cekrutin->row('sisa_bayar');
				$sisa_bayar=$cekrutin->row('wajib_bayar');
				$this->db->query('update t_penerimaan_rutin set sisa_bayar="'.$sisa_bayar.'", sudah_bayar="'.$sudah_bayar.'" where id="'.$cekrutin->row('id').'"');
			}

			$cekrecord = $this->db->query('select * from t_record_pembayaran_siswa where t_siswa_nis="'.$nis.'" and t_kelas_aktif_id="'.$idkelasaktif.'" and t_jenis_pembayaran_id="'.$idjenis.'"');
			if($cekrecord->num_rows!=0)
			{
				// $sisa=$cekrecord->row('wajib_bayar')-$cekrecord->row('sisa');
				$sisa=$cekrecord->row('wajib_bayar');
				// $sudah_bayar=$cekrecord->row('wajib_bayar')-$cekrecord->row('sudah_bayar');
				$sudah_bayar=0;
				$this->db->query('update t_record_pembayaran_siswa set sudah_bayar="'.$sudah_bayar.'", sisa="'.$sisa.'" where id="'.$cekrecord->row('id').'"');
			}
		}
		// echo $idjenis.'-'.$idtr.'-'.$idkelasaktif.'-'.$nis;
	}
	function exportjurnalharian($jenis,$date)
	{
		list($jns,$ket)=explode('-', $jenis);
		$data['jenis']=$jns;
		// $data['tr']=$tr=$this->lm->getTransaksiJurnal($date)->result();
		$data['tr']=$tr=$this->db->query('select * from v_pembayaran where tgl_transaksi like "%'.$date.'%" group by idjenis,tgl_transaksi,nama,keterangan')->result();

		if($ket!='all')
			$data['tr']=$tr=$this->db->query('select * from v_pembayaran where tgl_transaksi like "%'.$date.'%" and idjenis="'.$ket.'" group by idjenis,tgl_transaksi,nama,keterangan')->result();

		$j=count($tr);

		$k=array();

		for($t=0;$t<$j;$t++)
		{
			$k[$tr[$t]->nis][]=$tr[$t];
		}
		$trr=$k;
		$data['date']=$date;
		?>
					<table class="table table-striped table-bordered bootstrap-datatable">
							<thead>
								<tr>
									<th style="width:30px;text-align:center">No</th>
									<th style="width:130px;text-align:center">Tanggal</th>
									<th>Transaksi</th>
									<th>Nama Siswa / Kelas</th>
									<th>Jumlah</th>
									<th style="width:150px;">Status</th>
									<th style="width:150px;">Action</th>
								</tr>
							</thead>
							<?
								$k=count($trr);
								$jlhhh=0;
								if($k!=0)
								{
									$no=1;
									foreach($trr as $i =>$v)
									{
										// if($v[0]->idjenis!=10 && $v[0]->keterangan!='7')
										// {
											echo '<tr>';
											echo '<td style="text-align:center">'.($no).'</td>';
											echo '<td style="text-align:center">'.(tgl_indo($v[0]->tgl_transaksi)).'</td>';
											echo '<td style="text-align:left">Penerimaan Pembayaran :<br>';
											$c=count($v);
											$jlh='&nbsp;<br>';
											for($j=0;$j<$c;$j++)
											{
												if($v[$j]->keterangan!=7 || $v[$j]->idjenis!=10)
												{
													if($v[$j]->keterangan!=0)
														$bb=' -- Bulan : '.getBulan($v[$j]->keterangan).' '.$v[$j]->thn.'';
													else
														$bb=' '.$v[$j]->thn.'';

													echo '<div style="padding-left:20px;">'.$v[$j]->jenis.$bb.'</div>';
													$jlh.='<div style="text-align:right;">'.number_format($v[$j]->jumlah).'</div>';

													$jlhhh+=$v[$j]->jumlah;
												}
											}
											echo '</td>';
											echo '<td style="text-align:left">'.$v[0]->nama.'<br>Kelas  '.$v[0]->t_kelas_id.'</td>';
											echo '<td style="text-align:right">'.$jlh.'</td>';

											if($v[0]->status_pembayaran==='sudah')
												$st='<span class="label label-success"><i class="icon-ok icon-white"></i> Sudah Diverifikasi</span>';
											else
												$st='<span class="label label-important"><i class="icon-remove icon-white"></i> Belum Diverifikasi</span>';

											echo '<td style="text-align:center">'.$st.'</td>';
											echo '<td style="text-align:center">
												<button type="button" class="btn btn-danger" onclick="hapus(\''.$v[0]->tgl_transaksi.'\',\''.$v[0]->idjenis.'\',\''.$v[0]->idkelasaktif.'\',\''.$v[0]->nama.'\')">
													<i class="icon-white icon-trash"></i>
												</button>';

											if($v[0]->status_pembayaran=='sudah')
											{
												echo '<button type="button" class="btn btn-primary" onclick="verifikasi(\''.$v[0]->tgl_transaksi.'\',\''.$v[0]->idjenis.'\',\''.$v[0]->idkelasaktif.'\',\''.$v[0]->nama.'\',\'f\')">
													<i class="icon-white icon-remove"></i>
												</button>';
											}
											else
											{
												echo '<button type="button" class="btn btn-success" onclick="verifikasi(\''.$v[0]->tgl_transaksi.'\',\''.$v[0]->idjenis.'\',\''.$v[0]->idkelasaktif.'\',\''.$v[0]->nama.'\',\'sudah\')">
													<i class="icon-white icon-ok"></i>
												</button>';
											}

											echo '</td>';
											echo '</tr>';
											$no++;
										// }
									}
								}
							?>
							</tbody>
							<thead>
								<tr>
									<th style="width:30px;text-align:right" colspan="4">Total Penerimaan Harian</th>
									<th style="text-align:right"><?=rupiah($jlhhh)?></th>
									<th style="width:150px;"></th>
									<th style="width:150px;"></th>
								</tr>
							</thead>
						</table>
	<?
	}

	function verifikasipembayaran($tgl,$idjenis,$idkelasaktif,$nama,$status)
	{
		$tgl=str_replace('%20', ' ', $tgl);
		list($dt,$wk)=explode(' ', $tgl);
		$nama=str_replace('%20', ' ', $nama);

		if($status=='sudah')
			$st='sudah';
		else
			$st='';
		// $x=$this->db->query('select * from t_pembayaran where t_jenis_pembayaran_id="'.$idjenis.'" and t_siswa_has_t_kelas_id="'.$idkelasaktif.'" and tgl_transaksi like "%'.$tgl.'%"');
		$this->db->query('update t_pembayaran set status_pembayaran="'.$st.'" where t_jenis_pembayaran_id="'.$idjenis.'" and t_siswa_has_t_kelas_id="'.$idkelasaktif.'" and tgl_transaksi like "%'.$tgl.'%"');

		$this->session->set_flashdata('tanggal',$dt);

		redirect('laporan/datajurnal/harian','redirect');
		// echo $x->num_rows;
	}

	//-----------------------------
	function tagihansms()
	{
		$data['title']='Data Tagihan';
		$data['isi']='laporan/sms-index';
		$this->load->view('index',$data);
	}

	function datasms($kelasid=null,$bulan=null,$tahun=null)
	{
		$data['idkelas']=$kelasid;
		$data['bulan']=$bulan;
		$data['tahun']=$tahun;
		if($bulan>=1 && $bulan<=6)
		{
			$ta=($tahun-1).'-'.$tahun;
		}
		else
			$ta=$tahun.'-'.($tahun+1);

		$dk=$this->db->from('v_kelas_aktif')->where('idkelas',$kelasid)->where('st_aktif','t')->where('status_siswa_aktif','t')->where('tahunajaran',$ta)->order_by('nis','asc')->get();
		$this->load->view('laporan/sms-data',$data);
	}
}
