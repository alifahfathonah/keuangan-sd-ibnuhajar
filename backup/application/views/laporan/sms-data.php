<table class="table table-striped table-bordered bootstrap-datatable" style="width:100%">
	<thead>
		<tr>
<?php
$header=array('No','No HP','Virtual Account','Nama','Kelas','Bulan Sebelumnya','UTAB','PPTAB','SPP','Cateting','Jemputan','Snack','Club','Seragam','Total');
foreach ($header as $k => $v) 
{
	# code...
	echo '<th style="text-align:center;padding:2px;vertical-align:middle">'.$v.'</th>';
}
?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>