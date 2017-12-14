<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Tambah Transaksi Penerimaan</a>
			</li>
		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Tambah Transaksi Penerimaan</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
				<?
				$attr=array('id'=>'myForm');
				echo form_open('penerimaan/simpantransaksi',$attr);
				?>	
					<div class="box-content" style="background:#fff">
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
						<div style="width:100%;text-align:left">
							<div style="float:left;">
								Tanggal : 
							</div>
							<input readonly type="text" name="tgl_transaksi" class="span2" id="tgl_transaksi" style="float:left;margin-left:10px;"></div>
							<div style="width:100%;text-align:center;float:left">
								<h4>
									Transaksi Penerimaan
									<br>
									Sekolah Islam Ibnu Hajar
								</h4>	
									<div class="row-fluid" style="text-align:left !important;margin-top:10px;">
										<div class="span4">&nbsp;</div>
										<div class="span2" style="width:100px;">Nama Siswa</div>
										<div class="span1" style="width:10px;">:</div>
										<div class="span4">
										<?
										$l=array();
										//$siswa=$this->sm->getSiswa($l,'null');
										$siswa=$this->sm->getSiswaAktifKelasAktif('t');
										?>
											<select data-rel="chosen" name="siswa" id="siswa" data-placeholder="Pilih Nama Siswa">
												<option value="" selected></option>
												<?
												foreach($siswa->result() as $s)
												{
													echo '<option value="'.$s->nis.'">'.$s->nama.'</option>';
												}
												?>
											</select>
										</div>
									</div>
							<div class="row-fluid" style="text-align:left !important;margin-top:10px;" id="">
								<div class="row-fluid" style="text-align:left !important;">
								<div class="span4">&nbsp;</div>
								<div class="span2" style="width:100px;">Kelas</div>
								<div class="span1" style="width:10px;">:</div>
								<div class="span4" id="">
									<select data-rel="chosen" name="datakelas" id="datakelas" data-placeholder="Pilih Data Kelas">
										<option value="" selected></option>
									</select>
								</div>
							</div>
							<div class="row-fluid" style="text-align:left !important;">
								<div class="span4">&nbsp;</div>
								<div class="span2" style="width:100px;">Penyetor</div>
								<div class="span1" style="width:10px;">:</div>
								<div class="span4" >
									<input type="text" name="penyetor" id="penyetor" style="width:100%">
								</div>
							</div>
							<div id="trans">
							<?
							$bayar=$ket='';
							if($jenis=='tahunan')
							{
							?>
							<table class="table table-striped table-bordered bootstrap-datatable" style="width:50%;float:left;">
								<thead>
									<tr>
										<th style="text-align:center;" colspan="2"><?=$pen['lain'][0]->jenis?></th>
									</tr>
								</thead>
								<tbody>
								<?
									$utab=$pen[$pen['lain'][0]->id];
									$tb='';
									foreach($utab as $ut)
									{

										if($ut->jenis=='SPP')
										{
											$tb='<select data-rel="chosen" data-placeholder="Bulan" name="bulanspp['.$pen['lain'][0]->id.']['.$ut->id.']" style="width:100px;padding:2px;margin:0px;">';
											$tb.='<option selected value=""></option>';
											for($ii=1;$ii<=12;$ii++)
											{
												if($ii==7)
													$tb.='<option selected value="'.$ii.'">'.getBulan($ii).'</option>';
												else	
													$tb.='<option value="'.$ii.'">'.getBulan($ii).'</option>';
											}
											$tb.='</select>';
										}
										else if(strtolower($ut->jenis)=='seragam')
										{
											$tb='<select data-rel="chosen" data-placeholder="Seragam" name="bulanspp['.$pen['lain'][1]->id.']['.$ut->id.']" style="width:100px;padding:2px;margin:0px;">';
											$tb.='<option selected value=""></option>';
											$tb.='<option value="olahraga">Seragam Olahraga</option>';
											$tb.='<option value="biasa">Seragam Biasa</option>';
											
											$tb.='</select>';
										}
										else
											$tb='';

										echo '<tr>
											<td style="width:60%">'.$ut->jenis.' '.$tb.'</td>
											<td style="width:40%">
												<input type="text" name="transaksi['.$pen['lain'][0]->id.']['.$ut->id.']" style="width:100%;margin:0px;padding:3px;text-align:right;border:0px;border-bottom:1px dotted #888;font-size:11px;" placeholder="Rp." id="transaksi_'.$pen['lain'][0]->id.'" onkeyup="hitung(\''.$pen['lain'][0]->id.'\')" value="0">
											</td>
										</tr>';
									}
								?>
								</tbody>
							</table>
							<table class="table table-striped table-bordered bootstrap-datatable" style="width:50%;float:left;">
								<thead>
									<tr>
										<th style="text-align:center;" colspan="2"><?=$pen['lain'][1]->jenis?></th>
									</tr>
								</thead>
								<tbody>
								<?
									$pptab=$pen[$pen['lain'][1]->id];
									$tb='';
									foreach($pptab as $ut)
									{
										if($ut->jenis=='SPP')
										{
											$tb='<select data-rel="chosen" data-placeholder="Bulan" name="bulanspp['.$pen['lain'][1]->id.']['.$ut->id.']" style="width:100px;padding:2px;margin:0px;">';
											$tb.='<option selected value=""></option>';
											for($ii=1;$ii<=12;$ii++)
											{
												if($ii==7)
													$tb.='<option selected value="'.$ii.'">'.getBulan($ii).'</option>';
												else	
													$tb.='<option value="'.$ii.'">'.getBulan($ii).'</option>';
											}
											$tb.='</select>';
										}
										else if(strtolower($ut->jenis)=='seragam')
										{
											$tb='<select data-rel="chosen" data-placeholder="Seragam" name="bulanspp['.$pen['lain'][1]->id.']['.$ut->id.']" style="width:100px;padding:2px;margin:0px;">';
											$tb.='<option selected value=""></option>';
											$tb.='<option value="olahraga">Seragam Olahraga</option>';
											$tb.='<option value="biasa">Seragam Biasa</option>';
											
											$tb.='</select>';
										}
										else
											$tb='';
										echo '<tr>
											<td style="width:60%">'.$ut->jenis.' '.$tb.'</td>
											<td style="width:40%">
												<input type="text" name="transaksi['.$pen['lain'][1]->id.']['.$ut->id.']" style="width:100%;margin:0px;padding:3px;text-align:right;border:0px;border-bottom:1px dotted #888;font-size:11px;" placeholder="Rp." id="transaksi_'.$pen['lain'][1]->id.'" onkeyup="hitung(\''.$pen['lain'][1]->id.'\')" value="0">
											</td>
										</tr>';
									}
								?>
								</tbody>
							</table>
							<div style="width:100%;float:left;margin-top:-20px">
								<table class="table table-striped table-bordered bootstrap-datatable table-lain" style="width:50%;float:left;">
									<thead>
										<tr>
											<th style="text-align:right;font-weight:bold;width:60%">Jumlah <?=$pen['lain'][0]->jenis?></th>
											<th style="width:40%;text-align:right;font-weight:bold" id="jlh1">
											0
											</th>
										</tr>
										<tr>
											<td style="text-align:left;font-weight:bold;font-style:italic;" colspan="2">Terbilang : <br>
												<span id="terbilang"></span>
											</td>

											
										</tr>
									</thead>
									
								</table>
								<table class="table table-striped table-bordered bootstrap-datatable table-lain" style="width:50%;float:left;">
									<thead>
										<tr>
											<th style="text-align:right;font-weight:bold">Jumlah <?=$pen['lain'][1]->jenis?></th>
											<th style="width:40%;text-align:right;font-weight:bold;border-right:1px solid #ddd;" id="jlh2" >0</th>
											<input type="hidden" name="jumlah[3]" id="jlh1_3" value="0">
											<input type="hidden" name="jumlah[4]" id="jlh2_4"  value="0">
											<input type="hidden" name="jumlah['lain']" id="jlh3_lain"  value="0">
										</tr>
										<tr>
											
											
											<th style="text-align:right;font-weight:bold;font-size:17px;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">T O T A L</th>
											<th style="text-align:right;font-weight:bold;font-size:17px;border-bottom:1px solid #ddd;border-right:1px solid #ddd;" id="total">0</th>
										
											
										</tr>
									</thead>
									
								</table>
							</div>
							<?
							}
							else
							{
							?>

							<table class="table table-striped table-bordered bootstrap-datatable" style="width:70%;;margin:0 auto;">
								<thead>
									<tr>
										<th style="text-align:center;" >Keterangan</th>
										<th style="text-align:center;" >Kewajiban</th>
										<th style="text-align:center;" >Pembayaran</th>
									</tr>
									<tbody>
									<input type="hidden" name="namasiswa" id="namasiswa">
									<input type="hidden" name="idkelasaktif" id="idkelasaktif">
									<?
										$lain=$pen['lain'];
										$tb='';
										foreach($lain as $key=> $ut)
										{
											//if($ut->id!=3 && $ut->id!=4)
											//{

												if($ut->id==10 || $ut->id==12 || $ut->id==13)
												{
													$tb='<select data-rel="chosen" data-placeholder="Bulan" name="bulanspp[\'lain\']['.$ut->id.']"  style="width:150px;padding:2px;margin:0px;" onchange="getdataspp(this.value,\''.$ut->id.'\')">';
													$tb.='<option selected value=""></option>';
													for($ii=1;$ii<=12;$ii++)
													{
														if($ii==date('n'))
															$tb.='<option selected value="'.$ii.'">'.getBulan($ii).'</option>';
														else
															$tb.='<option value="'.$ii.'">'.getBulan($ii).'</option>';
													}
													$tb.='</select>';
													//$
												}
												else if(strtolower($ut->jenis)=='seragam')
												{
													$tb='<select data-rel="chosen" data-placeholder="Seragam" name="bulanspp[\'lain\']['.$ut->id.']" style="width:150px;padding:2px;margin:0px;">';
													$tb.='<option selected value=""></option>';
													$tb.='<option value="olahraga">Seragam Olahraga</option>';
													$tb.='<option value="biasa">Seragam Biasa</option>';
													
													$tb.='</select>';
												}
												else
													$tb='';

												$bayar.='jenis'.$key.'='.$ut->jenis.'&';
												echo '<input type="hidden" name="idjenis" id="idjenisdata" value="'.$ut->id.'">';
												echo '<tr>
													<td style="width:50%">
														<div style="width:35%;float:left;">
															'.$ut->jenis.'
														</div>
														<div style="width:65%;float:left">
															'.$tb.'
														</div>
													</td>
													<td style="width:25%;text-align:right"><span class="wajibb" id="wajib_'.$ut->id.'">0</span></td>
													<td style="width:25%">
														<input type="text" name="transaksi[\'lain\']['.$ut->id.']" style="width:100%;margin:0px;padding:3px;text-align:right;border:0px;border-bottom:1px dotted #888;font-size:11px;" placeholder="Rp." id="transaksi_lain" onkeyup="hitung(\'lain\')" value="0">
													</td>
												</tr>';
											//}
										}
									?>
									</tbody>
								</thead>
							</table>
							<div style="width:100%;float:left;">
								<table class="table table-striped table-bordered bootstrap-datatable" style="width:70%;margin:0 auto;">
									<thead>
										<input type="hidden" name="jumlah[3]" id="jlh1_3" value="0">
											<input type="hidden" name="jumlah[4]" id="jlh2_4"  value="0">
											<input type="hidden" name="jumlah['lain']" id="jlh3_lain"  value="0">
										<tr>
											<th style="text-align:right;font-weight:bold;width:50%">Jumlah</th>
											<th style="text-align:right;font-weight:bold;width:25%;padding-right:15px"><div id="jlhtagihan"></div></th>
											<th style="width:25%;text-align:right;font-weight:bold" id="jlh3">0</th>
										</tr>
										<tr>
											<th style="text-align:right;font-weight:bold;font-size:17px;" colspan="2">T O T A L</th>
											<th style="width:25%;text-align:right;font-weight:bold;font-size:17px;" id="total">0</th>
										</tr>
										<tr>
											<td style="text-align:right;font-weight:bold;font-style:italic;" colspan="3">
												<div style="width:40%;float:left;text-align:left">
													Catatan :<br>
													<textarea style="width:100%;height:40px;"></textarea>
												</div>
												<div style="width:55%;float:right;text-align:left;">
													Terbilang : 
													<span id="terbilang"></span>
												</div>
											</td>

											
										</tr>
									</thead>
									
								</table>
								
							</div>
							<?
							}
							?>
									</div>
							</div>
								<input type="hidden" id="idkelasaktif">
								<input type="hidden" id="jumlahtagihan">
								<!-----------------------Jumlah Penerimaan------------------>
								<div class="form-actions" style="width:96%;float:left;">
								  <button type="button" class="btn btn-primary" id="simpan">Simpan Transaksi</button>
								  <a type="reset" class="btn" id="reset">Cancel</a>
								  <a type="reset" class="btn btn-primary" id="reset" href="<?=site_url()?>penerimaan">Back</a>
								</div>
								
						</div>						     
					</div>
					<?=form_close()?>
				</div><!--/span-->
			
			</div>
