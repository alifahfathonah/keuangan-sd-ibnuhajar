<?php
/*	CREATE TABLE `db_sd_ibnuhajar`.`t_pembagian` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nama_kelas` VARCHAR(255) NULL COMMENT '',
  `tahun_ajaran` VARCHAR(45) NULL COMMENT '',
  `status` ENUM('t', 'f', 'i') NULL DEFAULT 't' COMMENT '',
  `walikelas` VARCHAR(255) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '');
*/
//Loads configuration from database into global CI config
function load_config()
{
	$ci =& get_instance();
	$smp_db= $ci->load->database('second', TRUE);
	// if($ci->session->userdata('sistem')=='SD')
	// {
	// 	$ci->load->database('default',true);
	// }
	// else
	// {
	// 	$ci->db=$ci->load->database('second',true);
	// }
	// $t_pembagian=$ci->db->query('show tables like "t_pembagian"');
	// if($t_pembagian->num_rows==0)
	// {
	// 	$ci->db->query("CREATE TABLE `t_pembagian` (
	// 					  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
	// 					  `nama_kelas` VARCHAR(255) NULL COMMENT '',
	// 					  `tahun_ajaran` VARCHAR(45) NULL COMMENT '',
	// 					  `status` ENUM('t', 'f', 'i') NULL DEFAULT 't' COMMENT '',
	// 					  `walikelas` VARCHAR(255) NULL COMMENT '',
	// 					  PRIMARY KEY (`id`)  COMMENT '');");
	// }

	// $t_pembagian_data=$ci->db->query('show tables like "t_pembagian_siswa"');
	// if($t_pembagian_data->num_rows==0)
	// {
	// 	$ci->db->query("CREATE TABLE `t_pembagian_siswa` (
	// 					  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
	// 					  `id_pembagian` INT NULL COMMENT '',
	// 					  `nama_siswa` VARCHAR(255) NULL COMMENT '',
	// 					  `id_siswa` VARCHAR(255) NULL COMMENT '',
	// 					  `id_kelas_aktif` BIGINT NULL COMMENT '',
	// 					  `status` ENUM('t', 'f') NULL COMMENT '',
	// 					  PRIMARY KEY (`id`));");
	// }

	$c_penerimaan_rutin = $ci->db->query('select * from t_penerimaan_rutin where sisa_bayar < 0');
	if($c_penerimaan_rutin->num_rows!=0)
	{
		foreach ($c_penerimaan_rutin->result() as $k => $v) 
		{
			$ci->db->query('update t_penerimaan_rutin set sudah_bayar = (sudah_bayar+sisa_bayar), sisa_bayar=0 where id="'.$v->id.'"');
		}
	}	

	$c_penerimaan_rutin_smp = $smp_db->query('select * from t_penerimaan_rutin where sisa_bayar < 0');
	if($c_penerimaan_rutin_smp->num_rows!=0)
	{
		foreach ($c_penerimaan_rutin_smp->result() as $k => $v) 
		{
			$smp_db->query('update t_penerimaan_rutin set sudah_bayar = (sudah_bayar+sisa_bayar), sisa_bayar=0 where id="'.$v->id.'"');
		}
	}
//---------------------------------------------------------------------------------------------------
	$c_record_pembayaran = $ci->db->query('select * from t_record_pembayaran_siswa where sisa < 0');
	if($c_record_pembayaran->num_rows!=0)
	{
		foreach ($c_record_pembayaran->result() as $k => $v) 
		{
			$ci->db->query('update t_record_pembayaran_siswa set sudah_bayar = (sudah_bayar+sisa), sisa=(wajib_bayar-(sudah_bayar+sisa)) where id="'.$v->id.'"');
		}
	}	

	$c_record_pembayaran_smp = $smp_db->query('select * from t_record_pembayaran_siswa where sisa < 0');
	if($c_record_pembayaran_smp->num_rows!=0)
	{
		foreach ($c_record_pembayaran_smp->result() as $k => $v) 
		{
			$smp_db->query('update t_record_pembayaran_siswa set sudah_bayar = (sudah_bayar+sisa), sisa=(wajib_bayar-(sudah_bayar+sisa)) where id="'.$v->id.'"');
		}
	}
//---------------------------------------------------------------------------------------------------

	if (!$ci->db->field_exists('kode_akun', 't_jenis_pembayaran'))
	{
	   $sql="alter table t_jenis_pembayaran add column `kode_akun` char(10)";
	   $ci->db->query($sql);
	}	
	if (!$smp_db->field_exists('kode_akun', 't_jenis_pembayaran'))
	{
	   $sql="alter table t_jenis_pembayaran add column `kode_akun` char(10)";
	   $smp_db->query($sql);
	}	
//---------------------------------------------------------------------------------------------------

	if (!$ci->db->field_exists('VA', 't_siswa'))
	{
	   $sql="alter table t_siswa add column `VA` varchar(255)";
	   $ci->db->query($sql);
	}	
	if (!$smp_db->field_exists('VA', 't_siswa'))
	{
	   $sql="alter table t_siswa add column `VA` varchar(255)";
	   $smp_db->query($sql);
	}	

//---------------------------------------------------------------------------------------------------
	if (!$ci->db->field_exists('jumlah_diskon', 't_penerimaan_rutin'))
	{
	   $sql="alter table t_penerimaan_rutin add column `jumlah_diskon` double default 0";
	   $ci->db->query($sql);
	}
	if (!$smp_db->field_exists('jumlah_diskon', 't_penerimaan_rutin'))
	{
	   $sql="alter table t_penerimaan_rutin add column `jumlah_diskon` double default 0";
	   $smp_db->query($sql);
	}	
//---------------------------------------------------------------------------------------------------

	if(!$ci->db->field_exists('jumlah_diskon', 't_record_pembayaran_siswa'))
	{
	   $sql="alter table t_record_pembayaran_siswa add column `jumlah_diskon` double default 0";
	   $ci->db->query($sql);
	}	
	if(!$smp_db->field_exists('jumlah_diskon', 't_record_pembayaran_siswa'))
	{
	   $sql="alter table t_record_pembayaran_siswa add column `jumlah_diskon` double default 0";
	   $smp_db->query($sql);
	}

//---------------------------------------------------------------------------------------------------
	if(!$ci->db->field_exists('bulan_tahun_tagihan', 't_pembayaran'))
	{
	   $sql="alter table t_pembayaran add column `bulan_tahun_tagihan` varchar(255)";
	   $ci->db->query($sql);
	}	
	if(!$smp_db->field_exists('bulan_tahun_tagihan', 't_pembayaran'))
	{
	   $sql="alter table t_pembayaran add column `bulan_tahun_tagihan` varchar(255)";
	   $smp_db->query($sql);
	}
//---------------------------------------------------------------------------------------------------

	if(!$ci->db->field_exists('tampil_jemputan', 't_penerimaan_rutin'))
	{
	   $sql="alter table t_penerimaan_rutin add column `tampil_jemputan` char(2) default 1";
	   $ci->db->query($sql);
	}	
	if(!$smp_db->field_exists('tampil_jemputan', 't_penerimaan_rutin'))
	{
	   $sql="alter table t_penerimaan_rutin add column `tampil_jemputan` char(2) default 1";
	   $smp_db->query($sql);
	}
//------------------------------------------------------------------------------------------------------
	if (!$ci->db->table_exists('t_tabungan'))
	{
	   $sql="create table t_tabungan
	   		(
	   			id int primary key,
	   			nama_siswa varchar(255),
	   			nis varchar(50),
	   			kelas varchar(50),
	   			tahun_ajaran varchar(20),
	   			tanggal_transaksi datetime,
	   			penerima varchar(100),
	   			saldo double,
	   			last_update datetime,
	   			keterangan text,
	   			nokwitansi varchar(255)
	   		)";
	   	$ci->db->query($sql);	

	   	$sql2="create table t_tabungan_detail
	   		(
	   			id_d int primary key,
	   			id_tab int,
	   			tarik_setor enum('tarik','setor'),
	   			jumlah double,
	   			keterangan text,
	   			nokwitansi varchar(255),
	   			petugas varchar(255),
	   			tgl_transaksi datetime
	   		)";
	   	$ci->db->query($sql2);	
	}

	if (!$smp_db->table_exists('t_tabungan'))
	{
	   $sql="create table t_tabungan
	   		(
	   			id int primary key,
	   			nama_siswa varchar(255),
	   			nis varchar(50),
	   			kelas varchar(50),
	   			tahun_ajaran varchar(20),
	   			tanggal_transaksi datetime,
	   			penerima varchar(100),
	   			saldo double,
	   			last_update datetime,
	   			keterangan text,
	   			nokwitansi varchar(255)
	   		)";
	   	$smp_db->query($sql);	

	   	$sql2="create table t_tabungan_detail
	   		(
	   			id_d int primary key,
	   			id_tab int,
	   			tarik_setor enum('tarik','setor'),
	   			jumlah double,
	   			keterangan text,
	   			nokwitansi varchar(255),
	   			petugas varchar(255),
	   			tgl_transaksi datetime
	   		)";
	   	$smp_db->query($sql2);	
	}
//------------------------------------------------------------------------------------------------------
	if (!$ci->db->table_exists('t_diskon'))
	{
	   $sql="create table t_diskon
	   		(
	   			id_diskon int primary key,
	   			jumlah_diskon double,
	   			satuan_diskon char(8),
	   			id_jenis_pembayaran int,
	   			nama_jenis_pembayaran varchar(100),
	   			status_diskon enum('t','f'),
	   			id_kelas_aktif int,
	   			nis varchar(50)
	   		)";
	   	$ci->db->query($sql);	
	}

	if (!$smp_db->table_exists('t_diskon'))
	{
	   $sql="create table t_diskon
	   		(
	   			id_diskon int primary key,
	   			jumlah_diskon double,
	   			satuan_diskon char(8),
	   			id_jenis_pembayaran int,
	   			nama_jenis_pembayaran varchar(100),
	   			status_diskon enum('t','f'),
	   			id_kelas_aktif int,
	   			nis varchar(50)
	   		)";
	   	$smp_db->query($sql);	
	}

//------------------------------------------------------------------------------------------------------
	if (!$ci->db->table_exists('t_club'))
	{
	   $sql="create table t_club
	   		(
	   			id_club int primary key,
	   			nama_club varchar(255),
	   			penanggung_jawab varchar(100),
	   			status_tampil enum ('t','f') default 't',
	   			telp_pj varchar(100),
	   			jadwal varchar(255),
	   			email_pj varchar(255),
	   			biaya double,
	   			hari char(10),
	   			waktu varchar(20),
	   			guru_pendamping varchar(100)
	   		)";
	   	$ci->db->query($sql);	
	}

	if (!$ci->db->table_exists('t_club_siswa'))
	{
	   $sql="create table t_club_siswa
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			nis varchar(50),
	   			id_club int,
	   			status_tampil enum ('t','f') default 't'
	   		)";
	   	$ci->db->query($sql);	
	}	

	
	if (!$smp_db->table_exists('t_club'))
	{
	    $sql="create table t_club
	   		(
	   			id_club int primary key,
	   			nama_club varchar(255),
	   			penanggung_jawab varchar(100),
	   			jadwal varchar(255),
	   			status_tampil enum ('t','f') default 't',
	   			telp_pj varchar(100),
	   			email_pj varchar(255),
	   			biaya double,
	   			hari char(10),
	   			waktu varchar(20),
	   			guru_pendamping varchar(100)
	   		)";
	   	$smp_db->query($sql);	
	}

	if (!$smp_db->table_exists('t_club_siswa'))
	{
	   $sql="create table t_club_siswa
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			nis varchar(50),
	   			id_club int,
	   			status_tampil enum ('t','f') default 't'
	   		)";
	   	$smp_db->query($sql);	
	}

