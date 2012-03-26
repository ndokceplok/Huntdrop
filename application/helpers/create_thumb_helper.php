<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * pretty url
 *
 * Create a pretty readable url format.
 * e.g. A Little "Something" -> a-little-something
 *
 * @access	public
 * @param	string
 * @return	string
 */
function create_thumb($file_name){
	$CI =& get_instance(); 
	$CI->load->library('image_lib');
	
	$path = './uploads/';
	if(!is_dir($path.'thumbs/')){
		mkdir($path.'thumbs/');
	}
	$config['source_image'] =  $path.$file_name;
	$config['new_image'] = $path.'thumbs/'.$file_name;
	$CI->image_lib->initialize($config); 
	if ( ! $CI->image_lib->resize())
	{
		// an error occured
		$thumb = false;
	}else{
		$thumb = true;
	}
	return $thumb;

}
	
/* End of file pretty_url_helper.php */
/* Location: ./application/helpers/pretty_url_helper.php */