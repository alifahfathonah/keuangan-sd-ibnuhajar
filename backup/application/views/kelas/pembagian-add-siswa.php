<?
list($kelasid,$namakelas)=explode('_', $det[0]->nama_kelas);
?>
<form id="form-add-siswa" class="form-horizontal" action="<?=site_url()?>kelas/addpembagiansiswa/<?=$id?>/<?=$kelasid?>/<?=$subkelasid?>/<?=$idajaran?>" method="post" onsubmit="return cekform()" enctype="multipart/form-data">
	<!-- <div class="span12"> -->
		<fieldset>
			<legend style="text-align:left;">Form Tambah Siswa : Kelas
											<?
												echo $namakelas;
											?></legend>

			<div class="control-group" style="margin-top:-15px;">
			  <label class="control-label" for="typeahead" style="float:left;width:100%;text-align:center">Pilih Siswa</label>
			  <div class="controls" style="text-align:left;float:left;margin-left:0px;width:100%">
			  	<select name="namasiswa" data-rel="chosen" data-placeholder="Pilih Nama Siswa" style="width:100%" multiple id="namasiswa" data-placeholder="Pilih Siswa">

			  		<?
			  		$sis=$this->db->query('select * from v_kelas_aktif where idkelas="'.$id.'" and st_aktif="t" and id_ajaran="'.$idajaran.'" and status_siswa_aktif="t" order by nama');
			  		$data=array();
			  		if($sis->num_rows!=0)
			  		{
			  			foreach ($sis->result() as $k => $v)
			  			{
			  				$data[$v->nama]=$v;
			  			}
			  		}

			  		$ta=$this->db->query('select * from t_ajaran where id="'.$idajaran.'"');
			  		$ss=$this->db->query('select * from t_pembagian_siswa as tps inner join t_pembagian as tp on (tp.id=tps.id_pembagian) where tp.nama_kelas like "%'.$kelasid.'%" and tps.status="t" and tahun_ajaran="'.$ta->row('tahunajaran').'" and tp.status="t"');

			  		if($ss->num_rows!=0)
			  		{
			  			foreach ($ss->result() as $kk => $vv)
			  			{
			  				unset($data[$vv->nama_siswa]);
			  			}
			  		}

			  		foreach ($data as $kd => $vd)
			  		{
			  			# code...
			  			echo '<option value="'.$vd->nis.'|'.$vd->id.'|'.$vd->nama.'">'.$vd->nama.'</option>';
			  		}
			  		?>
			  	</select>
			  </div>
			  <input type="hidden" name="namasiswadata" id="namasiswadata">
			</div>

			<div class="form-actions" style="text-align:left;">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="reset" class="btn">Batal</button>
			</div>
		</fieldset>
	<!-- </div> -->
</form>
<style type="text/css">
	#namasiswa__div_style__chzn
	{
		width:100% !important;
	}
</style>
<script type="text/javascript">
	$('#namasiswa').change(function(){
		var data=$(this).val();
		$('#namasiswadata').val(data);
	});
</script>
