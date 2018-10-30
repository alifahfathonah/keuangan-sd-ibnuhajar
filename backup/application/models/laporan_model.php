<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getTransaksiJurnal($date)
	{
		$qry=$this->db->select('*')->from('v_pembayaran')
				->like('tgl_transaksi',$date)
				->group_by(array('idjenis','tgl_transaksi'))
				->order_by('tgl_transaksi','desc')->get();
		return $qry;
	}
}