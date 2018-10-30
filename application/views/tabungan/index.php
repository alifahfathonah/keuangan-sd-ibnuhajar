	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Tabungan Siswa</a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Tabungan Siswa</h2>
						<!-- <div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div> -->
					</div>
					<?
					// echo '<pre>';
					// print_r($datatab['']);
					// echo '</pre>';
					?>
					<div class="box-content" style="background:#fff">
						<div class="row-fluid">
							<div class="span7">
<legend>Rekapitulasi Tabungan</legend>
<div class="box-content" style="margin-top:1px !important;padding-top:1px !important;">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#info">Tab. Kelas</a></li>
		<li><a href="#custom">Tab. Siswa</a></li>
		<li><a href="#rekap">Rekap Tanggal</a></li>
		<li><a href="#rekapbulan">Rekap Bulan</a></li>
		<li><a href="#tariktab">Penarikan</a></li>
	</ul>
	 
	<div id="myTabContent" class="tab-content">
		<div class="tab-pane active" id="info">
			<select id="rekapperkelas" style="float:left">
				<option value="0">Keseluruhan</option>
				<option value="1">Per Tanggal</option>
			</select>
			<input readonly type="text" name="tgl_transaksi" class="span2" id="rekap_tgl_transaksi" style="float:left;display:none" value="<?=date('Y-m-d')?>">
			<div id="datarekap">
				
				<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
					<thead>
						<tr>
							<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">No</th>
							<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Kelas</th>
							<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Wali Kelas</th>
							<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Tahun Ajaran</th>
							<th colspan="3" style="text-align:center;padding:2px;vertical-align:middle">Jumlah</th>
							<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Terakhir Setor</th>
						</tr>
						<tr>
							<th style="text-align:center;padding:2px;vertical-align:middle">Tabungan Harian</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Tabungan Tak Lain</th>
							<th style="text-align:center;padding:2px;vertical-align:middle">Infaq</th>
						</tr>
					</thead>
					<tbody>
						
					<?
					$kelas=$this->db->query('SELECT * FROM  `t_pembagian` where status="t" order by tahun_ajaran desc, nama_kelas asc');
					$dt['kelas']=$kelas;
					$j_totalharian=$j_totallain=$j_infaq=0;
					foreach ($kelas->result() as $k => $v) 
					{
						$idx=$v->id.'__'.$v->nama_kelas;
						$totalharian=$totallain=$infaq=0;
						$lastupdate='';
						if(isset($datatab[$idx]))
						{
							if(isset($jumlah[$idx]['harian']))
$totalharian=array_sum($jumlah[$idx]['harian']);

							if(isset($jumlah[$idx]['tablain']))
$totallain=array_sum($jumlah[$idx]['tablain']);

							if(isset($jumlah[$idx]['infaq']))
$infaq=array_sum($jumlah[$idx]['infaq']);
							// else

							$lastupdate=$dd[$idx]->last_update;
						}
						$j_totalharian += $totalharian;
						$j_totallain += $totallain;
						$j_infaq += $infaq;
						echo '<tr style="cursor:pointer;">
							<td style="text-align:center">'.($k+1).'</td>
							<td>'.str_replace('_', '<br>', $v->nama_kelas).'</td>
							<td>'.$v->walikelas.'</td>
							<td style="width:60px;text-align:center">'.$v->tahun_ajaran.'</td>
							<td style="text-align:right;" onclick="detailtab(\''.$v->id.'__'.str_replace(' ', '%20', $v->nama_kelas).'\',\'harian\',0)">'.number_format($totalharian).'</td>
							<td style="text-align:right;" onclick="detailtab(\''.$v->id.'__'.str_replace(' ', '%20', $v->nama_kelas).'\',\'tablain\',0)">'.number_format($totallain).'</td>
							<td style="text-align:right;" onclick="detailtab(\''.$v->id.'__'.str_replace(' ', '%20', $v->nama_kelas).'\',\'infaq\',0)">'.number_format($infaq).'</td>
							<td style="text-align:center;">'.tgl_indo_time($lastupdate).'</td>
						</tr>';
					}
					?>
					</tbody>
					<thead>
						<tr>
							<th colspan="4" style="text-align: right;">T O T A L</th>
							<th colspan="" style="text-align: right;"><?=number_format($j_totalharian)?></th>
							<th colspan="" style="text-align: right;"><?=number_format($j_totallain)?></th>
							<th colspan="" style="text-align: right;"><?=number_format($j_infaq)?></th>
							<th colspan="" style="text-align: right;"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class="tab-pane" id="custom" style="min-height:400px !important">
			<form class="form-horizontal" action="<?=site_url()?>tabungan/prosestabungan" method="post">
				<div class="span12">
					<div class="control-group" style="margin-top:0px;margin-bottom:3px;">
					  <label class="control-label" for="typeahead">Nama Siswa</label>
					  <div class="controls">
						<select name="siswa" id="siswa" data-rel="chosen">
							<option value="0">-Pilih Siswa-</option>
							<?
							$sis=$this->db->from('t_pembagian_siswa')->where('status','t')->order_by('nama_siswa','asc')->get();
							foreach ($sis->result() as $k => $v) 
							{
// list($kls,$nama)=explode('_', $v->nama_kelas);
$kel=$this->db->query('select * from t_pembagian where id="'.$v->id_pembagian.'"');
list($idp,$namak)=explode('_', $kel->row('nama_kelas'));
echo '<option value="'.$v->id_pembagian.'__'.str_replace(' ', '%20', $v->id_siswa).'">'.$v->id_siswa.' - '.$v->nama_siswa.' ('.$namak.')</option>';
							}
							?>
						</select>
					  </div>
					</div>
					<div id="tabsiswa"></div>
				</div>
			</form>
		</div>
		<div class="tab-pane" id="rekap" style="min-height:400px !important">
			<div style="float:right;width:95%">
				<input class="span2" type="text" id="tgll" name="tgl" style="float:left;" readonly value="<?=date('Y-m-d')?>">
			</div>
			<div id="grafik" style="width:90%;float:left"></div>
		</div>
		<div class="tab-pane" id="rekapbulan" style="min-height:400px !important">
			<div style="float:right;width:95%;text-align:right;">
			<?=combobln(1, 12, 'bulan',date('n'), 'onChange="grafikbulan()"')?>	
			<?=combotahun((date('Y')-5), date('Y'), 'tahun',date('Y'), 'onChange="grafikbulan()"')?>	
			</div>
			<div id="grafikbulan" style="width:90%;float:left"></div>
		</div>
		<div class="tab-pane" id="tariktab" style="min-height:400px !important">
			<div style="float:right;width:95%">
				<input class="span2" type="text" id="tglll" name="tgl" style="float:left;" readonly value="<?=date('Y-m-d')?>">
			</div>
			<div id="" style="width:90%;float:left"><?=$this->load->view('tabungan/form-penarikan')?></div>
			
		</div>
	</div>