</div>
<style type="text/css">
.table td
{
	padding:5px 15px;
}
.table-lain td
{
	border:0px;
	border-top:1px solid #ddd;
}
.table-lain
{
	border-bottom:0px;
	border-right:0px;
}
</style>
<script type="text/javascript">
function rapel(id,v)
{
	var ttt=0;
	$('span.wajibb').each(function(a){
		var tt=$(this).text();
		tt=parseFloat(tt.replace(/,/g,''));
		ttt = ttt + tt;
	});
	// alert(v);
	if($("#rapel_"+id).prop("checked"))
	{
		// alert('ok');
		$('#rapelbulan_'+id).css({'display':'inline'});
	}
	else
	{
		$('#rapelbulan_'+id).css({'display':'none'});
		$('#catatan').val('');
		$('#total_'+id).css({'display':'none'});
		$('#catatan').val('');
		$('#totalsemua').text(ttt)
		$('#totalsemua').formatCurrency({symbol:''})

		$('div.nilairapel_'+id).each(function(a){
			$(this).css({'display':'none'});
		});
		$('input.bayarrapel_'+id).each(function(a){
			$(this).prop('checked',false);
		});
		// alert('no');
	}
	// alert(c);
}
function bayarrapel(id,bl,th)
{
	// alert(id+'-'+bl+'-'+th);
	var cat=$('#catatanrapel').val();
	var ni=$('#wajib_'+id).text();
	if($("#bayarrapel_"+id+"_"+bl+"_"+th).prop("checked"))
	{
		// alert('ok');
		$('#nilairapel_'+id+'_'+bl+'_'+th).css({'display':'block'});
		cat += id +'_'+bl+'_'+th+';';
		$('#catatan').val('Pembayaran Rapel');
		$('#catatanrapel').val(cat);
	}
	else
	{
		$('#nilairapel_'+id+'_'+bl+'_'+th).css({'display':'none'});
		cat = cat.replace(id +'_'+bl+'_'+th+';','');
		$('#catatanrapel').val(cat);
		// alert('no');
	}

	var ttt=0;
	$('span.wajibb').each(function(a){
		var tt=$(this).text();
		tt=parseFloat(tt.replace(/,/g,''));
		ttt = ttt + tt;
	});
	
	if($('input.bayarrapel_'+id+':checked').length>0)
	{
		
		ni = parseFloat(ni.replace(/,/g,''));
		var tot=(($('input.bayarrapel_'+id+':checked').length) * ni) + ni;
		
		$('#total_'+id).css({'display':'block'});
		$('#totot_'+id).text(tot);
		$('#totot_'+id).formatCurrency({ symbol:'' });

		var ts;
		// ts = parseFloat(ts.replace(/,/g,''));
		ts = ttt + tot - ni;
		$('#totalsemua').text(ts)
		$('#totalsemua').formatCurrency({symbol:''})
		// $('#jlh1').formatCurrency({ symbol:'' });
	}
	else
	{
		$('#total_'+id).css({'display':'none'});
		$('#catatan').val('');
		$('#catatanrapel').val('');
		$('#totalsemua').text(ttt)
		$('#totalsemua').formatCurrency({symbol:''})
	}
}

