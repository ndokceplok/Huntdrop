<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * link
 *
 * Create easier to customize links
 * e.g. base_url().'user/'.$user_name; -> user_link($user_name);
 *
 * @access	public
 * @param	string
 * @return	string
 */
function user_link($user_name)
{	
	$link = base_url().'user/'.$user_name;
	return $link;
}

function user_image($photo)
{	
	$link = base_url().(!empty($photo) && file_exists('assets/avatar/'.$photo)?'assets/avatar/'.$photo:'assets/images/no-avatar.jpg');
	echo $link;
}

function content_image($src)
{	
	$link = base_url().(!empty($src)?'uploads/'.$src:'assets/images/no-photo.jpg');
	return $link;
}

function content_thumb($src)
{	
	$link = base_url().(!empty($src)?'uploads/thumbs/'.$src:'assets/images/no-photo.jpg');
	return $link;
}

function contest_image($src)
{	
	$link = base_url().(!empty($src)?'uploads/contest/'.$src:'assets/images/no-photo.jpg');
	return $link;
}

function banner_image($src)
{	
	$link = base_url().(!empty($src)?'uploads/banners/'.$src:'assets/images/no-photo.jpg');
	return $link;
}

function youtube_thumb($youtube_id,$no=2)
{
	$link = "http://img.youtube.com/vi/".$youtube_id."/".$no.".jpg";
	return $link;
}

function project_link($ref_id, $alias)
{	
	$link = base_url().'project/'.$ref_id.'/'.$alias;
	return $link;
}

function plural($qty)
{	
	if($qty>1){ echo 's';}
}

/* End of file link_helper.php */
/* Location: ./application/helpers/link_helper.php */