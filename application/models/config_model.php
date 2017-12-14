<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getTahunAjaran($id=-1)
	{
		if($id!=-1)
		{
			$qry=$this->db->select('*')
							->from('t_ajaran')
							->where('id',$id)
							->get();
		}
		else
		{
			$qry=$this->db->select('*')
							->from('t_ajaran')
							->order_by('tahunajaran','asc')
							->get();
		}
		return $qry;
	}
	function saveTahunAjaran($ta)
	{
		$in=array(
			'id'=>substr(abs(crc32(md5(rand()))),0,8),
			'tahunajaran'=>$ta,
			'bulan_awal'=>'juli',
			'bulan_akhir'=>'juni',
		);
		$this->db->insert('t_ajaran',$in);
		$this->session->set_flashdata('pesan','Tahun Ajaran Baru Berhasil Disimpan');
	}

	function EditTahunAjaran(&$ta)
	{
		$up=array(
			'tahunajaran'=>$ta['ta']
		);
		$this->db->where('id',$ta['id']);
		$this->db->update('t_ajaran',$up);
		$this->session->set_flashdata('pesan','Tahun Ajaran Berhasil Di Edit');
	}

	////////////////////////////
	//////DRIVER

	function getDriver($id=-1)
	{
		if($id!=-1)
		{
			$q=$this->db->select('*')->from('t_driver')->where('id',$id)->get();
		}
		else
		{
			$q=$this->db->select('*')->from('t_driver')->order_by('nama_driver','asc')->get();	
		}
		return $q;
	}

	function saveDriver(&$data)
	{
		$in=array(
			'id'=>substr($data['id'],0,8),
			'nama_driver'=>$data['nama'],
			'alamat'=>$data['alamat'],
			'telp'=>$data['telp'],
			'status'=>'f',
		);
		$this->db->insert('t_driver',$in);
		$this->session->set_flashdata('pesan','Data Driver Berhasil Ditambahkan');
	}	

	function updateDriver(&$data)
	{
		$in=array(
			'nama_driver'=>$data['nama'],
			'alamat'=>$data['alamat'],
			'telp'=>$data['telp'],
			'status'=>$data['status'],
		);
		$this->db->where('id',$data['id']);
		$this->db->update('t_driver',$in);
		$this->session->set_flashdata('pesan','Data Driver Berhasil Di Edit');
	}

	function getSiswaByDriver($iddriver)
	{
		$qry=$this->db->select('*')->from('v_driver_siswa')->where('id_driver',$iddriver)->get();
		return $qry;
	}

	function saveDriverSiswa(&$data)
	{
		$cek=$this->db->query('select * from t_driver_siswa where id="'.$data['iddriver'].'" and nis="'.$data['nis'].'"')->result();
		$c=count($cek);
		if($c==0)
		{
			$in=array(
				'nis'=>$data['nis'],
				'id_driver'=>$data['iddriver']
			);
			$this->db->insert('t_driver_siswa',$in);
			$this->session->set_flashdata('pesan','Data Jemputan Siswa Berhasil Ditambahkan');
		}
		else
			$this->session->set_flashdata('pesan','Data Jemputan Siswa Gagal Ditambahkan');

	}
}
