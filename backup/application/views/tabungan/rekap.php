<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
	<thead>
		<tr>
			<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">No</th>
			<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Kelas</th>
			<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Wali Kelas</th>
			<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Tahun Ajaran</th>
			<th colspan="3" style="text-align:center;padding:2px;vertical-align:middle">Jumlah</th>
			<th rowspan="2" style="text-align:center;padding:2px;vertical-align:middle">Total</th>
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
	$j_totalharian=$j_totallain=$j_infaq=$t_semua=0;
	foreach ($kelas->result() as $k => $v) 
	{
		$subtotal=0;
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

			$subtotal=$totalharian+$totallain+$infaq;

			$lastupdate=$dd[$idx]->tgl_transaksi;
			// list($tgl,$wkt)=explode(' ', $dd[$idx]->tgl_transaksi);
		}
		$j_totalharian += $totalharian;
		$j_totallain += $totallain;
		$j_infaq += $infaq;
		$t_semua += $subtotal;
		echo '<tr style="cursor:pointer;">
			<td style="text-align:center">'.($k+1).'</td>
			<td>'.str_replace('_', '<br>', $v->nama_kelas).'</td>
			<td>'.$v->walikelas.'</td>
			<td style="width:60px;text-align:center">'.$v->tahun_ajaran.'</td>
			<td style="text-align:right;" onclick="detailtab(\''.$v->id.'__'.str_replace(' ', '%20', $v->nama_kelas).'\',\'harian\',\''.$tgl.'\')">'.number_format($totalharian).'</td>
			<td style="text-align:right;" onclick="detailtab(\''.$v->id.'__'.str_replace(' ', '%20', $v->nama_kelas).'\',\'tablain\',\''.$tgl.'\')">'.number_format($totallain).'</td>
			<td style="text-align:right;" onclick="detailtab(\''.$v->id.'__'.str_replace(' ', '%20', $v->nama_kelas).'\',\'infaq\',\''.$tgl.'\')">'.number_format($infaq).'</td>
			<td style="text-align:right;font-weight:bold">'.number_format($subtotal).'</td>
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
			<th colspan="" style="text-align: right;"><?=number_format($t_semua)?></th>
		</tr>
	</thead>
</table>