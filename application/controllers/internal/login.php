<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin';
	
	private $active = 'dashboard';

	function __construct()
	{
		parent::__construct();
		
		$this->load->library(array(
			'encrypt'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_admins'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

      	$this->load->vars(array('active'=>$this->active));
	}

	function index()
	{
		if(userdata('admin_logged_in')){
			redirect($this->admin_link.'dashboard');
		}
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_login', $data);
	}

	function login_exec()
	{
		/*$user_name = $this->input->post('user_name');
		$pass = $this->input->post('pass');

		$this->db->where('user_name', $user_name);
		$this->db->where('pass', sha1($pass));
		$q = $this->db->get('admins');
		$r = $q->row();*/
		$r = $this->m_admins->do_login();

		if(!empty($r)){
			
			//create login log
			$ourfile = $this->config->item('doc_root').'_log/backadmin.log';
			if(!is_file($ourfile)){
				$fh = fopen($ourfile,"w");
			}
			$fh = fopen($ourfile,"a");
			$myTime = date("l, d M Y - h:i");
			$log = "$r->user_name - group : ".$r->user_group." - login at : $myTime \r\n";
			fwrite($fh,$log);
			fclose($fh);
			//end log
			
			$this->session->set_userdata(array(
#				'token' => $a,
				'admin_id' => $r->ID,
				'admin_user_name' => $r->user_name,
				'admin_group' => $r->user_group,
#				'email' => $r->email,
				'admin_logged_in' => TRUE
			));
			
			redirect('backadmin/dashboard');
			
			
		}else{
			$this->session->set_flashdata('log', 'Authentication error! Access denied.');
			redirect('backadmin/login');
		}
	}

	function logout()
	{
		$data = array(
			'admin_id' => '',
			'admin_user_name' => '',
			'admin_group' => '',
#			'email' => '',
			'admin_logged_in' => FALSE,
#			'fb_profile' => ''
		);
		$this->session->set_userdata($data);
		$this->session->sess_destroy();
		$this->session->set_flashdata('log', 'Logged out');
		
		redirect('backadmin/login');
	}

}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */