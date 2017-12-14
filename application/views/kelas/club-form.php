<table class="table table-bordered table-hovered" style="width:65%;float:left">
	<thead>
		<tr>
			<th style="text-align:center">No</th>
			<th style="text-align:center">Nama Club</th>
			<th style="text-align:center">PJ</th>
			<th style="text-align:center">Telp & Email</th>
			<th style="text-align:center">Jadwal</th>
			<th style="text-align:center">Biaya</th>
			<th style="text-align:center">Action</th>
		</tr>	
	</thead>
	<tbody>
	<?php
		if(count($data)!=0)
		{
			for($i=0;$i<count($data);$i++)
			{
				echo '<tr>
					<td style="text-align:center">'.($i+1).'</td>
					<td style="text-align:left">'.$data[$i]->nama_club.'</td>
					<td style="text-align:left">'.$data[$i]->penanggung_jawab.'</td>
					<td style="text-align:center">'.$data[$i]->telp_pj.'<br>'.$data[$i]->email_pj.'</td>
					<td style="text-align:center">'.ucwords($data[$i]->hari).' - '.$data[$i]->waktu.'</td>
					<td style="text-align:center">'.number_format($data[$i]->biaya).'</td>
					<td style="text-align:center">
						<button class="btn btn-info  btn-mini" href="#" onclick="edit(\''.$data[$i]->id_club.'\')">
							<i class="icon-edit icon-white"></i>  					                                            
						</button>
					</td>
				</tr>';
			}
		}
	?>
	</tbody>
</table>
<div style="width:35%;float:right;text-align:right;margin-bottom:10px;" id="form-club">
	<h3>Tambah Data Club</h3>	
	<form id="fform-action-club" style="width:100% !important" class="form-horizontal" action="<?=site_url()?>club/proses/<?=$id?>" method="post" enctype="multipart/form-data">
		<div class="">
		
			<div class="control-group">
			  <label class="control-label" for="typeahead">Nama Club</label>
			  <div class="controls">
				<input type="text" name="nama_club" class="span6 typeahead" id="" style="width:100%;" value="<?=($id!=-1 ? $det->row('nama_club') : '')?>">
				<input type="hidden" name="id_club" value="<?=($id!=-1 ? $det->row('id_club') : generate_id())?>" class="span6 typeahead" id="" style="width:100%;">
			  </div>
			</div>
			<div class="control-group">
			  <label class="control-label" for="typeahead">Penanggung Jawab</label>
			  <div class="controls">
				<input type="text" name="penanggung_jawab" class="span6 typeahead" id="" style="width:100%;" value="<?=($id!=-1 ? $det->row('penanggung_jawab') : '')?>">
			  </div>
			</div>
			<div class="control-group">
			  <label class="control-label" for="typeahead">Telp</label>
			  <div class="controls">
				<input type="text" name="telp_pj" class="span6 typeahead" id="" style="width:100%;" value="<?=($id!=-1 ? $det->row('telp_pj') : '')?>">
			  </div>
			</div>			
			<div class="control-group">
			  <label class="control-label" for="typeahead">Email</label>
			  <div class="controls">
				<input type="text" name="email_pj" class="span6 typeahead" id="" style="width:100%;" value="<?=($id!=-1 ? $det->row('email_pj') : '')?>">
			  </div>
			</div>	
			<div class="control-group">
			  <label class="control-label" for="typeahead">Biaya</label>
			  <div class="controls">
				<input type="text" name="biaya" class="span6 typeahead" id="" style="width:100%;" value="<?=($id!=-1 ? $det->row('biaya') : '')?>">
			  </div>
			</div>			
			<div class="control-group">
			  <label class="control-label" for="typeahead">Jadwal</label>
			  <div class="controls">
				<select name="hari" style="width:50%;float:left">
				<?
				$hari=array('ahad','senin','selasa','rabu','kamis','jumat','sabtu');
				foreach ($hari as $k => $v) 
				{
					if($id!=-1)
					{
						if($det->row('hari')==$v)
							echo '<option selected="selected" value="'.$det->row('hari').'">'.ucwords($det->row('hari')).'</option>';
						else
							echo '<option value="'.$v.'">'.ucwords($v).'</option>';
					}
					else
						echo '<option value="'.$v.'">'.ucwords($v).'</option>';
				}
				?>
				</select>
				&nbsp;&nbsp;
				<select name="waktu" style="width:45%;float:left;margin-left:5px;">
				<?
				$waktu=array('08.00','08.30','09.00','09.30','10.00','10.30','11.00','11.30','12.00','12.30','13.00','13.30','14.00','14.30','15.00','15.30','16.00','16.30','17.00','17.30',);
				foreach ($waktu as $k => $v) 
				{
					if($id!=-1)
					{
						if($det->row('waktu')==$v)
							echo '<option selected="selected" value="'.$det->row('waktu').'">'.$det->row('waktu').'</option>';
						else
							echo '<option value="'.$v.'">'.$v.'</option>';
					}
					else
						echo '<option value="'.$v.'">'.$v.'</option>';
				}
				?>
				</select>
			  </div>
			</div>			
			<div class="form-actions" style="text-align:center">
			  <button type="button" onclick="simpan(<?=$id?>)" id="save" class="btn btn-primary">Save</button>
			</div> 
		</div>
	</form>	
</div>