<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertising extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Advertise Requests';
	private $active = 'advertising';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Advertising Requests List';
		
		$this->load->model(array(
			'm_advertise_requests'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

  	$this->load->vars(array('active'=>$this->active));
	}

	/*private function _auth()
	{
		if( $this->session->userdata('admin_logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access admin area');
			redirect('backadmin/login');
		}
	}*/

	function index()
	{

		$data['add_js'] = array('notice');
		$data['add_css'] = array('backadmin/table');
		

		$data['requests'] = $this->m_advertise_requests->read();

		$data['title'] = $this->title;
		$this->load->view('backadmin/v_advertising', $data);
	}

	function read(){
		
		$request_id = $this->uri->segment(4);

		$data['request_info'] = $this->m_advertise_requests->read($request_id);
	 	if(empty($request_id) || empty($data['request_info'])){
	 		$this->session->set_flashdata('log', 'you reached an unidentified page');
	 		redirect($this->admin_link.'advertising','refresh');
	 	}

	 	$this->m_advertise_requests->mark_as_read($request_id);
		// $data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
		// $data['add_css'] = array('backadmin/table','validationEngine.jquery');
		
		// $data['action'] = 'edit';
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_advertising_read', $data);
	}


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */