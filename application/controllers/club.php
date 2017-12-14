<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Club extends A {

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
		$data['title']='Club';
		$data['isi']='kelas/club';
		$this->load->view('index',$data);
	}
	
	function form($id=-1)
	{
		$data['id']=$id;
		// if($id==-1)
		$data['data']=$this->db->from('t_club')->where('status_tampil','t')->order_by('nama_club','asc')->get()->result();
		// else
		$data['det']=$this->db->from('t_club')->where('status_tampil','t')->where('id_club',$id)->order_by('nama_club','asc')->get();

		$this->load->view('kelas/club-form',$data);
	}

	function process($id=-1)
	{
		if(!empty($_POST))
		{
			$data=$_POST;
			// $data['jadwal']=$_POST['hari'].'__'.$_POST['waktu'];
			if($id!=-1)
			{
				unset($data['id_club']);
				$this->db->where('id_club',$id);
				$c=$this->db->update('t_club',$data);
				if($c)
					echo 2;
				else
					echo 0;
			}
			else
			{
				$c=$this->db->insert('t_club',$data);
				if($c)
					echo 1;
				else
					echo 0;
			}
			
			// $this->session->set_flashdata('');
			// echo '<pre>';
			// print_r($_POST);
			// echo '</pre>';
			// [nama_club] => a
		    // [id_club] => 31457438
		    // [penanggung_jawab] => b
		    // [telp_pj] => c
		 	// [email_pj] => d
		 	// [biaya] => 3
		}
		else
			echo 0;
	}

	function addclubsiswa()
	{
		if(!empty($_POST))
		{
			list($idclub,$bln,$idjenis,$thn)=explode('/', $_POST['idcl']);
			foreach ($_POST['namasiswa'] as $k => $v) 
			{
				if($v!='')
				{
					$d['nis']=$v;
					$d['id_club']=$idclub;
					$d['status_tampil']='t';;
					$this->db->insert('t_club_siswa',$d);
				}
			}
			echo 1;
			// echo '<pre>';
			// print_r($_POST);
			// echo '</pre>';
		}
		else
			echo 0;
	}

	function addpenerimaanclub()
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		if(!empty($_POST))
		{
			$bln=$_POST['bulan'];
			$thn=$_POST['tahun'];
			if($bln>=7 && $bln<=12)
			{
				$ta=($thn).'-'.($thn+1);
			}
			else
			{
				$ta=($thn-1).'-'.($thn);
			}
			$ajaran=$this->db->from('t_ajaran')->where('tahunajaran',$ta)->get();
			//-------------------------------
			$data['bulan']=$bln;
			$data['tahun']=$thn;
			$data['t_jenis_pembayaran_id']=$_POST['jenispenerimaan'];

			foreach ($_POST['siswa'] as $ks => $vs) 
			{
				$data['id']=generate_id();
				$nis=str_replace('\'', '', $ks);
				if($vs=='on')
				{
					$kelasaktif=$this->db->from('v_kelas_aktif')->where('st_aktif','t')->where('status_siswa_aktif','t')->like('nis',$nis)->like('tahunajaran',$ta)->get();
					$nilai=str_replace(',', '', $_POST['jemputan'][$ks]);
					$data['wajib_bayar']=$nilai;
					$data['t_siswa_nis']=$nis;
					$data['t_siswa_has_t_kelas_id']=$kelasaktif->row('id');
					$data['sudah_bayar']=0;
					$data['sisa_bayar']=$nilai;
					$data['keterangan']='idclub:'.$_POST['club'];
					// $data['sisa_bayar']=$nilai;
					// echo '<pre>';
					// print_r($data);
					// echo '</pre>';
					$wh=array('t_siswa_has_t_kelas_id'=>$kelasaktif->row('id') , 'bulan'=>$bln, 'tahun'=>$thn,'t_siswa_nis'=>$nis);
					$cek=$this->db->from('t_penerimaan_rutin')->where($wh)->like('keterangan',$_POST['club'])->get();
					if($cek->num_rows==0)
					{
						$this->db->insert('t_penerimaan_rutin',$data);
					}
					else
					{
						unset($data['id']);
						$this->db->where('id',$cek->row('id'));
						$this->db->update('t_penerimaan_rutin',$data);
					}
					// echo $nis.':'.$nilai.'<br>';
				}
			}
			$this->session->set_flashdata('pesan','Data Tagihan Club Berhasil Ditambah');
			redirect('club','location');
		}
	}
	function hapusdatasiswa($nis,$idclub,$bulan,$tahun)
	{
		$nis=str_replace('_', ' ', $nis);
		$wh1=array('tahun'=>$tahun,'t_siswa_nis' =>$nis);
		$this->db->where($wh1);
		$this->db->where('sisa_bayar >',0);
		$this->db->like('keterangan',$idclub);
		$this->db->delete('t_penerimaan_rutin');

		$wh2 =('nis ="'.$nis.'" and id_club="'.$idclub.'"');
		$d=array('status_tampil'=>'f');
		$this->db->where($wh2);
		$this->db->update('t_club_siswa',$d);
	}
}