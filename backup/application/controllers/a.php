<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A extends CI_Controller {

	function __construct()
	{
		// private $
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
		$this->load->model('siswa_model','sm');
		$this->load->model('kelas_model','km');
		$this->load->model('user_model','um');
		$this->load->model('config_model','cm');
		$this->load->model('penerimaan_model','pm');
		$this->load->model('laporan_model','lm');
		if($this->session->userdata('logged')!='TRUE')
			redirect('login','location');
	}
	
	function index()
	{
		// echo $this->db->database;
		$cekfield="SHOW COLUMNS FROM `t_pembayaran` LIKE 'status_pembayaran';";
		$cf=$this->db->query($cekfield);
		if($cf->num_rows==0)
		{
			$this->db->query("ALTER TABLE  `t_pembayaran` ADD  `status_pembayaran` TEXT NULL ;");				
		}

		$cektable="SHOW TABLES like 't_driver_siswa';";
		$ct=$this->db->query($cektable);
		if($ct->num_rows==0)
		{
			$table="CREATE TABLE IF NOT EXISTS `t_driver_siswa` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `nis` char(11) NOT NULL,
				  `id_driver` int(11) NOT NULL,
				  `biaya` double NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `nis` (`nis`),
				  KEY `id_driver` (`id_driver`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;";
			$this->db->query($table);
		}
		
		$cekview="SHOW TABLES like 'v_driver_siswa';";
		$cv=$this->db->query($cekview);
		if($cv->num_rows==0)
		{
			$view="CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_driver_siswa` AS select `ds`.`id` AS `id`,`ds`.`id_driver` AS `id_driver`,`ds`.`biaya` AS `biaya`,`n`.`nis` AS `nis`,`n`.`nama` AS `nama`,`n`.`alamat` AS `alamat`,`d`.`nama_driver` AS `nama_driver`,`d`.`alamat` AS `rute` from ((`t_driver_siswa` `ds` join `t_siswa` `n` on((`n`.`nis` = `ds`.`nis`))) join `t_driver` `d` on((`d`.`id` = `ds`.`id_driver`)));
";
			$this->db->query($view);
		}

		$data['title']='Home';
		$data['isi']='layout/home';
		
			// $url = '192.168.100.51/AndroidApi/v2/register';

		// echo (is_callable('curl_init')) ? '<h1>Enabled</h1>' : '<h1>Not enabled</h1>' ;
		$this->load->view('index',$data);
	}
		
	function logout()
	{
		$this->session->unset_userdata('iduser');
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('level');
		$this->session->unset_userdata('idlevel');
		$this->session->unset_userdata('logged');
		$this->session->set_flashdata('pesan','Anda Sudah Logout<br>Terima Kasih !!');
		redirect('login','location');
	}

	function bacaexcel($tahunajaran)
	{
		$this->load->library("Classes/PHPExcel");
		// $objPHPExcel = new PHPExcel();
		$file='media/files/UTAB 2015-2016.xls';
		// $file='media/files/coba.xls';
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		$tgl=$vl=array();
		$noo=1;
		foreach ($cell_collection as $cell) {
		    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		    
		    $header[$row][$column] = $data_value;
		    $xx = $data_value;
		    if(PHPExcel_Shared_Date::isDateTime($objPHPExcel->getActiveSheet()->getCell($cell))) 
		    {
		    	if($data_value!='')
		    	{
		    		$vl[$row][$column] = $data_value;
			    	$InvDate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($data_value)); 
		    		$tgl[$row][$column] = $InvDate;
		    	}
		    	// else
		    		// $tgl[$row][] = '';
			}
		    // $date_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		    //header will/should be in row 1 only. of course this can be modified to suit your need.
		    // if ($row == 1) {
		    // if()
		    // } else {
		    //     $arr_data[$row][$column] = $data_value;
		    // }
		    $noo++;
		}
		// echo '<pre>';
		// print_r($tgl);
		// echo '</pre>';
		//send the data in an array format
		$data['header'] = $header;
		echo '<table border="1" cellspacing=0 cellpadding=3 style="font-size:11px;">';
		$ta=$this->db->query('select * from t_ajaran where tahunajaran="'.$tahunajaran.'"');
		$no=1;
		foreach ($header as $k => $v) 
		{


			$siswa=$this->db->query('select * from t_siswa where nama like "%'.trim($v['B']).'%"');
			$bayar='';
			$byr=$byrin=$total=array();
			if($siswa->num_rows!=0)
			{
				$ss=$siswa->row('nis');
				$penyetor=$siswa->row('nama_ayah').','.$siswa->row('nama_ibu');
				$kelasaktif=$this->db->query('select * from t_siswa_has_t_kelas where t_ajaran_id="'.$ta->row('id').'" and t_siswa_nis like "%'.$ss.'%" and status_siswa_aktif="t"');
				if($kelasaktif->num_rows!=0)
				{
					$idkelas=$kelasaktif->row('id');
					$tkelasid=$kelasaktif->row('t_kelas_id');
					// $by=$this->db->query('select * from v_pembayaran where idkelasaktif="'.$idkelas.'" and nis="'.$ss.'" and tgl_transaksi like "%'.$v['E'].'%"');

					
					// $cekc=$this->db->query('select * from t_record_pembayaran_siswa 
					// 							where t_siswa_nis="'.$ss.'"
					// 							and t_kelas_aktif_id="'.$idkelas.'" and t_jenis_pembayaran_id="3"');
					// 						//echo $cekc->num_rows.'<br>';
					// if($cekc->num_rows!=0)
					// {
					// 	if($cekc->row('sisa')!=0)
					// 	{
					// 		$wb=$cekc->row('wajib_bayar');
					// 		$sb=$jlh+$cekc->row('sudah_bayar');
					// 		$sisa=$wb-$sb;
					// 		$upd=array(
					// 			'sisa'=>$sisa,
					// 			'wajib_bayar'=>$wb,
					// 			'sudah_bayar'=>$sb
					// 		);
					// 		$this->db->where('id',$cekc->row('id'));
					// 		$this->db->update('t_record_pembayaran_siswa',$upd);
					// 	}
					// }

					// $this->pm->saveTransaksi($simpan);


					$by=$this->db->query('select * from v_pembayaran where idkelasaktif="'.$idkelas.'" and nis="'.$ss.'" and idjenis=3 and status_siswa_aktif="t" order by tgl_transaksi desc');
					if($by->num_rows!=0)
					{
						// $bayar=' style="background:rgb(255,240,90)"';
						$t=0;
						foreach ($by->result() as $k => $vv) 
						{
							$bayar.=strtok($vv->tgl_transaksi, ' ').' : '.rupiah($vv->jumlah).'<br>';
							$byr[$ss][strtok($vv->tgl_transaksi, ' ')]=$vv->jumlah;
							$byrin[$ss][trim(strtok($vv->tgl_transaksi, ' '))]=$vv->tgl_transaksi;
							$t+=$vv->jumlah;
						}
						$total[$ss]=$t;
						$sss=$this->db->query('select * from t_record_pembayaran_siswa where t_kelas_aktif_id="'.$idkelas.'" and t_jenis_pembayaran_id=3;');
						$sisa[$ss]=($sss->num_rows!=0 ? $sss->row('sisa') : 0);

						// echo '<pre>';
						// print_r($byrin);
						// echo '</pre>';
					}
				}
				else
					$idkelas='';
			}
			else
			{	
				$ss='';
				$idkelas='';
			}
			// if($no==2)
					// {
					echo '<tr>';
						echo '<td>';
							echo $v['A'];
						echo '</td>';
						echo '<td style="width:100px;">';
							echo $idkelas;
						echo '</td>';				
						echo '<td style="width:100px;">';
							echo $ss;
						echo '</td>';
						echo '<td style="width:150px;">';
							echo $bayar;
							echo '<hr>';
							if(isset($total[$ss]))
							{
								echo rupiah($total[$ss]);
								if($total[$ss]==$v['C'])
									echo '<BR><center style="font-weight:bold;">LUNAS</center>';
								else
									echo '<BR><center style="font-weight:bold;">Sisa : '.rupiah($sisa[$ss]).'</center>';

							}
						echo '</td>';
						echo '<td>';
							echo $v['B'];
						echo '</td>';
						echo '<td align="right">';
							echo rupiah($v['C']);
						echo '</td>';
						if(!empty($tgl[$no]))
						{
							foreach ($tgl[$no] as $kk => $vv) 
							// for($p=0;$p<count($tgl[$k]);$p++)
							{
								# code...
								// if(isset($tgl[$k][$p]))
								// {
								if(isset($byrin[$ss][$vv]))
								{
										echo '<td align="right" style="background:#ccc">';
											echo rupiah($header[$no][chr(ord($kk) - 1)]);
										echo '</td>';
										echo '<td align="right" style="background:#eee">';
											echo strtok($byrin[$ss][$vv],' ');
										echo '</td>';
								}
								else
								{

									$tg=$vv;
									$jumlah=$header[$no][chr(ord($kk) - 1)];

									$simpan['nis']=$ss;
									$simpan['id_kelas']=$tkelasid;
									$simpan['penyetor']=$penyetor;
									$simpan['idkelasaktif']=$idkelas;
									$simpan['kelas_aktif']=$kelas_id=$idkelas;
									$simpan['tgl_transaksi']=$tgl_transaksi=$tg;
									$simpan['iduser']= $iduser = $this->session->userdata('iduser');
									$simpan['tr_id']=$transaksi_id=substr(abs(crc32(md5(sha1(rand())))),0,8);
									$simpan['jumlah']=$jlh=$jumlah;
									$simpan['t_jenis_pembayaran_id']=$idt=3;
									$simpan['id_parent_jenis_pembayaran'] =3;
									$simpan['keterangan']=$simpan['catatan']='';
									$simpan['total']=str_replace(',', '', $jumlah);

									// echo '<pre>';
									// print_r($simpan);
									// echo '</pre>';
									
												
										
										
											
											$cekc=$this->db->query('select * from t_record_pembayaran_siswa 
																	where t_siswa_nis="'.$ss.'"
																	and t_kelas_aktif_id="'.$idkelas.'" and t_jenis_pembayaran_id="'.$idt.'"');
											//echo $cekc->num_rows.'<br>';
											if($cekc->num_rows!=0)
											{
												$wb=$cekc->row('wajib_bayar');
												$sb=$jlh+$cekc->row('sudah_bayar');
												$sisa=$wb-$sb;
												$upd=array(
													'sisa'=>$sisa,
													'wajib_bayar'=>$wb,
													'sudah_bayar'=>$sb
												);
												$this->db->where('id',$cekc->row('id'));
												$this->db->update('t_record_pembayaran_siswa',$upd);

												$cekcc=$this->db->query('select * from t_penerimaan_rutin 
																		where t_siswa_nis="'.$ss.'"
																		and t_siswa_has_t_kelas_id="'.$idkelas.'" and t_jenis_pembayaran_id="10" and bulan="7"');
												//echo $cekc->num_rows.'<br>';
												if($cekcc->num_rows!=0)
												{
													if($cekcc->row('wajib_bayar')<=$sb)
													{
														$wbc=375000;
														// $sisac=$wbc-$sbc;
														$updc=array(
															'sisa_bayar'=>0,
															'sudah_bayar'=>$wbc
														);
														$this->db->where('id',$cekcc->row('id'));
														$this->db->update('t_penerimaan_rutin',$updc);

														$cekek=$this->db->query('select * from t_pembayaran where t_jenis_pembayaran_id=10 and t_siswa_has_t_kelas_id="'.$idkelas.'" and keterangan=7');
														if($cekek->num_rows==0)
														{
															$ins=array(
																't_jenis_pembayaran_id'=>10,
																't_siswa_has_t_kelas_id'=>$idkelas,
																'id'=>abs(crc32(sha1(md5(rand())))),
																'jumlah'=>$cekcc->row('wajib_bayar'),
																'tgl_transaksi'=>$tg,
																't_user_id'=>$this->session->userdata('iduser'),
																'penyetor'=>$penyetor,
																'id_parent_jenis_pembayaran'=>10,
																'keterangan'=>7,
																'catatan'=>''
															);
															$this->db->insert('t_pembayaran',$ins);
														}
													}
												}

												$cekeke=$this->db->query('select * from t_pembayaran where t_jenis_pembayaran_id=3 and t_siswa_has_t_kelas_id="'.$idkelas.'" and catatan like "%Formulir Pendaftaran%"');
														if($cekeke->num_rows==0)
														{
															$tglll=$this->db->query('select * from t_pembayaran 
																					where t_siswa_has_t_kelas_id like "%'.$idkelas.'%"  
																					and t_jenis_pembayaran_id=3 order by tgl_transaksi limit 1;');

															if($tglll->num_rows!=0)
																$tlll=$tglll->row('tgl_transaksi');
															else
																$tlll='2014-08-01';

															$ins=array(
																't_jenis_pembayaran_id'=>3,
																't_siswa_has_t_kelas_id'=>$idkelas,
																'id'=>abs(crc32(sha1(md5(rand())))),
																'jumlah'=>400000,
																'tgl_transaksi'=>$tlll,
																't_user_id'=>$this->session->userdata('iduser'),
																'penyetor'=>$penyetor,
																'id_parent_jenis_pembayaran'=>3,
																'keterangan'=>'Formulir Pendaftaran',
																'catatan'=>'Formulir Pendaftaran'
															);
															$this->db->insert('t_pembayaran',$ins);

															$cekc=$this->db->query('select * from t_record_pembayaran_siswa 
																	where t_siswa_nis="'.$ss.'"
																	and t_kelas_aktif_id="'.$idkelas.'" and t_jenis_pembayaran_id="3"');

															$wb=$cekc->row('wajib_bayar');
															$sb=400000+$cekc->row('sudah_bayar');
															$sisa=$wb-$sb;
															$upd=array(
																'sisa'=>$sisa,
																'wajib_bayar'=>$wb,
																'sudah_bayar'=>$sb
															);
															$this->db->where('id',$cekc->row('id'));
															$this->db->update('t_record_pembayaran_siswa',$upd);
														}
											}

										
										$this->pm->saveTransaksi($simpan);
										
										echo '<td align="right">';
											echo rupiah($jumlah);
										echo '</td>';
										echo '<td align="right">';
											echo $tg;
										echo '</td>';
								}
							}
						}
						// echo '<td align="right">';
						// 	echo rupiah($v['O']);
						// echo '</td>';
						// echo '<td align="left">';
						// 	echo ($v['P']);
						// echo '</td>';
					echo '</tr>';
				// }


			

			$no++;
		}
		echo '</table>';
		// $data['values'] = $arr_data;
		// - See more at: https://arjunphp.com/how-to-use-phpexcel-with-codeigniter/#sthash.sZjQUlV1.dpuf
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
	}

	function perbaiki()
	{

		$this->load->helper('file');
		if(!empty($_FILES['file']['name']))
		{
			list($idajaran,$tahunaj)=explode('_', $_POST['ajaran']);
			// $aj=$this->db->query('');
			$x=read_file($_FILES['file']['tmp_name']);
			$pecah = explode("\n", $x);
			foreach ($pecah as $k => $v) 
			{
				// echo $v.'<br>';
				if($v!='')
				{
					$p=explode(',', $v);
					$ta=$p[14];
					$this->db->query('update t_siswa_has_t_kelas set t_ajaran_id="'.$idajaran.'", namakelasaktif="Tahun Ajaran '.$tahunaj.'" where id='.$p[7].'');
					echo $v.'<br>';
				}
			}
		}

		echo form_open_multipart('a/perbaiki');
		echo 'Upload File <input type="file" name="file">';
		echo '<br>';
		$tahunajaran=$this->db->query('select * from t_ajaran order by tahunajaran');
		if($tahunajaran->num_rows!=0)
		{
			echo 'Tahun Ajaran<select name="ajaran">';
			foreach ($tahunajaran->result() as $k => $v) 
			{
				echo '<option value="'.$v->id.'_'.$v->tahunajaran.'">'.$v->tahunajaran.'</option>';
			}
			echo '</select>';
		}
		echo '<br><input type="submit" value="upload">';
		echo '</form>';
	}
}
/*
$config['upload_path'] = 'media/files/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '100000';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file'))
			{
				$error = array('error' => $this->upload->display_errors());
				echo '<pre>';
				print_r($error);
				echo '</pre>';
				// $this->load->view('upload_form', $error);
			}
			else
			{
				$data = $this->upload->data();
				$file = $data['full_path'];
				
				$baca=
				$pecah = explode("\n", $file);
				foreach ($pecah as $k => $v) 
				{
					echo $v.'<br>';
				}

			}
*/