<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Public_Controller extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
        $this->load->model('m_banners');
        $home_side_banners = $this->m_banners->get_active_banners(array('banner_page'=>'home','banner_position'=>'sidebar'));
        $this->load->vars(array('home_side_banners'=>$home_side_banners));

 	}

	public function _remap($method)
	{
    	if(method_exists($this,$method)){
    		$this->$method();
    	}else{
        	#$this->index();
        	#or show 404
        	show_404();
    	}
	}


}