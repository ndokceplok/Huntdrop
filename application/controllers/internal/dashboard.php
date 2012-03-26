<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Dashboard';
	private $active = 'dashboard';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Dashboard';
		
		$this->load->library(array(
			'encrypt','upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_blogs','m_projects','m_reviews','m_videos','m_posts','m_comments','m_likes','m_messages','m_threads'
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

		$data['title'] = $this->title;
		$this->load->view('backadmin/v_dashboard', $data);
	}


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */