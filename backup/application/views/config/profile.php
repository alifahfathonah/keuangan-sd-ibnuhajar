<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?=base_url()?>">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="#">Profile</a>
			</li>

		</ul>
		<div class="row-fluid sortable ui-sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Change Profil</h2>
						<div class="box-icon">
						
						</div>
					</div>
					<div class="box-content" style="background:#fff">
							<form id="fform-action" class="form-horizontal" action="<?=site_url()?>config/saveprofile/" method="post" enctype="multipart/form-data">
								<div class="span11">
														
									<div class="control-group">
									  <label class="control-label" for="typeahead">Nama Pengguna</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<input type="text" name="nama" value="<?=$this->session->userdata('nama')?>" id="optionsRadios1">
										</label>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Email</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<input type="text" name="email" value="<?=$this->session->userdata('email')?>" id="optionsRadios1">
										</label>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Username</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<input type="text" name="username" value="<?=$this->session->userdata('user')?>" id="optionsRadios1">
										</label>
									  </div>
									</div>
									<div class="control-group">
									  <label class="control-label" for="typeahead">Password</label>
									  <div class="controls">
										<label class="control-label" for="typeahead" style="text-align:left;font-weight:bold;">
											<input type="text" name="password" id="optionsRadios1"><small style="font-size:10px;"><i>* kosongkan jika tidak diubah</i></small>
										</label>
									  </div>
									</div>
								</div>
								<div class="span11">
									<div class="form-actions" style="text-align:center">
									  <button type="button" class="btn btn-primary">Lupa Password</button>
									  <button type="submit" class="btn btn-primary">Save changes</button>
									</div> 
								</div>
							</form>
					</div>
				</div>
		</div>
</div>