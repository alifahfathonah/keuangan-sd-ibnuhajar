<?
$url='http://localhost/kehalutuju/laundry/index.php/webservice/datapengajuan/f';
$str= getDataCurl($url);
$laundry=json_decode($str);
$d_laundry=[];
foreach ($laundry as $k => $v) 
{
	$d_laundry[$v->id][]=$v;
}
// echo '<pre>';
// print_r($d_laundry);
// echo '</pre>';
?>
<table class="table table-striped table-bordered bootstrap-datatable">
	<thead>
		<tr>
			<th style="text-align:center;">No</th>
			<th style="text-align:center;">Tanggal</th>
			<th style="text-align:center;">No Kwitansi</th>
			<th style="text-align:left;">Keterangan</th>
			<th style="text-align:left;">Pengajuan dari</th>
			<th style="text-align:right;">Jumlah</th>
			<th  style="text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?
		$no=1;
		foreach ($d_laundry as $k => $v) 
		{
			echo '<tr>';
			echo '<td style="text-align:center;">'.$no.'</td>';
			echo '<td style="text-align:center;">'.tgl_indo2($v[0]->tanggal).'</td>';
			echo '<td style="text-align:center;">'.($v[0]->no_kwitansi).'</td>';
			echo '<td style="text-align:left;">'.($v[0]->keterangan).'</td>';
			echo '<td style="text-align:left;">Laundry</td>';
			echo '<td style="text-align:right;">'.number_format($v[0]->jumlah).'</td>';
			echo '<td style="text-align:center">
				<i class="icon-ok icon-color icon-blue" style="cursor:pointer" onclick="setujuipengajuan(\''.$v[0]->id.'\',\'laundry\')"></i>  	                                            
				<i class="icon-search icon-color icon" style="cursor:pointer" onclick="detailpengajuan(\''.$v[0]->id.'\',\'laundry\')"></i>  	                                            
			</td>';
			echo '</tr>';
			$no++;
		}
	?>
	</tbody>
</table>
<script type="text/javascript">
jQuery(function($){
	$('#disetujui').keyup(function(){
		$(this).formatCurrency({ symbol:'' });
	});
});
	function setujuipengajuan(id,jenis)
	{
		// $('#formpengajuan').load('<?=site_url()?>pengeluaran/pangajuanform/'+id);
		if(jenis=='laundry')
		{

			$.ajax({
				url : '<?=site_url()?>pengeluaran/pengajuanform/'+id+'/'+jenis,
				data : {source : '<?=$str?>'},
				type : 'POST',
				success : function (a)
				{
					$('#formpengajuan').html(a);
				}					
			});
		}
	}

	function detailpengajuan(id,jenis)
	{
		if(jenis=='laundry')
		{

			$.ajax({
				url : '<?=site_url()?>pengeluaran/pengajuandetail/'+id+'/'+jenis,
				data : {source : '<?=$str?>'},
				type : 'POST',
				success : function (a)
				{
					// $('#formpengajuan').html(a);
					$("#myModal").modal("show");
					$('#modal-body').html(a);
					$('.modal-header h3').text('Detail Pengajuan');
					$('#myModal').css({'width':'1000px','top':'35%','left':'35%','outline':'none'});
				}					
			});
		}
	}

	
</script>