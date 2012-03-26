<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Member_Controller {

	#private $title = 'Hunterdrop - Profile';
	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Profile';
		$this->load->library(array(
			'upload','image_lib','encrypt'
		));
		$this->load->model(array(
			'm_profiles','m_accounts'
		));
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

  	$this->load->vars(array('ql_active'=>'profile','page_css'=>array('contents')));
	}
	
	function index()
	{
		$data['title'] = $this->title;
		echo "load view profile";
	}
	
	function update()
	{
		$data['title'] = $this->title.' | Update profile';
		$data['bio'] = $this->m_profiles->read_by_account_id($this->session->userdata('user_id'));
		$this->load->view('member/v_member_profile', $data);
	}
	
	function update_exec()
	{
		//if user uploads an image
		if($_FILES['photo']['error'] == 0){
			//$new_post = $this->db->insert_id();

			//set the config to upload the files -> config/upload.php
			$config['upload_path'] = './assets/avatar/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '100';
			$config['max_width']  = '500';
			$config['max_height']  = '500';
			
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect('member/profile/update');
			}
			else
			{
				//remove the previous image(?)
				$prev_image = $this->m_profiles->get_avatar();
				if(is_file('assets/avatar/'.$prev_image->photo)){
					unlink('assets/avatar/'.$prev_image->photo);
				}

				$image_data = array('upload_data' => $this->upload->data());
				
				$path = './assets/avatar/';
				$config['source_image'] =  $path.$image_data['upload_data']['file_name'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 150;
				#$config['height'] = 150;
				$config['create_thumb'] = FALSE;
				//$config['new_image'] = $path.;

				$this->image_lib->initialize($config); 
				if ( ! $this->image_lib->resize())
				{
					// an error occured
				}

				$update = $this->m_profiles->update($image_data['upload_data']);
				redirect('member/profile/update');
			}
		}else{
			//if user doesn't upload an image, just update the database

			//update profile
			$this->m_profiles->update();
			redirect('member');
		}

	}

	function ajax_user_check_exclude_self()
	{

		/* RECEIVE VALUE */
		$validateValue= $this->input->get('fieldValue');
		$validateId= $this->input->get('fieldId');

		$validateError= "This username is already taken";
		$validateSuccess= "This username is available";

		/* RETURN VALUE */
		$arrayToJs = array();
		$arrayToJs[0] = $validateId;

		$user_exist = $this->m_accounts->ajax_check_exclude_self($validateValue);

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

	function setting()
	{
		$data['title'] = $this->title.' | Change Account Setting';
		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		$data['add_css'] = array('validationEngine.jquery');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
		
		$this->load->view('member/v_member_setting', $data);
	}

	function setting_update_exec()
	{
		#if user just logins via fb, change the rules a bit
		if($this->session->userdata('from_fb')){ 
			//check if users fill in empty form
			if( ($this->input->post('new_password')) && ($this->input->post('confirm_password')) ){

				//check length of new password
				if(strlen($this->input->post('new_password'))<6 || strlen($this->input->post('confirm_password'))<6 ){
					$this->session->set_flashdata('log','Your new password must be at least 6 characters!');
					redirect('member/profile/setting');
				}

				//check if new password is the same as confirm password
				if($this->input->post('new_password') == $this->input->post('confirm_password') ){
					$this->m_accounts->change_pass();
					$this->session->set_flashdata('log','Your password has been changed!');

					#here's the difference, after saving the username and password, REMOVE the session data from_fb
					$this->session->set_userdata('from_fb','');

					redirect('member');
				}else{
					$this->session->set_flashdata('log','Your didn\'t confirm your new password!');
					redirect('member/profile/setting');
				}	
			}else{
				$this->session->set_flashdata('log','You didn\'t input any password!');
				redirect('member/profile/setting');		
			}

		}else{
		#user change settings	

			//check if users fill in empty form
			if(($this->input->post('old_password')) && ($this->input->post('new_password')) && ($this->input->post('confirm_password')) ){
				
				//check if old password is correct
				$acc = $this->m_accounts->read($this->session->userdata('user_id'));
				if($this->encrypt->sha1($this->input->post('old_password') . $acc->hash) != $acc->pass){
					#echo "old password wrong";
					$this->session->set_flashdata('log','Your old password is incorrect!');
					redirect('member/profile/setting');	
				}

				//check length of new password
				if(strlen($this->input->post('new_password'))<6 || strlen($this->input->post('confirm_password'))<6 ){
					$this->session->set_flashdata('log','Your new password must be at least 6 characters!');
					redirect('member/profile/setting');
				}

				//check if new password is the same as confirm password
				if($this->input->post('new_password') == $this->input->post('confirm_password') ){
					$this->m_accounts->change_pass();
					$this->session->set_flashdata('log','Your account has been changed!');
					redirect('member/profile/setting');
				}else{
					$this->session->set_flashdata('log','Your didn\'t confirm your new password!');
					redirect('member/profile/setting');
				}	
			}else{
				$this->session->set_flashdata('log','You didn\'t input any password!');
				redirect('member/profile/setting');		
			}

		}

	}
	
//	function delete()
//	{
//		$id = $this->uri->segment(3);
//		
//		//delete review
//		$this->m_reviews->delete($id);
//		
//		//delete post, delete(type_id, ref_id)
//		$this->m_posts->delete_by_type_ref(1, $id); //type_id:1 = review
//	}

}

/* End of file review.php */
/* Location: ./system/application/controllers/review.php */