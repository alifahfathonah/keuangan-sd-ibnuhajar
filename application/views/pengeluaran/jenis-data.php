<table id="simple-table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Jenis Pengeluaran</th>
			<th>Kategori</th>
			<th>Jumlah</th>
			<th>Kode Akun</th>
			<th></th>
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
			<td style="text-align:left"><?=$v->jenis;?></td>
			<td style="text-align:left"><?=($v->kategori);?></td>
			<td style="text-align:right"><?=number_format($v->jumlah);?></td>
			<td style="text-align:left"><?=($v->kodeakun);?></td>
			<td style="text-align:center">
				<i class="icon-edit icon" onclick="editjenis(<?=$v->id?>)"></i>  	                                            
				<i class="icon icon-add icon-color" onclick="addjenis(<?=$v->id?>)"></i>  	                                            
				<i class="icon-trash icon-color icon" onclick="hapusjenis(<?=$v->id?>)"></i>
			</td>
		</tr>
	<?
		$no++;
	}
	?>
	</tbody>
</table>