<link rel='stylesheet' href='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/css/bootstrap.min.css'>
<link rel='stylesheet' href='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/css/material.css'>
<link rel='stylesheet' href='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/css/style.css'>
<link rel='stylesheet' href='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/fileupload/bootstrap-fileupload.min.css'>
<link rel='stylesheet' href='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/css/sweet-alerts/sweetalert.css'>
<link rel='stylesheet' href="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/js/uploadify/uploadify.css" >
<script src='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/jquery.js'></script>
<script type="text/javascript" src="<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/js/jquery-1.10.2.min.js"></script>
<script src='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/app.js'></script>
<script>
	jQuery(window).load(function () {
		$('.piluku-preloader').addClass('hidden');
	});
</script>
<script>
	var _REQUEST_HOST='<?php echo APP_URL_ROOT;?>';
	var _THEMES_HOST = '<?php echo APP_HTTP_ROOT.$this->GetThemes();?>';
</script>
<style type="text/css">
	label.error {
		color: #EA5200;
	}
</style>