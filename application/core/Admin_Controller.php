<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();

	  $this->title = $this->title.' - Back Admin';
	  
		$this->load->vars(array('admin_link'=>base_url().'backadmin/'));
		$this->admin_link = base_url().'backadmin/';
 	}

	function _auth()
	{
		if( $this->session->userdata('admin_logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access admin area');
			redirect('backadmin/login');
		}
	}

	function _only_superadmin(){
		if($this->session->userdata('admin_group')!='superadmin'){
			$this->session->set_flashdata('log', 'you are not authorized to access that area');
			redirect('backadmin/admin');
		}
	}

	public function _remap($method)
	{
		 	$args = array_slice($this->uri->rsegments,2);
    	if(method_exists($this,$method)){
    		return call_user_func_array(array(&$this,$method),$args);
    		#$this->$method();
    	}else{
        	$this->index();
        	#or show 404
    	}
	}


}