//------------------------------------------------------------------------------------------------------
	if (!$ci->db->table_exists('t_kode_akun'))
	{
	   $sql="create table t_kode_akun
	   		(
	   			kode_akun char(10) primary key,
	   			nama_akun varchar(100),
	   			id_parent char(10) default 0,
	   			status_tampil enum('t','f')
	   		)";
	   	$ci->db->query($sql);	
	}	
	if (!$smp_db->table_exists('t_kode_akun'))
	{
	   $sql="create table t_kode_akun
	   		(
	   			kode_akun char(10) primary key,
	   			nama_akun varchar(100),
	   			id_parent char(10) default 0,
	   			status_tampil enum('t','f')
	   		)";
	   	$smp_db->query($sql);	
	}
//------------------------------------------------------------------------------------------------------
	
	if (!$ci->db->table_exists('t_saldo_akun'))
	{
	   $sql="create table t_saldo_akun
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			kode_akun char(10),
	   			nama_akun varchar(100),
	   			saldo double default 0,
	   			modified datetime
	   		)";
	   	$ci->db->query($sql);	
	}	
	if (!$smp_db->table_exists('t_saldo_akun'))
	{
	   $sql="create table t_saldo_akun
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			kode_akun char(10),
	   			nama_akun varchar(100),
	   			saldo double default 0,
	   			modified datetime
	   		)";
	   	$smp_db->query($sql);	
	}
