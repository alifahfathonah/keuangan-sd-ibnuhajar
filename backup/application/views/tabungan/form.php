<form class="form-horizontal" id="simpantabungan" action="<?=site_url()?>tabungan/prosestabungan" method="post">
	<div class="span12">
		<fieldset>
			<legend style="text-align:left;">Form <?=(isset($idedit) ? 'Edit' : 'Tambah')?> Tabungan</legend>		
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
			  <label class="control-label" for="typeahead">Tanggal</label>
			  <div class="controls">
				<input readonly type="text" name="tgl_transaksi" class="span4" id="tgl_transaksi" style="float:left;" value="<?=date('Y-m-d')?>">
			  </div>
			</div>
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
			  <label class="control-label" for="typeahead">Jenis Tabungan</label>
			  <div class="controls">
				<select name="jenistabungan" id="jenistabungan" data-rel="chosen">
					<option value="0">-Pilih Jenis-</option>
					<option value="1">Tabungan Harian</option>
					<option value="2">Tabungan Tak Lain</option>
					<option value="3">Infaq</option>
				</select>
			  </div>
			</div>
			<input type="hidden" name="jenis_transaksi" value="setor">
			<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
			  <label class="control-label" for="typeahead">Kelas</label>
			  <div class="controls">
				<select name="kelas" id="kelas" data-rel="chosen">
					<option value="0">-Pilih Kelas-</option>
					<?
					
					foreach ($kelas->result() as $k => $v) 
					{
						list($kls,$nama)=explode('_', $v->nama_kelas);
						echo '<option value="'.$v->id.'__'.$v->tahun_ajaran.'__'.str_replace(' ', '%20', $v->walikelas).'__'.str_replace(' ', '%20',$v->nama_kelas).'">'.$kls.' - '.$nama.'</option>';
					}
					?>
				</select>
			  </div>
			</div>
			<div id="datasiswa"></div>
			<div class="form-actions" style="text-align:left;">
				<button type="button" id="simpan" class="btn btn-primary">Simpan</button>
				<button type="reset" class="btn">Batal</button>
			</div>
		</fieldset>
	</div>
</form>
<script type="text/javascript">
function formatuang(id,jenis)
{
	if(jenis==1)
	{
		var tot=0;
		$('#jlh_'+id).formatCurrency({ symbol:'' });
		$('input.jlhtab').each(function(a){
			var tt=$(this).val();
			var t=parseFloat(tt.replace(/,/g,''));
			tot += t;
		});
		$('#total').val(tot);
		$('#total').formatCurrency({ symbol:'' });
	}
	else if(jenis==2)
		$('#jenis_'+id).formatCurrency({ symbol:'' });
	else if(jenis==3)
		$('#jenis_'+id).formatCurrency({ symbol:'' });
}
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
				// $('#simpantabungan').submit();
			}
		});

		$('#tgl_transaksi').datepicker({
			  changeMonth: true,
			  changeYear: true,
			  dateFormat : 'yy-mm-dd',
			  showOn: "button",
			buttonImage: "<?=base_url()?>media/img/calendar146.png"
			});

		$('#kelas').change(function(){
			var jenis=$('#jenistabungan').val();
			var kelas=$(this).val();
			if(jenis==0)
				alert('Jenis Tabungan Belum Dipilih')
			else
			{
				// if(jenis==1)
					// $('#datasiswa').load('<?=site_url()?>');
				// else
					$('#datasiswa').load('<?=site_url()?>tabungan/jenis/'+jenis+'/'+kelas);
			}
		});

		$('#jenistabungan').change(function(){
			var kelas=$('#kelas').val();
			var jenis=$(this).val();
			$('#datasiswa').load('<?=site_url()?>tabungan/jenis/'+jenis+'/'+kelas);
			
		});

		// $('#kelas').change(function(){
		// 	$('#datasiswa').load('<?=site_url()?>');
		// });
	});
</script>