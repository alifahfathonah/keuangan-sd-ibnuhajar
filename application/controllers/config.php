<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Config extends A {

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
		
		if($this->session->userdata('logged')!='TRUE')
			redirect('login','location');
	}
	
	function jenispenerimaan($id=null)
	{
		$data['jenis']=array();
		if($id!=null)
		{
			// $kd=substr($kode, 0,1);
			list($jns,$idd)=explode('-', $id);
			$data['jenis']=$this->db->query('select * from t_jenis_pembayaran where kategori="'.str_replace('%20', ' ', $jns).'" and status="t" order by id')->result();
		}
		// else
		// {

		// }
		$data['data']=$this->db->query('select * from t_jenis_pembayaran where status="t" and kategori!="" group by kategori')->result();
		$data['title']='Pengaturan Jenis Penerimaan';
		$data['isi']='config/jenispenerimaan';
		$data['jenisp']=$id;
		$this->load->view('index',$data);
	}

	function editjenispenerimaan($id)
	{
		$det=$this->db->query('select * from t_jenis_pembayaran where id="'.$id.'"');
		if(!empty($_POST))
		{
			$data['kode_akun']=$kodeakun=$this->input->post('kodeakun');
			$data['jenis']=$this->input->post('jenispenerimaan');
			$data['kategori']=$this->input->post('kategoripenerimaan');
			$idp=strtok($kodeakun, 0);
			$cidp=strlen($idp);
			if($cidp==1)
				$data['id_parent']=0;
			else
			{
				$ctot=strlen($id);
				$kali=$ctot-($cidp-1);
				$data['id_parent']=(substr($idp, 0,($cidp-1))*pow(10,$kali));
			}
			$data['status_tampil']='t';
			// $id=$this->input->post('kodeakun');
			$this->db->where('kode_akun',$id);
			$this->db->update('t_kode_akun',$data);
			$ka=substr($id, 0, 1);
			redirect('config/jenispenerimaan/'.$ka,'location');
		}
		$akun=$this->db->query('select * from t_kode_akun order by kode_akun');
		$ak=$akc=array();
		foreach ($akun->result() as $k => $v) 
		{
			$ak[$v->id_parent][$v->kode_akun]=$v;
			if($v->id_parent!=0)
			{
				$left=substr($v->kode_akun, 0,1);
				$akc[$left][$v->kode_akun]=$v;
			}
		}
		$data['det']=$det;
		$data['id']=$id;
		echo '<form id="fform-action-edit" style="width:100% !important" class="form-horizontal" action="'.site_url().'config/editjenispenerimaan/'.$id.'" method="post" enctype="multipart/form-data">
				<div class="">

					<div class="control-group">
						<label class="control-label" for="typeahead">Kode Akun</label>
							<div class="controls">
								<select name="kodeakun" data-placeholder="Kode Akun" id="selectError2" data-rel="chosen">
									<option value=""></option>';
									foreach ($ak[0] as $k => $v) 
									{
										echo '<optgroup label="'.$v->kode_akun.'-'.$v->nama_akun.'">';
										$pe=strtok($v->kode_akun, '0');
										foreach ($akc[$pe] as $ka => $va) 
										{
											if($v->kode_akun==$det->row('kode_akun'))
												echo '<option selected="selected" value="'.$va->kode_akun.'">'.$va->kode_akun.'-'.$va->nama_akun.'</option>';
											else
												echo '<option value="'.$va->kode_akun.'">'.$va->kode_akun.'-'.$va->nama_akun.'</option>';
										}
										echo '</optgroup>';	# code...
									}
							echo '</select>
							</div>
						</div>
						<div class="control-group">
									  <label class="control-label" for="typeahead">Jenis Penerimaan</label>
									  <div class="controls">
										<input type="text" name="jenispenerimaan" class="span6 typeahead" id="namaakun"  value="'.$det->row('jenis').'" style="width:100%;" required>
										<input type="hidden" name="idparent" class="span6 typeahead" id="idparent" style="width:100%;" >
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Kategori Penerimaan</label>
									  <div class="controls">
										<select id="selectError" name="kategoripenerimaan" data-rel="chosen">
											<option></option>
											<option value="sekolah" '.($det->row('kategori')=='sekolah' ? 'selected="selected"' : '').'>Penerimaan Sekolah</option>
											<option value="unit bisnis" '.($det->row('kategori')=='unit bisnis' ? 'selected="selected"' : '').'>Penerimaan Unit Bisnis</option>
										  </select>
									  </div>
									</div>
		
					
				</div>
			</form>';
	}

	function kodeakun($kode=null)
	{
		$data['kode']=array();
		if($kode!=null)
		{
			$kd=substr($kode, 0,1);
			// $data['kode']=$this->db->query('select * from t_kode_akun where left(kode_akun,1)="'.$kd.'" order by kode_akun')->result();
		}
		else
		{
			$data['kodeakun']=$kd=1;
		}
			$data['kode']=$this->db->query('select * from t_kode_akun where left(kode_akun,1)="'.$kd.'" order by kode_akun')->result();
			//$
		$data['data']=$this->db->query('select * from t_kode_akun where id_parent=0 and status_tampil="t" order by kode_akun')->result();
		$data['title']='Pengaturan Kode Akun';
		$data['isi']='config/kodeakun';
		$data['kodeakun']=$kode;
		$this->load->view('index',$data);
	}

	function addkodeakun($id=null)
	{
		if(!empty($_POST))
		{
			$data['kode_akun']=$kodeakun=$this->input->post('kodeakun');
			$data['nama_akun']=$this->input->post('namaakun');
			$data['id_parent']=$this->input->post('idparent');
			$data['status_tampil']='t';
			$this->db->insert('t_kode_akun',$data);
			// $this->session->set_flashdata('pesan','Kode Akun Berhasil Di Tambahkan');
			redirect('config/kodeakun/'.$kodeakun,'location');
		}
		$kod=strtok($id, '0');
		echo '<form id="fform-action-edit" style="width:100% !important" class="form-horizontal" action="'.site_url().'config/addkodeakun" method="post" enctype="multipart/form-data">
				<div class="">

					<div class="control-group">
						<label class="control-label" for="typeahead">Kode Akun</label>
							<div class="controls">
								<input type="text" name="kodeakun" class="span6 typeahead" id="kodeakunadd" style="width:100%;" required value="'.$kod.'">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="typeahead">Nama Akun</label>
								<div class="controls">
									<input type="text" name="namaakun" class="span6 typeahead" id="namaakun" style="width:100%;" required >
									<input type="hidden" name="idparent" class="span6 typeahead" id="idparent" style="width:100%;" value="'.$id.'">
								</div>
						</div>
		
					
				</div>
			</form>';
	}

	function editkodeakun($id)
	{
		$det=$this->db->query('select * from t_kode_akun where kode_akun="'.$id.'"');
		if(!empty($_POST))
		{
			$data['kode_akun']=$kodeakun=$this->input->post('kodeakun');
			$data['nama_akun']=$this->input->post('namaakun');
			$idp=strtok($kodeakun, 0);
			$cidp=strlen($idp);
			if($cidp==1)
				$data['id_parent']=0;
			else
			{
				$ctot=strlen($id);
				$kali=$ctot-($cidp-1);
				$data['id_parent']=(substr($idp, 0,($cidp-1))*pow(10,$kali));
			}
			$data['status_tampil']='t';
			// $id=$this->input->post('kodeakun');
			$this->db->where('kode_akun',$id);
			$this->db->update('t_kode_akun',$data);
			$ka=substr($id, 0, 1);
			redirect('config/kodeakun/'.$ka,'location');
		}

		$data['det']=$det;
		$data['id']=$id;
		echo '<form id="fform-action-edit" style="width:100% !important" class="form-horizontal" action="'.site_url().'config/editkodeakun/'.$id.'" method="post" enctype="multipart/form-data">
				<div class="">

					<div class="control-group">
						<label class="control-label" for="typeahead">Kode Akun</label>
							<div class="controls">
								<input type="text" name="kodeakun" class="span6 typeahead" id="kodeakunedit" style="width:100%;" required value="'.$det->row('kode_akun').'">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="typeahead">Nama Akun</label>
								<div class="controls">
									<input type="text" name="namaakun" class="span6 typeahead" id="namaakun" style="width:100%;" required  value="'.$det->row('nama_akun').'">
									
								</div>
						</div>
		
					
				</div>
			</form>	';
	}

	function tahunajaran()
	{
		$data['title']='Pengaturan Tahun Ajaran';
		$data['isi']='config/tahunajaran';
		$data['data']=$this->cm->getTahunAjaran(-1)->result();
		$this->load->view('index',$data);
	}

	function addajaran()
	{
		if(!empty($_POST))
		{
			$ta=$this->input->post('tahunajaran');
			$this->cm->saveTahunAjaran($ta);
			
			redirect('config/tahunajaran','location');
		}
	}

	function editajaran($id)
	{
		$data['det']=$det=$this->cm->getTahunAjaran($id);
		$data['id']=$id;
		if(!empty($_POST))
		{
			$data['ta']=$this->input->post('tahunajaranedit');
			$this->cm->EditTahunAjaran($data);
			
			redirect('config/tahunajaran','location');
		}

		echo '<form id="fform-action-edit" style="width:100% !important" class="form-horizontal" action="'.site_url().'config/editajaran/'.$id.'" method="post" enctype="multipart/form-data">
				<div class="">

					<div class="control-group">
					  <label class="control-label" for="typeahead">Tahun Ajaran</label>
					  <div class="controls">
						<input type="text" name="tahunajaranedit" class="span6 typeahead" id="tahunajaran" value="'.$det->row('tahunajaran').'" style="width:80%;">
					  </div>
					</div>
		
					
				</div>
			</form>	';
	}

	///////////////////////Driver/////////////////////////////

	function driver()
	{
		$data['title']='Pengaturan Data Driver';
		$data['isi']='config/driver';
		$data['data']=$this->cm->getDriver(-1)->result();
		$this->load->view('index',$data);
	}

	function tambahdriver()
	{
		if(!empty($_POST))
		{
			$data['id']=abs(crc32(md5(rand())));
			$data['nama']=$this->input->post('nama');
			$data['alamat']=$this->input->post('alamat');
			$data['telp']=$this->input->post('telp');
			$this->cm->saveDriver($data);
			redirect('config/driver','location');
		}
	}

	function editdriver($id)
	{
		$data['det']=$det=$this->cm->getDriver($id);
		$data['id']=$id;
		if(!empty($_POST))
		{
			$data['nama']=$this->input->post('nama');
			$data['alamat']=$this->input->post('alamat');
			$data['telp']=$this->input->post('telp');
			$data['id']=$id;
			$this->cm->updateDriver($data);
			
			redirect('config/driver','location');
		}

		echo '<form id="fform-action-edit" style="width:100% !important" class="form-horizontal" action="'.site_url().'config/editdriver/'.$id.'" method="post" enctype="multipart/form-data">
	<div class="">
		<div class="control-group">
		  <label class="control-label" for="typeahead">Nama</label>
		  <div class="controls">
			<input type="text" name="nama" value="'.$det->row('nama_driver').'" class="span6 typeahead" id="" style="width:80%;">
		  </div>
		</div>
		<div class="control-group">
		  <label class="control-label" for="typeahead">Rute</label>
		  <div class="controls">
			<input type="text" name="alamat" value="'.$det->row('alamat').'" class="span6 typeahead" id="" style="width:80%;">
		  </div>
		</div>
		<div class="control-group">
		  <label class="control-label" for="typeahead">Telp</label>
		  <div class="controls">
			<input type="text" name="telp" class="span6 value="'.$det->row('telp').'" typeahead" id="" style="width:80%;">
		  </div>
		</div>		
		 
	</div>
</form>';
	}

	function adddriversiswa($idjenis)
	{
		if(!empty($_POST))
		{
			$data['iddriver']=$iddriver=$this->input->post('iddriver');
			$nis=$this->input->post('namasiswa');

			foreach ($nis as $k => $n) 
			{
				# code...
				$data['nis']=$n;
				if(!empty($n) || $n!='')
				{
					$this->cm->saveDriverSiswa($data);
				}
			}
			//echo $iddriver.'-'.$nis;
			
			redirect('penerimaan/rutin/'.$idjenis.'','location');
		}
	}

	function editspp()
	{
		$sq=$this->db->query('select * from v_data_kewajiban where sisa=0 and (t_jenis_pembayaran_id=3 or t_jenis_pembayaran_id=4)');
		if($sq->num_rows!=0)
		{
			foreach ($sq->result() as $k => $v) 
			{
				$cek=$this->db->query('select * from t_penerimaan_rutin where t_siswa_nis="'.$v->t_siswa_nis.'" and t_siswa_has_t_kelas_id="'.$v->t_kelas_aktif_id.'" and t_jenis_pembayaran_id="10" and bulan=7');
				// $this->db->query("update t_penerimaan_rutin set sudah_bayar='300000', sisa_bayar=0 where id='".$cek->row('id')."'");
				
				$pemb=$this->db->query('select * from t_pembayaran where t_jenis_pembayaran_id=4 and t_siswa_has_t_kelas_id="'.$v->t_kelas_aktif_id.'"');

				if($pemb->num_rows!=0)
				{
					$ins=array(
						't_jenis_pembayaran_id'=>10,
						't_siswa_has_t_kelas_id'=>$v->t_kelas_aktif_id,
						'id'=>abs(crc32(sha1(md5(rand())))),
						'jumlah'=>$cek->row('wajib_bayar'),
						'tgl_transaksi'=>$pemb->row('tgl_transaksi'),
						't_user_id'=>1,
						'penyetor'=>$pemb->row('penyetor'),
						'id_parent_jenis_pembayaran'=>10,
						'keterangan'=>7,
						'catatan'=>$pemb->row('catatan')
					);
					$this->db->insert('t_pembayaran',$ins);
				}
				// if($v->t_jenis_pembayaran_id==4)
					// echo $cek->row('id').'<br>';
			}
		}
	}

	//-----------------------------------------
	function profile()
	{
		$data['title']='Profile System';
		$data['isi']='config/profile';
		// $data['data']=$this->cm->getTahunAjaran(-1)->result();
		$this->load->view('index',$data);
	}
	function saveprofile()
	{
		if(!empty($_POST))
		{
			$id=$this->session->userdata('iduser');
			$user=$_POST['username'];
			$password=sha1($_POST['password']);
			$nama=($_POST['nama']);
			$email=($_POST['email']);
			$n=array(
				'user' => $user,
				'pass' => $password,
				'nama' => $nama,
				'email' => $email
			);
			$this->db->where('id',$id);
			$this->db->update('t_user',$n);
			$this->session->set_flashdata('pesan','Data Profile Berhasil Di Update');
			redirect('config/profile','location');
		}

	}
}