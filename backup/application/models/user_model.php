<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getUser(&$limit,$like=null,$level=null)
	{
		$this->db->select('*');
		$this->db->from('t_user');
		$this->db->where('t_level_id',$level);
		$this->db->where('status','t');
		
		if($like!='null')
		{
			$like=str_replace(array('%20','+'), ' ', $like);
			$this->db->like('namak',$like);
			//$this->db->or_like('nis',$like);
			//$this->db->and_like('status','t');
		}

		if(isset($limit['num']) && isset($limit['offset']))
			$this->db->limit($limit['num'],$limit['offset']);
		
		return $this->db->get();
	}
}