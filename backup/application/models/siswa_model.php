<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siswa_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getSiswa(&$limit,$like=null)
	{
		$this->db->select('*');
		$this->db->from('t_siswa');
		$this->db->where('status','t');
		
		if($like!='null')
		{
			$like=str_replace(array('%20','+'), ' ', $like);
			$this->db->like('nama',$like);
			//$this->db->or_like('nis',$like);
			//$this->db->and_like('status','t');
		}

		if(isset($limit['num']) && isset($limit['offset']))
			$this->db->limit($limit['num'],$limit['offset']);
		
		return $this->db->get();
	}

	function getSiswaStatus(&$limit,$st=null,$like=null)
	{
		$this->db->select('*');
		$this->db->from('t_siswa');
		if($st!='null')
			$status=$st;
		else	
			$status='f';
		
		$this->db->where('status',$status);

		if($like!='null')
		{
			$like=str_replace(array('%20','+'), ' ', $like);
			$this->db->like('nama',$like);
			//$this->db->or_like('nis',$like);
			//$this->db->and_like('status','t');
		}

		if(isset($limit['num']) && isset($limit['offset']))
			$this->db->limit($limit['num'],$limit['offset']);
		
		return $this->db->get();
	}


	function getSiswaById($id=null)
	{
		$this->db->select('*');
		$this->db->from('t_siswa');
		$this->db->where('nis',$id);
		return $this->db->get();
	}

	function getSiswaAktif($st=null)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');

		if($st!=null)
			$this->db->where('status_siswa_aktif',$st);

		$this->db->group_by('nis');
		$this->db->order_by('nis asc,nama asc');
		return $this->db->get();
	}

	function getSiswaAktifKelasAktif($st=null)
	{
		$this->db->select('*');
		$this->db->from('v_kelas_aktif');

		if($st!=null)
		{
			$this->db->where('status_siswa_aktif',$st);
			$this->db->where('st_aktif',$st);
		}
		$this->db->group_by('nis');
		$this->db->order_by('nis asc,nama asc');
		return $this->db->get();
	}

}