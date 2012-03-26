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
function pretty_url($plain_text)
{	
	$pattern = '([\W\s]+)';
	$replacement = '-';
	$alias = trim(preg_replace($pattern, $replacement, strtolower($plain_text)),'-');
	
	return $alias;
}

/* End of file pretty_url_helper.php */
/* Location: ./application/helpers/pretty_url_helper.php */