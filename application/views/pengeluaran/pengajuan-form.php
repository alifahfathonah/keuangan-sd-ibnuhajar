<form id="simpanpengajuan" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>pengeluaran/pengajuanproses/<?=$id?>/<?=$jenis?>" method="post">
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Yang Mengajukan</label>
				  <div class="controls">
						<input type="text" name="pengajuandari" class="span6 typeahead" id="pengajuandari" style="width:100%;" required value="<?=$jenis?>">
				  </div>
				</div> 
				 <label class="control-label" for="typeahead">Dibayarkan Kepada</label>
				  <div class="controls">
						<input type="text" name="dibayarkankepada" class="span6 typeahead" id="dibayarkankepada" style="width:100%;" required value="">
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">No Kwitansi</label>
				  <div class="controls">
						<input type="text" value="<?=generate_id()?>" name="nokwitansi" class="span6 typeahead" id="nokwitansi" style="width:100%;" required>
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Kasir</label>
				  <div class="controls">
						<input type="text" name="kasir" class="span6 typeahead" id="nokwitansi" style="width:100%;" required>
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Bendahara</label>
				  <div class="controls">
						<input type="text" name="bendahara" class="span6 typeahead" id="nokwitansi" style="width:100%;" required>
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Tanggal Pengajuan</label>
				  <div class="controls">
						<input type="text" name="tanggal" readonly="readonly" value="<?=$d[0]->tanggal?>" class="span6 typeahead" id="tanggal" style="width:100%;" required>
				  </div>
				</div>	
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Jumlah Pengajuan</label>
				  <div class="controls">
						<input type="text" readonly name="jumlah" value="<?=number_format($d[0]->jumlah)?>" class="span6 typeahead" id="jumlah" style="width:100%;" required>
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Jumlah Di Setujui</label>
				  <div class="controls">
						<input type="text" name="disetujui" value="" class="span6 typeahead" id="disetujui" style="width:100%;" required>
				  </div>
				</div>
				<div class="control-group" style="margin-top:0px;margin-bottom:3px;"">
				  <label class="control-label" for="typeahead">Keperluan</label>
				  <div class="controls">
						<input type="text" name="keperluan" value="" class="span6 typeahead" id="jumlah" style="width:100%;" required>
				  </div>
				</div>				
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="tidaksetuju" type="button" onclick="setujui('t')">
							<i class="icon icon-close icon-white"></i>
							Tidak 
						</button>
						
						<button class="btn btn-primary" id="setujuipengajuan" onclick="setujui('y')" type="button">
							<i class="icon icon-check icon-white"></i>
							Setujui
						</button>
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

	function setujui(status)
	{
		if(status=='y')
		{
			var c=confirm('Yakin Akan Menyetujui Pengajuan ini?');
			if(c)
			{
				$.ajax({
					url : '<?=site_url()?>pengeluaran/pengajuanproses/<?=$id?>/<?=$jenis?>/'+status,
					type : 'POST',
					data : $('#simpanpengajuan').serialize(),
					success : function(a){
						var nokw=$('#nokwitansi').val();
						window.open(
							'<?=site_url()?>pengeluaran/kwitansipengeluaran/'+nokw,
							'_blank'
						);
						location.href='<?=site_url()?>pengeluaran';
					}
					//$('#simpanpengajuan').submit();
				});
			}
		}
		else
		{
			var c=confirm('Yakin Akan Menolak Pengajuan ini?');
			if(c)
			{
				//$('#simpanpengajuan').submit();
				$("#myModalConfirm").modal("show");
				// $('#modal-body').html(a);
				$('#myModalConfirm .modal-body').load('<?=site_url()?>pengeluaran/alasanmenolakform/<?=$id?>/<?=str_replace(' ', '_', $jenis)?>');
				$('#headerPesan h3').text('Alasan Penolakan');
				//$('#myModal').css({'width':'1000px','top':'35%','left':'35%','outline':'none'});
			}	
		}
	}
</script>