$(document).ready(function(){
	$('#tgl_transaksi').datepicker({
			  changeMonth: true,
			  changeYear: true,
			  dateFormat : 'yy-mm-dd',
			  showOn: "button",
			buttonImage: "<?=base_url()?>media/img/calendar146.png"
			});
	$('#simpan').click(function(){
		var siswa=$('#siswa').val();
		var datakelas=$("#datakelas").val();
		var tgl=$("#tgl_transaksi").val();

		if(tgl=='')
		{
			$('#myModal').modal('show');
			$('#isiModal').html('Tanggal Transaksi Tidak Boleh Kosong');
			$("#tgl_transaksi").focus();
		}
		else if(siswa=='')
		{
			$('#myModal').modal('show');
			$('#isiModal').html('Nama Siswa Belum Dipilih');
		}
		else if(datakelas=='')
		{
			$('#myModal').modal('show');
			$('#isiModal').html('Data Kelas Belum Dipilih');
		}
		else
		{
			$('#myModalConfirm').modal('show');
			$('#isiModalConfirm').html('Apakah Data Transaksi ini sudah Benar ??');
		}
	});

	$('#Yes').click(function(){
		var tot=$('#total').text();
		var penyetor=$('#penyetor').val();
		var datakelas=$('#datakelasbaru').val();
		// var datakelas=$('#datakelas').val();
		var catatan=$('#catatan').val();
		var siswa=$('#siswa').val();
		var catatanrapel=$('#catatanrapel').val();
		var s='idsiswa='+siswa+'&idkelas='+datakelas+'&penyetor='+penyetor+'&total='+tot+'&catatan='+catatan+'&catatanrapel='+catatanrapel;
		if(tot=='0')
		{
			$('#myModal').modal('show');
			$('#isiModal').html('Data Transaksi Belum Dimasukan');
		}
		else
		{
			$('#myForm').submit();
			
			$('input#idjj').each(function(i){
				var ii=$(this).val();
				var vv=$('input.transaksi_'+ii).val();
				var tgl_transaksi=$('#tgl_transaksi').val();
				var kt=$('#ket_'+ii).val();
				s+='&jenis_'+ii+'='+vv+'&ket_'+ii+'='+kt+'&tgl_transaksi='+tgl_transaksi;
			});
			$('input#idjjclub').each(function(i){
				var ii=($(this).val()).split('_');
				var idjenis=ii[0];
				var idclub=ii[1];
				var kt=$('#ketclub_'+idjenis+'_'+idclub).val();
				var vv=$('input.transaksi_'+idjenis+'_'+idclub).val();
				s+='&jenisclub_'+idclub+'='+vv+'&ketclub_'+idclub+'='+kt;
			});
			//alert(s);
			var xmlhttp = new XMLHttpRequest();
			var originalContents = document.body.innerHTML;
			xmlhttp.open('POST', "<?=site_url()?>topdf/kwitansi", false);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send(s);
			if(xmlhttp.status == 200) {
				document.body.innerHTML = xmlhttp.responseText;
				window.print();
				document.body.innerHTML = originalContents;

			}
		}
		//alert(tot);
	});

	$('#reset').click(function(){
		$('#jlh1').text('0');
		$('#jlh2').text('0');
		$('#jlh3').text('0');
		$('#total').text('0');
		$('#terbilang').text('');
	});

	$('#datakelas').change(function(){
		var id=$(this).val();
		//var d=new Date();
		var siswa=$('#siswa').val();
		var bulan='<?=date('n')?>';
		$('#trans').load('<?=site_url()?>penerimaan/getTransaksi/'+str_replace(' ','%20',siswa)+'/'+id);
	});
	$('#siswa').change(function(){
		var idsiswa=id=$(this).val();
		//var d=new Date();
		var bulan='<?=date('n')?>';
		// $('#trans').load('<?=site_url()?>penerimaan/getTransaksi/'+str_replace(' ','%20',a.nis)+'/'+idkelasaktif);
		//alert(id);
		$.ajax({
			url : '<?=site_url()?>siswa/getSiswaByIdJSON/'+id,
			type : 'POST',
			dataType : 'JSON',
			success:function(a)
			{
				//alert(a.nama);
				var n_ayah=a.nama_ayah;
				var n_ibu=a.nama_ibu;
				$('#datakelas')
			    .find('option')
			    .remove()
			    .end()
			    .append('<option value="" selected=""></option>')
			    .val('');
				$("#datakelas").trigger("liszt:updated");
				//alert(a.nis);
				$('#penyetor').val(n_ayah+' ; '+n_ibu);
				$.ajax({
					url : '<?=site_url()?>kelas/getKelasByNISJSON/'+a.nis,
					type : 'POST',
					dataType : 'JSON',
					success : function(b)
					{
						//alert(b.length);
						//alert(b);
						var toAppend = '';
						var idkelasaktif;
						var idjenis;
				        $.each(b,function(i,o){
				        	//alert(o.id);
				           	//$('#').val();


				           	toAppend += '<option '+(o.st_aktif=='t' ? 'selected' : '')+' value="'+o.id+'">'+o.namakelas+'-'+o.namakelasaktif+'</option>';
				        	//toAppend += o.namakelas;
				        	idkelasaktif=o.id;
				        	$('#idkelasaktif').val(o.id);
				        });

		// 		        //$('#idkelasaktif').val(idkelasaktif);
		// 		        //alert(toAppend);
				        $('#datakelas').append(toAppend);
				        $("#datakelas").trigger("liszt:updated");
				        $('#trans').load('<?=site_url()?>penerimaan/getTransaksi/'+str_replace(' ','%20',idsiswa)+'/'+idkelasaktif);
		// 		        var jlhtagihan=0;
		// 		        // $('input#idjenisdata').each(function(aa){
		// 		        // 	var idi=$(this).val();
		// 		        // 	$('#wajib_'+idi).text(0);
		// 		        // 	//alert(idkelasaktif);
		// 		        // 	$.ajax({
		// 		        // 		url : '<?=site_url()?>penerimaan/getDataKewajiban/'+a.nis+'/'+idkelasaktif+'/'+idi+'/'+bulan,
		// 		        // 		type : 'POST',
		// 		        // 		dataType : 'JSON',
		// 		        // 		success : function(js)
		// 		        // 		{
		// 		        // 			//alert(js.sisa+' - '+idi);
		// 		        // 			$('#wajib_'+idi).text(js.sisa);
		// 		        // 			$('#wajib_'+idi).formatCurrency({ symbol:'' });
		// 		        // 			jlhtagihan+= parseFloat(js.sisa);
		// 		        // 			$('#jumlahtagihan').val(jlhtagihan);
		// 		        // 			$('#jlhtagihan').text(jlhtagihan);
		// 		        // 			$('#jlhtagihan').formatCurrency({ symbol:'' });
		// 		        // 			//toAp = '<option selected="selected" value="'+js.bulan+'">'+o.namakelas+'-'+o.namakelasaktif+'</option>';
		// 		        // 		}
		// 		        // 	});

		// 		        // });

		// 		        $('#trans').load('<?=site_url()?>penerimaan/getTransaksi/'+str_replace(' ','%20',a.nis)+'/'+idkelasaktif);

					}
				});
			}
		});
	});
});