//------------------------------------------------------------------------------------------------------

	if (!$ci->db->table_exists('t_jurnal_seluruh'))
	{
	   $sql="create table t_jurnal_seluruh
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			kode_akun char(10),
	   			nama_akun varchar(100),
	   			keterangan varchar(255),
	   			debit double default 0,
	   			kredit double default 0,
	   			saldo double default 0,
	   			modified datetime
	   		)";
	   	$ci->db->query($sql);	
	}	

	if (!$smp_db->table_exists('t_jurnal_seluruh'))
	{
	   $sql="create table t_jurnal_seluruh
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			kode_akun char(10),
	   			nama_akun varchar(100),
	   			keterangan varchar(255),
	   			debit double default 0,
	   			kredit double default 0,
	   			saldo double default 0,
	   			modified datetime
	   		)";
	   	$smp_db->query($sql);	
	}
	if (!$smp_db->table_exists('t_transaksi'))
	{
	   $sql="create table t_transaksi
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			id_pembayaran int,
	   			id_record_pembayaran int,
	   			tanggal datetime,
	   			total double default 0,
	   			kode_transaksi varchar(255)
	   		)";
	   	$smp_db->query($sql);	
	}
	if (!$ci->db->table_exists('t_transaksi'))
	{
	   $sql="create table t_transaksi
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			id_pembayaran int,
	   			id_record_pembayaran int,
	   			tanggal datetime,
	   			total double default 0,
	   			kode_transaksi varchar(255)
	   		)";
	   	$ci->db->query($sql);	
	}
	if (!$ci->db->table_exists('t_transaksi_va'))
	{
	   $sql="create table t_transaksi_va
	   		(
	   			id int primary key AUTO_INCREMENT,
	   			idTagihan bigint,
	   			t_penerimaan_rutin_id varchar(255),
	   			t_record_pembayaran_id varchar(255),
	   			status int default 0
	   		)";
	   	$ci->db->query($sql);	
	}

//------------------------------------------------------------------------------------------------------

	if (!$ci->db->table_exists('v_club_siswa'))
	{
	   $sql="CREATE VIEW `v_club_siswa` AS select `d`.*,`ds`.`status_tampil` as `st_siswa`,`d`.`status_tampil` as `st`,`n`.`nis` AS `nis`,`n`.`nama` AS `nama`,`n`.`alamat` AS `alamat` from ((`t_club_siswa` `ds` join `t_siswa` `n` on((`n`.`nis` = `ds`.`nis`))) join `t_club` `d` on((`d`.`id_club` = `ds`.`id_club`)))";
	   	$ci->db->query($sql);	
	}

	if (!$smp_db->table_exists('v_club_siswa'))
	{
	   $sql="CREATE VIEW `v_club_siswa` AS select `d`.*,`ds`.`status_tampil` as `st_siswa`,`d`.`status_tampil` as `st`,`n`.`nis` AS `nis`,`n`.`nama` AS `nama`,`n`.`alamat` AS `alamat` from ((`t_club_siswa` `ds` join `t_siswa` `n` on((`n`.`nis` = `ds`.`nis`))) join `t_club` `d` on((`d`.`id_club` = `ds`.`id_club`)))";
	   	$smp_db->query($sql);	
	}	
//------------------------------------------------------------------------------------------------------

	if(date('n')==10)
	{
		$tahun_ajaran=date('Y').'-'.(date('Y')+1);
		$cekta=$ci->db->query('select * from t_ajaran where tahunajaran="'.$tahun_ajaran.'"');
		if($cekta->num_rows==0)
		{
			$id=generate_id();
			$d=array(
				'id'=>$id,
				'tahunajaran'=>$tahun_ajaran,
				'bulan_awal'=>'juli',
				'bulan_akhir'=>'juni'
			);
			$ci->db->insert('t_ajaran',$d);
		}
	}

	if(date('n')==10)
	{
		$tahun_ajaran=date('Y').'-'.(date('Y')+1);
		$cekta_smp=$smp_db->query('select * from t_ajaran where tahunajaran="'.$tahun_ajaran.'"');
		if($cekta_smp->num_rows==0)
		{
			$id_smp=generate_id();
			$d_smp=array(
				'id'=>$id_smp,
				'tahunajaran'=>$tahun_ajaran,
				'bulan_awal'=>'juli',
				'bulan_akhir'=>'juni'
			);
			$smp_db->insert('t_ajaran',$d_smp);
		}
	}

	$user=$ci->db->from('t_user')->get();
	$us=array();
	foreach($user->result() as $k => $v)
	{
		$us[$v->id]=$v;
	}
	$ci->config->set_item('user_id',$us);
	$user->free_result();
}
?>