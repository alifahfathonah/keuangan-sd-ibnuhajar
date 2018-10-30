			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><?=$title?></a>
					</li>
				</ul>
			</div>
			<div class="row-fluid sortable ui-sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-edit"></i> <?=$title?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" style="background:#fff">
						<div class="box-content">
							
											<form id="fform-action" class="form-horizontal" action="<?=site_url()?>kelas/aktifedit/<?=$id?>" method="post" enctype="multipart/form-data">
											<div class="row-fluid">
												<div class="span5">
																		
<?php
	$l=$k=$u=array();
	$siswa=$this->sm->getSiswa($l,'null');
	$kelas=$this->km->getKelas($k,'null');
	$user=$this->um->getUser($u,'null',1);
?>													
													<div class="control-group">
													  <label class="control-label" for="typeahead">Kelas*</label>
													  <div class="controls">
														<select id="selectError1" data-rel="chosen" name="kelas" data-placeholder="Pilih Kelas">
														
														<?
														foreach($kelas->result() as $kl)
														{
															if($kl->id==$det->row('idkelas'))
																echo '<option value="'.$det->row('idkelas').'" selected="selected">'.$det->row('namakelas').'</option>';
															else
																echo '<option value="'.$kl->id.'">'.$kl->namakelas.'</option>';
														}
														?>	
														</select>
													  </div>
													</div>	
													<div class="control-group">
													  <label class="control-label" for="typeahead">Nama Kelas*</label>
													  <div class="controls">
														<input type="text" name="namakelas" id="namakelas" value="<?=$det->row('namakelasaktif')?>">
													  </div>
													</div>
													<div class="control-group">
													  <label class="control-label" for="typeahead">Status</label>
													  <div class="controls">
														<select name="status" data-rel="chosen">
															<option value="t" <?=($det->row('st_aktif')=='t' ? 'selected' : '')?>>Aktif</option>
															<option value="f" <?=($det->row('st_aktif')=='f' ? 'selected' : '')?>>Non Aktif</option>
														</select>
													  </div>
													</div>												
													<div class="control-group">
													  <label class="control-label" for="typeahead">Wali Kelas*</label>
													  <div class="controls">
														<select id="selectError2" data-rel="chosen" name="walikelas" data-placeholder="Wali Kelas">
														
														<?
														foreach($user->result() as $us)
														{
															if($us->id==$det->row('id_user'))
																echo '<option value="'.$det->row('id_user').'" selected="selected">'.$det->row('nama_guru').'</option>';
															else
																echo '<option value="'.$us->id.'">'.$us->nama.'</option>';
														}
														?>	
														</select>
													  </div>
													</div>
													<div class="control-group">
													  <label class="control-label" for="typeahead">Tahun Ajaran*</label>
													  <div class="controls">
														<select name="ajaran" data-rel="chosen">
															
															<?
															$aj=$this->db->query('select * from t_ajaran order by id');
															foreach($aj->result() as $a)
															{
																if($a->id==$det->row('id_ajaran'))
																	echo '<option value="'.$det->row('id_ajaran').'" selected="selected">'.$det->row('tahunajaran').'</option>';
																else
																echo '<option value="'.$a->id.'">'.$a->tahunajaran.'</option>';
															}
															?>
														</select>
													  </div>

													</div>
												
												</div>
												</div>
												<div class="form-actions" style="text-align:center">
												  	<button type="Submit" class="btn btn-primary" id="submit">Save changes</button>
												  	
													<button type="reset" class="btn" onclick="location.href='<?=site_url()?>kelas/aktif'">Back</button>

													
												</div>
											</form>
								
						</div>
					</div>
				</div><!--/span-->

			</div> 