<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
  
  function assets_url(){
    $CI =& get_instance();
    return $CI->config->slash_item('assets_url');
  }

  function images_url(){
    $CI =& get_instance();
    return $CI->config->slash_item('assets_url').'images/';
  }

/* End of file MY_url_helper.php */
/* Location: ./system/application/helpers/MY_url_helper.php */
