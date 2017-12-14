<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penerimaan_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getJenisPembayaranByParent($id)
	{
		$this->db->select('*');
		$this->db->from('t_jenis_pembayaran');
		$this->db->like('id_parent',$id);
		$this->db->where('status','t');
		$this->db->order_by('id','asc');
		return $this->db->get();
	}

	function getJenisPembayaranByID($id)
	{
		$this->db->select('*');
		$this->db->from('t_jenis_pembayaran');
		$this->db->where('id',$id);
		return $this->db->get();
	}

	function getrecordpembayaranby_idkelasaktif_nis_idjenis($idjenis,$nis,$idkelasaktif)
	{
		$nis=str_replace('%20', ' ', $nis);
		$this->db->select('*')
					->from('v_record_pembayaran')
					->where('id_kelas_aktif',$idkelasaktif)
					->where('nis',$nis)
					->where('id_jenis',$idjenis);
		return $this->db->get();
	}

	function getpembayaranby_idkelasaktif_nis_idjenis($idjenis,$nis,$idkelasaktif)
	{
		$nis=str_replace('%20', ' ', $nis);
		$this->db->select('*')
					->from('v_pembayaran')
					->where('idkelasaktif',$idkelasaktif)
					->where('nis',$nis)
					->where('idjenis',$idjenis);
		return $this->db->get();
	}

	function getpembayaranby_idkelasaktif_nis_idjenis_bulan_tahun($idjenis,$nis,$idkelasaktif,$bulan,$tahun)
	{
		$nis=str_replace('%20', ' ', $nis);
		$this->db->select('*')
					->from('v_pembayaran')
					->where('idkelasaktif',$idkelasaktif)
					->where('nis',$nis)
					->where('keterangan',$bulan)
					//group by idjenis,tgl_transaksi,nama,keterangan order by nama
					// ->where('thn',$tahun)
					->where('idjenis',$idjenis);
					// ->group_by('idjenis,tgl_transaksi,nama,keterangan');
		return $this->db->get();
	}

	function saveTransaksi(&$simpan)
	{
		$in=array(
			't_jenis_pembayaran_id' => $simpan['t_jenis_pembayaran_id'],
			't_siswa_has_t_kelas_id' => $simpan['kelas_aktif'],
			'id' => substr($simpan['tr_id'],0,8),
			'jumlah' => $simpan['jumlah'],
			'tgl_transaksi' => $simpan['tgl_transaksi'],
			't_user_id' => ($this->session->userdata('iduser')),
			'penyetor' => $simpan['penyetor'],
			'id_parent_jenis_pembayaran' => $simpan['t_jenis_pembayaran_id'],
			'keterangan' => $simpan['keterangan'],
			'catatan' => $simpan['catatan'],
			'bulan_tahun_tagihan' => $simpan['bulan_tahun_tagihan'],
		);
		$this->db->insert('t_pembayaran',$in);
		//echo '<pre>';
		//print_r($in);
	}

	function createRecordPembayaran(&$simpan)
	{
		$in=array(
			't_jenis_pembayaran_id'=>$simpan['t_jenis_pembayaran_id'],
			't_siswa_nis'=>$simpan['nis'],
			'sisa'=>$simpan['sisa'],
			'sudah_bayar'=>$simpan['sudah_bayar'],
			'wajib_bayar'=>$simpan['wajib_bayar'],
			'id'=>substr(abs(crc32(sha1(md5(rand())))),0,8),
			't_kelas_aktif_id'=>$simpan['id'],
			'tahun'=>date('Y'),
			'jumlah_diskon'=>$simpan['jumlah_diskon']
		);
		$this->db->insert('t_record_pembayaran_siswa',$in);
	}

	function updateJumlahJenisPembayaran($id,$jumlah,$jumlah2)
	{
		$up=array(
			'jumlah' => $jumlah,
			'jumlah2' => $jumlah2
		);
		$this->db->where('id',$id);
		$this->db->update('t_jenis_pembayaran',$up);
	}

	function addpenerimaanrutin(&$simpan)
	{
		//echo '<pre>';
		//print_r($simpan);
		//echo '</pre>';
		$in=array(
			'id'=>substr($simpan['id'],0,8),
			'wajib_bayar'=>$simpan['wajib_bayar'],
			'bulan'=>$simpan['bulan'],
			't_jenis_pembayaran_id'=>$simpan['t_jenis_pembayaran_id'],
			't_siswa_nis'=>$simpan['t_siswa_nis'],
			't_siswa_has_t_kelas_id'=>$simpan['t_siswa_has_t_kelas_id'],
			'sudah_bayar'=>$simpan['sudah_bayar'],
			'tahun'=>$simpan['tahun'],
			'keterangan'=>$simpan['ket'],
			'sisa_bayar'=>$simpan['sisa_bayar']
			//'jumlah_diskon'=>$simpan['jumlah_diskon']
		);
		$this->db->insert('t_penerimaan_rutin',$in);

	}

	function updatepenerimaanrutin(&$simpan)
	{
		//echo '<pre>';
		//print_r($simpan);
		//echo '</pre>';
		$in=array(
			'wajib_bayar'=>$simpan['wajib_bayar'],
			'bulan'=>$simpan['bulan'],
			't_jenis_pembayaran_id'=>$simpan['t_jenis_pembayaran_id'],
			't_siswa_nis'=>$simpan['t_siswa_nis'],
			't_siswa_has_t_kelas_id'=>$simpan['t_siswa_has_t_kelas_id'],
			'sudah_bayar'=>$simpan['sudah_bayar'],
			'tahun'=>$simpan['tahun'],
			'keterangan'=>$simpan['ket'],
			'sisa_bayar'=>$simpan['sisa_bayar']
		);
		$this->db->where('id',$simpan['id']);
		$this->db->update('t_penerimaan_rutin',$in);

	}

	function getDataKewajiban($nis,$idkelas,$idjenis,$bln)
	{
		$sql="select
				ta.id,
				ta.t_jenis_pembayaran_id,
				ta.t_siswa_nis,
				ta.t_kelas_aktif_id,
				ta.tahun,
				ta.wajib_bayar,
				ta.sudah_bayar,
				ta.sisa from t_record_pembayaran_siswa as ta
				where ta.t_siswa_nis='".$nis."'
				and ta.t_jenis_pembayaran_id=".$idjenis."
				and ta.t_kelas_aktif_id=".$idkelas."

				union all

				select
				tb.id,
				tb.t_jenis_pembayaran_id,
				tb.t_siswa_nis,
				tb.t_siswa_has_t_kelas_id,
				tb.tahun,
				tb.wajib_bayar,
				tb.sudah_bayar,
				tb.sisa_bayar from t_penerimaan_rutin as tb where tb.t_siswa_nis='".$nis."'
				and tb.t_jenis_pembayaran_id=".$idjenis."
				and tb.bulan=".$bln."
				and tb.t_siswa_has_t_kelas_id=".$idkelas."";
		return $this->db->query($sql);
	}

	function getViewDataKewajiban($nis,$idkelas,$idjenis)
	{
		$qry=$this->db->select('*')
				->select('(sudah_bayar-sisa) as h')
				->from('v_data_kewajiban')
				->where('t_jenis_pembayaran_id',$idjenis)
				->where('t_siswa_nis',$nis)
				->where('t_kelas_aktif_id',$idkelas)
				->where('sisa >',0)
				->order_by('tahun asc,(bulan*1) asc')
				->limit(1)->get();
		return $qry;
	}

	function cekPenerimaanRutin($bulan,$idjenis,$nis,$idkelasaktif,$tahun=null)
	{
		$this->db->from('t_penerimaan_rutin');
		$this->db->where('bulan',$bulan);
		if($tahun!=null)
			$this->db->where('tahun',$tahun);

		$this->db->where('t_jenis_pembayaran_id',$idjenis);
		$this->db->like('t_siswa_nis',$nis);
		$this->db->where('t_siswa_has_t_kelas_id',$idkelasaktif);
		$d=$this->db->get();
		return $d;
	}

	function cekPenerimaanRutinJemputan($bulan,$idjenis,$nis,$tahun=null)
	{
		$this->db->select('*');
		$this->db->from('t_penerimaan_rutin');
		$this->db->where('bulan',$bulan);
		if($tahun!=null)
			$this->db->where('tahun',$tahun);

		$this->db->where('t_jenis_pembayaran_id',$idjenis);
		$this->db->where('t_siswa_nis',$nis);
		return $this->db->get();
	}
	function cekPenerimaanRutinLain($bulan,$idjenis,$nis,$tahun=null)
	{
		$this->db->select('*');
		$this->db->from('t_penerimaan_rutin');
		$this->db->where('bulan',$bulan);
		if($tahun!=null)
			$this->db->where('tahun',$tahun);

		$this->db->where('t_jenis_pembayaran_id',$idjenis);
		$this->db->where('t_siswa_nis',$nis);
		return $this->db->get();
	}

	function dataPenerimaanRutin($idjenis,$nis,$idkelasaktif)
	{
		$this->db->select('*')
				->from('t_penerimaan_rutin')
				->where('t_jenis_pembayaran_id',$idjenis)
				->where('t_siswa_nis',$nis)
				->where('t_siswa_has_t_kelas_id',$idkelasaktif)
				->order_by('tahun asc,bulan asc');
		return $this->db->get();
	}

	function dataRecordPenerimaan($idjenis,$nis,$idkelasaktif)
	{
		$this->db->select('*')
				->from('t_record_pembayaran_siswa')
				->where('t_jenis_pembayaran_id',$idjenis)
				->where('t_siswa_nis',$nis)
				->where('t_kelas_aktif_id',$idkelasaktif);
		return $this->db->get();
	}
}
