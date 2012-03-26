<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Page List';
	private $active = 'page';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Page List';
		
		$this->load->library(array(
			'upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_pages'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
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

		$data['add_css'] = array('backadmin/table');
		$data['add_js'] = array('notice');

		$data['pages'] = $this->m_pages->read();

		$data['title'] = $this->title;
		$this->load->view('backadmin/v_page', $data);
	}

	function create()
	{

		#$data['add_js'] = array('uploadify/swfobject','uploadify/jquery.uploadify.v2.1.4.min');
		#$data['add_css'] = array(/*'uploadify',*/'backadmin/table');
		$data['add_css'] = array('backadmin/table','validationEngine.jquery');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');

		$data['parents'] = $this->m_pages->read_by('parent',0);
		
		$data['action'] = 'add';
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_page_form', $data);
	}
	
	function create_exec()
	{
		
		$this->m_pages->create();
		redirect('backadmin/page');
		#echo "aaa";
		
	}

	function update()
	{

		$page_id = $this->uri->segment(4);

		$data['add_css'] = array('backadmin/table','validationEngine.jquery');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
		
		$data['action'] = 'edit';
		$data['parents'] = $this->m_pages->read_by('parent',0);

		$data['title'] = $this->title;
		$data['page_info'] = $this->m_pages->read($page_id);
		$this->load->view('backadmin/v_page_form', $data);
	}

	function update_exec()
	{
		
		$this->m_pages->update();
		redirect('backadmin/page');
		#echo "aaa";
		
	}
	
	function delete($page_id){
		echo $page_id;
		#$this->m_pages->delete($page_id);
		#redirect('backadmin/page');
	}
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */