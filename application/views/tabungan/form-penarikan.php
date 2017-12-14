<form class="form-horizontal" id="simpanpenarikan" action="<?=site_url()?>tabungan/penarikan" method="post">
	<div class="span12">
		<fieldset>
			<legend style="text-align:left;">Form Penarikan Tabungan</legend>		

			<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
			  <label class="control-label" for="typeahead">Nama Siswa</label>
			  <div class="controls">
				<select name="nama_siswa" id="nama_siswa" data-rel="chosen" >
					<option value="0">-Pilih Siswa-</option>
					<?
					$siswa=$this->db->from('t_tabungan')->order_by('nama_siswa')->get();
					foreach ($siswa->result() as $k => $v) 
					{
						echo '<option value="'.$v->nis.'_'.$v->id.'">'.$v->nama_siswa.'</option>';
					}
					?>
				</select>
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Jumlah Penarikan</label>
			  <div class="controls">
				<input type="text" name="jumlah" class="span4" id="jumlah" style="" onkeyup="cektabungan(this.value)">
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Ditarik Oleh</label>
			  <div class="controls">
				<input type="text" name="penarik" class="span6" id="penarik" style="">
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Keterangan</label>
			  <div class="controls">
				<textarea name="keterangan" id="keterangan"></textarea>
			  </div>
			</div>
			
			<div class="form-actions" style="text-align:left;">
				<button type="button" id="simpantarikan" class="btn btn-primary">Tarik</button>
			</div>
		</fieldset>
	</div>
</form>