</div>

							</div>
							<div class="span5" id="formtabungan">
<?=$this->load->view('tabungan/form',$dt)?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
	</div>
	<style type="text/css">
		.table th,.table td
		{
			font-size: 10px !important;
			
		}
		.table td
		{
			line-height: 12px !important;
		}
		#siswa_chzn,
		.chzn-drop, 
		.chzn-search,
		.chzn-search, 
		.chzn-result
		{
			width:400px !important;
		}
	</style>
<script type="text/javascript">
	$(document).keypress(function(e){
// alert(e.which);

		if(e.which==100)
		{
			$('i#icon-hapus').each(function(ii){
				$(this).css({'display':'inline'});
			});	
		}
	});

	function edittab(idd,idtab)
	{
		//alert(idd+'--'+idtab);
		$('#ModalTabungan').modal();
		$('#bodyform').load('<?=site_url()?>tabungan/formedit/'+idd+'/'+idtab,function(){
			$('input#tgl_transaksi').datepicker({
				  changeMonth: true,
				  changeYear: true,
				  dateFormat : 'yy-mm-dd',
				  showOn: "button",
					buttonImage: "<?=base_url()?>media/img/calendar146.png"
				});
		});
	}
	function hapustab(idd,idtab)
	{
		//alert(idd+'--'+idtab);
		// $('#ModalTabungan').modal();
		// $('#bodyform').load('<?=site_url()?>tabungan/formedit/'+idd+'/'+idtab,function());
		var c=confirm('Yakin ingin menghapus data ini ??');
		if(c)
		{
			// location.href='<?=site_url()?>tabungan/hapussatu/'+idd+'-'+idtab;
			$.ajax({
				url : '<?=site_url()?>tabungan/hapussatu/'+idd+'-'+idtab,
				success : function (a)
				{
					var id=$('#siswa').val();
					$('#tabsiswa').load('<?=site_url()?>tabungan/tabungansiswa/'+id);
					$("#myModal").modal("show");
					$('#isiModal').html(a);
				}
			});
		}
	}

	function cektabungan(val)
	{
		var nis=$('#nama_siswa').val();
		$.ajax({
			url : '<?=site_url()?>tabungan/cekdatatabungan/'+nis,
			success : function(a)
			{
				a = parseFloat(a);
				val = parseFloat(val.replace(/,/g, ''));
				if(val > a)
				{
					alert('Jumlah Penarikan Melebihi Saldo');
					$('#jumlah').val('');
				}
			}
		});
	}
	function printkwitansi()
	{
		//($nis,$idtabungan,$jumlah,$tgl)
		var tgl=$('#tglll').val();
		var penarik=$('#penarik').val();
		var keterangan=$('#keterangan').val();
		var jumlah=$('#jumlah').val();
		var petugas_tarik=$('#petugas_tarik').val();
		var jenistabungantarik=$('#jenistabungantarik').val();
		jumlah = jumlah.replace(/,/g,'');
		var nama_siswa=$('#nama_siswa_tarik').val();
		var xmlhttp = new XMLHttpRequest();
			var originalContents = document.body.innerHTML;
			xmlhttp.open('POST', "<?=site_url()?>topdf/penarikantabungan/"+nama_siswa+'/'+jumlah+'/'+tgl, false);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send('keterangan='+keterangan+'&penarik='+penarik+'&petugas='+petugas_tarik+'&jenistarik='+jenistabungantarik);
			if(xmlhttp.status == 200) {
				document.body.innerHTML = xmlhttp.responseText;
				window.print();
				document.body.innerHTML = originalContents;

			}
	}
	function grafikbulan()
	{
		var bln=$('#bulan').val();
		var thn=$('#tahun').val();
		$('#grafikbulan').load('<?=site_url()?>tabungan/rekap/'+bln+'-'+thn+'/bulanan');
	}
	$(document).ready(function(){
		grafikbulan();
		$('button#simpantarikan').click(function(){
			var sis=$('#nama_siswa_tarik').val();
			var jns=$('#jenistabungantarik').val();
			if(sis==0)
			{
				alert('Nama Siswa Belum Dipilih');
			}
			else if(jns==0)
			{
				alert('Jenis Penarikan Tabungan Belum Dipilih');
			}
			else
			{
				var c=confirm("Apakah Data Penarikan ini sudah Benar ?");
				if(c)
				{
					var tgl=$('#tglll').val();
					$.ajax({
						url : '<?=site_url()?>tabungan/simpanpenarikan/'+tgl,
						type : 'POST',
						data : $('form#simpanpenarikan').serialize(),
						success : function(a)
						{
							printkwitansi();
						}
					});
				}
			}
		});

		$('#jumlah').keyup(function(){
			$(this).formatCurrency({ symbol:'' });
		});
		$('#grafik').load('<?=site_url()?>tabungan/rekap');
		$('#rekapperkelas').change(function(){
			var id=$(this).val();
			if(id==1)
			{
				var tt=$('#rekap_tgl_transaksi').val();
				$('#datarekap').load('<?=site_url()?>tabungan/datarekap/'+tt);
				$('#rekap_tgl_transaksi').css({'display':'inline'});
				$( "#rekap_tgl_transaksi" ).datepicker('enable');
				$( "#rekap_tgl_transaksi" ).datepicker({
						showOn: "button",
						buttonImage: "<?=base_url()?>media/img/calendar146.png",
						buttonImageOnly: true,
						dateFormat:'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
						onClose: function( selectedDate ) 
						{
							$('#datarekap').load('<?=site_url()?>tabungan/datarekap/'+selectedDate);
				    	}
				});
			}
			else if(id==0)
			{
				$('#datarekap').load('<?=site_url()?>tabungan/datarekap/0');
				$('#rekap_tgl_transaksi').css({'display':'none'});
				$( "#rekap_tgl_transaksi" ).datepicker('destroy');
			}
		});
		$( "#tgll" ).datepicker({
				showOn: "button",
				buttonImage: "<?=base_url()?>media/img/calendar146.png",
				buttonImageOnly: true,
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				onClose: function( selectedDate ) 
				{
		        	$('#grafik').load('<?=site_url()?>tabungan/rekap/'+selectedDate);
		    	}
		});
		$( "#tglll" ).datepicker({
				showOn: "button",
				buttonImage: "<?=base_url()?>media/img/calendar146.png",
				buttonImageOnly: true,
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				onClose: function( selectedDate ) 
				{
		        	// $('#grafik').load('<?=site_url()?>tabungan/rekap/'+selectedDate);
		    	}
		});

		$('#siswa').change(function(){
			var id=$(this).val();
			$('#tabsiswa').load('<?=site_url()?>tabungan/tabungansiswa/'+id);
		});
		$( "#tgll" ).datepicker({
				showOn: "button",
				buttonImage: "<?=base_url()?>media/img/calendar146.png",
				buttonImageOnly: true,
				dateFormat:'dd-mm-yy',
				changeMonth: true,
				changeYear: true,
				onClose: function( selectedDate ) 
				{
		        	// $('#grafik').load('<?=site_url()?>penerimaan/penerimaanharian/'+selectedDate);
		    	}
		});


		$('a#simpantabungan').on('click',function(){
			// $('#simpanedittabungan').submit();
			var action = $('#simpanedittabungan').attr('action');
			$.ajax({
				url : action,
				type : 'POST',
				data : $('#simpanedittabungan').serialize(),
				success : function (a)
				{
					location.href='<?=site_url()?>tabungan';
				}
			});
		});

	});

	function detailtab(id,jenis,tgl)
	{
		$('#myModal').modal('show');
		$('.modal-header h3').text('Detail Tabungan');
		$('.modal-body h3').load('<?=site_url()?>tabungan/detailtabungan/'+id+'/'+jenis+'/'+tgl);
	}
	function hapusatu(idd,idtab,tanggal,jns,id_kelas)
	{
		$.ajax({
			url : '<?=site_url()?>tabungan/hapussatu',
			data : {id_d : idd, id_tab:idtab, tgl_transaksi:tanggal,jenis:jns,idkelas:id_kelas},
			type : 'POST',
			success : function(a)
			{
			// alert(a);
				$('.modal-body h3').load('<?=site_url()?>tabungan/detailtabungan/'+id_kelas+'/'+jns+'/'+tanggal);
				$('#grafik').load(tanggal);
				$('#datarekap').load('<?=site_url()?>tabungan/datarekap/'+tanggal);
				// $('.modal-body h3').load('<?=site_url()?>tabungan/detailtabungan/'+id_kelas+'/'+jns+'/'+tanggal);
				// $('#grafik').load('<?=site_url()?>tabungan/rekap/'+tanggal);
				// $('#datarekap').load('<?=site_url()?>tabungan/datarekap/'+tanggal);
				// $('#myModal').on('hidden', function(){
				//     $(this).remove();
				// });
				// $('this').remove();
				// detailtab(id_kelas,jns/,tanggal);
			}
		});
	}
</script>
<style type="text/css">
	.modal-body {
	    position: relative;
	    overflow-y: auto;
	    max-height: 500px !important;
	    padding: 5px;
	    /*width: 95% !important;*/
	}
	#myModal
	{
	    /*max-height: 500px !important;*/
		/*width:50% !important;*/
		/*left:20% !important;*/
		top:35% !important;
		overflow-y:auto;
	}
</style>

<div class="modal hide fade" id="ModalTabungan" >
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Form Tabungan</h3>
	</div>
	<div class="modal-body">
		<div id="bodyform"></div>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-dismiss="modal">Tidak</a>
		<a href="#" class="btn btn-primary" data-dismiss="modal" id="simpantabungan">Simpan</a>
	</div>
</div>