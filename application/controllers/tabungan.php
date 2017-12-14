<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Tabungan extends A {

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
		$data['title']='Tabungan Siswa';
		$data['isi']='tabungan/index';
		$tab=$this->db->from('t_tabungan')->order_by('last_update','asc')->get();
		$datatab=$jumlah=$dd=array();
		foreach ($tab->result() as $k => $v) 
		{
			if($v->nama_siswa=='tablain')
			{
				$datatab[$v->kelas]['tablain'][]=$v;
				$jumlah[$v->kelas]['tablain'][]=$v->saldo;
			}
			else if($v->nama_siswa=='infaq')
			{
				$datatab[$v->kelas]['infaq'][]=$v;
				$jumlah[$v->kelas]['infaq'][]=$v->saldo;
			}
			else
			{
				$datatab[$v->kelas]['harian'][]=$v;
				$jumlah[$v->kelas]['harian'][]=$v->saldo;
			}
			$dd[$v->kelas]=$v;
		}
		$data['datatab']=$datatab;
		$data['jumlah']=$jumlah;
		$data['dd']=$dd;
		$this->load->view('index',$data);
	}

	function jenis($jenis=null,$val=null)
	{
		$val=str_replace('%20', ' ', $val);
		if($val!=0)
		{
			list($id,$ta,$wk,$namakelas)=explode('__', $val);

			if($jenis==1)
			{
				echo '<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
				  <label class="control-label" for="typeahead">Total Tabungan</label>
				  <div class="controls">
					<input type="text" name="total" id="total" value=0 style="text-align:right;font-weight:bold;font-size:13px !important" readonly>
				  </div>
				</div>';
				$sis=$this->db->from('t_pembagian_siswa')->where('id_pembagian',$id)->where('status','t')->get();
				foreach ($sis->result() as $k => $v) 
				{
					$namasiswa=str_replace(array('-','\'','.',','), ' ', $v->nama_siswa);
					echo '<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
						  <label class="control-label" for="typeahead" style="font-size:10px !important;width:200px !important">'.$v->nama_siswa.'</label>
						  <div class="controls">

								<input type="text" name="jumlah['.$v->id_siswa.'__'.$namasiswa.']" class="jlhtab" id="jlh_'.$v->id.'" value=0 style="text-align:right;width:150px !important;margin-left:20px !important" onkeyup="formatuang('.$v->id.','.$jenis.')">	
						  </div>
						</div>';		
				}
			}
			else if($jenis==2 || $jenis==3)
			{
				echo '<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
				  <label class="control-label" for="typeahead">Jumlah Tabungan</label>
				  <div class="controls">
						<input type="text" name="jumlah[0]" value=0 style="text-align:right" id="jenis_'.$jenis.'" onkeyup="formatuang('.$jenis.','.$jenis.')">	
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
				  <label class="control-label" for="typeahead">Penyetor</label>
				  <div class="controls">
						<input type="text" name="penyetor" value="'.$wk.'" >	
				  </div>
				</div>';
			}
		}
	}

	function prosestabungan($idd_idtab=null)
	{
		if(!empty($_POST))
		{
			// $
			if($idd_idtab==null)
			{
				$kel=str_replace('%20', ' ', $_POST['kelas']);
				list($idp,$ta,$wk,$namakelas)=explode('__', $kel);
				
				$dd['tarik_setor']=$_POST['jenis_transaksi'];

				if($_POST['jenistabungan']==1)
				{
					$dd['keterangan']='';
					$jn='';
				}
				else if($_POST['jenistabungan']==2)
				{
					$dd['keterangan']='Di Setor oleh '.$_POST['penyetor'];
					$jn='tablain';
				}
				else if($_POST['jenistabungan']==3)
				{
					$dd['keterangan']='Di Setor Infaq oleh '.$_POST['penyetor'];
					$jn='infaq';
				}	
					
				
				foreach ($_POST['jumlah'] as $k => $v) 
				{
					if($v!=0)
					{
						$dd['nokwitansi']=$_POST['jenistabungan'].'-'.date('Ymd').$idp.'-'.substr(generate_id(), 0,4);
						if($k==0)
						{
							$cektab=$this->db->from('t_tabungan')->where('nama_siswa',$jn)->where('tahun_ajaran',$ta)->where('kelas',$idp.'__'.$namakelas)->get();
							if($cektab->num_rows==0)
							{
								$d['id']=$id=generate_id();
								$d['nama_siswa']=$jn;
								$d['kelas']=$idp.'__'.$namakelas;
								$d['tahun_ajaran']=$ta;
								$d['tanggal_transaksi']=$_POST['tgl_transaksi'];
								$d['penerima']=$this->session->userdata('nama');
								$d['saldo']=str_replace(',', '', $v);
								$d['last_update']=date('Y-m-d H:i:s');
								$d['keterangan']=$dd['keterangan'];
								$this->db->insert('t_tabungan',$d);
							}
							else
							{
								$id=$cektab->row('id');
								$ud['saldo']=$cektab->row('saldo') + str_replace(',', '', $v);
								$ud['last_update']=date('Y-m-d H:i:s');
								$this->db->where('id',$id);
								$this->db->update('t_tabungan',$ud);
							}

							$dd['jumlah']=str_replace(',', '', $v);
							$dd['id_tab']=$id;
							$dd['id_d']=generate_id();
							$dd['tgl_transaksi']=$_POST['tgl_transaksi'];
							$dd['petugas']=$this->session->userdata('nama');
							$this->db->insert('t_tabungan_detail',$dd);

							echo  $dd['id_d'];
						}
						else
						{
							list($nis,$namasiswa)=explode('__', $k);					

							$cektab=$this->db->from('t_tabungan')->where('nis',$nis)->where('tahun_ajaran',$ta)->where('kelas',$idp.'__'.$namakelas)->get();
							if($cektab->num_rows==0)
							{
								$d['id']=$id=generate_id();
								$d['nama_siswa']=$namasiswa;
								$d['nis']=$nis;
								$d['kelas']=$idp.'__'.$namakelas;
								$d['tahun_ajaran']=$ta;
								$d['tanggal_transaksi']=$_POST['tgl_transaksi'];
								$d['penerima']=$this->session->userdata('nama');
								$d['saldo']=str_replace(',', '', $v);
								$d['last_update']=date('Y-m-d H:i:s');
								$d['keterangan']=$dd['keterangan'];
								$this->db->insert('t_tabungan',$d);
							}
							else
							{
								$id=$cektab->row('id');
								$ud['saldo']=$cektab->row('saldo') + str_replace(',', '', $v);
								$ud['last_update']=date('Y-m-d H:i:s');
								$this->db->where('id',$id);
								$this->db->update('t_tabungan',$ud);
							}


							$dd['jumlah']=str_replace(',', '', $v);
							$dd['id_tab']=$id;
							$dd['id_d']=generate_id();
							$dd['tgl_transaksi']=$_POST['tgl_transaksi'].' '.date('H:i:s');
							$dd['petugas']=$this->session->userdata('nama');
							$this->db->insert('t_tabungan_detail',$dd);
							// echo '<pre>';
							// print_r($dd);
							// echo '</pre>';
							echo 'harian';
						}
					}
				}
				$this->session->set_flashdata('pesan','Data Tabungan '.$namakelas.' Berhasil Ditambah');
			}
			else
			{

				// echo '<pre>';
				// print_r($_POST);
				// echo '</pre>';
				$nama_siswa=$_POST['nama_siswa'];
				$jlh_sebelum=$_POST['jumlahsebelum'];
				
				unset($_POST['nama_siswa']);
				unset($_POST['kelas']);
				unset($_POST['jenistabungan']);
				unset($_POST['jumlahsebelum']);

				list($idd,$idtab)=explode('-', $idd_idtab);
				$this->db->set('saldo','(saldo - '.$jlh_sebelum.') + '.$_POST['jumlah'].'',false);
				$this->db->where('id',$idtab);
				$this->db->update('t_tabungan');

				$this->db->where('id_d',$idd);
				$this->db->update('t_tabungan_detail',$_POST);
				$this->session->set_flashdata('pesan','Data Tabungan '.$nama_siswa.' Berhasil DiEdit');
				/*
				    [tgl_transaksi] => 2016-08-01
				    [jumlah] => 5000
				    [tarik_setor] => setor
				*/
			}
			// redirect('tabungan','location');
			// $d['nama_siswa']=generate_id();

		}
	}

	function detailtabungan($idkelas,$jenis,$tgl=0)
	{
		// echo $idkelas.'-'.$je/nis;
		list($idk,$namakelas)=explode('__', $idkelas);
		$namakelas=str_replace('%20', ' ', $namakelas);
		$nm=str_replace('%20', ' ', $idkelas);
		$namakelas=str_replace('_', ' : ', $namakelas);
		if($tgl==0)
			echo '<legend>'.$namakelas.'</legend>';
		else
			echo '<legend>'.$namakelas.'  <small>Tanggal : '.tgl_indo($tgl).'</small></legend>';
		if($tgl==0)
			$data=$this->db->select('*')->from('t_tabungan')->join('t_tabungan_detail','t_tabungan_detail.id_tab=t_tabungan.id')->order_by('t_tabungan_detail.tgl_transaksi','asc')->get();
		else	
			$data=$this->db->select('*')->from('t_tabungan')->join('t_tabungan_detail','t_tabungan_detail.id_tab=t_tabungan.id')->like('t_tabungan_detail.tgl_transaksi',$tgl)->order_by('t_tabungan_detail.tgl_transaksi','asc')->get();
		
		$dt=$jlh=array();
		foreach ($data->result() as $kd => $vd) 
		{
			// $kl=str_replace('__', '|', $vd->kelas);
			// $kl=strtok($kl,'_');
			// $kl=str_replace('|', '__', $kl);
			$dt[$vd->kelas][$vd->nama_siswa][]=$vd;
			$jlh[$vd->kelas][$vd->nama_siswa][]=$vd->saldo;
		}
		// echo '<pre>';
		// print_r($dt);
		// echo '</pre>';
		
		if($jenis=='harian')
		{
			$sis=$this->db->from('t_pembagian_siswa')->where('id_pembagian',$idk)->where('status','t')->get();
			echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">';
			echo '<thead>
						<tr>
							<th style="text-align:center;padding:2px;vertical-align:middle">No</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">NIS</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Nama Siswa</th>
							<th style="text-align:center;padding:2px;vertical-align:middle;width:100px">Tanggal Menabung</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Setor</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Tarik</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Saldo</th>
						</tr>
					</thead>
					<tbody>';	
			foreach ($sis->result() as $k => $v) 
			{
				// $
				$kr=$db=$tgl=$tt='';
				$tot=0;
				$namsis=str_replace(array('-',',','.','\''), ' ', $v->nama_siswa);
				if(isset($dt[$nm][$namsis]))
				{
					foreach ($dt[$nm][$namsis] as $km => $vm) 
					{
						// $tt.='<br>';
						$tgl.='<div style="width:100%;float:left"><i class="icon icon-trash icon-red" style="font-size:9px !important;display:none;float:left;cursor:pointer" id="icon-hapus" onclick="hapusatu(\''.$vm->id_d.'\',\''.$vm->id_tab.'\',\''.strtok($vm->tgl_transaksi,' ').'\',\''.$jenis.'\',\''.$idkelas.'\')"></i><span style="float:left">'.tgl_indo2($vm->tgl_transaksi).'</span></div>';
						if($vm->tarik_setor=='setor')
						{
							$db.=number_format($vm->jumlah);
							$tot+=$vm->jumlah;
						}
						else
						{
							$kr.=number_format($vm->jumlah);
							$tot-=$vm->jumlah;
						}
						$db.='<br>';
						$kr.='<br>';
					}
					// $tot=$jlh[$nm][$v->nama_siswa][0];
				}
				echo '<tr>';
				echo '<td style="text-align:center">'.($k+1).'</td>';
				echo '<td style="text-align:center">'.($v->id_siswa).'</td>';
				echo '<td style="text-align:left">'.($v->nama_siswa).'</td>';
				echo '<td style="text-align:center">'.($tgl).'</td>';
				echo '<td style="text-align:right">'.($db).'</td>';
				echo '<td style="text-align:right">'.($kr).'</td>';
				echo '<td style="text-align:right">'.$tt.(number_format($tot)).'</td>';
				echo '</tr>';
			}
			echo '</tbody>
				</table>';
		}
		else if($jenis=='tablain' || $jenis=='infaq')
		{
			echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">';
			echo '<thead>
						<tr>
							<th style="text-align:center;padding:2px;vertical-align:middle">No</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Tanggal Setor</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Keterangan</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Setor</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Tarik</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Saldo</th>
						</tr>
					</thead>
					<tbody>';
			$kr=$db=$tgl=$tt='';
			$tot=0;
			if(isset($dt[$nm][$jenis]))
			{

				foreach ($dt[$nm][$jenis] as $km => $vm) 
				{
							// $tt.='<br>';
					$tgl=tgl_indo2($vm->tgl_transaksi).'<br>';
					if($vm->tarik_setor=='setor')
					{
						$db=number_format($vm->jumlah);
						$tot+=$vm->jumlah;
					}
					else
					{
						$kr=number_format($vm->jumlah);
						$tot-=$vm->jumlah;
					}

					echo '<tr>';
						echo '<td style="text-align:center">'.($km+1).'</td>';
						echo '<td style="text-align:center">'.($tgl).'</td>';
						echo '<td style="text-align:left">'.($vm->keterangan).'</td>';
						echo '<td style="text-align:right">'.($db).'</td>';
						echo '<td style="text-align:right">'.($kr).'</td>';
						echo '<td style="text-align:right">'.(number_format($tot)).'</td>';
					echo '</tr>';
				}
			}
			echo '</tbody>
				</table>';
		}

	}

	function tabungansiswa($id=null)
	{
		if($id!=null)
		{
			list($id,$nis)=explode('__', $id);
			$nis = str_replace('%20', ' ', $nis);
			$data=$this->db->select('*')->from('t_tabungan')
						->join('t_tabungan_detail','t_tabungan_detail.id_tab=t_tabungan.id')
						->where('nis',$nis)
						->like('t_tabungan.kelas',($id.'__'))
						->not_like('t_tabungan.nama_siswa','tablain')
						->not_like('t_tabungan.nama_siswa','infaq')
						->order_by('t_tabungan_detail.tgl_transaksi','asc')->get();
			
			echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">';
			echo '<thead>
						<tr>
							<th style="text-align:center;padding:2px;vertical-align:middle">No</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Kelas</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Tanggal</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Debit</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Kredit</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Jumlah</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Keterangan</th>
						</tr>
					</thead>
					<tbody>';
			$total=0;
			foreach ($data->result() as $k => $v) 
			{
				list($idpem,$namakelas)=explode('__', $v->kelas);
				$namakelas=str_replace('_', ' ', $namakelas);
				$debit=$kredit=0;
				if($v->tarik_setor=='setor')
				{
					$debit=$v->jumlah;
					$total+=$debit;
				}
				else
				{
					$kredit=$v->jumlah;
					$total-=$kredit;
				}

				echo '<tr>';
					echo '<td style="text-align:center">'.($k+1).'</td>';
					echo '<td>'.$namakelas.'</td>';
					echo '<td style="text-align:center;width:150px;">
						<div style="width:10%;float:left;cursor:pointer"><i class="icon-edit" id="edittab" onclick="edittab(\''.$v->id_d.'\',\''.$v->id_tab.'\')"></i></div>
						<div style="width:10%;float:left;cursor:pointer"><i class="icon icon-trash icon-color" id="hapustab" onclick="hapustab(\''.$v->id_d.'\',\''.$v->id_tab.'\')"></i></div>
						<div style="width:80%;float:right">'.tgl_indo($v->tgl_transaksi).'</div>
						</td>';
					echo '<td style="text-align:right">'.number_format($debit).'</td>';
					echo '<td style="text-align:right">'.number_format($kredit).'</td>';
					echo '<td style="text-align:right">'.number_format($total).'</td>';
					echo '<td style="text-align:left">'.$v->keterangan.'</td>';
				echo '</tr>';
			}
			echo '</tbody></table>';
			// echo '<pre>';
			// print_r($data->result());
			// echo '</pre>';
		}
	}

	function kwitansi($id)
	{
		$data['id']=$id;
		$data['d']=$this->db->select('*')->from('t_tabungan')->join('t_tabungan_detail','t_tabungan_detail.id_tab=t_tabungan.id')->where('t_tabungan_detail.id_d',$id)->order_by('t_tabungan_detail.tgl_transaksi','asc')->get();
		$this->load->view('tabungan/kwitansi_tabungan',$data);
	}

	function rekap($date=null,$jenis='harian')
	{
		if($date==null)
		{
			if($jenis=='bulanan')
			{
				list($bl,$th)=explode('-', date('n-Y'));
				$tg='';
			}
			else
				list($tg,$bl,$th)=explode('-', date('d-n-Y'));
			
			// $data['tgl']=$th.'-'.$bl.'-'.$tg;
		}
		else
		{
			if($jenis=='bulanan')
			{
				list($bl,$th)=explode('-', $date);
				$tg='';
			}
			else
				list($th,$bl,$tg)=explode('-', $date);
			
		}
		$data['tgl']=$tggl=$th.'-'.$bl.'-'.$tg;
		// $gr=$this->db->query('select tp.*,tp.jumlah as jlh,sum(tp.jumlah) as jumlah_2,tj.* 
		// 									from t_pembayaran as tp
		// 									inner join t_jenis_pembayaran as tj on (tj.id=tp.t_jenis_pembayaran_id)
		// 									where tp.tgl_transaksi like "%'.$tg.'%" and (tp.keterangan!=7 or tp.t_jenis_pembayaran_id!=10 )
		// 									group by tp.t_jenis_pembayaran_id,tp.t_siswa_has_t_kelas_id,tp.keterangan;');

		// $jenis=array('tablain','infaq','harian');
		if($jenis=='bulanan')
			$gr=$this->db->query('select *,tp.nokwitansi as nokw,sum(tp.jumlah) as jumlah from t_tabungan_detail as tp inner join t_tabungan as tt on (tt.id=tp.id_tab) where month(tgl_transaksi)='.$bl.' and year(tgl_transaksi)='.$th.'  group by left(tp.nokwitansi,2)');
		else
			$gr=$this->db->query('select *,tp.nokwitansi as nokw,sum(tp.jumlah) as jumlah from t_tabungan_detail as tp inner join t_tabungan as tt on (tt.id=tp.id_tab) where tgl_transaksi like "%'.($th.'-'.$bl.'-'.$tg).'%"  group by left(tp.nokwitansi,2)');

		$g='';
		$total=0;
		// echo '<pre>';
		// print_r($gr->result());
		// echo '</pre>';
		if($gr->num_rows!=0)
		{
			foreach ($gr->result() as $k => $v) 
			{
				$jn=strtok($v->nokw, '-');
				if($jn==1)
					$jns='Tab. Harian';
				else if($jn==2)
					$jns='Tab. Tak Lain';
				else if($jn==3)
					$jns='Infaq';
				else if($jn==4)
					$jns='Penarikan';
				// echo $v->nokwitansi.'--<br>';

				$dt[$jns][]=$v->jumlah;
				// $total+=$v->total;
			}

			$total=0;
			foreach ($dt as $k => $v) 
			{
				$jlh=array_sum($dt[$k]);
				//$jenis[$k]=$jlh;				
				// echo $k.'-'.$jlh.'<br>';
				if($k!='Penarikan')
				{
					$total+=$jlh;
					$color = '#00FF00';
				}
				else
				{
					$total-=$jlh;
					$color = '#FF00FF';
				}
				
				// $g.='["'.$k.'", '.$jlh.'],';
				$g.='{name : "'.$k.'",color : "'.$color.'", y : '.$jlh.'},';
			}

			// echo $total;
			
			// echo '<pre>';
			// print_r($dt);
			// echo '</pre>';
		}

		if($jenis=='bulanan')
		{
			$data['judul']='Jumlah Tabungan Bulanan : '.getBulan($bl).' - '.$th;
		}
		else
		{
			$data['judul']='Jumlah Tabungan Harian : '.tgl_indo2($tggl);
		}
		$data['g']=$g.'["Total",'.$total.']';
		$data['jenis']=$jenis;
		$this->load->view('tabungan/grafik',$data);	
	}

	function datarekap($tgl=0,$kelas=null)
	{
			$datatab=$jumlah=$dd=array();
			if($tgl==0)
				$tab=$this->db->select('*')->from('t_tabungan')->join('t_tabungan_detail','t_tabungan_detail.id_tab=t_tabungan.id')->order_by('t_tabungan_detail.tgl_transaksi','asc')->get();
			else
				$tab=$this->db->select('*')->from('t_tabungan')->join('t_tabungan_detail','t_tabungan_detail.id_tab=t_tabungan.id')->like('t_tabungan_detail.tgl_transaksi',$tgl)->order_by('t_tabungan_detail.tgl_transaksi','asc')->get();
			$data['tgl']=$tgl;
			foreach ($tab->result() as $k => $v) 
			{
				if($v->nama_siswa=='tablain')
				{
					$datatab[$v->kelas]['tablain'][]=$v;
					if($v->tarik_setor=='setor')
						$jumlah[$v->kelas]['tablain'][]=$v->jumlah;
					else
						$jumlah[$v->kelas]['tablain'][]=(0-$v->jumlah);
				}
				else if($v->nama_siswa=='infaq')
				{
					$datatab[$v->kelas]['infaq'][]=$v;
					if($v->tarik_setor=='setor')
						$jumlah[$v->kelas]['infaq'][]=$v->jumlah;
					else
						$jumlah[$v->kelas]['infaq'][]=(0-$v->jumlah);
				}
				else
				{
					$datatab[$v->kelas]['harian'][]=$v;
					if($v->tarik_setor=='setor')
						$jumlah[$v->kelas]['harian'][]=$v->jumlah;
					else
						$jumlah[$v->kelas]['harian'][]=(0-$v->jumlah);
				}
				$dd[$v->kelas]=$v;
			}
			$data['datatab']=$datatab;
			$data['jumlah']=$jumlah;
			$data['dd']=$dd;
			$this->load->view('tabungan/rekap',$data);
	}

	function formedit($idd,$idtab)
	{
		$d=$this->db->query('select * from t_tabungan as tb inner join t_tabungan_detail as tbd on (tb.id=tbd.id_tab) where tbd.id_d="'.$idd.'" and tb.id="'.$idtab.'"');
		$data['d']=$d;
		$data['idd']=$idd;
		$data['idtab']=$idtab;
		$this->load->view('tabungan/form-edit',$data);
	}

	function hapussatu($idd_idtab)
	{
		// if(!empty($_POST))
		// {
			// $id_d=$_POST['id_d'];
			// $id_tab=$_POST['id_tab'];
			list($id_d,$id_tab)=explode('-', $idd_idtab);
			$tab=$this->db->from('t_tabungan')->where('id',$id_tab)->get();
			$getdata=$this->db->from('t_tabungan_detail')->where('id_d',$id_d)->get();
			$this->db->query('update t_tabungan set saldo=(saldo-'.$getdata->row('jumlah').') where id="'.$id_tab.'"');
			$this->db->query('delete from t_tabungan_detail where id_d="'.$id_d.'"');

			echo 'Data Tabungan '.$tab->row('nama_siswa').' Berhasil Dihapus';
			//redirect('tabungan','location');
		// }
	}

	function simpanpenarikan($tgl)
	{
		if(!empty($_POST))
		{
			list($nis,$idtabungan)=explode('_', $_POST['nama_siswa']);
			$jumlah=str_replace(',', '', $_POST['jumlah']);
			$penarik=$_POST['penarik'];
			$keterangan=$_POST['keterangan'];
			$wh=array('nis'=>$nis,'id'=>$idtabungan);
			$up=array(
				'sald' => ('saldo - ' . $jumlah),
				'last_update' => $tgl.' '.date('H:i:s')
			);
			$this->db->set('saldo','saldo - '.$jumlah, FALSE);
			$this->db->set('last_update', $tgl.' '.date('H:i:s'));
			$this->db->where($wh);
			$this->db->update('t_tabungan');

			$d['id_d']=generate_id();
			$d['id_tab']=$idtabungan;
			$d['tarik_setor']='tarik';
			$d['jumlah']=$jumlah;
			$d['keterangan']=$keterangan;
			$d['penarik']=$penarik;
			$d['nokwitansi']='4'.'-'.date('Ymd').'-'.substr(generate_id(), 0,4);
			$d['tgl_transaksi']=$tgl.' '.date('H:i:s');
			$d['petugas']=$this->session->userdata('nama');
			$this->db->insert('t_tabungan_detail',$d);
		}
	}

	function cekdatatabungan($val)
	{
		list($nis,$idtabungan)=explode('_', $val);
		$cek=$this->db->from('t_tabungan')->where('id',$idtabungan)->where('nis',$nis)->get()->result();
		echo $cek[0]->saldo;
	}
}