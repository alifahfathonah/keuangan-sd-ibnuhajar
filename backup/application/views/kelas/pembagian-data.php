<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
	<thead>
		<tr>
			<th style="text-align:center;">No</th>
			<th style="text-align:center;">Kelas</th>
			<!--<th style="text-align:center;">Wali Kelas</th>-->
			<th style="text-align:center;">Tahun Ajaran</th>
			<th style="text-align:center;">Wali Kelas</th>
			<th style="text-align:center;">Jumlah Siswa</th>
			<!-- <th  style="text-align:center;"></th> -->
			<th  style="text-align:center;">Action</th>
		
		</tr>
	</thead>
	<tbody>
	<?
	if(count($d)!=0)
	{
		foreach ($d as $k => $v) 
		{
			$jlhsiswa=$this->db->query('select * from t_pembagian_siswa where id_pembagian="'.$v->id.'" and status="t"');
			$offset=$offset+1;
			list($kelasid,$namakelas)=explode('_', $v->nama_kelas);
			$kkelas=$this->db->query('select * from t_kelas where namakelas like "%'.$kelasid.'%"');
			list($k,$i)=explode(' ', $kelasid);
			echo '<tr>';
				echo '<td style="text-align:center">'.($offset).'</td>';
				echo '<td>'.($namakelas).'</td>';
				echo '<td style="text-align:center">'.($v->tahun_ajaran).'</td>';
				echo '<td style="text-align:center">'.($v->walikelas).'</td>';
				echo '<td style="text-align:center"><span class="label label-inverse" style="cursor:pointer" id="jlhsiswa_'.$v->id.'" onclick="datasiswa(\''.$v->id.'\')">'.$jlhsiswa->num_rows.' Siswa</span>&nbsp;
					<a href="'.site_url().'kelas/pembagiankelas/'.$kkelas->row('id').'/'.$idajaran.'/'.$v->id.'">	 
						<button class="btn btn-warning btn-mini">
							<i class="icon-white icon-plus-sign"></i>&nbsp;Tambah Siswa
						</button>
					</a>
				</td>';
				echo '<td style="text-align:center">
					<button class="btn btn-primary btn-mini"  onclick="editkelas(\''.$i.'\',\''.$v->tahun_ajaran.'\',\''.$v->id.'\')">
						<i class="icon-white icon-edit"></i>
					</button>
					<button class="btn btn-danger btn-mini"  onclick="hapuskelas(\''.$v->id.'\',\''.$i.'\')">
						<i class="icon-white icon-remove"></i>
					</button>
				</td>';
			echo '</tr>';
			// $offset++;
		}
	}
	else
	{
		echo '<tr><td colspan="7" style="text-align:center;"><b>Data Kosong</b></td></tr>';
	}
	?>
	</tbody>
</table>
