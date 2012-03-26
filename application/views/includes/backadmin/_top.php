<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url().'images/favicon.ico';?>">
	<link rel="stylesheet" href="<?=assets_url()?>css/backadmin/main.css" type="text/css" />
	<script type="text/javascript" src="<?=assets_url()?>js/jquery.min.js"></script>
 	<script>
		var base_url = '<?php echo base_url();?>';
	</script>
 	<?php 
		if(isset($page_css)){ 
		foreach($page_css as $r){
	?>
	<link rel="stylesheet" href="<?php echo assets_url();?>css/<?php echo $r;?>.css" type="text/css" />
    <?php
		}
		} 
	?>    <?php 
		if(isset($add_css)){ 
		foreach($add_css as $r){
	?>
	<link rel="stylesheet" href="<?php echo assets_url();?>css/<?php echo $r;?>.css" type="text/css" />
    <?php
		}
		} 
	?>