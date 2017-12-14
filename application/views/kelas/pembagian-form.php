<form id="fform-action" class="form-horizontal" action="<?=site_url()?>kelas/<?=(isset($idedit) ? 'edit' : 'add')?>pembagiankelas/<?=$d[0]->id?>/<?=$d[0]->namakelas?>/<?=$ta[0]->tahunajaran?>/<?=$idajaran?>" method="post" onsubmit="return cekform()" enctype="multipart/form-data">
	<div class="span12">
		<fieldset>
			<legend style="text-align:left;">Form <?=(isset($idedit) ? 'Edit' : 'Tambah')?> Pembagian Kelas</legend>		
			<div class="control-group">
			  <label class="control-label" for="typeahead">Kelas</label>
			  <div class="controls">
				<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;font-size:16px;">
					<?=$d[0]->namakelas?>
				</label>
			  </div>
			</div>
			<div class="control-group">
			  <label class="control-label" for="typeahead">Tahun Ajaran</label>
			  <div class="controls">
				<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;font-size:16px;">
					<?=$ta[0]->tahunajaran?>
				</label>
			  </div>
			</div>
			<div class="control-group">
			  <label class="control-label" for="typeahead">Wali Kelas</label>
			  <div class="controls">
				<!-- <label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;"> -->
				<?
				$guru=$this->db->query('select * from v_user where level="Guru" and status="t"');
				$g='[';
				foreach ($guru->result() as $k => $v) 
				{
					$g.='"'.$v->nama.'",';
				}
				$g=substr($g, 0,-1).']';
				?>
					<input type="text" class="span4 typeahead" id="walikelas" autocomplete="off"  data-provide="typeahead" data-items="4" data-source='<?=$g?>' name="walikelas" required value="<?=(isset($idedit) ? $da[0]->walikelas : '')?>">
				<!-- </label> -->
			  </div>
			</div>
			
			<div class="control-group">
			  <label class="control-label" for="typeahead">Nama Kelas</label>
			  <div class="controls">
				<input type="text" class="span4" name="namakelas" autocomplete="off" required value="<?=(isset($idedit) ? $namakelas : '')?>">
			  </div>
			</div>
			<?
			if(!isset($idedit))
			{
			?>
			<div class="form-actions" style="text-align:left;">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="reset" class="btn">Batal</button>
			</div>
			<?
			}
			else
				echo '<input type="hidden" name="idedit" value="'.$idedit.'">';
			?>
		</fieldset>	
	</div>
</form>
			
<script type="text/javascript">
	function cekform()
	{
		var walikelas=$('#walikelas').val();
		var namakelas=$('#namakelas').val();
		if(walikelas=='')
		{
			alert('Wali Kelas Belum Diisi');
		}
		else if(namakelas=='')
			alert('Nama Kelas Belum Diisi');
		else
			return true;

		return false;
	}
</script>