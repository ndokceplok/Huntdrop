<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Public_Controller {

	#private $title = 'Hunterdrop - Account';

	function __construct(){
		parent::__construct();
		#$this->title = $this->title.' - Account';
		$this->load->library(array(
			'encrypt','image_lib'
		));		
		$this->load->model(array(
			'm_accounts','m_profiles'
		));
		
		include('includes/fb_info.php');
	}

	function index()
	{
		redirect('account/login');
	}
	
	function forgot_password(){
		if($this->session->userdata('logged_in')){
			redirect('member');
		}

		$data['title'] = $this->title;
		$this->load->view('v_account_forgot_password', $data);
		
	}

	function forgot_password_exec(){
		if($this->session->userdata('logged_in')){
			redirect('member');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('log',form_error('email'));
			redirect('account/forgot_password');
		}
		else
		{
			//get the email
			$email = $this->input->post('email');
			//get user_info
			$account_info = $this->m_accounts->read_by('email',$email);

			//i'm a lazy bastard, i don't use model
			//check in table password_changes for account_id
			$q = $this->db->where('account_id',$account_info->ID)
						->get('password_change_requests');
			#account id exists in table, remove it!
			if($q->num_rows()>0){
				$r = $q->row();
				$this->db->where('ID', $r->ID)
						->delete('password_change_requests');
			}

			//store in table password_changes
			$p = array( 
					'ID' => $this->encrypt->sha1( $email.time()) ,
					'time' => date("Y-m-d H:i:s"),
					'account_id' => $account_info->ID
					);
			
			$this->db->insert('password_change_requests',$p);

			$q = $this->db->where('account_id',$account_info->ID)
						->get('password_change_requests');
			if($q->num_rows()>0){
				$r = $q->row();
				//send email with link to change the password
				$account = $this->m_accounts->read($r->account_id);

				$subject = "Reset Your Password";
				$message = "Hello, ".$account->user_name."! \r\n\r\n";
				$message.= "We have received your request to change your password. Please click the link below to reset your password. \r\n\r\n";
				$message.= base_url().'account/reset_password/'. $r->ID ."\r\n\r\n";
				$message.= "If you didn't request to change your password, please ignore this email.  \r\n\r\n";
				$send = sendmail(array('to'=>$account->email,'subject'=>$subject,'message'=>$message));
				if($send=="error"){
					$this->session->set_flashdata('log','Failed to send reset password email. Please try again later');
				}else{
					$this->session->set_flashdata('log','We have sent you an email to reset your password');					
				}
				redirect('account/login');
			}

		}

	}

	function reset_password($hash=''){
		if(empty($hash)){
			#no hash no change password
			$this->session->set_flashdata('log','You have the invalid link to reset password');
			redirect('account/forgot_password');
		}else{
			$q = $this->db->where('ID',$hash)
						->get('password_change_requests');
			if($q->num_rows()==0){
				#invalid hash
				$this->session->set_flashdata('log','You have the invalid link to reset password');
				redirect('account/forgot_password');

			}else{
				
				#check for time. link should be invalid if the time is more than 1 day (TO BE DEVELOPED)

				$data['hash'] = $hash;
				$data['title'] = $this->title;
				$this->load->view('v_account_reset_password', $data);

			}
			
		}

		
	}

	function reset_password_exec(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('log',validation_errors());
			redirect('account/reset_password/'.$this->input->post('hash'));
		}
		else
		{
			$q = $this->db->where('ID',$this->input->post('hash'))
						->get('password_change_requests');
			if($q->num_rows()>0){
				$r = $q->row();

				$this->m_accounts->reset_pass($r->account_id);

				#remove the data from password_change_requests so the link will be invalid next time
				$this->db->where('ID', $this->input->post('hash') )
						->delete('password_change_requests');

				$this->session->set_flashdata('log','Your password has been changed! You can now login with your new password!');
				redirect('account/login');
				
				//send new password email ?
			}
		}

	}


	function register()
	{
		if($this->session->userdata('logged_in')){
			redirect('member');
		}
		$data['title'] = $this->title;

		$login_url = $this->facebook->getLoginUrl(array(  
			'scope' => 'email,publish_stream,read_stream,user_birthday'
		));
		$data['login_url'] = $login_url;
		
		$user = null;
		$user_profile = null;

		$user = $this->facebook->getUser();

		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $this->facebook->api('/me?fields=id,name,username,link,email,first_name,last_name,birthday');
				$this->session->set_userdata('fb_profile', $user_profile);
				redirect('account/login_facebook');
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
				$this->session->set_flashdata('log', $e);
				redirect('account', 'refresh');
			}
		} else {
			$data['add_css'] = array('validationEngine.jquery');
			$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
			$this->load->view('v_account_register', $data);
		}
	}
	
	function register_exec()
	{
		if( ! $this->_reg_exist()) {
			
			if($this->input->post('user_name')!=''){
				$id = $this->m_accounts->create();
				
				//create entry for table profiles
				$this->m_profiles->create($id);
				
				//send verification email
				$this->send_welcome_email($id);
				$this->session->set_flashdata('log','We have sent an email to you, please verify your account to login');
				redirect('account/login');
			}else{
				redirect('/account/register');
			}
		} else {
			echo 'User data already used by someone else';
		}
	}

	function send_verification_email($id){
		$account = $this->m_accounts->read($id);

		#echo 'verify your account '. anchor('account/verify/'. $account->hash, 'here');
		$subject = "Verify your account";
		$message = "Please verify your account by clicking the link below \r\n";
		$message.= base_url().'account/verify/'. $account->hash;
		sendmail(array('to'=>$account->email,'subject'=>$subject,'message'=>$message));
		
	}

	function send_welcome_email($id){
		$account = $this->m_accounts->read($id);

		$subject = "Welcome to Huntdrop";
		$message = "Thank you for joining Huntdrop! \r\n\r\n";
		$message.= "Please verify your account by clicking the link below \r\n\r\n";
		$message.= base_url().'account/verify/'. $account->hash;
		sendmail(array('to'=>$account->email,'subject'=>$subject,'message'=>$message));
		
	}


	private function _reg_exist()
	{
		$data = array(
			'user_name' => $this->input->post('user_name'),
			'email' => $this->input->post('email')
			//'nid' => $this->input->post('nid') //needs review
		);

		//print_r($data);
		return $this->m_accounts->check($data);
	}
	
	function verify()
	{
		$hash = $this->uri->segment(3);
		if($this->m_accounts->check(array('hash' => $hash))) {
			$this->m_accounts->verify($hash);
			$this->session->set_flashdata('log','Your account has been verified, you can login now');
			#echo 'Your account has been verified, you can login '. anchor('account/login', 'here') ;
			#email user of his username and password
			#$this->send_welcome_email();
		} else {
			$this->session->set_flashdata('log','Your verification key is invalid!');
			#echo 'Your verification key is invalid!';
		}
		redirect('account/login');
	}

	function ajax_check()
	{
		$field = $this->input->get('fieldId');
		$value = $this->input->get('fieldValue');
		$data = array();

		if($this->m_accounts->check(array($field => $value))) {
			$data[] = $this->input->get('fieldId');
			$data[] = FALSE;
		} else {
			$data[] = $this->input->get('fieldId');
			$data[] = TRUE;
		}
		echo json_encode($data);
	}

	function login()
	{
		if($this->session->userdata('logged_in')){
			redirect('member');
		}
		$data['title'] = $this->title;
		
		//$login_url = $this->facebook->getLoginUrl();
		$login_url = $this->facebook->getLoginUrl(array(  
			'scope' => 'email,publish_stream,read_stream,user_birthday'
		));
		$data['login_url'] = $login_url;
		
		$user = null;
		$user_profile = null;

		$user = $this->facebook->getUser();

		if($this->input->get('error')=='access_denied'){
			$this->session->set_flashdata('log','Sorry, we can\'t sign you up if you don\'t allow us to access your Facebook data');
			redirect('account/login', 'refresh');
			#$data['error_log'] = '';
		}

		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $this->facebook->api('/me?fields=id,name,username,link,email,first_name,last_name,birthday');
				$this->session->set_userdata('fb_profile', $user_profile);
				redirect('account/login_facebook');
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
				$this->session->set_flashdata('log', $e);
				redirect('account', 'refresh');
			}
		} else {
			$this->load->view('v_account_login', $data);
		}
	}
	
	function login_facebook()
	{	
		//check if fb_profile->email exist in database
		$user_profile = $this->session->userdata('fb_profile');
		
		$check = $this->m_accounts->check(array('email' => $user_profile['email']));
		if($check) {
			$this->db->where('email', $user_profile['email']);
			$this->db->where('status', 1);
			$q = $this->db->get('accounts');
			$r = $q->row();
			if(empty($r->fb_uid)) {
				$this->db->set('fb_uid', $user_profile['id']);
				$this->db->where('email', $user_profile['email']);
				$this->db->update('accounts');
			}

			#update prof pic with FB prof pic
			$path = './assets/avatar/';
			#remove prev image
			$rr = $this->m_profiles->read_by('account_id',$r->ID);
			$prev_image = $path.$rr[0]->photo;
			if(is_file($prev_image)){
				unlink($prev_image);
			}

			#get user facebook picture
			$filename = time().'.jpg';
			file_put_contents($path.$filename,file_get_contents('https://graph.facebook.com/'.$user_profile['username'].'/picture?type=large'));

			//resize the image;
			$config['source_image'] =  $path.$filename;
			$config['width'] = 150;
			#$config['height'] = 100;
			$config['create_thumb'] = FALSE;
			//$config['new_image'] = $path.;

			$this->image_lib->initialize($config); 
			if ( ! $this->image_lib->resize())
			{
				// an error occured
			}
			//update photo in profiles
			$this->db->set('photo', $filename);
			$this->db->where('account_id', $r->ID);
			$this->db->update('profiles');

			if(empty($r->hash) && empty($r->pass)){
			#set session data to recognize the users register from fb connect
			$this->session->set_userdata('from_fb',true);
			}
		} else {
			#if if fb_profile->email is not exist, store data to database using fb_profile->email
			#get user facebook picture
			$path = './assets/avatar/';
			$filename = time().'.jpg';
			file_put_contents($path.$filename,file_get_contents('https://graph.facebook.com/'.$user_profile['username'].'/picture?type=large'));

			//resize the image;
			$config['source_image'] =  $path.$filename;
			$config['width'] = 100;
			#$config['height'] = 100;
			$config['create_thumb'] = FALSE;
			//$config['new_image'] = $path.;

			$this->image_lib->initialize($config); 
			if ( ! $this->image_lib->resize())
			{
				// an error occured
			}

			#$hash = $this->encrypt->sha1(time());
			#$gen_pass = generate_password();
			$data = array(
				'user_name' => str_replace('.','-',$user_profile['username']),
				'fb_uid' => $user_profile['id'],
				'user_group' => 'member',
				'email' => $user_profile['email'],
				'status' => 1,
			#	'hash' => $hash,
			#	'pass' => $this->encrypt->sha1($gen_pass . $hash),
				'entry_date' => date('Y-m-d H:i:s')
			);
			$this->db->insert('accounts', $data);
			$id = $this->db->insert_id();
			


			//insert into profiles
			$this->db->insert('profiles', array(
				'account_id' => $id,
				'first_name' => $user_profile['first_name'],
				'last_name' => $user_profile['last_name'],
				'photo'	=> $filename,
				#'dob' => $user_profile['birthday'],
				'member_since' => date('Y-m-d H:i:s')
			));

			#set session data to recognize the users register from fb connect
			$this->session->set_userdata('from_fb',true);

			#email user of his username and password
			#$this->send_welcome_email();
		}
		
		$this->db->where('email', $user_profile['email']);
		$this->db->where('status', 1);
		$q = $this->db->get('accounts');
		$r = $q->row();

		$this->db->set('is_online', 1);
		$this->db->set('last_active', date('Y-m-d H:i:s'));
		$this->db->where('ID', $r->ID);
		$this->db->update('accounts');
		
		$this->session->set_userdata(array(
			'user_id' => $r->ID,
			'user_name' => $r->user_name,
			'user_group' => $r->user_group,
			'email' => $r->email,
			'logged_in' => TRUE
		));
		
		#$this->session->set_flashdata('notif','Your password is '.$gen_pass.' . Please change it to your liking ');
		#redirect('member');
		#$this->session->set_flashdata('log','Your password is '.$gen_pass.' . Please change it to your liking!');
		if($this->session->userdata('from_fb')){
		redirect('member/profile/setting');
		}else{
		redirect('member');
		}
		/*
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
		*/
		
		/*
		echo '<pre>';
		print_r($_COOKIE);
		echo '</pre>';
		*/
	}

	function login_exec()
	{
		$user_name = $this->input->post('user_name');
		$pass = $this->input->post('pass');

		$this->db->where('user_name', $user_name);
		$this->db->where('status', 1);
		$q = $this->db->get('accounts');
		$r = $q->row();

		if(empty($r)){
			$this->session->set_flashdata('log', 'Authentication error! Access denied.');
			redirect('account/login');			
		}
		
		$real_pass = $this->encrypt->sha1($pass . $r->hash); 

		if($real_pass == $r->pass) {

			$this->db->set('is_online', 1);
			$this->db->set('last_active', date('Y-m-d H:i:s'));
			$this->db->where('ID', $r->ID);
			$this->db->update('accounts');

			$this->session->set_userdata(array(
				'user_id' => $r->ID,
				'user_name' => $r->user_name,
				'user_group' => $r->user_group,
				'email' => $r->email,
				'logged_in' => TRUE
			));
			
			//update accounts and profiles last login
			$now = date('Y-m-d H:i:s');
			$this->m_accounts->update_last_login($this->session->userdata('user_id'), $now);
			
			//store permission to userdata as array

			//check request uri

			//update last_login in accounts and profiles table


			//redirect to http_referer if available
			//redirect($this->session->flashdata('ref'));
			
			$this->session->set_flashdata('log', 'Access granted');
			
			//check user_group, redirect to dir
			
			redirect('member');

		} else {
			$this->session->set_flashdata('log', 'Authentication error! Access denied.');
			redirect('account/login');
		}
	}

	function logout()
	{
		$this->db->set('is_online', 0);
		$this->db->where('ID', $this->session->userdata('user_id'));
		$this->db->update('accounts');

		$data = array(
			'user_id' => '',
			'user_name' => '',
			'user_group' => '',
			'email' => '',
			'logged_in' => FALSE,
			'fb_profile' => ''
		);
		$this->session->set_userdata($data);
		$this->session->sess_destroy();
		$this->session->set_flashdata('log', 'Logged out');

		
		redirect('account/login');
	}
	
	function logout_facebook()
	{
		$this->db->set('is_online', 0);
		$this->db->where('ID', $this->session->userdata('user_id'));
		$this->db->update('accounts');

		$data = array(
			'user_id' => '',
			'user_name' => '',
			'user_group' => '',
			'email' => '',
			'logged_in' => FALSE,
			'fb_profile' => ''
		);
		$this->session->set_userdata($data);
		$this->session->sess_destroy();
		$this->session->set_flashdata('log', 'Logged out');
		
		$logout_url = $this->facebook->getLogoutUrl(array('next' => base_url() .''));
		redirect($logout_url);
	
		//echo $logout_url = $this->facebook->getLogoutUrl(array('next' => base_url() .'account/login'));
		//redirect($logout_url);
	}


	function ajax_user_check()
	{

		/* RECEIVE VALUE */
		$validateValue= $this->input->get('fieldValue');
		$validateId= $this->input->get('fieldId');

		$validateError= "This username is already taken";
		$validateSuccess= "This username is available";

		/* RETURN VALUE */
		$arrayToJs = array();
		$arrayToJs[0] = $validateId;

		$user_exist = $this->m_accounts->ajax_read_by('user_name',$validateValue);

		if(count($user_exist)==0){		// user doesn't exist
			$arrayToJs[1] = true;			// RETURN TRUE
			echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
		}else{
			for($x=0;$x<1000000;$x++){
				if($x == 990000){
					$arrayToJs[1] = false;
					echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
				}
			}
			
		}
	}

	function ajax_email_check()
	{

		/* RECEIVE VALUE */
		$validateValue= $this->input->get('fieldValue');
		$validateId= $this->input->get('fieldId');

		$validateError= "This email is already taken";
		$validateSuccess= "This email is available";

		/* RETURN VALUE */
		$arrayToJs = array();
		$arrayToJs[0] = $validateId;

		$user_exist = $this->m_accounts->ajax_read_by('email',$validateValue);

		if(count($user_exist)==0){		// user doesn't exist
			$arrayToJs[1] = true;			// RETURN TRUE
			echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
		}else{
			for($x=0;$x<1000000;$x++){
				if($x == 990000){
					$arrayToJs[1] = false;
					echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
				}
			}
			
		}
	}

}

/* End of file account.php */
/* Location: ./application/controllers/account.php */