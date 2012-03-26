<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Page List';
	private $active = 'config';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Site Configs';
		
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
		$data['add_js'] = array('jquery.jeditable','notice');

		$data['configs'] = $this->db->get('site_configs')->result();
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_config', $data);
	}

	function update()
	{

		//update the item POSTed
		$key = $this->input->post('id');
		$value = $this->input->post('value');

		$this->db->set('value',$value)->where('key',$key)->update('site_configs');
		$r = $this->db->where('key',$key)->get('site_configs')->row();

		echo $r->value;
	}

	
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */