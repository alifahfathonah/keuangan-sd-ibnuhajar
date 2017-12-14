<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Siswa extends A {

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

	function index()
	{
		$data['title']='Siswa';
		$data['isi']='siswa/index';
		$this->load->view('index',$data);
	}
	function dataSiswa($like=null)
	{
		$data['d']=$dd=array();
		$this->load->library('pagination');

		$d=$this->sm->getSiswa($date,$like);


		$config['per_page'] = 10;
		$urisegment=4;
		if($like==null || $like=='null')
		{
			$like='null';
		}
		$config['base_url'] = site_url().'siswa/dataSiswa/'.$like;
		$config['uri_segment'] = $urisegment;

		$config['class_js'] = 'halSiswa';
		$query=$d;
		$jumlah=$query->num_rows();
		$config['total_rows'] = $jumlah;
		$this->pagination->initialize($config);
		$data['num']=$config['per_page'];
		$data['offset']=$config['uri_segment'];
		$data['offset']=$this->uri->segment($urisegment);
		if (!$data['offset'])
		{
			$data['offset']=0;
		}
		$data['num'] = $config['per_page'];

		$dr['num']=$data['num'];
		$dr['offset']=$data['offset'];

		$ddpage=$this->sm->getSiswa($dr,$like);
		//$data['dd']=$ddpage;
		foreach($ddpage->result() as $_)
		{
			$dd[]=$_;
		}
		$data['d']=$dd;
		echo '<table class="table table-striped table-bordered bootstrap-datatable">
						<thead>
							<tr>
								<th style="text-align:center;">No</th>
								<th style="text-align:center;">NIS</th>
								<th style="text-align:left;">Nama Siswa</th>
								<th style="text-align:left;">T/TL</th>
								<th style="text-align:left;">Nama Ayah</th>
								<th  style="text-align:left;">Nama Ibu</th>
								<th  style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
						';
		$no=$this->uri->segment($urisegment)+1;
		foreach($dd as $idx=>$si)
		{
			echo '<tr '.($idx%2==0 ? 'class="odd"' : 'class="even"').'>
				<td style="text-align:center">'.$no.'</td>
				<td class="center">'.$si->nis_baru.'</td>
				<td class="left">'.$si->nama.'</td>
				<td class="left">'.$si->tlahir.' / '.tgl_indo2($si->tgllahir).'</td>
				<td class="left">'.$si->nama_ayah.'</td>
				<td class="left">'.$si->nama_ibu.'</td>
				<td class="right" style="text-align:center">
					<!--<a class="btn btn-success btn-mini" href="#">
						<i class="icon-zoom-in icon-white"></i>

					</a>-->
					<a class="btn btn-info  btn-mini" href="'.site_url().'siswa/edit/'.$si->nis.'">
						<i class="icon-edit icon-white"></i>

					</a>
					<a class="btn btn-danger btn-mini" href="#" onclick="del(\''.$si->nis.'\')">
						<i class="icon-trash icon-white"></i>

					</a>
				</td>
			</tr>';
			$no++;
		}

		echo '</tbody></table>
		<div class="pagination">'.$this->pagination->create_links2().'</div>';
		echo '<script>
		function '.$config['class_js'].'(h)
		{
			//alert(h);
			$(\'#isi\').load(\''.site_url().'siswa/dataSiswa/'.$like.'/\'+h);
		}
		</script>';
	}

	function waitinglist()
	{
		$data['title']='Data Siswa Waiting List';
		$data['isi']='siswa/waitinglist';
		$this->load->view('index',$data);
	}

	function wl($like=null)
	{
		$data['d']=$dd=array();
		$this->load->library('pagination');

		$d=$this->sm->getSiswaStatus($date,'w',$like);


		$config['per_page'] = 10;
		$urisegment=4;
		if($like==null || $like=='null')
		{
			$like='null';
		}
		$config['base_url'] = site_url().'siswa/wl/'.$like;
		$config['uri_segment'] = $urisegment;

		$config['class_js'] = 'halSiswa';
		$query=$d;
		$jumlah=$query->num_rows();
		$config['total_rows'] = $jumlah;
		$this->pagination->initialize($config);
		$data['num']=$config['per_page'];
		$data['offset']=$config['uri_segment'];
		$data['offset']=$this->uri->segment($urisegment);
		if (!$data['offset'])
		{
			$data['offset']=0;
		}
		$data['num'] = $config['per_page'];

		$dr['num']=$data['num'];
		$dr['offset']=$data['offset'];

		$ddpage=$this->sm->getSiswaStatus($dr,'w',$like);
		//$data['dd']=$ddpage;
		foreach($ddpage->result() as $_)
		{
			$dd[]=$_;
		}
		$data['d']=$dd;
		echo '<table class="table table-striped table-bordered bootstrap-datatable">
						<thead>
							<tr>
								<th style="text-align:center;">No</th>
								<th style="text-align:center;">NIS</th>
								<th style="text-align:left;">Nama Siswa</th>
								<th style="text-align:left;">T/TL</th>
								<th style="text-align:left;">Nama Ayah</th>
								<th  style="text-align:left;">Nama Ibu</th>
								<th  style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
						';
		$no=$this->uri->segment($urisegment)+1;
		foreach($dd as $idx=>$si)
		{
			echo '<tr '.($idx%2==0 ? 'class="odd"' : 'class="even"').'>
				<td style="text-align:center">'.$no.'</td>
				<td class="center">'.$si->nis_baru.'</td>
				<td class="left">'.$si->nama.'</td>
				<td class="left">'.$si->tlahir.' / '.tgl_indo2($si->tgllahir).'</td>
				<td class="left">'.$si->nama_ayah.'</td>
				<td class="left">'.$si->nama_ibu.'</td>
				<td class="right" style="text-align:center">
					<!--<a class="btn btn-success btn-mini" href="#">
						<i class="icon-zoom-in icon-white"></i>

					</a>-->
					<a class="btn btn-info  btn-mini" href="'.site_url().'siswa/edit/'.$si->nis.'">
						<i class="icon-edit icon-white"></i>

					</a>
					<a class="btn btn-danger btn-mini" href="#" onclick="del(\''.$si->nis.'\')">
						<i class="icon-trash icon-white"></i>

					</a>
				</td>
			</tr>';
			$no++;
		}

		echo '</tbody></table>
		<div class="pagination">'.$this->pagination->create_links2().'</div>';
		echo '<script>
		function '.$config['class_js'].'(h)
		{
			//alert(h);
			$(\'#isi\').load(\''.site_url().'siswa/wl/'.$like.'/\'+h);
		}
		</script>';
	}

	function add($id=null)
	{

		$data['title'] = ($id!=null ? 'Edit Data Siswa' : 'Tambah Data Siswa Baru');
		$data['isi']='siswa/add';
		$data['nis']=$data['nama']=$data['tempat']=$data['tgl']=$data['kelamin']=$data['foto']=$data['masuk']=$data['alamat']=$data['nama_ayah']=$data['nama_ibu']=$data['telp_ayah']=$data['telp_ibu']=$data['kerja_ayah']=$data['kerja_ibu']=$data['pendidikan_ibu']=$data['pendidikan_ayah']=$data['status']="";

		if($id!=null)
		{
			$data['id']=$id;
			$data['det']=$d=$this->sm->getSiswaById($id);
			$data['nis']=$d->row('nis');
			$data['nama']=$d->row('nama');
			$data['tempat']=$d->row('tlahir');
			$data['tgl']=$d->row('tgllahir');
			$data['kelamin']=$d->row('jenis_kelamin');
			$data['foto']=$d->row('foto');
			$data['masuk']=$d->row('tahunmasuk');
			$data['alamat']=$d->row('alamat');
			$data['nama_ayah']=$d->row('nama_ayah');
			$data['nama_ibu']=$d->row('nama_ibu');
			$data['telp_ayah']=$d->row('telp_ayah');
			$data['telp_ibu']=$d->row('telp_ibu');
			$data['kerja_ayah']=$d->row('pekerjaan_ayah');
			$data['kerja_ibu']=$d->row('pekerjaan_ibu');
			$data['pendidikan_ayah']=$d->row('pendidikan_ayah');
			$data['pendidikan_ibu']=$d->row('pendidikan_ibu');
			$data['status']=$d->row('status');
		}
		$this->load->view('index',$data);
	}

	function edit($id=null)
	{
		$id=str_replace('%20', ' ', $id);
		$this->add($id);
	}

	function prosessiswa($id)
	{
		$id=str_replace('%20', ' ', $id);
		if(!empty($_POST))
		{
			$nis=$_POST['nis'];
			if($nis=='')
				$nis=substr(abs(crc32(sha1(md5(rand())))),0,8);
			//else
			//	$nis=$nis
			$nama=$_POST['nama'];
			$tl=$_POST['tempat'];
			$tg=$_POST['tgl'];
			$al=$_POST['alamat'];
			$na=$_POST['ayah'];
			$ni=$_POST['ibu'];
			$tl_a=$_POST['telp_a'];
			$tl_i=$_POST['telp_i'];
			$pk_a=$_POST['kerja_a'];
			$pk_i=$_POST['kerja_i'];
			$pdk_a=$_POST['pendidikan_a'];
			$pdk_i=$_POST['pendidikan_i'];
			$foto=$_POST['foto'];
			$kelamin=$_POST['kelamin'];
			$thn_masuk=$_POST['tahunmasuk'];
			$status=$_POST['status'];
			$add=array(
				'nis' => $nis,
				'nama' => $nama,
				'tlahir' => $tl,
				'tgllahir' => $tg,
				'alamat' => $al,
				'nama_ayah' => $na,
				'nama_ibu' => $ni,
				'telp_ayah' => $tl_a,
				'telp_ibu' => $tl_i,
				'pekerjaan_ayah' => $pk_a,
				'pekerjaan_ibu' => $pk_i,
				'pendidikan_ayah' => $pdk_a,
				'pendidikan_ibu' => $pdk_i,
				'jenis_kelamin' => $kelamin,
				'foto' => $foto,
				'status' => $status,
				'nis_baru' => $nis,
				'tahunmasuk' => $thn_masuk
			);

			if($id!='null')
			{
				$this->db->where('nis',$id);
				$this->db->update('t_siswa',$add);

				$this->db->query('update t_siswa set nis="'.$id.'", nis_baru="'.$nis.'" where nis="'.$nis.'"');

				$this->session->set_flashdata('pesan','Data Siswa Berhasil Di Edit');
			}
			else
			{
				$this->db->insert('t_siswa',$add);
				$this->session->set_flashdata('pesan','Data Pendaftaran Baru Berhasil Ditambahkan');
			}
			//echo 'Berhasil';
			//redirect('siswa','location');
		}
	}
	function delete($id,$s=null)
	{
		$id=str_replace('%20', ' ', $id);
		$edit=array(
			'status'=>'i'
		);
		$this->db->where('nis',$id);
		$this->db->update('t_siswa',$edit);
		$this->session->set_flashdata('pesan','Data Siswa Berhasil Dihapus');

		if($s!=null)
			redirect('siswa/waitinglist','location');
		else
			redirect('siswa','location');
	}
	function getSiswaByIdJSON($id)
	{
		$id=str_replace('%20', ' ', $id);
		$sis=$this->sm->getSiswaById($id);
		if($sis->num_rows!=0)
		{
			$json = $sis->result();
			$a=json_encode($json);
			echo str_replace(array('[',']'),'',$a);
		}
	}
	//3|1950496897|Tahun Ajaran 2016-2017/7/10/2016
	function getSiswaByKelas($idkelasaktif,$bulan=null,$idjenis=null,$tahun=null)
	{
		$idkelasaktif=str_replace(array('%7C','|'), '|', $idkelasaktif);
		$idkelasaktif=str_replace('%20', ' ', $idkelasaktif);
		list($idk,$ida,$nk)=explode('|', $idkelasaktif);
		//$sis=$this->km->getSiswaByKelas($idk,$ida,'t');
		$sis=$this->km->getSiswaByNamaKelas($idk,$nk,$ida,'t');



				echo '<table class="table table-striped table-bordered bootstrap-datatable"  style="width:49%;float:left">
						<thead>
							<tr>
								<th style="text-align:center;">No</th>
								<th style="text-align:center;">NIS</th>
								<th style="text-align:left;">Nama Siswa</th>
								<th style="text-align:left;">Status</th>

								<th  style="text-align:center;">Pilih <input type="checkbox" id="pilih" onclick="pilihsemua(\'pilih\')"></th>
							</tr>
						</thead>
						<tbody>';
				$jlh=$sis->num_rows();
				$bg=ceil($jlh/2);
				foreach($sis->result() as $ix=> $s)
				{
					$idkk=$this->km->getKelasAktifByNIS($s->nis,'t');
					// $idkk=$this->db->query('select * from t_siswa_has_t_kelas where t_siswa_nis like "%'.$s->nis.'%" and t_ajaran_id="');
					$bayarblm=$this->db->query('select * from t_pembayaran where t_siswa_has_t_kelas_id='.$s->id.' and keterangan='.$bulan.' and t_jenis_pembayaran_id='.$idjenis.';');
					$x=($ix);

					//if()
					$cek=$this->pm->cekPenerimaanRutin($bulan,$idjenis,$s->nis,$idkk->row('id'),$tahun);

					if($bulan!=7)
					{
						if($cek->num_rows()!=0)
							$cc='<span class="label label-success" style="font-size:11px;">'.($bayarblm->num_rows!=0 ? 'Sudah Bayar' : 'Terdaftar').'</span> '.($bayarblm->num_rows==0 ? '<span class="label label-important" style="cursor:pointer"  onclick="hapusdata(\''.$s->id.'\',\''.$idjenis.'\')"><i class="icon icon-white icon-trash"></i></span>':'');
						else
							$cc='<span class="label label-important" style="font-size:11px;">Belum Terdaftar</span>';
					}
					else
					{
						$cc='<span class="label label-success" style="font-size:11px;">'.($bayarblm->num_rows!=0 ? 'Sudah Bayar' : 'Terdaftar').'</span> '.($bayarblm->num_rows==0 ? '<span class="label label-important" style="cursor:pointer"  onclick="hapusdata(\''.$s->id.'\',\''.$idjenis.'\')"><i class="icon icon-white icon-trash"></i></span>':'');
					}
					if($ix==$bg)
						break;

						echo '<tr>
							<td>'.($ix+1).'</td>
							<td>'.$s->nis.'</td>
							<td>'.$s->nama.'</td>
							<td>'.$cc.'</td>
							<td style="text-align:center">
								<input type="checkbox" name="siswa[\''.$s->nis.'\']" id="pilihan">
							</td>
						</tr>';

				}

				echo '</tbody>
				</table>';
				echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:49%;float:right">
						<thead>
							<tr>
								<th style="text-align:center;">No</th>
								<th style="text-align:center;">NIS</th>
								<th style="text-align:left;">Nama Siswa</th>
								<th style="text-align:left;">Status</th>

								<th  style="text-align:center;"></th>
							</tr>
						</thead>
						<tbody>';
				foreach($sis->result() as $ix=> $s)
				{
					$x=($ix);
					$idkk=$this->km->getKelasAktifByNIS($s->nis,'t');
					$bayarblm=$this->db->query('select * from t_pembayaran where t_siswa_has_t_kelas_id='.$s->id.' and keterangan='.$bulan.' and t_jenis_pembayaran_id='.$idjenis.';');

					// $cek=$this->pm->cekPenerimaanRutin($bulan,$idjenis,$s->nis,$s->id,$tahun);
					$cek=$this->pm->cekPenerimaanRutin($bulan,$idjenis,$s->nis,$idkk->row('id'),$tahun);
					if($bulan!=7)
					{

					if($cek->num_rows()!=0)
						$cc='<span class="label label-success" style="font-size:11px;">'.($bayarblm->num_rows!=0 ? 'Sudah Bayar' : 'Terdaftar').'</span> '.($bayarblm->num_rows==0 ? '<span class="label label-important" style="cursor:pointer"  onclick="hapusdata(\''.$s->id.'\',\''.$idjenis.'\')"><i class="icon icon-white icon-trash"></i></span>':'');
					else
						$cc='<span class="label label-important" style="font-size:11px;">Belum Terdaftar</span>';

					}
					else
					{
						$cc='<span class="label label-success" style="font-size:11px;">'.($bayarblm->num_rows!=0 ? 'Sudah Bayar' : 'Terdaftar').'</span> '.($bayarblm->num_rows==0 ? '<span class="label label-important" style="cursor:pointer"  onclick="hapusdata(\''.$s->id.'\',\''.$idjenis.'\')"><i class="icon icon-white icon-trash"></i></span>':'');
					}
					if($ix<$bg)
						continue;

						echo '<tr>
							<td>'.($ix+1).'</td>
							<td>'.$s->nis.'</td>
							<td>'.$s->nama.'</td>
							<td>'.$cc.'</td>
							<td style="text-align:center">
								<input type="checkbox" name="siswa[\''.$s->nis.'\']" id="pilihan">
							</td>
						</tr>';

				}

				echo '</tbody>
				</table>
				<style>
				.table td
				{
					font-size:10px !important;
				}
				</style>';
	}

	function hapusdatapenerimaan($id,$jns,$kelasaktif,$bulan,$jenis,$tahun)
	{
		// if($jns=='jemputan')
		// {
			$this->db->query('delete from t_penerimaan_rutin where t_siswa_has_t_kelas_id="'.$id.'" and bulan='.$bulan.' and tahun='.$tahun.' and t_jenis_pembayaran_id='.$jenis.';');
		// }
		// else
		// {

		// }
	}

	function getSiswaByDriver($iddriver,$bulan=null,$idjenis=null,$tahun=null)
	{
				$sis=$this->cm->getSiswaByDriver($iddriver)->result();
				echo '<table class="table table-striped table-bordered bootstrap-datatable"  style="width:100%;float:left">
						<thead>
							<tr>
								<th style="text-align:center;font-size:10px;">No</th>
								<th style="text-align:center;font-size:10px;">NIS</th>
								<th style="text-align:left;font-size:10px;">Nama Siswa</th>
								<th style="text-align:left;font-size:10px;width:100px;">Jlh Pembayaran</th>
								<th style="text-align:left;font-size:10px;">Keterangan</th>
								<th style="text-align:left;font-size:10px;">Status</th>

								<th  style="text-align:center;font-size:10px;">Pilih <input type="checkbox" id="pilih" onclick="pilihsemua(\'pilih\')"></th>
								<th style="text-align:left;font-size:10px;">Aksi</th>
							</tr>
						</thead>
						<tbody>';
				$jlh=count($sis);
				$bg=$jlh/2;

				//foreach($sis->result() as $ix=> $s)
				for($ix=0;$ix<$jlh;$ix++)
				{
					$x=($ix);

					if($bulan==null)
						$bl=date('m');
					else
						$bl=$bulan;

					if($tahun==null)
						$th=date('Y');
					else
						$th=$tahun;

					if($bulan>=1 && $bulan<=6)
					{
						$ta = ($tahun-1).'-'.$tahun;
					}
					else
						$ta = $tahun.'-'.($tahun+1);

					//if()
					// $idkk=$this->km->getKelasAktifByNIS($sis[$ix]->nis,'t')->result();
					$idkk=$this->db->query('select * from v_kelas_aktif where nis="'.$sis[$ix]->nis.'" and st_aktif="t" and status_siswa_aktif="t" and tahunajaran="'.$ta.'"')->result();

						# code...
						if(count($idkk)!=0)
						{
							// $cek=$this->pm->cekPenerimaanRutinJemputan($bl,$idjenis,$sis[$ix]->nis,$th)->result();
							$cek=$this->pm->cekPenerimaanRutin($bl,$idjenis,$sis[$ix]->nis,$idkk[0]->id,$th)->result();
							// echo $bl.'-'.$idjenis.'-'.$sis[$ix]->nis.'-'.$th.'-'.$idkk[0]->id.'<br>';
							// echo count($cek).'-<br>';
							// echo '<pre>';
							// print_r($cek->result());
							// echo '</pre>';
						}
						else
							$cek=array();

							// echo $ta;
							// echo '<pre>';
							// print_r($cek);
							// echo '</pre>';


					$sel='';
					$cc='';
					if(count($cek)!=0)
					{
						$cc='<span style="color:green">Daftar</span> <span class="label label-important" style="cursor:pointer" onclick="hapusdata(\''.$sis[$ix]->nis.'__'.$idkk[0]->id.'__'.$idkk[0]->idkelas.'__'.$idkk[0]->id_ajaran.'__'.$idkk[0]->namakelasaktif.'\',\'jemputan\')"><i class="icon icon-white icon-trash"></i></span>';

						if($cek[0]->sisa_bayar==0)
						{
							$cekbayar=$this->db->query('select * from t_pembayaran where t_siswa_has_t_kelas_id="'.$idkk[0]->id.'" and t_jenis_pembayaran_id="'.$idjenis.'" and keterangan="'.$bl.'" and bulan_tahun_tagihan="'.$th.'"');
							$cc='<div style="float:left;width:100%"><span style="color:green">Sudah Bayar</span> <span class="label label-important" style="cursor:pointer" onclick="hapusdata(\''.$sis[$ix]->nis.'__'.$idkk[0]->id.'__'.$idkk[0]->idkelas.'__'.$idkk[0]->id_ajaran.'__'.$idkk[0]->namakelasaktif.'\',\'jemputan\')"><i class="icon icon-white icon-trash"></i></span></div>';
							if($cekbayar->num_rows!=0)
							{
								// $cc.= '<br>';
								$cc.= '<div style="color:green;width:100%;float:left;font-size:9px;"><small>Tgl : '.tgl_indo2($cekbayar->row('tgl_transaksi')).'</small></div>';
							}
						}

						if($cek[0]->keterangan=='Pulang-Pergi')
						{
							$sel='<option value="Pulang-Pergi" selected="selected">Pulang-Pergi</option>';
							$sel.='<option value="Pergi-Saja">Pergi-Saja</option>
								<option value="Pulang-Saja">Pulang-Saja</option>';
						}
						else if($cek[0]->keterangan=='Pergi-Saja')
						{
							$sel='<option value="Pergi-Saja" selected="selected">Pergi-Saja</option>';
							$sel.='<option value="Pulang-Pergi" >Pulang-Pergi</option>
								<option value="Pulang-Saja">Pulang-Saja</option>';
						}
						else if($cek[0]->keterangan=='Pulang-Saja')
						{
							$sel='<option value="Pulang-Saja" selected="selected">Pulang-Saja</option>';
							$sel.='<option value="Pulang-Pergi" >Pulang-Pergi</option>
								<option value="Pergi-Saja">Pergi-Saja</option>';
						}
						else
						{
							$sel='<option value="Pulang-Pergi" >Pulang-Pergi</option>
								<option value="Pergi-Saja">Pergi-Saja</option>
								<option value="Pulang-Saja">Pulang-Saja</option>';

						}
						$input='<input type="text" id="jum'.$ix.'" name="jemputan[\''.$sis[$ix]->nis.'\']" style="width:95%;border:0px;border-bottom:1px dotted #bbb;text-align:right" onkeyup="format(this.value,\'jum'.$ix.'\')" value="'.number_format($cek[0]->sisa_bayar).'">';
					}
					else
					{
						// if($cek[0]->tampil_jemputan==1)
						if($sis[$ix]->biaya==1)
							continue;


						$cc='<span style="color:red">Belum Daftar</span>';
						$sel.='
								<option selected></option>
								<option value="Pulang-Pergi" >Pulang-Pergi</option>
								<option value="Pergi-Saja">Pergi-Saja</option>
								<option value="Pulang-Saja">Pulang-Saja</option>';

						$cb=$this->db->query('select * from v_data_kewajiban where t_jenis_pembayaran_id="'.$idjenis.'" and t_siswa_nis="'.$sis[$ix]->nis.'" order by tahun desc, bulan desc limit 1');

						if($cb->num_rows!=0)
							$nn=$cb->row('sisa');
						else
							$nn=0;

						$input='<input type="text" id="jum'.$ix.'" name="jemputan[\''.$sis[$ix]->nis.'\']" style="width:95%;border:0px;border-bottom:1px dotted #bbb;text-align:right" onkeyup="format(this.value,\'jum'.$ix.'\')" value="'.number_format($nn).'">';



					}
					//if($ix==$bg)
						//break;
						// $cc='';
						echo '<tr>
							<td>'.($x+1).'</td>
							<td>'.$sis[$ix]->nis.'</td>
							<td>'.$sis[$ix]->nama.'</td>
							<td>'.$input.'</td>
							<td>
							<select name="ket[\''.$sis[$ix]->nis.'\']">

								'.$sel.'
							</select>
							</td>
							<td>'.$cc.'</td>
							<td style="text-align:center">
								<input type="checkbox" name="siswa[\''.$sis[$ix]->nis.'\']" id="pilihan">
							</td>
							<td><button class="btn btn-mini btn-danger" type="button" onclick="hapusdatasiswadriver(\''.$sis[$ix]->nis.'\',\''.$iddriver.'\',\''.$bl.'\',\''.$th.'\')"><i class="icon icon-trash icon-white" ></i></button></td>
						</tr>';

				}

				echo '</tbody>
				</table>';

	}

	function getSiswaByClub($idclub,$bulan=null,$idjenis=18,$tahun=null)
	{
				// $sis=$this->cm->getSiswaByDriver($iddriver)->result();
				$sis=$this->db->from('v_club_siswa')->where('id_club',$idclub)->get()->result();

				echo '<table class="table table-striped table-bordered bootstrap-datatable"  style="width:100%;float:left">
						<thead>
							<tr>
								<th style="text-align:center;font-size:10px;">No</th>
								<th style="text-align:center;font-size:10px;">NIS</th>
								<th style="text-align:left;font-size:10px;">Nama Siswa</th>
								<th style="text-align:left;font-size:10px;width:100px;">Jlh Pembayaran</th>
								<th style="text-align:left;font-size:10px;">Status</th>

								<th  style="text-align:center;font-size:10px;">Pilih <input type="checkbox" id="pilih" onclick="pilihsemua(\'pilih\')"></th>
								<th style="text-align:left;font-size:10px;">Aksi</th>
							</tr>
						</thead>
						<tbody>';
				$jlh=count($sis);
				$bg=$jlh/2;
				//foreach($sis->result() as $ix=> $s)
				for($ix=0;$ix<$jlh;$ix++)
				{
					$x=($ix);

					if($bulan==null)
						$bl=date('m');
					else
						$bl=$bulan;

					if($tahun==null)
						$th=date('Y');
					else
						$th=$tahun;

					if($bulan>=1 && $bulan<=6)
					{
						$ta = ($tahun-1).'-'.$tahun;
					}
					else
						$ta = $tahun.'-'.($tahun+1);

					//if()
					// $idkk=$this->km->getKelasAktifByNIS($sis[$ix]->nis,'t')->result();
					$idkk=$this->db->query('select * from v_kelas_aktif where nis="'.$sis[$ix]->nis.'" and st_aktif="t" and status_siswa_aktif="t" and tahunajaran="'.$ta.'"')->result();
					// echo  $ta.'-';
					if(count($idkk)!=0)
					{
						$cek=$this->db->select('*')
								->from('t_penerimaan_rutin')
								->where('bulan',$bl)
								->where('tahun',$th)
								->where('t_jenis_pembayaran_id',$idjenis)
								->where('t_siswa_nis',$sis[$ix]->nis)
								->like('keterangan',$sis[$ix]->id_club)
								->where('t_siswa_has_t_kelas_id',$idkk[0]->id)->get()->result();
						// $cek=$this->pm->cekPenerimaanRutin($bl,$idjenis,$sis[$ix]->nis,$idkk[0]->id,$th)->result();
					}
					else
						$cek=array();




					$sel='';
					if(count($cek)!=0)
					{
						$cc='<span style="color:green">Daftar</span> <span class="label label-important" style="cursor:pointer" onclick="hapusdata(\''.$sis[$ix]->id_club.'__'.$idkk[0]->id.'__'.$idkk[0]->idkelas.'__'.$idkk[0]->id_ajaran.'__'.$idkk[0]->namakelasaktif.'\',\'jemputan\')"><i class="icon icon-white icon-trash"></i></span>';

						if($cek[0]->sisa_bayar==0)
						{
							$cekbayar=$this->db->query('select * from t_pembayaran where t_siswa_has_t_kelas_id="'.$idkk[0]->id.'" and t_jenis_pembayaran_id="'.$idjenis.'" and keterangan="'.$bl.'" and bulan_tahun_tagihan="'.$th.'"');

							$cc='<div style="float:left;width:100%"><span style="color:green">Sudah Bayar</span> <span class="label label-important" style="cursor:pointer" onclick="hapusdata(\''.$sis[$ix]->id_club.'__'.$idkk[0]->id.'__'.$idkk[0]->idkelas.'__'.$idkk[0]->id_ajaran.'__'.$idkk[0]->namakelasaktif.'\',\'jemputan\')"><i class="icon icon-white icon-trash"></i></span></div>';

							if($cekbayar->num_rows!=0)
							{
								// $cc.= '<br>';
								$cc.= '<div style="color:green;width:100%;float:left;font-size:9px;"><small>Tgl : '.tgl_indo2($cekbayar->row('tgl_transaksi')).'</small></div>';
							}
						}

						$input='<input type="text" id="jum'.$ix.'" name="jemputan[\''.$sis[$ix]->nis.'\']" style="width:95%;border:0px;border-bottom:1px dotted #bbb;text-align:right" onkeyup="format(this.value,\'jum'.$ix.'\')" value="'.number_format($cek[0]->sisa_bayar).'">';
					}
					else
					{
						// if($cek[0]->tampil_jemputan==1)
						if($sis[$ix]->st_siswa=='f')
							continue;


						$cc='<span style="color:red">Belum Daftar</span>';

						$cb=$this->db->query('select * from v_data_kewajiban where t_jenis_pembayaran_id="'.$idjenis.'" and t_siswa_nis="'.$sis[$ix]->nis.'" order by tahun desc, bulan desc limit 1');

						if($cb->num_rows!=0)
							$nn=$cb->row('sisa');
						else
							$nn=$sis[$ix]->biaya;

						$input='<input type="text" id="jum'.$ix.'" name="jemputan[\''.$sis[$ix]->nis.'\']" style="width:95%;border:0px;border-bottom:1px dotted #bbb;text-align:right" onkeyup="format(this.value,\'jum'.$ix.'\')" value="'.number_format($nn).'">';



					}
					//if($ix==$bg)
						//break;

						echo '<tr>
							<td>'.($ix+1).'</td>
							<td>'.$sis[$ix]->nis_baru.'</td>
							<td>'.$sis[$ix]->nama.'</td>
							<td>'.$input.'</td>

							<td>'.$cc.'</td>
							<td style="text-align:center">
								<input type="checkbox" name="siswa[\''.$sis[$ix]->nis.'\']" id="pilihan">
							</td>
							<td><button class="btn btn-mini btn-danger" type="button" onclick="hapusdatasiswa(\''.str_replace(' ', '_', $sis[$ix]->nis).'\',\''.$idclub.'\',\''.$bl.'\',\''.$th.'\')"><i class="icon icon-trash icon-white" ></i></button></td>
						</tr>';

				}

				echo '</tbody>
				</table>';

	}
}
