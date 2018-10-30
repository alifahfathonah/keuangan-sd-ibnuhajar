<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrasi extends CI_Controller {

    function __construct()
	{
		parent::__construct();
    }
    
    function migration($table=null)
    {
        $new_db=$this->load->database('third',true);
        $second_db=$this->load->database('second',true);
        // $siswa=$this->db->from('t_siswa')->get()->result();
        // $siswa=$second_db->from('t_siswa')->get()->result();
        // $n_siswa=array();
        // $idx=0;
        // foreach($siswa as $k => $v)
        // {
        //     $n_siswa[$idx]['nis']=$v->nis;
        //     $n_siswa[$idx]['nama_murid']=$v->nama;
        //     $n_siswa[$idx]['tempat_lahir']=$v->tlahir;
        //     $n_siswa[$idx]['tanggal_lahir']=$v->tgllahir;
        //     $n_siswa[$idx]['alamat']=$v->alamat;
        //     $n_siswa[$idx]['nama_ayah']=$v->nama_ayah;
        //     $n_siswa[$idx]['nama_ibu']=$v->nama_ibu;
        //     $n_siswa[$idx]['hp_ayah']=str_replace('-','',$v->telp_ayah);
        //     $n_siswa[$idx]['hp_ibu']=str_replace('-','',$v->telp_ibu);
        //     $n_siswa[$idx]['pekerjaan_ayah']=$v->pekerjaan_ayah;
        //     $n_siswa[$idx]['pekerjaan_ibu']=$v->pekerjaan_ibu;
        //     $n_siswa[$idx]['foto']=$v->foto;
        //     $n_siswa[$idx]['status_tampil']=$v->status;
        //     $n_siswa[$idx]['tahun_masuk']=$v->tahunmasuk;
        //     $n_siswa[$idx]['pendidikan_ayah']=$v->pendidikan_ayah;
        //     $n_siswa[$idx]['pendidikan_ibu']=$v->pendidikan_ibu;
        //     $n_siswa[$idx]['jenis_kelamin']=$v->jenis_kelamin;
        //     $n_siswa[$idx]['nisn']=$v->nis_baru;
        //     $idx++;
        // }
        // $new_db->insert_batch('t_siswa',$n_siswa);

        // $ajaran=$this->db->from('t_ajaran')->get()->result();
        // $n_ajaran=array();
        // $idx=0;
        // foreach($ajaran as $k=>$v)
        // {
        //     $n_ajaran[$idx]['id_ajaran']=$v->id;
        //     $n_ajaran[$idx]['tahun_ajaran']=$v->tahunajaran;
        //     $n_ajaran[$idx]['bulan_awal']=$v->bulan_awal;
        //     $n_ajaran[$idx]['bulan_akhir']=$v->bulan_akhir;
        //     $n_ajaran[$idx]['status_tampil']='t';
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_ajaran',$n_ajaran);

        // $club=$this->db->from('t_club')->get()->result();
        // $n_club=array();
        // $idx=0;
        // foreach($club as $k=>$v)
        // {
        //     $n_ajaran[$idx]['id_club']=$v->id_club;
        //     $n_ajaran[$idx]['nama_club']=$v->nama_club;
        //     $n_ajaran[$idx]['penanggung_jawab']=$v->penanggung_jawab;
        //     $n_ajaran[$idx]['status_tampil']=$v->status_tampil;
        //     $n_ajaran[$idx]['telp_pj']=$v->telp_pj;
        //     $n_ajaran[$idx]['email_pj']=$v->email_pj;
        //     $n_ajaran[$idx]['biaya']=$v->biaya;
        //     $n_ajaran[$idx]['hari']=$v->hari;
        //     $n_ajaran[$idx]['waktu']=$v->waktu;
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_club',$n_ajaran);    

        
        $sis=$new_db->from('t_siswa')->get()->result();
        $clb=$new_db->from('t_club')->get()->result();
        $siswa=$club=array();
        foreach($sis as $ks=>$vs)
        {
            $siswa[$vs->nis]=$vs;
        }    
        foreach($clb as $kc=>$vc)
        {
            $club[$vc->id_club]=$vc;
        }    

        // $club_siswa=$this->db->from('t_club_siswa')->get()->result();
        // $n_club_siswa=array();
        // $idx=0;
        // foreach($club_siswa as $k=>$v)
        // {
        //     $namaclub=$club[$v->id_club]->nama_club;
        //     $namasiswa=$siswa[$v->nis]->nama_murid;
        //     $n_ajaran[$idx]['id']=$v->id;
        //     $n_ajaran[$idx]['nis']=$v->nis;
        //     $n_ajaran[$idx]['id_club']=$v->id_club;
        //     $n_ajaran[$idx]['status_tampil']=$v->status_tampil;
        //     $n_ajaran[$idx]['nama_siswa']=$namasiswa;
        //     $n_ajaran[$idx]['nama_club']=$namaclub;
        //     $n_ajaran[$idx]['keterangan']='';
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_data_club_siswa',$n_ajaran);   

        // $driver=$this->db->from('t_driver')->get()->result();
        // $n_driver=array();
        // $idx=0;
        // foreach($driver as $k=>$v)
        // {
        //     $n_driver[$idx]['id_supir']=$v->id;
        //     $n_driver[$idx]['nama_supir']=$v->nama_driver;
        //     $n_driver[$idx]['alamat']=$v->alamat;
        //     $n_driver[$idx]['telp']=$v->telp;
        //     $n_driver[$idx]['status_tampil']=$v->status;
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_supir',$n_driver);    
        
        $drv=$new_db->from('t_supir')->get()->result();
        $driver=array();
        foreach($drv as $kd=>$vd)
        {
            $driver[$vd->id_supir]=$vd;
        }  

        // $jemputan=$this->db->from('t_driver_siswa')->get()->result();
        // $n_jemputan=array();
        // $idx=0;
        // foreach($jemputan as $k=>$v)
        // {
        //     $namadriver=isset($driver[$v->id_driver]) ? $driver[$v->id_driver]->nama_supir : '';
        //     $namasiswa=$siswa[$v->nis]->nama_murid;
        //     $n_jemputan[$idx]['id']=$v->id;
        //     $n_jemputan[$idx]['nis']=$v->nis;
        //     $n_jemputan[$idx]['id_driver']=$v->id_driver;
        //     $n_jemputan[$idx]['keterangan']='';
        //     $n_jemputan[$idx]['status_tampil']='t';
        //     $n_jemputan[$idx]['nama_siswa']=$namasiswa;
        //     $n_jemputan[$idx]['nama_driver']=$namadriver;
        //     $n_jemputan[$idx]['status']=$v->biaya==1 ? 'pulang-pergi':'pulang';
        //     $n_jemputan[$idx]['jemputan_club']=NULL;
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_data_jemputan',$n_jemputan); 
        
        // $kode_akun=$this->db->from('t_kode_akun')->get()->result();
        // $n_kode_akun=array();
        // $idx=0;
        // foreach($kode_akun as $k=>$v)
        // {
        //     // $n_jemputan[$idx]['id']=$v->id;
        //     $n_kode_akun[$idx]['kode_akun']=$v->kode_akun;
        //     $n_kode_akun[$idx]['nama_akun']=$v->nama_akun;
        //     $n_kode_akun[$idx]['status_tampil']=$v->status_tampil;
        //     $n_kode_akun[$idx]['id_parent']=$v->id_parent;
        //     $n_kode_akun[$idx]['kat']='sekolah';
        //     $n_kode_akun[$idx]['jenis']='penerimaan';
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_akun',$n_kode_akun); 
        
        $tajaran=$new_db->from('t_ajaran')->get()->result();
        $thn_ajaran=array();
        foreach($tajaran as $kd=>$vd)
        {
            $thn_ajaran[$vd->id_ajaran]=$vd;
        }  
        
        $akun=$new_db->from('t_akun')->get()->result();
        $kd_akun=array();
        foreach($akun as $kd=>$vd)
        {
            $kd_akun[$vd->kode_akun]=$vd;
        }  

        // $jenis_penerimaan=$this->db->from('t_jenis_pembayaran')->get()->result();
        // $n_jenis_penerimaan=array();
        // $idx=0;
        // foreach($jenis_penerimaan as $k=>$v)
        // {
        //     $n_jenis_penerimaan[$idx]['id']=$v->id;
        //     $n_jenis_penerimaan[$idx]['jenis']=$v->jenis;
        //     $n_jenis_penerimaan[$idx]['jumlah']=$v->jumlah;
        //     $n_jenis_penerimaan[$idx]['kategori']=$v->kategori;
        //     $n_jenis_penerimaan[$idx]['status_tampil']=$v->status;
        //     $n_jenis_penerimaan[$idx]['kodeakun']=NULL;
        //     $n_jenis_penerimaan[$idx]['level']='all';
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_jenis_penerimaan',$n_jenis_penerimaan); 

        $jenis_pen=$new_db->from('t_jenis_penerimaan')->get()->result();
        $j_pen=array();
        foreach($jenis_pen as $kd=>$vd)
        {
            $j_pen[$vd->id]=$vd;
        }  

        // $kelas=$this->db->from('t_kelas')->get()->result();
        // $n_kelas=array();
        // $idx=0;
        // foreach($kelas as $k=>$v)
        // {
        //     $n_kelas[$idx]['id_level']=$v->id;
        //     $n_kelas[$idx]['nama_level']=$v->namakelas;
        //     $n_kelas[$idx]['status_tampil']=$v->status;
        //     $n_kelas[$idx]['kapasitas']=$v->jlh_siswa;
        //     $n_kelas[$idx]['kategori']=NULL;
        //     $idx++;             
        // }
        // $new_db->insert_batch('t_level_kelas',$n_kelas); 

        $t_kelas=$new_db->from('t_level_kelas')->get()->result();
        $t_kls=array();
        foreach($t_kelas as $kd=>$vd)
        {
            $t_kls[$vd->id_level]=$vd;
        }  

        

    }
}

            
            
            