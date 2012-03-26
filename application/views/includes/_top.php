<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?=$title?></title>
	<meta name="description" content="<?php echo isset($page_description)?$page_description:$this->site_description;#$this->config->item('site_description');?>" >
	<meta name="keywords" content="<?php echo isset($page_keywords)?$page_keywords:$this->site_keywords;#$this->config->item('site_keywords');?>" >

	<!-- <meta http-equiv="content-language" content="EN" >
	<meta name="copyright" content="Copyright © <?php echo date("Y");?> Pennmultimedia, Inc." > -->
	<meta name="author" content="Pennmultimedia, Inc." >
	<meta name="designer" content="Pennmultimedia, Inc." >
	<meta name="publisher" content="Pennmultimedia, Inc." >
	<meta name="robots" content="index, follow" >
	<meta name="googlebot" content="index, follow" >
	<meta name="rating" content="General" >
	<!-- <meta name="distribution" content="Local" >
	<meta name="audience" content="All" > -->
	<meta name="geo.country" content="USA" >
	<meta name="geo.region" content="US" >

  <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url().'images/favicon.ico';?>">
	<link rel="stylesheet" href="<?=assets_url()?>css/main.css?v=1" type="text/css" />
	<?php 
		if(isset($add_css)){ 
		foreach($add_css as $r){
	?>
	<link rel="stylesheet" href="<?php echo assets_url();?>css/<?php echo $r;?>.css" type="text/css" />
    <?php
		}
		} 
	?>
	<script type="text/javascript" src="<?=assets_url()?>js/modernizr-2.0.6.min.js"></script>
	<script type="text/javascript" src="<?=assets_url()?>js/jquery.min.js"></script>
	<script>
		var base_url = '<?php echo base_url();?>';
		Modernizr.load([
		{
		  test: Modernizr.borderradius,
		  nope: '<?=assets_url()?>css/ie.css'
		},
		{
			test: Modernizr.input.placeholder,
		  nope: '<?=assets_url()?>js/placeholder-fix.js'
		}
		]);
	</script>
  <?php 
		if(isset($page_css)){ 
		foreach($page_css as $r){
	?>
	<link rel="stylesheet" href="<?php echo assets_url();?>css/<?php echo $r;?>.css" type="text/css" />
    <?php
		}
		} 
	?>    
