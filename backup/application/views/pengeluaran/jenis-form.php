<form id="simpanjarak" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>pengeluaran/jenisproses/<?=$id?>" method="post">
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Jenis Pengeluaran</label>
				  <div class="controls">
						<input type="text" name="jenis" class="span6 typeahead" id="jenis" style="width:100%;" required value="<?=($id!=-1 ? ($child!="" ? $idp : $d->row('jenis')) : '')?>">
				  </div>
				</div>				
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Kategori</label>
				  <div class="controls">

								<select  data-rel="chosen" name="kategori" data-placeholder="Kategori">
									<option value="sekolah">Dana Sekolah</option>
									<option value="non-sekolah">Dana Non Sekolah</option>
								</select>
								<input type="hidden" name="id_parent" value="<?=($id!=-1 ? ($child!="" ? $id : $d->row('id_parent')) : $id_parent)?>">
								<input type="hidden" name="child" value="<?=($id!=-1 ? $child : '')?>">
				  </div>
				</div>

				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Biaya</label>
				  <div class="controls">
						
						<input type="text" name="jumlah" class="span6 typeahead" id="biaya" style="width:100%;" required value="<?=($id!=-1 ? ($child!="" ? $idp : $d->row('jumlah')) : '0')?>">
				  </div>
				</div>				
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Kode Akun Terkait</label>
				  <div class="controls">
						
								<select name="kodeakun" id="kodeakun" class="col-xs-12 col-sm-8 chosen-select">
									<option value=""></option>
									<?
									$ajaran=$this->db->from('t_kode_akun')->where('status_tampil','t')->order_by('kode_akun asc')->get();
									$ka=array();
									foreach ($ajaran->result() as $k => $v) 
									{
										$l=strtok($v->kode_akun, '0');
										$ln=strlen($l);
										if($id==-1)
											echo '<option value="'.$v->kode_akun.'-'.$v->nama_akun.'" style="padding-left:'.($ln*10).'px;">'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
										else
										{
											if(($v->kode_akun.'-'.$v->nama_akun)==$d->row('kodeakun'))
												echo '<option selected="selected" value="'.$d->row('kodeakun').'">'.$v->kode_akun.' | '.$v->nama_akun.'</option>';
											else
												echo '<option value="'.$v->kode_akun.'-'.$v->nama_akun.'">'.$v->kode_akun.' - '.$v->nama_akun.'</option>';
										}
										
									}
									?>
								</select>

				  </div>
				</div>
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="simpanjenis" type="button">
							
							<?=(($id!=-1 && $child=='') ? '<i class="ace-icon fa fa-pencil bigger-110"></i> Edit' : '<i class="ace-icon fa fa-check bigger-110"></i> Simpan')?>
						</button>
						<?
						if($id!=-1 && $child=='')
						{
						?>
						<button class="btn btn-primary" id="barujenis" type="button">
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
<style type="text/css">
	.form-group label
	{
		font-size:10px !important;
	}
	#kodeakun_chosen
	{
		width:100% !important;
	}
	input
	{
		font-size:11px !important;
	}
</style>
<script type="text/javascript">
	$('#barujenis').on('click',function(){
		$('#formjenis').load('<?=site_url()?>pengeluaran/jenisform/-1');
	});
	$('.chosen-select').chosen({allow_single_deselect:true});
	// 			bootbox.confirm("<h3>Apakah Data Jenis Pengeluaran ini sudah Benar </h3>", function(result) {
	$("#simpanjenis").on('click', function() 
	{
			var result=confirm('Apakah Data Jenis Pengeluaran ini sudah Benar ?');
					if(result) 
					{
						$.ajax({
							url : '<?=site_url()?>pengeluaran/jenisproses/<?=$id?>',
							type : 'POST',
							data : $('#simpanjarak').serialize(),
							success : function(a)
							{
								alert(a);
								// tampilpesan(a);
								$('#datajenis').load('<?=site_url()?>pengeluaran/jenisdata');
								$('#formjenis').load('<?=site_url()?>pengeluaran/jenisform/-1');
							}
						});
					}
	});
	// 			});
	$('input#biaya').keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
</script>