function hitung(id)
{
	//alert(id);
	var jlh=0;
	$('input#transaksi_'+id).each(function(a){
		$(this).formatCurrency({ symbol:'' });
		$(this).blur(function(){
			if($(this).val()=='')
				$(this).val(0);
		});

		var j=parseFloat(parseInt(str_replace(',','',$(this).val())));
		jlh+=j;
	});
	
	if(id==3)
	{
		$('#jlh1').text(jlh);
		$('#jlh1').formatCurrency({ symbol:'' });
		$('#jlh1_3').val(jlh);
	}
	else if(id==4)
	{	
		$('#jlh2').text(jlh);	
		$('#jlh2').formatCurrency({ symbol:'' });
		$('#jlh2_4').val(jlh);
	}
	else if(id=='lain')
	{	
		$('#jlh3').text(jlh);
		$('#jlh3').formatCurrency({ symbol:'' });
		$('#jlh3_lain').val(jlh);
	}

	var j1=parseFloat($('#jlh1_3').val());
	var j2=parseFloat($('#jlh2_4').val());
	var j3=parseFloat($('#jlh3_lain').val());
	//var total=j1+j2+j3;
	$('#total').text(jlh);
	$('#total').formatCurrency({ symbol:'' });
	$('#terbilang').text(terbilang(jlh));
}

