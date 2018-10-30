<form class="form-horizontal" id="simpanpenarikan" action="<?=site_url()?>tabungan/penarikan" method="post">
	<div class="span12">
		<fieldset>
			<legend style="text-align:left;">Form Penarikan Tabungan</legend>		

			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Nama Siswa</label>
			  <div class="controls">
				<select name="nama_siswa" id="nama_siswa_tarik" data-rel="chosen" >
					<option value="0">-Pilih Siswa-</option>
					<?
					$siswa=$this->db->from('t_tabungan')->order_by('nama_siswa')->get();
					foreach ($siswa->result() as $k => $v) 
					{
						list($idkls,$nmkls)=explode('__',$v->kelas);
						$kelas=str_replace('_',' ',$nmkls);
						echo '<option value="'.$v->nis.'_'.$v->id.'">'.$v->nama_siswa.' - ('.$kelas.')</option>';
					}
					?>
				</select>
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Jenis Tabungan</label>
			  <div class="controls">
				<select name="jenistabungan" id="jenistabungantarik" data-rel="chosen">
					<option value="0">-Pilih Jenis-</option>
					<option value="1">Tabungan Harian</option>
					<option value="2">Tabungan Tak Lain</option>
					<option value="3">Infaq</option>
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
			  <label class="control-label" for="typeahead">Petugas</label>
			  <div class="controls">
				<input type="text" name="petugas" class="span6" id="petugas_tarik" style="" value="<?=$this->session->userdata('nama')?>">
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