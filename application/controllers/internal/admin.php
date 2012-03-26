<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Admin List';
	private $active = 'admin';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Admin List';
		
		$this->load->library(array(
			'encrypt'
		));

		$this->load->model(array(
			'm_admins'
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
		$data['admins'] = $this->m_admins->read();

		$data['title'] = $this->title;
		$this->load->view('backadmin/v_admin', $data);
	}

	function create(){
		$this->_only_superadmin();

		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','validationEngine.jquery');
		
		$data['action'] = 'add';
		$data['title'] = $this->title;
		$data['groups'] = array(
							array('label'=>'','title'=>'Select One Group'),
							array('label'=>'superadmin','title'=>'Superadmin'),
							array('label'=>'admin','title'=>'Admin'),
							array('label'=>'business','title'=>'Business'),
							);
		$this->load->view('backadmin/v_admin_form', $data);
	}

	function create_exec()
	{
		$this->_only_superadmin();
		
		$this->m_admins->create();
		redirect('backadmin/admin');
		
	}

	function update(){
		
		$admin_id = $this->uri->segment(4);

		if($admin_id==1 ){
			$this->_only_superadmin();
		}
		
		$data['admin_info'] = $this->m_admins->read($admin_id);
		if(empty($admin_id) || empty($data['admin_info'])){
			$this->session->set_flashdata('log', 'you reached an unidentified page');
			redirect($this->admin_link.'admin','refresh');
		}

		if(userdata('admin_id')!=1 && $admin_id != userdata('admin_id')){
			$this->session->set_flashdata('log', 'Access denied');
			redirect($this->admin_link.'admin','refresh');
		}

		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','validationEngine.jquery');
		
		$data['action'] = 'edit';
		$data['title'] = $this->title;
		$data['groups'] = array(
							array('label'=>'','title'=>'Select One Group'),
							array('label'=>'superadmin','title'=>'Superadmin'),
							array('label'=>'admin','title'=>'Admin'),
							array('label'=>'business','title'=>'Business'),
							);
		$this->load->view('backadmin/v_admin_form', $data);
	}

	function update_exec(){

		$admin_id = $this->input->post('admin_id');

		if($admin_id==1 ){
			$this->_only_superadmin();
		}

		if($admin_id != userdata('admin_id')){
			$this->session->set_flashdata('log', 'Access denied');
			redirect($this->admin_link.'admin','refresh');
		}
		
		$this->m_admins->update();
		redirect('backadmin/admin');
		
	}

	function delete(){
		$this->_only_superadmin();

		$admin_id = $this->uri->segment(4);

		$this->m_admins->delete($admin_id);
		redirect('backadmin/admin');

	}
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */