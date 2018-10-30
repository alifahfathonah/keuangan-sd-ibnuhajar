<!-- content starts -->
			

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Dashboard</a>
					</li>
				</ul>
			</div>

			
			
					
			<div class="row-fluid">

			<?
			// if($this->session->userdata('idlevel')==0)
			// {
			?>		
				<div class="box span6">
					<div class="box-header well">
						<h2><i class="icon-th"></i> Data Nominal UTAB</h2>

					</div>
					<div class="box-content">
						<div style="width:100%;text-align:left;" id="isi">
							<form class="form-horizontal" action="<?=site_url()?>penerimaan/addplafond" method="post">
								  <fieldset>
									
									
								<?
								$jlh=0;
									$penerimaan=$this->pm->getJenisPembayaranByParent(3);
									foreach ($penerimaan->result() as $v) 
									{
										# code...
									
								?>
									<div class="control-group">
									  <label class="control-label" for="date01" style="width:190px;"><?=$v->jenis?></label>
									  <div class="controls" style="padding-left:60px !important;padding-top:5px;width:100px;text-align:right;font-weight:bold;">
										<?=rupiah($v->jumlah)?>
									  </div>
									</div>
								<?
										$jlh+=$v->jumlah;
									}
								?>       
									<input type="hidden" name="jenispenerimaan" value="3">
									<div class="form-actions">
									  <label class="control-label" for="date01" style="margin-left:-100px;">Jumlah UTAB</label>
									  <div class="controls" style="padding-top:5px;text-align:left;font-weight:bold;margin-left:95px;">
										<?=rupiah($jlh)?>
										  <button class="btn btn-mini btn-primary" type="submit">
										  	Edit Nominal
										  </button>
									  </div>
									</div>         
									
								  </fieldset>
								</form>
						</div>
					</div>
						
				</div><!--/span-->

				<div class="box span6">

					<div class="box-header well" data-original-title>
						<h2><i class="icon-th"></i> Data Nominal PPTAB</h2>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="<?=site_url()?>penerimaan/addplafond" method="post">
								  <fieldset>
									
								
								<?
									$jlh=0;
									$penerimaand=$this->pm->getJenisPembayaranByParent(4);
									foreach ($penerimaand->result() as $v) 
									{
										# code...
									
								?>
									<div class="control-group">
									  <label class="control-label" for="date01" style="width:190px;"><?=$v->jenis?></label>
									  <div class="controls" style="padding-left:60px !important;padding-top:5px;width:100px;text-align:right;font-weight:bold;">
										<?=rupiah($v->jumlah2)?>
									  </div>
									</div>
								<?
										$jlh+=$v->jumlah2;
									}
								?>       
									<div class="form-actions">
									  <label class="control-label" for="date01" style="margin-left:-100px;">Jumlah PPTAB</label>
									  <div class="controls" style="padding-top:5px;text-align:left;font-weight:bold;margin-left:95px;">
										<?=rupiah($jlh)?>
										<input type="hidden" name="jenispenerimaan" value="4">
										<button class="btn btn-mini btn-primary" type="submit">
										  	Edit Nominal
										  </button>
									  </div>
									</div>         
									
								  </fieldset>
								</form>
					</div>
				</div><!--/span-->
						
			<?
				// }
			?>
			</div><!--/row-->

		  
       
					<!-- content ends --> 
