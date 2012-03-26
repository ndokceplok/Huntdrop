<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Site Config
|--------------------------------------------------------------------------
|
| Site-wide config
|
*/

// Change to database-based
#$config['site_description'] = 'Huntdrop - Celebrating The Original Sport';
#$config['site_keywords'] = 'hunters, huntdrop, hunt drop';

$config['base_title'] = 'Huntdrop';

// when site is live, set email based on ENVIRONMENT
#if(ENVIRONMENT == 'development'){
$config['site_email'] = 'benhanks040888@gmail.com';
#}elseif(ENVIRONMENT == 'production'){
#	$config['site_email'] = 'benhanks040888@gmail.com';
#}