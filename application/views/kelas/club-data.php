<form action="<?=site_url()?>club/addpenerimaanclub" method="post" class="form-horizontal" > 	
<fieldset style="width:99%;float:left">
	<div class="control-group" style="width:33%;float:left">
	  <label class="control-label" for="typeahead">Jenis Penerimaan </label>
	  <div class="controls">
		<!--<label class="control-label" style="text-align:left;font-weight:bold" for="typeahead">-->
		<select name="jenispenerimaan" id="jenispenerimaan" data-rel="chosen" data-placeholder="Jenis Penerimaan">
			<option selected></option>	
			<?
				echo '<option value="18" selected>Club</option>';
				//$jenisP->row('jenis')
			?>
		</select>
	  </div>
	</div>

	<div class="control-group"  style="width:30%;float:left">
	  <label class="control-label" for="date01">Bulan</label>
	  <div class="controls">
		<select name="bulan" id="bulan" data-rel="chosen" data-placeholder="Pilih Bulan">
			<option selected></option>
			<?
			for($i=1;$i<=12;$i++)
			{
				if($i==date('n'))
					echo '<option selected value="'.$i.'">'.getBulan($i).'</option>';
				else	
					echo '<option value="'.$i.'">'.getBulan($i).'</option>';
			}
			?>
		</select>
	  </div>
	</div>
	<div class="control-group"  style="width:30%;float:left">
	  <label class="control-label" for="date01">Tahun</label>
	  <div class="controls">
		<select name="tahun" data-rel="chosen" data-placeholder="Pilih Tahun" id="tahun">
			<option selected></option>
			<?
			for($i=(date('Y')-2);$i<=(date('Y')+1);$i++)
			{
				if($i==date('Y'))
					echo '<option value="'.date('Y').'" selected>'.$i.'</option>';
				else
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
			?>
		</select>
	  </div>
	</div>  
       

<div class="control-group" id="by_kelas" style="width:50%;float:left;">
	  <label class="control-label" for="date01">Nama Club</label>
	  <div class="controls">
		<select name="club" id="club" data-rel="chosen" data-placeholder="Pilih Club">
			<option selected></option>
			<?
			$dr=array();
			$club=$this->db->from('t_club')->where('status_tampil','t')->order_by('nama_club','asc')->get();
			foreach($club->result() as $d)
			{
				echo '<option value="'.$d->id_club.'">'.$d->nama_club.'</option>';
			}
			?>
		</select>
	  </div>
  </div>

<div style="float:right;margin-right:10px;">
 		<button type="button" class="btn btn-primary" id="adddriversiswa">Tambah Siswa</button>
</div>
  </fieldset>
 
	<div style="border-top:1px solid #ccc;width:100%;float:left;margin-top:10px" id="datasiswa"></div>
	<div class="form-actions" style="float:left;width:60%;padding-left:400px">
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
 </form> 

<div class="modal hide fade" id="ModalTambahSiswa" >
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Tambah Siswa Club</h3>
	</div>
	<div class="modal-body" style="height:380px !important">
		<form class="form-horizontal" action="<?=site_url()?>club/addclubsiswa" id="form-add-siswa" method="post">
		    <input type="hidden" id="idcl" name="idcl">
		    <?
		    $ajaran=gettahunajaran();
		    $ajarans=gettahunajaransebelum();
		    // $ta=$this->db->query('select * from t_ajaran order by tahunajaran desc limit 1');
		    // for($si=0;$si<8;$si++)
		    // {
		    ?>
		    <div class="control-group">
		      <label class="control-label" for="input01">Nama Siswa</label>
		      <div class="controls">
		        <select name="namasiswa[]" multiple id="namasiswa" data-rel="chosen" data-placeholder="Pilih Siswa" style="width:300px !important">
		        	<!-- <option selected></option> -->
		        	<?
		        	// $sa=$this->sm->getSiswaAktifKelasAktif('t')->result();
		        	$where=array('st_kelas'=>'t','status_siswa_aktif'=>'t');
		        	$ta=array($ajaran,$ajarans);
		        	$sa=$this->db->from('v_kelas_aktif')->where($where)->where_in('tahunajaran',$ta)->order_by('nama','asc')->get()->result();
		        	$ca=count($sa);
		        	if($ca!=0)
		        	{
		        		for($c=0;$c<$ca;$c++)
		        		{
		        			echo '<option value="'.$sa[$c]->nis.'">'.$sa[$c]->nama.'</option>';
		        		}
		        	}
		        	?>
		        </select>
		      </div>
		    </div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-dismiss="modal">Tidak</a>
		<a href="#" class="btn btn-primary" data-dismiss="modal" id="simpansiswa">Simpan</a>
	</div>
</div>
<style type="text/css">
	.table td
	{
		/*margin:2px !important;*/
		padding-bottom:0px !important;
		padding-top:2px !important;
	}
</style>
<script type="text/javascript">
	
	function loaddata()
	{
		$('#namasiswa').chosen().val('');
		var jenispenerimaan=$('#jenispenerimaan').val();
		var club=$('#club').val();
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		$('#datasiswa').load('<?=site_url()?>siswa/getSiswaByClub/'+club+'/'+bulan+'/'+jenispenerimaan+'/'+tahun);
	}
	function getid()
	{
		var jenispenerimaan=$('#jenispenerimaan').val();
		var club=$('#club').val();
		var bulan=$('#bulan').val();
		var tahun=$('#tahun').val();
		$('#idcl').val(club+'/'+bulan+'/'+jenispenerimaan+'/'+tahun);
	}

</script>