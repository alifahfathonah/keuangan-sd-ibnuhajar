<form id="simpanpengeluaran" style="width:100% !important" class="form-horizontal" method="post" action="<?=site_url()?>pengeluaran/pengeluaranproses/<?=$id?>">
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Jenis Pengeluaran</label>
				  <div class="controls">
						<select name="jenis_pengeluaran" id="jenis_pengeluaran" data-rel="chosen">
							<option value=""></option>
							<?
								$jenis=$this->db->from('t_jenis_pengeluaran')->where('status_tampil','t')->order_by('jenis asc')->get();
								$jn=array();
								foreach ($jenis->result() as $k => $v) 
								{
									if($id==-1)
										echo '<option value="'.$v->id.'-'.str_replace(' ', '%20', $v->jenis).'">'.$v->jenis.'</option>';
									else
									{
										if(($v->id)==$d->row('id'))
											echo '<option selected="selected" value="'.$v->id.'-'.str_replace(' ', '%20', $v->jenis).'">'.$v->jenis.'</option>';
										else
											echo '<option value=""'.$v->id.'-'.str_replace(' ', '%20', $v->jenis).'">'.$v->jenis.'</option>';
									}
										
								}
							?>
						</select>
				  </div>
				</div>				
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Tanggal </label>
				  <div class="controls">
						<input readonly type="text" name="tgl_transaksi" class="span2" id="tgl_transaksi" style="float:left;" value="<?=($id!=-1 ? $d->row('tgl_transaksi') : date('Y-n-d'))?>">			
					</div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">No Kwitansi</label>
				  <div class="controls">
						<input type="text" name="no_kwitansi" class="span2" id="no_kwitansi" style="float:left;" value="<?=($id!=-1 ? $d->row('no_kwitansi') : generate_id())?>">			
					</div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Dibayar Kepada </label>
				  <div class="controls">
						<input type="text" name="dibayar_kepada" class="span4" id="dibayar_kepada" style="float:left;" value="<?=($id!=-1 ? $d->row('dibayar_kepada') : '')?>">			
					</div>
				</div>
				
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Jumlah</label>
				  <div class="controls">
						
						<input type="text" name="jumlah" style="text-align:right" class="span4 " id="jumlah"  required value="<?=($id!=-1 ? $d->row('jumlah') : 0)?>">
				  </div>
				</div>

				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Kasir</label>
				  <div class="controls">
						
						<input type="text" name="kasir" class="span4 " id="kasir" required value="<?=($id!=-1 ? $d->row('kasir') : '')?>">
				  </div>
				</div>

				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Bendahara</label>
				  <div class="controls">
						
						<input type="text" name="bendahara" class="span4 " id="bendahara"  required value="<?=($id!=-1 ? $d->row('kasir') : '')?>">
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Keterangan</label>
				  <div class="controls">
						
						<input type="text" name="ket" style="width:90%" id="ket"  required value="<?=($id!=-1 ? $d->row('kasir') : '')?>">
				  </div>
				</div>

				
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="simpantransaksi" type="button">
							
							<?=($id!=-1  ? '<i class="ace-icon fa fa-pencil bigger-110"></i> Edit' : '<i class="ace-icon fa fa-check bigger-110"></i> Simpan')?>
						</button>
						<?
						if($id!=-1)
						{
						?>
						<button class="btn btn-primary" id="barupengeluaran" type="button">
							<i class="ace-icon fa fa-check bigger-110"></i>
							Baru
						</button>
						<?
						}
						?>
						&nbsp; &nbsp; &nbsp;
					</div>
				</div>

				<div class="hr hr-24"></div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tgl_transaksi').datepicker({
				  changeMonth: true,
				  changeYear: true,
				  dateFormat : 'yy-mm-dd',
				  showOn: "button",
				buttonImage: "<?=base_url()?>media/img/calendar146.png"
				});

		$('#simpantransaksi').on('click',function(){
			var jenis_pengeluaran=$('#jenis_pengeluaran').val();
			var dibayar_kepada=$('#dibayar_kepada').val();
			var jumlah=$('#jumlah').val();
			var kasir=$('#kasir').val();
			var bendahara=$('#bendahara').val();

			if(jenis_pengeluaran=='')
				alert('Jenis Pengeluaran Belum Di Pilih');
			else if(dibayar_kepada=='')
				alert('Nama Penerima Belum Diisi');
			else if(jumlah==0)
				alert('Jumlah Pengeluaran Belum Diisi');
			else if(kasir=='')
				alert('Nama Kasir Belum Diisi');
			else if(bendahara=='')
				alert('Nama Bendahara Belum Diisi');
			else
			{

				var c=confirm("Apakah Data Pengeluaran ini Sudah Benar??");
				if(c)
				{
					$('#simpanpengeluaran').submit();
				}
			}
		});
	});
</script>