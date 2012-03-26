<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends Public_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function page_404()
	{
		$data['title'] =  "We can't find what you're looking for";
		$data['add_css'] = array('404');
		
 		$this->output->set_status_header(404);
 		$this->load->view('v_404', $data);
	}

	function denied()
	{
		$data['title'] =  "You have no permission to access that page";
		$data['add_css'] = array('404');
		
 		$this->load->view('v_access_denied', $data);
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */