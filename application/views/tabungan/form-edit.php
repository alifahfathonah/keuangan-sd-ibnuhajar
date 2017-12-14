<form class="form-horizontal" id="simpanedittabungan" action="<?=site_url()?>tabungan/prosestabungan/<?=$idd?>-<?=$idtab?>" method="post">
	<div class="span12">
		<fieldset>
				
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
			  <label class="control-label" for="typeahead">Nama Siswa</label>
			  <div class="controls">
				<input readonly type="text" name="nama_siswa" class="span6" id="nama_siswa" style="float:left;" value="<?=$d->row('nama_siswa')?>">
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
			  <label class="control-label" for="typeahead">Tanggal</label>
			  <div class="controls">
				<input readonly type="text" name="tgl_transaksi" class="span4" id="tgl_transaksi" style="float:left;" value="<?=strtok($d->row('tgl_transaksi'),' ')?>">
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
			  <label class="control-label" for="typeahead">Jenis Tabungan</label>
			  <div class="controls">
				<select name="jenistabungan" id="jenistabungan" data-rel="chosen">
				<?
				$jns=strtok($d->row('nokwitansi'), '-');
				?>
					<option value="4">Penarikan</option>
					<option value="1" <?=($jns==1 ? 'selected="selected"' : '')?>>Tabungan Harian</option>
					<option value="2" <?=($jns==2 ? 'selected="selected"' : '')?>>Tabungan Tak Lain</option>
					<option value="3" <?=($jns==3 ? 'selected="selected"' : '')?>>Infaq</option>
				</select>
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Jumlah Tabungan</label>
			  <div class="controls">
				<input type="text" name="jumlah" class="span4" value="<?=$d->row('jumlah')?>" id="jumlah" style="" onkeyup="formatuang(this.value)">
				<input type="hidden" name="jumlahsebelum" class="span4" value="<?=$d->row('jumlah')?>">
			  </div>
			</div>
			<input type="hidden" name="tarik_setor" value="<?=$d->row('tarik_setor')?>">
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Kelas</label>
			  <div class="controls">
				<select name="kelas" id="kelas" data-rel="chosen">
					<option value="0">-Pilih Kelas-</option>
					<?
					$kelas=$this->db->query('SELECT * FROM  `t_pembagian` where status="t" order by tahun_ajaran desc, nama_kelas asc');
					foreach ($kelas->result() as $k => $v) 
					{
						list($kls,$nama)=explode('_', $v->nama_kelas);
						list($kls2,$nama2)=explode('_', str_replace('__',' ',$d->row('kelas')));
						if($nama2==$nama)
						{
							echo '<option selected="selected" value="'.$v->id.'__'.$v->tahun_ajaran.'__'.str_replace(' ', '%20', $v->walikelas).'__'.str_replace(' ', '%20',$v->nama_kelas).'">'.$kls.' - '.$nama.'</option>';
						}
						else
							echo '<option value="'.$v->id.'__'.$v->tahun_ajaran.'__'.str_replace(' ', '%20', $v->walikelas).'__'.str_replace(' ', '%20',$v->nama_kelas).'">'.$kls.' - '.$nama.'</option>';
					}
					?>
				</select>
			  </div>
			</div>
			<div id="datasiswa"></div>
			
		</fieldset>
	</div>
</form>
<script type="text/javascript">

	jQuery(function($){

		$('#simpan').click(function(){
			var c=confirm('Apakah Data Tabungan ini sudah Benar ?');
			if(c)
			{
				$.ajax({
					url : '<?=site_url()?>tabungan/prosestabungan',
					data : $('#simpantabungan').serialize(),
					type : 'POST',
					success : function(a)
					{
						var hr=a.indexOf("harian");
						if(hr!=0)
						{
							// location.href='<?=site_url()?>tabungan';
							window.open('<?=site_url()?>tabungan/kwitansi/'+a,'_blank');
							location.href='<?=site_url()?>tabungan';
						}
						else
							location.href='<?=site_url()?>tabungan';
					}
				});
			}
		});

		

		$('#kelas').change(function(){
			var jenis=$('#jenistabungan').val();
			var kelas=$(this).val();
			if(jenis==0)
				alert('Jenis Tabungan Belum Dipilih')
			else
			{
				$('#datasiswa').load('<?=site_url()?>tabungan/jenis/'+jenis+'/'+kelas);
			}
		});

		$('#jenistabungan').change(function(){
			var kelas=$('#kelas').val();
			var jenis=$(this).val();
			$('#datasiswa').load('<?=site_url()?>tabungan/jenis/'+jenis+'/'+kelas);
			
		});
	});
</script>