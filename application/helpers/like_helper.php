<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * like
 *
 * Create easier to customize links
 * e.g. base_url().'user/'.$user_name; -> user_link($user_name);
 *
 * @access	public
 * @param	string
 * @return	string
 */
 
function build_like($liker_id,$post_type,$post_id)
{	
	$CI =& get_instance(); 
	
	//check if the liker is the author of the content
	$q=mysql_query("SELECT * FROM posts WHERE account_id='$liker_id' AND type_id='$post_type' AND ref_id='$post_id' ")or die(" Error: ".mysql_error());
	if (mysql_num_rows($q) == 0) {
		$like['can_like'] = true;
		$query=mysql_query("SELECT * FROM likes WHERE liker_id='$liker_id' AND post_type='$post_type' AND post_id='$post_id' ")or die(" Error: ".mysql_error());
		if (mysql_num_rows($query) > 0) {
			$like['has_like'] = true;
		}else{
			$like['has_like'] = false;
		}
		$like['post_type'] = $post_type;
		$like['id'] = $post_id;
		//$data['like_bar'] = $this->load->view('includes/like_bar.php',$like,true); 
	}else{
		$like['can_like'] = false;
	}
	return $CI->load->view('includes/like_bar.php',$like,true);
}

/* End of file like_helper.php */
/* Location: ./application/helpers/_helper.php */