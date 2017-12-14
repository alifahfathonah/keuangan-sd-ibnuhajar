<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('a.php');
class Pengeluaran extends A {

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
		$data['title']='Transaksi Pengeluaran';
		$data['isi']='pengeluaran/index';
		$this->load->view('index',$data);
	}

	function jenisdata()
	{
		$d=$this->db->from('t_jenis_pengeluaran')->where('status_tampil','t')->order_by('jenis')->get();
		$data['d']=$d;
		$this->load->view('pengeluaran/jenis-data',$data);
	}
	function jenisform($id=-1,$child=null)
	{
		$data['id_parent']=0;
		$data['child']='';
		if($id!=-1)
		{
			$d=$this->db->from('t_jenis_pengeluaran')->where('id',$id)->get();
			$data['d']=$d;
			if($child!=null)
			{
				// $ctot=strlen($id);
				$idp=strtok($id, '0');
				
				// $cidp=strlen($idp);
				// $data['id_parent']=(substr($d->row('id_parent'), 0,($cidp-1))*pow(10,$kali));
				$data['idp']=$idp;
				$data['child']='child';
				$data['id_parent']=$id;
			}
		}
		$data['id']=$id;
		$this->load->view('pengeluaran/jenis-form',$data);
	}
	function jenisproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$child=$_POST['child'];
			$data['jumlah']=$jarak=str_replace(',', '', $_POST['jumlah']);
			$data['status_tampil']='t';
			unset($data['child']);
			if($id!=-1 && $child=='')
			{
				$this->db->where('id',$id);
				$c=$this->db->update('t_jenis_pengeluaran',$data);
				
				if($c)
					echo 'Data Jenis Pengeluaran Berhasil Di Edit';
				else
					echo 'Data Jenis Pengeluaran Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_jenis_pengeluaran',$data);
				
				if($c)
					echo 'Data Jenis Pengeluaran Berhasil Di Simpan';
				else
					echo 'Data Jenis Pengeluaran Gagal Di Simpan';
			}	
		}
		else
			echo 'Data Jenis Pengeluaran Gagal Di Simpan';
	}
	function jenishapus($id)
	{
		$this->db->query('update t_jenis_pengeluaran set status_tampil="f" where id="'.$id.'"');
		echo 'Data Jenis Pengeluaran Berhasil Di Hapus';
	}
	//----------------------------------------------------------------------------------------

	function pengeluaranform($id=-1)
	{
		$data['id_parent']=0;
		if($id!=-1)
		{
			$d=$this->db->from('t_jenis_pengeluaran')->where('id',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('pengeluaran/pengeluaran-form',$data);
	}

	function pengeluaranproses($id)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		$d=$_POST;
		list($idjenis,$jenis)=explode('-', $_POST['jenis_pengeluaran']);
		$jenis=str_replace('%20', ' ', $jenis);
		unset($d['jenis_pengeluaran']);
		unset($d['ket']);
		$d['jenis']=$jenis;
		$d['jumlah']=str_replace(',', 0, $d['jumlah']);
		$d['id_jenis']=$idjenis;
		$d['status_tampil']='t';
		$d['status_verifikasi']='t';
		if($id!=-1)
		{
			$this->db->where('id_trans',$id);
			$this->db->update('t_transaksi_pengeluaran',$d);
		}
		else
		{
			$this->db->insert('t_transaksi_pengeluaran',$d);

			$dkas['jumlah']=$dkas['sisa']=$d['jumlah'];
			$dkas['tanggal']=$d['tgl_transaksi'];
			$dkas['no_kwitansi']=$d['no_kwitansi'];
			$dkas['keterangan']=$_POST['ket'];
			$dkas['status_verifikasi']='t';
			$dkas['status_tampil']='t';
		}


	}
	function pengeluarandata()
	{
		$d=$this->db->from('t_transaksi_pengeluaran')->where('status_tampil','t')->order_by('tgl_transaksi')->get();
		$data['d']=$d;
		$this->load->view('pengeluaran/pengeluaran-data',$data);
	}
	//------------------------

	function pengajuandata()
	{
		$this->load->view('pengeluaran/pengajuan-data');
	}	
	function kwitansipengeluaran($nokwitansi)
	{
		$data['nokwitansi']=$nokwitansi;
		$data['d']=$this->db->from('t_transaksi_pengeluaran')->where('no_kwitansi',$nokwitansi)->get()->result();
		$this->load->view('pengeluaran/kwitansi-pengeluaran-cetak',$data);
	}
	function pengajuandetail($id,$jenis)
	{
		// echo 'asas';
		$data['id']=$id;
		$data['jenis']=$jenis;
		if($jenis=='laundry')
		{

			$laundry=json_decode($_POST['source']);
			$d_laundry=[];
			foreach ($laundry as $k => $v) 
			{
				$d_laundry[$v->id][]=$v;
			}
			$data['d']=$d_laundry[$id];
		}
		// echo $_POST['source'];
		$this->load->view('pengeluaran/pengajuan-detail',$data);
	}

	function pengajuanform($id,$jenis)
	{
		// echo 'asas';
		$data['id']=$id;
		$data['jenis']=$jenis;
		if($jenis=='laundry')
		{

			$laundry=json_decode($_POST['source']);
			$d_laundry=[];
			foreach ($laundry as $k => $v) 
			{
				$d_laundry[$v->id][]=$v;
			}
			$data['d']=$d_laundry[$id];
		}
		// echo $_POST['source'];
		$this->load->view('pengeluaran/pengajuan-form',$data);
	}

	function pengajuanproses($id,$jenis,$status)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		$d['tgl_transaksi']=$_POST['tanggal'];
		$d['no_kwitansi']=$_POST['nokwitansi'];
		$d['jumlah']=str_replace(',', '', $_POST['disetujui']);
		$d['kasir']=$_POST['kasir'];
		$d['bendahara']=$_POST['bendahara'];
		$d['dibayar_kepada']=$_POST['dibayarkankepada'];
		$d['ket']=$_POST['keperluan'];
		$d['status_verifikasi']=$status;
		$d['status_tampil']='t';
		$d['jenis']=$jenis;

		$this->db->insert('t_transaksi_pengeluaran',$d);
		$this->session->set_flashdata('pesan','Data Pengeluaran Berhasil Di Tambahkan');

		if($jenis=='laundry')
		{
			$d['id']=$id;
			$_url='http://localhost/kehalutuju/laundry/index.php/webservice/postpengajuan';
			$x=postCURL($_url, $d);
		}

		// redirect('pengeluaran','location');
	}
}