<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelas_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getKelas(&$limit,$like=null)
	{
		$this->db->select('*');
		$this->db->from('t_kelas');
		$this->db->where('status','t');

		if($like!='null')
		{
			$like=str_replace(array('%20','+'), ' ', $like);
			$this->db->like('namakelas',$like);
			//$this->db->or_like('nis',$like);
			//$this->db->and_like('status','t');
		}

		$this->db->order_by('status desc, namakelas asc');

		if(isset($limit['num']) && isset($limit['offset']))
			$this->db->limit($limit['num'],$limit['offset']);

		return $this->db->get();
	}

	function getKelasById($id=null)
	{
		$this->db->select('*');
		$this->db->from('t_kelas');
		$this->db->where('id',$id);
		return $this->db->get();
	}

	function getSiswaByKelas($id,$idajaran,$st=null)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');
		$this->db->where('idkelas',$id);
		$this->db->where('id_ajaran',$idajaran);

		if($st!=null)
			$this->db->where('status_siswa_aktif',$st);

		$this->db->order_by('nis asc,nama asc');
		return $this->db->get();
	}

	function getSiswaByNamaKelas($id,$nama,$idajaran,$st=null)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');
		$this->db->where('idkelas',$id);
		$this->db->where('id_ajaran',$idajaran);
		$this->db->where('namakelasaktif',$nama);

		if($st!=null)
			$this->db->where('status_siswa_aktif',$st);

		$this->db->order_by('nis asc,nama asc');
		return $this->db->get();
	}

	function getKelasAktif(&$limit,$like=null,$st)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');
		$this->db->where('st_aktif',$st);

		if($like!='null')
		{
			$like=str_replace(array('%20','+'), ' ', $like);
			$this->db->like('namakelas',$like);
			//$this->db->or_like('nis',$like);
			//$this->db->and_like('status','t');
		}

		if(isset($limit['num']) && isset($limit['offset']))
			$this->db->limit($limit['num'],$limit['offset']);

		$this->db->group_by(array('idkelas','id_ajaran','namakelasaktif'));
		$this->db->order_by('tahunajaran','desc');
		$this->db->order_by('namakelas','asc');
		return $this->db->get();
	}

	function getTahunAjaranById($id)
	{
		$this->db->select('*');
		$this->db->from('t_ajaran');
		$this->db->where('id',$id);
		return $this->db->get();
	}

	function getKelasAktifByNIS($nis,$st)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');
		$this->db->where('nis',$nis);

		if($st!='all')
			$this->db->where('st_aktif',$st);

		$this->db->where('status_siswa_aktif','t');
		$this->db->order_by('tahunajaran','desc');
		return $this->db->get();
	}

	function getKelasAktifById($id)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');
		$this->db->where('id',$id);
		return $this->db->get();
	}

	function addKelasAktif(&$simpan)
	{
		$a=array(
			'id' => substr($simpan['id'],0,8),
			't_siswa_nis' => $simpan['nis'],
			't_kelas_id' => $simpan['kelas'],
			't_user_id' => $simpan['wali'],
			't_ajaran_id' => $simpan['ajaran'],
			'namakelasaktif' => $simpan['namakelas'],
			'status'=>'t',
			'status_siswa_aktif'=>'t'
		);
		$this->db->insert('t_siswa_has_t_kelas',$a);
		$this->session->set_flashdata('pesan','Data Kelas Aktif Berhasil Ditambahkan');
	}

	function getKelasAktifByNameNAjaran($idkelas,$namakelasaktif,$idajaran)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');
		$this->db->where('idkelas',$idkelas);
		$this->db->where('id_ajaran',$idajaran);
		$this->db->where('namakelasaktif',$namakelasaktif);
		$this->db->order_by('nama','asc');
		return $this->db->get();
	}
}
