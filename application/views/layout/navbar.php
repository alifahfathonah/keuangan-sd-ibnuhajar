<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner" style="background:#fff">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?=site_url()?>" style="width:300px;margin:0px;padding:0px;"> <img src="<?=base_url()?>media/img/logo-2.png" style="height:50px;width:auto;margin:0px;padding:0px;"/></a>
				
				
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> <?=$this->session->userdata('nama')?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?=site_url()?>config/profile">Profile</a></li>
						<li class="divider"></li>
						<li><a href="<?=site_url()?>a/logout">Logout</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
				
				<div class="top-nav nav-collapse">
					
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends --> 
