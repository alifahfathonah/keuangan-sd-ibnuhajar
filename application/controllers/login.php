<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged')=='TRUE')
			redirect('a','location');
	}
	
	function index()
	{
		// $c=$this->db->query('');
		$cidpetugas=$this->db->query("SHOW COLUMNS FROM v_pembayaran like 'status_pembayaran'");
		if($cidpetugas->num_rows==0)
		{
			// $this->db->query('Drop View v_pembayaran');
			// $this->db->query("CREATE VIEW `v_pembayaran` AS
			// 				    select 
			// 				        `tp`.`t_jenis_pembayaran_id` AS `idjenis`,
			// 				        `tp`.`t_siswa_has_t_kelas_id` AS `idkelasaktif`,
			// 				        `tp`.`id` AS `idp`,
			// 				        `tp`.`jumlah` AS `jumlah`,
			// 				        `tp`.`tgl_transaksi` AS `tgl_transaksi`,
			// 						`tp`.`status_pembayaran` AS `status_pembayaran`,
			// 				        month(`tp`.`tgl_transaksi`) AS `bln`,
			// 				        year(`tp`.`tgl_transaksi`) AS `thn`,
			// 				        dayofmonth(`tp`.`tgl_transaksi`) AS `tgl`,
			// 				        `tp`.`t_user_id` AS `id_user`,
			// 				        `tp`.`penyetor` AS `penyetor`,
			// 				        `tp`.`keterangan` AS `keterangan`,
			// 				        `tj`.`jenis` AS `jenis`,
			// 				        `tsa`.`t_kelas_id` AS `t_kelas_id`,
			// 				        `tsa`.`namakelasaktif` AS `namakelasaktif`,
			// 				        `tsa`.`status_siswa_aktif` AS `status_siswa_aktif`,
			// 				        `ts`.`nama` AS `nama`,
			// 				        `ts`.`nis` AS `nis`
			// 				    from
			// 				        (((`db_sd_ibnuhajar`.`t_pembayaran` `tp`
			// 				        join `db_sd_ibnuhajar`.`t_jenis_pembayaran` `tj` ON ((`tp`.`t_jenis_pembayaran_id` = `tj`.`id`)))
			// 				        join `db_sd_ibnuhajar`.`t_siswa_has_t_kelas` `tsa` ON ((`tsa`.`id` = `tp`.`t_siswa_has_t_kelas_id`)))
			// 				        join `db_sd_ibnuhajar`.`t_siswa` `ts` ON ((`ts`.`nis` = `tsa`.`t_siswa_nis`)));");
			//if()
		}

		$data['title']='Login Page';
		$this->load->view('login',$data);

		// $url='http://localhost/kehalutuju/laundry/index.php/webservice/penerimaankasmasuk';
		// 	$passData = array(
		// 	           "nokw" => '123456',
		// 	           "jumlah" => '2000000',
		// 	           "tanggal" => date('Y-n-d')
		// 	        );
		// echo postCURL($url, $passData);
	}
	function log_in()
	{
		if(!empty($_POST))
		{
			$u=$_POST['username'];
			$p=sha1($_POST['password']);
			$d=$this->db->query('select * from v_user where user="'.$u.'" and pass="'.$p.'"');
			if(isset($_POST['sistem']))
			{
				$si=$_POST['sistem'];
				if($si=='on')
					$sis='SD';
				else
					$sis='SM';
			}
			else
				$sis='SM';

			// echo $sis;
			if($d->num_rows!=0)
			{
				$this->session->set_userdata('iduser',$d->row('idu'));
				$this->session->set_userdata('user',$d->row('user'));
				$this->session->set_userdata('nama',$d->row('nama'));
				$this->session->set_userdata('level',$d->row('level'));
				$this->session->set_userdata('idlevel',$d->row('idl'));
				$this->session->set_userdata('logged','TRUE');
				$this->session->set_userdata('sistem',$sis);
				
				redirect('a','location');
			}
			else
			{
				$this->session->set_flashdata('pesan','Login Gagal, Silahkan Periksa Username dan Password Anda !!');
				redirect('login','location');
			}
		}
	}


	public function postCURL($_url, $_param){

        $postData = '';
        //create name value pairs seperated by &
        foreach($_param as $k => $v) 
        { 
          $postData .= $k . '='.$v.'&'; 
        }
        rtrim($postData, '&');


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

        $output=curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    
	function cekcurl()
	{
		echo (is_callable('curl_init')) ? '<h1>Enabled</h1>' : '<h1>Not enabled</h1>' ;
	}
	
	function edit_pembayaran()
	{
		$file=file_get_contents('media/files/edit-pembayaran.txt');
		$f=explode("\n",$file);
		{
			// echo count($f);
			$x=0;
			foreach($f as $k=>$v){
				list($id,$idkelas2,$idkelas)=explode(';',$v);
				$data['t_siswa_has_t_kelas_id']=$idkelas2;
				// $data[$x]['id']=$id;
				$x++;

				// $this->db->set();
				$this->db->where('id',$id);
				$this->db->update('t_pembayaran',$data);
			}
			// $this->db->update_batch('t_pembayaran',$data, 'id'); 

			echo '<pre>';
			print_r($data);
			echo '</pre>';
		}
	}
}
