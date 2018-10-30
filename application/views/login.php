<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
	<meta charset="utf-8">
	<title><?=$title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
	<meta name="author" content="Muhammad Usman">

	<!-- The styles -->
	<link href="<?=base_url()?>media/css/bootstrap-simplex.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<script src="<?=base_url()?>media/js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?=base_url()?>media/js/jquery-ui-1.8.21.custom.min.js"></script>
	<link href="<?=base_url()?>media/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?=base_url()?>media/css/charisma-app.css" rel="stylesheet">
	<link href="<?=base_url()?>media/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='<?=base_url()?>media/css/fullcalendar.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='<?=base_url()?>media/css/chosen.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/uniform.default.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/colorbox.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/jquery.cleditor.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/jquery.noty.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/noty_theme_default.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/elfinder.min.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/elfinder.theme.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/opa-icons.css' rel='stylesheet'>
	<link href='<?=base_url()?>media/css/uploadify.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?=base_url()?>media/img/logoMIB.png">
	
</head>

<body>
	
	<div class="container-fluid">
		<div class="row-fluid">
		

			
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div class="alert alert-info">
						Silahkan Masukan Username dan Password Anda
					</div>
					<form class="form-horizontal" action="<?=site_url()?>login/log_in" method="post">
						<fieldset>
							<div class="input-prepend" title="Username" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="username" id="username" type="text" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="password" id="password" type="password" />
							</div>							
							<div class="clearfix"></div>
							<div class="input-prepend">
								<input data-no-uniform="true" type="checkbox" class="iphone-toggle" checked="checked" name="sistem">
							</div>

							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" class="btn btn-primary">Login</button>
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
				</div><!--/fluid-row-->
		
	</div>

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->

	<!-- transition / effect library -->
	<script src="<?=base_url()?>media/js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="<?=base_url()?>media/js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="<?=base_url()?>media/js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="<?=base_url()?>media/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="<?=base_url()?>media/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="<?=base_url()?>media/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="<?=base_url()?>media/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="<?=base_url()?>media/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="<?=base_url()?>media/js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="<?=base_url()?>media/js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="<?=base_url()?>media/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="<?=base_url()?>media/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="<?=base_url()?>media/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="<?=base_url()?>media/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='<?=base_url()?>media/js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='<?=base_url()?>media/js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="<?=base_url()?>media/js/excanvas.js"></script>
	<script src="<?=base_url()?>media/js/jquery.flot.min.js"></script>
	<script src="<?=base_url()?>media/js/jquery.flot.pie.min.js"></script>
	<script src="<?=base_url()?>media/js/jquery.flot.stack.js"></script>
	<script src="<?=base_url()?>media/js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="<?=base_url()?>media/js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="<?=base_url()?>media/js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="<?=base_url()?>media/js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="<?=base_url()?>media/js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="<?=base_url()?>media/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="<?=base_url()?>media/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="<?=base_url()?>media/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="<?=base_url()?>media/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="<?=base_url()?>media/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="<?=base_url()?>media/js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="<?=base_url()?>media/js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="<?=base_url()?>media/js/charisma.js"></script>
	
	<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Pesan</h3>
			</div>
			<div class="modal-body">
				<p><?=$this->session->flashdata('pesan')?></p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-primary" data-dismiss="modal">OK</a>
			</div>
		</div>

</body>
</html>
<?
if($this->session->flashdata('pesan'))
{
	echo '<script>
		$(document).ready(function()
		{
			$("#myModal").modal("show");
		});
	</script>';
}
?>

 <script type="text/javascript">
 $(document).ready(function(){
 // 	iOSCheckbox.defaults.checkedLabel='SD';
	// iOSCheckbox.defaults.uncheckedLabel='SM';
 	$('label.iPhoneCheckLabelOn span').text('SD');
 	$('label.iPhoneCheckLabelOff span').text('SM');

 	// });
 });
 </script>
<style type="text/css">

</style>