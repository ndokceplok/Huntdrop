<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function ckeditor($data,$name='editor')
{		
	$CI =& get_instance();
	$CI->load->helper('url');

	echo '<script type="text/javascript" src="'.base_url().'assets/ckeditor/ckeditor.js"></script>';
	echo '<script type="text/javascript" src="'.base_url().'assets/ckfinder/ckfinder.js"></script>';
	
	echo '<textarea id="'.$name.'" name="'.$name.'">'.html_entity_decode($data).'</textarea>';
	
	echo "
	<script type=\"text/javascript\">
	var editor = CKEDITOR.replace( '".$name."' , 
								{
									toolbar : 'myStyle' 
								});
	CKFinder.SetupCKEditor( editor, '".base_url()."assets/ckfinder/' ) ;	

	</script>
	";

}