function getdataspp(bln,id)
{
	//alert(bln+'-'+id);
	//bulan=bln,
	//idjenis=id,
	var nis=$('#siswa').val();
	var jlhtagihan=parseFloat($('#jumlahtagihan').val());
	var tagihanid=parseFloat(str_replace(',','',$('#wajib_'+id).text()));


	//alert(tagihanid);
	var idkelasaktif=$('#idkelasaktif').val();
	$.ajax({
		url : '<?=site_url()?>penerimaan/getDataPenerimaanRutin/'+bln+'/'+id+'/'+nis+'/'+idkelasaktif,
		type : 'POST',
		dataType : 'JSON',
		success : function(a)
		{
			//$('#wajib_'+id).text(0);

			if(a.sisa_bayar.length!=0)
			{
				var jjh=jlhtagihan-tagihanid+parseFloat(a.sisa_bayar);
				
				if(bln==7)
				{
					var utab=parseInt(str_replace(',','',$('#wajib_3').text()));
					var pptab=parseInt(str_replace(',','',$('#wajib_4').text()));
					//alert(utab+'-'+pptab);
					if(utab!=0)
					{
						var hh=utab-a.sisa_bayar;
						$('#wajib_3').text(hh);
						$('#wajib_3').formatCurrency({ symbol:'' });
						var jjh=jlhtagihan-tagihanid;
					}

					if(pptab!=0)
					{
						var hh=pptab-a.sisa_bayar;
						$('#wajib_4').text(hh);
						$('#wajib_4').formatCurrency({ symbol:'' });
						var jjh=jlhtagihan-tagihanid;
					}
				}

				$('#jumlahtagihan').val(jjh);
				$('#jlhtagihan').text(jjh);
				$('#jlhtagihan').formatCurrency({ symbol:'' });

				$('#wajib_'+id).text(a.sisa_bayar);
				$('#wajib_'+id).formatCurrency({ symbol:'' });

			}
			
				//alert(0);
			
			//alert(a.bulan);
		},
		error : function(b)
		{
			$('#wajib_'+id).text(0);
			var jjh=jlhtagihan-tagihanid+parseFloat(0);
				
			$('#jumlahtagihan').val(jjh);
			$('#jlhtagihan').text(jjh);
			$('#jlhtagihan').formatCurrency({ symbol:'' });

			$('#wajib_'+id).text(a.sisa_bayar);
			$('#wajib_'+id).formatCurrency({ symbol:'' });
		}
	});

	//alert(nis+'-'+idkelasaktif)
}

</script>
