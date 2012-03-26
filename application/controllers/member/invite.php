<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invite extends Member_Controller {
	
	#private $title = 'Hunterdrop - Invite Your Friends';
	private $active = 'dashboard';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Invite Your Friends';
		
		$this->load->library(array(
			'encrypt','upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_blogs','m_projects','m_reviews','m_posts'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

      	$this->load->vars(array('active'=>$this->active,'page_css'=>array('contents')));
	}

	// private function _auth()
	// {
	// 	if( $this->session->userdata('logged_in') != TRUE) {
	// 		$this->session->set_flashdata('ref', uri_string());
	// 		$this->session->set_flashdata('log', 'you are not authorized to access admin area');
	// 		redirect('account/login');
	// 	}
	// }
	
	function index()
	{
		$data['title'] = $this->title;

		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['posts'] = $this->m_posts->get_user_posts($data['account']->ID);
		$data['total_posts'] = count($data['posts']);

		$data['blogs'] = $this->m_posts->get_user_blogs($data['account']->ID,'desc');
		$data['projects'] = $this->m_posts->get_user_projects($data['account']->ID,'desc');
		$data['reviews'] = $this->m_posts->get_user_reviews($data['account']->ID,'desc');

		$this->load->view('member/v_member_invite', $data);
	}

	function send()
	{
		$account = $this->m_accounts->read($this->session->userdata('user_id'));

		$emails = $this->input->post('email');
			if(!empty($emails)){
				$to = $bcc = '';
				$emails_r = explode(",",$emails);
				$valid_emails = array();

				//filter the valid emails
				foreach($emails_r as $r){
					$r = trim($r);
					$this->load->library('form_validation');
					if($this->form_validation->valid_email($r)){
						$valid_emails[] = $r;
					}
				}

				if(empty($valid_emails)){
					$e = 'The email address you input is invalid.';
					$this->session->set_flashdata('log', array('msg'=>$e));					
					redirect('member/invite', 'refresh');
				}

				//first one goes to $to, others go to $bcc
				foreach($valid_emails as $key=>$r){
					$r = trim($r);
					if($key==0){ $to = $r;}
					else{
						if($key>1) $bcc.= ',';
						$bcc.= $r;				
					}
					
				}

				//send email to $to
				$subject = "[HuntDrop] Invitation from ".$account->user_name ;
				$message = "Hello, \n\n";
				$message.= "your friend ".$account->user_name." wants you to join them over at HuntDrop.com \n\n";
				$message.= "Just click the link below and create your free account at HuntDrop:\n";
				$message.= "http://www.huntdrop.com/account/register \n\n";
				$message.= "Hope to see you soon! \n\n";

				$message.= "-- HuntDrop \r\n";
				$message.= "http://www.huntdrop.com \n\n";

				$message.= "P.S. If you're not interested in joining HuntDrop, just ignore this email. \n\n";
				
				//echo $message;
				//mail($to, $subject, $message, "From: ".$account->email);
				$send_config = array('to'=>$to,'subject'=>$subject,'message'=>$message);
				if(!empty($bcc)){
					$send_config['bcc'] = $bcc;
				}
				$send = sendmail($send_config);
				$e = 'We have sent invitation emails to your friends';
				$this->session->set_flashdata('log', array('msg'=>$e,'type'=>'success'));
				redirect('member/invite', 'refresh');
				
			}else{
				
				$e = 'You must provide at least one email address.';
				$this->session->set_flashdata('log', array('msg'=>$e));
				redirect('member/invite', 'refresh');
			}
		
	}
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */