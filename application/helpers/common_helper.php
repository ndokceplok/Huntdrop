<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * generate_password
 *
 * Generate a random password.
 *
 * @access	public
 * @param	int
 * @return	string
 */
function generate_password($length=8)
{	
	$chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= $length) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 
}

/**
 * userdata
 *
 * A shortcode for $this->session->userdata
 *
 * @access  public
 * @param   $this->session->userdata parameter
 * @return  the parameter defined
 */

function userdata($item){
    $CI =& get_instance();
    return $CI->session->userdata($item);
}

/**
 * get_ip_address
 *
 * Get User IP
 *
 * @access  public
 * @param   -
 * @return  user IP
 */

function get_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/* End of file pretty_url_helper.php */
/* Location: ./application/helpers/pretty_url_helper.php */