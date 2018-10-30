<table id="table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">No</th>
			<th class="center">Nama Item</th>
			<th class="center">Harga Satuan</th>
			<th class="center">Jenis Satuan</th>
			<th class="center">Jumlah</th>
			<th class="center">Subtotal</th>
		</tr>				
	</thead>
	<tbody>
	<?
	$no=1;
	foreach ($d as $k => $v) 
	{
		echo '<tr>';
		echo '<td style="text-align:center">'.$no.'</td>';
		echo '<td style="text-align:left">'.$v->item.'</td>';
		echo '<td style="text-align:right">'.number_format($v->harga_satuan).'</td>';
		echo '<td style="text-align:center">'.$v->jenis_satuan.'</td>';
		echo '<td style="text-align:center">'.$v->qty.'</td>';
		echo '<td style="text-align:right">'.number_format($v->subtotal).'</td>';
		echo '</tr>';
		$no++;
	}
	?>
	</tbody>
</table>