<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Kelas extends A {

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
		$data['title']='Kelas';
		$data['isi']='kelas/index';
		$this->load->view('index',$data);
	}

	function dataKelas($like=null)
	{
		$data['d']=$dd=array();
		$this->load->library('pagination');
		
		$d=$this->km->getKelas($date,$like);
			
		
		$config['per_page'] = 10;
		$urisegment=4;
		if($like==null || $like=='null')
		{
			$like='null';
		}
		$config['base_url'] = site_url().'kelas/dataKelas/'.$like;
		$config['uri_segment'] = $urisegment; 
		
		$config['class_js'] = 'halKelas'; 
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
		
		$ddpage=$this->km->getKelas($dr,$like);
		//$data['dd']=$ddpage;
		foreach($ddpage->result() as $_)
		{
			$dd[]=$_;
		}
		$data['d']=$dd;
		echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:60%">
						<thead>
							<tr>
								<th style="text-align:center;">No</th>
								<th style="text-align:center;">Nama Kelas</th>
								<th style="text-align:center;">Kapasitas Siswa</th>
								<th  style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
						';
		$no=$this->uri->segment($urisegment)+1;
		foreach($dd as $idx=>$si)
		{
			echo '<tr '.($idx%2==0 ? 'class="odd"' : 'class="even"').'>
				<td style="text-align:left">'.$no.'</td>
				<td class="left" style="text-align:left">'.$si->namakelas.'</td>
				<td class="center" style="text-align:center">'.$si->jlh_siswa.'</td>

				<td class="right" style="text-align:center">
					<!--<a class="btn btn-success btn-mini" href="#">
						<i class="icon-zoom-in icon-white"></i>  
						                                            
					</a>-->
					<a class="btn btn-info  btn-mini" href="'.site_url().'kelas/edit/'.$si->id.'">
						<i class="icon-edit icon-white"></i>  
						                                            
					</a>
					<a class="btn btn-danger btn-mini" href="#" onclick="del(\''.$si->id.'\')">
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

	function add($id=null)
	{
		
		$data['title'] = ($id!=null ? 'Edit Data Kelas' : 'Tambah Data Kelas Baru');
		$data['isi']='kelas/add';
		$data['namakelas']=$data['kapasitas']="";

		if($id!=null)
		{
			$data['id']=$id;
			$data['det']=$d=$this->km->getKelasById($id);
			$data['namakelas']=$d->row('namakelas');
			$data['kapasitas']=$d->row('jlh_siswa');
			//$data['isi']='kelas/aktifedit';
		}
		$this->load->view('index',$data);
	}

	function proseskelas($id)
	{
		
		if(!empty($_POST))
		{
			$namakelas=$_POST['namakelas'];
			$kapasitas=$_POST['kapasitas'];
			
			$add=array(
				'namakelas' => $namakelas,
				'jlh_siswa' => $kapasitas,
				'status' => 't',
			);

			if($id!='null')
			{
				$id=str_replace('%20', ' ', $id);
				$this->db->where('id',$id);
				$this->db->update('t_kelas',$add);
				$this->session->set_flashdata('pesan','Data Kelas Baru Berhasil Di Edit');
			}
			else
			{
				$add=array(
					'namakelas' => $namakelas,
					'jlh_siswa' => $kapasitas,
					'status' => 't',
					'id'=>substr(abs(crc32(md5(sha1(rand())))),0,8),
				);
				$this->db->insert('t_kelas',$add);
				$this->session->set_flashdata('pesan','Data Kelas Baru Berhasil Ditambahkan');
			}
			//echo 'Berhasil';
			//redirect('siswa','location');
		}
	}

	function edit($id=null)
	{
		$id=str_replace('%20', ' ', $id);
		$this->add($id);
	}

	function delete($id)
	{
		$edit=array(
			'status'=>'i'
		);
		$this->db->where('id',$id);
		$this->db->update('t_kelas',$edit);
		$this->session->set_flashdata('pesan','Data Kelas Berhasil Dihapus');
		redirect('kelas','location');
	}
	//----------------------------------------------------------------
	//Kelas Aktif
	//----------------------------------------------------------------
	


	function aktif()
	{
		$data['title']='Daftar Kelas Aktif & Tidak Aktif';
		$data['isi']='kelas/aktif';
		$this->load->view('index',$data);
	}

	function aktifedit($id)
	{
		$data['id']=$id;
		$data['det']=$det=$this->km->getKelasAktifById($id);
		if(!empty($_POST))
		{
			//$simpan['id']=abs(crc32(md5(sha1(rand()))));
			$kk=$this->db->query('select * from t_siswa_has_t_kelas where t_kelas_id="'.$det->row('idkelas').'" and t_ajaran_id="'.$det->row('id_ajaran').'" and namakelasaktif="'.$det->row('namakelasaktif').'"');
			foreach ($kk->result() as $v) 
			{
				$u=array(
					't_kelas_id'=>$this->input->post('kelas'),
					't_user_id'=>$this->input->post('walikelas'),
					't_ajaran_id'=>$this->input->post('ajaran'),
					'namakelasaktif'=>$this->input->post('namakelas'),
					'status' => $this->input->post('status')
				);
				$this->db->where('id',$v->id);
				$this->db->update('t_siswa_has_t_kelas',$u);
			}
			//$this->km->addKelasAktif($simpan);
			redirect('kelas/aktif','location');
		}
		$data['title']='Edit Data Kelas Aktif';
		$data['isi']='kelas/aktifedit';
		
		$this->load->view('index',$data);
	}

	function getKelasAktif($like=null,$st=null)
	{
		$data['d']=$dd=array();
		$this->load->library('pagination');
		$d=$this->km->getKelasAktif($date,$like,$st);
	
		$config['per_page'] = 10;
		$urisegment=5;
		if($like==null || $like=='null')
		{
			$like='null';
		}
		$config['base_url'] = site_url().'kelas/getKelasAktif/'.$like.'/'.$st;
		$config['uri_segment'] = $urisegment; 
		
		$config['class_js'] = 'halKelas_'.$st; 
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
		
		$ddpage=$this->km->getKelasAktif($dr,$like,$st);
		//$data['dd']=$ddpage;
		foreach($ddpage->result() as $_)
		{
			$dd[]=$_;
		}
		$data['d']=$dd;
		echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
						<thead>
							<tr>
								<th style="text-align:center;">No</th>
								<th style="text-align:center;">Kelas</th>
								<!--<th style="text-align:center;">Wali Kelas</th>-->
								<th style="text-align:center;">Jumlah Siswa</th>
								<th style="text-align:center;">Tahun Ajaran</th>
								<th  style="text-align:center;"></th>
								<th  style="text-align:center;">Action</th>
								<!--<th  style="text-align:center;">
								Pilih Semua
								
								<input type="checkbox" id="pilih_'.$st.'" value="option1"  name="pilih" onclick="pilihsemua(\'pilih\',\''.$st.'\')">
								
								</th>-->							
							</tr>
						</thead>
						<tbody>
						';
		$no=$this->uri->segment($urisegment)+1;
		foreach($dd as $idx=>$si)
		{

			$jlhSiswa = $this->km->getSiswaByNamaKelas($si->idkelas,$si->namakelasaktif,$si->id_ajaran,'t');

			echo '<tr '.($idx%2==0 ? 'class="odd"' : 'class="even"').'>
				<td style="text-align:center">'.$no.'</td>
				<td class="center" style="text-align:left">'.$si->namakelas.' - '.$si->namakelasaktif.'</td>
				<!--<td class="center" style="text-align:left">'.$si->nama_guru.'</td>-->
				<td class="center" style="text-align:center">'.$jlhSiswa->num_rows().'</td>
				<td class="center" style="text-align:center">'.$si->tahunajaran.'</td>
				<td class="center" style="text-align:center">
					<a href="'.site_url().'kelas/addsiswakelas/'.$si->idkelas.'_'.$si->namakelasaktif.'/'.$si->id_ajaran.'" class="btn btn-primary btn-mini"><i class="icon-plus-sign"></i> Tambah Siswa</a>
				</td>

				<td class="right" style="text-align:center">
					<!--<a class="btn btn-success btn-mini" href="#">
						<i class="icon-zoom-in icon-white"></i>  
						                                            
					</a>-->
					<a class="btn btn-info  btn-mini" href="'.site_url().'kelas/aktifedit/'.$si->id.'">
						<i class="icon-edit icon-white"></i>  
						                                            
					</a>
					<a class="btn btn-danger btn-mini" href="#" onclick="del(\''.$si->id.'\')">
						<i class="icon-trash icon-white"></i> 
						
					</a>
				</td>
				<!--<td style="text-align:center;">
						<input type="checkbox" id="pilihan_'.$st.'" value="option1"  name="pilihan[\''.$si->id.'\']">
				</td>-->
			</tr>';
			$no++;
		}

		echo '</tbody></table>';
		if($st=='t')
		{
			echo '<script>
			function '.$config['class_js'].'(h)
			{
				//alert(h);
				$(\'#isiAktif\').load(\''.site_url().'kelas/getKelasAktif/'.$like.'/'.$st.'/\'+h);
			}
			</script>';
		}
		else
		{
			echo '<script>
			function '.$config['class_js'].'(h)
			{
				//alert(h);
				$(\'#isiTdkAktif\').load(\''.site_url().'kelas/getKelasAktif/'.$like.'/'.$st.'/\'+h);
			}
			</script>';

		}
		echo '<div class="pagination">'.$this->pagination->create_links2().'</div>';
	}

	function addkelasaktif()
	{
		if(!empty($_POST))
		{
			$simpan['id']=substr(abs(crc32(md5(sha1(rand())))),0,8);
			$simpan['nis']=$this->input->post('nama');
			$simpan['kelas']=$this->input->post('kelas');
			$simpan['wali']=$this->input->post('walikelas');
			$simpan['ajaran']=$this->input->post('ajaran');
			$simpan['namakelas']=$this->input->post('namakelas');
			
			$bayar=$this->input->post('bayar');

			$this->km->addKelasAktif($simpan);
			
			$cel=$this->db->query('select * from t_record_pembayaran_siswa where t_siswa_nis="'.$simpan['nis'].'" and t_kelas_aktif_id="'.$simpan['kelas'].'"');
			
			if($cel->num_rows==0)
			{

				//$jen=$this->pm->getJenisPembayaranByParent(1);
				
				$jen=$this->pm->getJenisPembayaranByID($bayar);
				

				$pen=array();
				foreach($jen->result() as $p)
				{
					//echo $p->id.'<br>';
					$simpan['t_jenis_pembayaran_id']=$p->id;
					$simpan['wajib_bayar']=$p->jumlah;
					$simpan['sudah_bayar']=0;
					$simpan['sisa']=$p->jumlah-0;
					$this->pm->createRecordPembayaran($simpan);
				}

				$ajaran=$this->km->getTahunAjaranById($simpan['ajaran']);
				$thn=explode('-', $ajaran->row('tahunajaran'));

				$spp['id']=substr(abs(crc32(md5(sha1(rand())))),0,8);
				$bb=$this->pm->getJenisPembayaranByID(10);
				$spp['wajib_bayar']=$bb->row('jumlah');
				$spp['bulan']=7;
				$spp['t_jenis_pembayaran_id']=10;
				$spp['t_siswa_nis']=$simpan['nis'];
				$spp['t_siswa_has_t_kelas_id']=$simpan['id'];
				$spp['sudah_bayar']=0;
				$spp['tahun']=$thn[0];
				$spp['ket']='';
				$spp['sisa_bayar']=$bb->row('jumlah');

				$this->pm->addpenerimaanrutin($spp);
			}

			redirect('kelas/aktif','location');
		}
	}

	function addsiswakelas($idk,$idajaran)
	{
		$ii=explode('_', $idk);
		$idkelas=$ii[0];
		$namakelasaktif=$ii[1];
		$namakelasaktif=str_replace('%20', ' ', $namakelasaktif);
		$cek=$this->km->getKelasAktifByNameNAjaran($idkelas,$namakelasaktif,$idajaran);
		if(!empty($_POST))
		{
			// echo '<pre>';
			// print_r($_POST);
			// echo '</pre>';
			$sis=$this->input->post('namasiswa');
			foreach($sis as $index=> $ss)
			{
				if(!empty($ss))
				{
					$diskon=$diskonspp='';
					$jumlah_diskon=$jumlah_diskonspp=0;
					$simpan['id']=$id=substr(abs(crc32(md5(sha1(rand())))),0,8);
					$simpan['nis']=$ss;
					$simpan['kelas']=$idkelas;
					$simpan['wali']=$cek->row('id_user');
					$simpan['ajaran']=$idajaran;
					$simpan['namakelas']=$cek->row('namakelasaktif');

					$bayar=$_POST['bayar_'.($index+1)][($index+1)];
					$ds=$_POST['diskon_'.($index+1)][($index+1)];
					$dsspp=$_POST['diskonspp_'.($index+1)][($index+1)];

					if($ds!='')
					{
						list($diskon,$jumlah_diskon)=explode('_', $ds);
					}

					if($dsspp!='')
						list($diskonspp,$jumlah_diskonspp)=explode('_', $dsspp);

					$simpan['bayar']=$bayar;
					//echo $index.'<br>';
					$this->km->addKelasAktif($simpan);

					


					$cel=$this->db->query('select * from t_record_pembayaran_siswa where t_siswa_nis="'.$simpan['nis'].'" and t_kelas_aktif_id="'.$simpan['kelas'].'"');
			
					if($cel->num_rows==0)
					{
						//$jen=$this->pm->getJenisPembayaranByParent(1);
						$jen=$this->pm->getJenisPembayaranByID($bayar);
						$pen=array();
						foreach($jen->result() as $p)
						{
							//echo $p->id.'<br>';
							$simpan['t_jenis_pembayaran_id']=$p->id;
							$simpan['wajib_bayar']=$p->jumlah;
							$simpan['sudah_bayar']=0;
							$simpan['sisa']=$p->jumlah-0;
							

							if($diskon!='')
							{	$simpan['jumlah_diskon']=0;
								if($diskon=='rp')
								{
									// $jd=$p->jumlah - $jumlah_diskon;
									$simpan['jumlah_diskon']=$jumlah_diskon;
								}
								else if($diskon=='%')
								{
									$p_p = $p->jumlah * ($jumlah_diskon / 100);
									// $jd = $p->jumlah - $p_p;
									$simpan['jumlah_diskon']=$p_p;
								}

								$diskonsave=array(
									'id_diskon'=>substr(abs(crc32(md5(sha1(rand())))),0,8),
									'jumlah_diskon' => $jumlah_diskon,
									'satuan_diskon' => $diskon,
									'id_jenis_pembayaran' => $p->id,
									'nama_jenis_pembayaran' => $p->jenis,
									'status_diskon'=>'t',
									'id_kelas_aktif' => $id,
									'nis' => $ss
								);
								$this->db->insert('t_diskon',$diskonsave);
							}

							$this->pm->createRecordPembayaran($simpan);
						}

						$ajaran=$this->km->getTahunAjaranById($simpan['ajaran']);
					
						$thn=explode('-', $ajaran->row('tahunajaran'));

						
						$bb=$this->pm->getJenisPembayaranByID(10);
						$spp['wajib_bayar']=$bb->row('jumlah');
						$spp['t_jenis_pembayaran_id']=10;
						$spp['t_siswa_nis']=$simpan['nis'];
						$spp['t_siswa_has_t_kelas_id']=$id;
						$spp['sudah_bayar']=0;
						
						$spp['ket']='';
						$spp['sisa_bayar']=$bb->row('jumlah');

						if($diskonspp!='')
						{
							$spp['jumlah_diskon']=0;
							if($diskonspp=='rp')
							{
								$jd=$bb->row('jumlah') - $jumlah_diskonspp;
								$spp['jumlah_diskon']=$jumlah_diskonspp;
							}
							else if($diskonspp=='%')
							{
								$p_pspp = $bb->row('jumlah') * ($jumlah_diskonspp / 100);
								// $jd = $bb->row('jumlah') - $p_pspp;
								$spp['jumlah_diskon']=$p_pspp;
							}

							$diskonsavespp=array(
								'id_diskon'=>substr(abs(crc32(md5(sha1(rand())))),0,8),
								'jumlah_diskon' => $jumlah_diskonspp,
								'satuan_diskon' => $diskonspp,
								'id_jenis_pembayaran' => $spp['t_jenis_pembayaran_id'],
								'nama_jenis_pembayaran' => 'SPP',
								'status_diskon'=>'t',
								'id_kelas_aktif' => $id,
								'nis' => $ss
							);
							$this->db->insert('t_diskon',$diskonsavespp);
						}
						for ($i=7; $i <= 18 ; $i++) 
						{ 
							$spp['id']=substr(abs(crc32(md5(sha1(rand())))),0,8);
							if($i>12)
							{
								$spp['bulan']=$i-12;
								$spp['tahun']=($thn[0]+1);
							}
							else
							{
								$spp['bulan']=$i;
								$spp['tahun']=$thn[0];
							}
							$this->pm->addpenerimaanrutin($spp);
						}
					}
					
					//echo '<pre>';
					//print_r($simpan);
					//echo '</pre>';
				}
			}
				
			
				
			redirect('kelas/addsiswakelas/'.$idkelas.'_'.$namakelasaktif.'/'.$idajaran.'','location');
		}
		//$data['siswakelas']=$this->km->getSiswaByKelas($idkelas,$idajaran,'t');
		$data['siswakelas']=$this->km->getSiswaByNamaKelas($idkelas,$namakelasaktif,$idajaran,'t');
		$data['cek']=$cek;
		$data['namakelasaktif']=$namakelasaktif;
		$data['title']='Tambah Siswa : Kelas '.$cek->row('namakelas').' - '.$cek->row('namakelasaktif').'';
		$data['isi']='kelas/addsiswa';
		$this->load->view('index',$data);
	
	}

	function delsiswakelas($nis,$idkelas,$idajaran)
	{
		$nis=str_replace('%20', ' ', $nis);
		$u=array(
			'status_siswa_aktif' => 'i',
		);
		$this->db->where('t_siswa_nis',$nis);
		$this->db->where('t_kelas_id',$idkelas);
		$this->db->where('t_ajaran_id',$idajaran);
		$this->db->update('t_siswa_has_t_kelas',$u);
	}

	function getKelasByNISJSON($nis,$status=null)
	{
		$st=($status==null ? 't' : $status);
		$nis=str_replace('%20', ' ', $nis);
		$kelas=$this->km->getKelasAktifByNIS($nis,$st);
		//if($kelas->num_rows!=0)
		//{
			$json = $kelas->result();
			$a=json_encode($json);
			//echo str_replace(array('[',']'),'',$a);
			echo $a;
		//}
	}

	function hapuskelas($id)
	{
		$sq=$this->db->query('select * from t_siswa_has_t_kelas where id="'.$id.'"');
		$this->db->query('update t_siswa_has_t_kelas set status="i" where t_kelas_id="'.$sq->row('t_kelas_id').'" and t_ajaran_id="'.$sq->row('t_ajaran_id').'" and namakelasaktif="'.$sq->row('namakelasaktif').'"');

		$this->session->set_flashdata('pesan','Data Kelas Aktif Berhasil Di Hapus');
		redirect('kelas/aktif','location');
	}

	//--------------------------------------------//
	function pembagiankelas($id=null,$idajaran=null,$subkelasid=null)
	{
		$data['title']='Pembagian Kelas';
		$data['isi']='kelas/pembagian';
		$data['dd']=$this->db->query('select * from v_kelas_aktif where st_aktif="t" group by id_ajaran,idkelas;')->result();
		$data['tabb']='utama';
		$data['id']='1';
		$data['idajaran']=$idajaran;
		$data['namakelas']='Kelas%201';
		$ta=$this->db->query('select * from t_ajaran where id="'.$idajaran.'"');
		if($id!=null)
		{
			$d=$this->db->query('select * from v_kelas_aktif where st_aktif="t"and idkelas="'.$id.'" and id_ajaran="'.$idajaran.'" group by id_ajaran,idkelas;')->result();
			$data['id']=$id;
			// $data['idajaran']=$idajaran;
			$data['namakelas']=str_replace(' ', '%20', $d[0]->namakelas);
			$data['tabb']='detail';
			$data['sub']=array();

			if($subkelasid!=null)
			{
				$data['tabb']='detailsubkelas';
				$data['det']=$d;
				$data['subkelasid']=$subkelasid;
				$sub=$this->db->query('select * from t_pembagian as tp left join t_pembagian_siswa as tps on (tp.id=tps.id_pembagian) where tp.id="'.$subkelasid.'" and tp.tahun_ajaran="'.$ta->row('tahunajaran').'"');
				$data['sub']=$sub->result();
			}

		}

		$this->load->view('index',$data);
	}

	function addpembagiansiswa($idkelas,$kelasid,$pembagianid,$idajaran)
	{
		$kelasid=str_replace('%20', ' ', $kelasid);
		if(!empty($_POST))
		{
			$dt=$_POST['namasiswadata'];
			$datasiswa=explode(',', $dt);
			foreach ($datasiswa as $k => $v) 
			{
				if($v!='')
				{

					$d[$k]=$v;
					list($nis,$idkelasaktif,$namasiswa)=explode('|', $v);
					$dd['nis'][$k]=$nis;
					$dd['idkelasaktif'][$k]=$idkelasaktif;
					$dd['nama'][$k]=$namasiswa;
				}
			}
			
			// echo '<pre>';
			// print_r($dd);
			// print_r($d);
			// echo '</pre>';

			foreach ($d as $kk => $vv) 
			{
				$ins=array(
					'id_pembagian' => $pembagianid,
					'nama_siswa' => $dd['nama'][$kk],
					'id_siswa' => $dd['nis'][$kk],
					'id_kelas_aktif' => $dd['idkelasaktif'][$kk],
					'status' => 't'
				);
				$this->db->insert('t_pembagian_siswa',$ins);
				# code...
			}

			$this->session->set_flashdata('pesan','Data Siswa Berhasil Di Tambahkan');
			redirect('kelas/pembagiankelas/'.$idkelas.'/'.$idajaran.'/'.$pembagianid,'location');
		}
	}

	function pembagianform($idkelas,$idajaran,$id=-1)
	{
		$data['idkelas']=$idkelas;
		$data['idajaran']=$idajaran;
		$d=$this->db->query('select * from t_kelas where id="'.$idkelas.'"');
		$data['d']=$d->result();

		$ta=$this->db->query('select * from t_ajaran where id="'.$idajaran.'" or tahunajaran="'.$idajaran.'"');
		$data['ta']=$ta->result();

		if($id!=-1)
		{
			$da=$this->db->from('t_pembagian')->where('id',$id)->get();
			$data['da']=$dda=$da->result();
			$data['idedit']=$id;
			list($kelas,$namakelas)=explode('_', $dda[0]->nama_kelas);
			$data['namakelas']=$namakelas;
		}

		$this->load->view('kelas/pembagian-form',$data);
	}

	function datasiswaperkelas($id_pembagian)
	{
		$d=$this->db->query('select * from t_pembagian_siswa where id_pembagian="'.$id_pembagian.'" and status="t" order by id_siswa,nama_siswa');
		echo '<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">';
		echo '<thead>';
		if($d->num_rows!=0)
		{
				echo '<tr>
						<th style="text-align:center;">No</th>
						<th style="text-align:center;">NIS</th>
						<th  style="text-align:center;">Nama Siswa</th>					
						<th  style="text-align:center;">Action</th>					
					</tr>
				</thead>
				<tbody>';
			foreach ($d->result() as $k => $v) 
			{
				echo '<tr>';
					echo '<td>'.($k+1).'</td>';
					echo '<td>'.($v->id_siswa).'</td>';
					echo '<td>'.($v->nama_siswa).'</td>';
					echo '<td style="text-align:center;cursor:pointer">
							<i class="icon icon-red icon-remove" onclick="removesiswa(\''.$v->id.'\')"></i>
						</td>';
				echo '</tr>';
			}
			echo '</tbody>';
		}
		else
		{
			echo '<tr><th style="text-align:center;"><i>Data Siswa Masih Belum Tersedia</i></th></tr>';
			echo '</thead>';
		}
		echo '</table>';
	}

	function hapusdatasiswa($id)
	{
		$d=$this->db->query('select * from t_pembagian_siswa where id="'.$id.'"');
		$dd=$this->db->query('select * from t_pembagian_siswa where id_pembagian="'.$d->row('id_pembagian').'" and status="t"');
		$this->db->query('update t_pembagian_siswa set status="f" where id="'.$id.'"');

		$jlh=($dd->num_rows - 1);

		echo $d->row('id_pembagian').'-'.$jlh;
	}

	function addpembagiankelas($idkelas,$kelas_id,$tahunajaran,$idajaran)
	{
		if(!empty($_POST))
		{
			$kelas=str_replace('%20', ' ', $kelas_id);
			foreach ($_POST as $k => $v) 
			{
				$d[$k]=$v;
			}

			$in=array(
				'nama_kelas' => $kelas.'_'.$d['namakelas'],
				'tahun_ajaran' => $tahunajaran,
				'status' => 't',
				'walikelas' => $d['walikelas']
			);
			$this->db->insert('t_pembagian',$in);
			$this->session->set_flashdata('pesan','Data Pembagian Kelas Berhasil Ditambah<br> Silahkan tambahkan Siswa ke dalam Kelas');
			redirect('kelas/pembagiankelas/'.$idkelas.'/'.$idajaran,'location');
			// echo '<pre>';
			// print_r($d);
			// echo '</pre>';
		}
	}

	function editpembagiankelas($idkelas,$kelas_id,$tahunajaran,$idajaran)
	{
		if(!empty($_POST))
		{
			$kelas=str_replace('%20', ' ', $kelas_id);
			// foreach ($_POST as $k => $v) 
			// {
			// 	$d[$k]=$v;
			// }
			$d=$_POST;
			// $idedit=$_POST[''];
			$in=array(
				'nama_kelas' => $kelas.'_'.$d['namakelas'],
				'tahun_ajaran' => $tahunajaran,
				'status' => 't',
				'walikelas' => $d['walikelas']
			);
			$this->db->where('id',$d['idedit']);
			$this->db->update('t_pembagian',$in);
			$this->session->set_flashdata('pesan','Data Pembagian Kelas Berhasil Di Edit<br> Silahkan tambahkan Siswa ke dalam Kelas');
			redirect('kelas/pembagiankelas/'.$idkelas.'/'.$idajaran,'location');
			// echo '<pre>';
			// print_r($d);
			// echo '</pre>';
		}
	}
	function pembagiankelashapus($id,$idkelas)
	{
		$this->db->query('update t_pembagian set status="f" where id="'.$id.'"');
		$this->session->set_flashdata('pesan','Data Pembagian Kelas Berhasil Di Hapus');
		redirect('kelas/pembagiankelas/'.$idkelas,'location');
	}

	function datapembagiankelas($st='t',$namakelas=null,$idajaran=null)
	{
		if($idajaran!=null)
		{
			$data['d']=$dd=array();
			$this->load->library('pagination');
			$namakelas=str_replace('%20', ' ', $namakelas);
			$ta=$this->db->query('select * from t_ajaran where id="'.$idajaran.'"');
			if($namakelas==null || $namakelas=='null')
				$d=$this->db->query('select * from t_pembagian where status="'.$st.'" and tahun_ajaran="'.$ta->row('tahunajaran').'"');
			else
				$d=$this->db->query('select * from t_pembagian where status="'.$st.'" and nama_kelas like "%'.$namakelas.'%"  and tahun_ajaran="'.$ta->row('tahunajaran').'"');

			$config['per_page'] = 10;
			$urisegment=6;
			$config['base_url'] = site_url().'kelas/datapembagiankelas/'.$st.'/'.$namakelas.'/'.$idajaran;
			$config['uri_segment'] = $urisegment; 
			$data['uri_segment'] = $urisegment; 
			
			$config['class_js'] = 'halKelas_'.$st; 
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
			
			if($namakelas==null)
				$ddpage=$this->db->query('select * from t_pembagian where status="'.$st.'" and tahun_ajaran="'.$ta->row('tahunajaran').'" order by nama_kelas limit '.$data['offset'].','.$data['num'].'');
			else
				$ddpage=$this->db->query('select * from t_pembagian where status="'.$st.'" and nama_kelas like "%'.$namakelas.'%" and tahun_ajaran="'.$ta->row('tahunajaran').'" order by nama_kelas limit '.$data['offset'].','.$data['num'].'');

			$data['d']=$ddpage->result();
			$data['idajaran']=$idajaran;
			$this->load->view('kelas/pembagian-data',$data);
		}
	}
}