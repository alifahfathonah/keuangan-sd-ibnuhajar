<table class="table table-striped table-bordered bootstrap-datatable">
	<thead>
		<tr>
			<th style="text-align:center;">No</th>
			<th style="text-align:center;">Tanggal</th>
			<th style="text-align:center;">Kode</th>
			<th style="text-align:center;">No Kwitansi</th>
			<th style="text-align:left;">Keterangan</th>
			<th style="text-align:right;">Jumlah</th>
			<th  style="text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?
	$no=1;
	foreach ($d->result() as $k => $v) 
	{
	?>
		<tr>
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:center"><?=tgl_indo2($v->tgl_transaksi);?></td>
			<td style="text-align:left"></td>
			<td style="text-align:center"><?=($v->no_kwitansi);?></td>
			<td style="text-align:left"><?=($v->ket);?></td>
			<td style="text-align:right"><?=number_format($v->jumlah);?></td>
			<td style="text-align:center">
				<i class="icon-check icon" onclick="verifikasipengeluaran(<?=$v->id_trans?>)"></i>  	                                            
				<i class="icon-trash icon-color icon" onclick="hapustransaksi(<?=$v->id_trans?>)"></i>
			</td>
		</tr>
	<?
		$no++;
	}
	?>
	</tbody>
</table>