<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	private $title = 'Hunterdrop - Member';

	function __construct()
	{
		parent::__construct();
		
		$this->load->library(array(
			'encrypt','upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_blogs','m_projects'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));
	}

	private function _auth()
	{
		if( $this->session->userdata('logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access admin area');
			redirect('account/login');
		}
	}
	
	function index()
	{
		$this->_auth();
		$data['title'] = $this->title.' Dashboard';
		$this->load->view('member/v_member_dashboard', $data);
	}

//	function profile()
//	{
//		$action = $this->uri->segment(3);
//		if($action == "edit"){
//			$this->_auth();
//			$data['title'] = $this->title.' Update profile';
//			$data['bio'] = $this->m_profiles->read_by_account_id($this->session->userdata('user_id'));
//		
//			$this->load->view('member/v_member_profile', $data);
//		}else{
//			echo "load view profile";
//		}
//	}

//	function profile_update_exec()
//	{
//		$this->_auth();
//		//Validation here
//		
//		$this->m_profiles->update();
//		redirect('member/profile/edit');
//	}

//	function blog()
//	{
//		$this->_auth();
//		$action = $this->uri->segment(3);
//		
//		if(empty($action)){
//			$data['title'] = $this->title.' Blogs';
//			$c = $this->m_blogs->count_user_blog($this->session->userdata('user_id'));
//			if($c>0){
//			$data['blog_list'] = $this->m_blogs->get_user_blog($this->session->userdata('user_id'));
//			}
//			$this->load->view('member/v_member_blog', $data);
//			
//		}elseif($action == "add"){
//			$data['title'] = $this->title.' Add a Blog';
//			$data['action'] = 'add';
//			$data['blog_series'] = $this->m_blogs->get_blog_series($this->session->userdata('user_id'));
//			$this->load->view('member/v_member_blog_form', $data);
//		}elseif($action == "edit"){
//			$blog_id = $this->uri->segment(4);
//			$data['title'] = $this->title.' Edit Blog';
//			$data['action'] = 'edit';
//			$data['blog_info'] = $this->m_blogs->read($blog_id);
//			$data['blog_photo'] = $this->m_blogs->get_blog_photo($blog_id);
//			$data['blog_series'] = $this->m_blogs->get_blog_series($this->session->userdata('user_id'));
//
//			$this->load->view('member/v_member_blog_form', $data);
//		}elseif($action == "delete"){
//			$blog_id = $this->uri->segment(4);
//
//			$delete = $this->m_blogs->delete($blog_id);
//
//			if($delete){
//				redirect('member/blog');
//			}else{
//				echo "go to hell";	
//			}
//		}
//	}
//
//	function blog_add_exec()
//	{
//		$this->_auth();
//		//Validate Here to prevent empty form submission
//		
//		//if user uploads an image
//		if($_FILES['photo']['error'] == 0){
//			//$new_post = $this->db->insert_id();
//
//			//set the config to upload the files -> config/upload.php
//	
//			if ( ! $this->upload->do_upload('photo'))
//			{
//				$a = array('error' => $this->upload->display_errors());
//				$this->session->set_flashdata('log', $a['error']);
//				redirect('member/blog/add');
//			}
//			else
//			{
//				$image_data = array('upload_data' => $this->upload->data());
//				$a = $this->m_blogs->create($this->session->userdata('user_id'),$image_data['upload_data']);
//				redirect('member/blog');
//			}
//		}else{
//			//if user doesn't upload an image, just insert to database
//			$a = $this->m_blogs->create($this->session->userdata('user_id'));
//			redirect('member/blog');
//		}
//
//		//		$a = $this->m_blogs->create($this->session->userdata('user_id'));
//		//		if(isset($a)){
//		//			$this->session->set_flashdata('log', $a['error']);
//		//			echo $a['error'];
//		//		}else{
//		//		redirect('member/blog');
//		//		}
//	}
//
//	function blog_update_exec()
//	{
//		$this->_auth();
//		//Validate Here to prevent empty form submission
//		
//		//if user uploads an image
//		if($_FILES['photo']['error'] == 0){
//			//$new_post = $this->db->insert_id();
//
//			//set the config to upload the files -> config/upload.php
//	
//			if ( ! $this->upload->do_upload('photo'))
//			{
//				$a = array('error' => $this->upload->display_errors());
//				$this->session->set_flashdata('log', $a['error']);
//				redirect('member/blog/edit/'.$this->input->post('blog_id'));
//			}
//			else
//			{
//				$image_data = array('upload_data' => $this->upload->data());
//				$update = $this->m_blogs->update($image_data['upload_data']);
//				if($update){
//					redirect('member/blog');
//				}else{
//					echo "go to hell";	
//				}
//			}
//		}else{
//			//if user doesn't upload an image, just insert to database
//			$update = $this->m_blogs->update();
//			if($update){
//				redirect('member/blog');
//			}else{
//				echo "go to hell";	
//			}
//		}
//	}
//
//	function blog_add_series_exec()
//	{
//		$this->_auth();
//		//Validate Here to prevent empty form submission
//		
//		$res = $this->m_blogs->create_series($this->session->userdata('user_id'));
//		if($res){
//			$data = array(
//				'id' => $res->ID,
//				'name' => $res->series_name
//			);
//			echo json_encode($data);
//		}else{
//			echo "0";	
//		}
//	}
	
//	function review()
//	{
//		$this->_auth();
//		$data['title'] = $this->title . ', review';
//		$this->load->view('member/v_member_review');
//	}


//	function project()
//	{
//		$this->_auth();
//		$action = $this->uri->segment(3);
//
//		if(empty($action)){
//			$data['title'] = $this->title.' Projects';
//			$c = $this->m_projects->count_user_project($this->session->userdata('user_id'));
//			if($c>0){
//			$data['project_list'] = $this->m_projects->get_user_project($this->session->userdata('user_id'));
//			}
//			$this->load->view('member/v_member_project', $data);
//			
//		}elseif($action == "add"){
//			$data['title'] = $this->title.' Add a Project';
//			$data['action'] = 'add';
//			//$data['blog_series'] = $this->m_blogs->get_blog_series($this->session->userdata('user_id'));
//			$this->load->view('member/v_member_project_form', $data);
//		}elseif($action == "edit"){
//			$project_id = $this->uri->segment(4);
//			$data['title'] = $this->title.' Edit Project';
//			$data['action'] = 'edit';
//			$data['project_info'] = $this->m_projects->read($project_id);
//			$data['project_photo'] = $this->m_projects->get_project_photo($project_id);
//			//$data['blog_series'] = $this->m_blogs->get_blog_series($this->session->userdata('user_id'));
//
//			$this->load->view('member/v_member_project_form', $data);
//		}elseif($action == "delete"){
//			$project_id = $this->uri->segment(4);
//
//			$delete = $this->m_projects->delete($project_id);
//
//			if($delete){
//				redirect('member/project');
//			}else{
//				echo "go to hell";	
//			}
//		}
//	}
//
//	function project_add_exec()
//	{
//		$this->_auth();
//		//Validate Here to prevent empty form submission
//		
//		//if user uploads an image
//		if($_FILES['photo']['error'] == 0){
//			//$new_post = $this->db->insert_id();
//
//			//set the config to upload the files -> config/upload.php
//	
//			if ( ! $this->upload->do_upload('photo'))
//			{
//				$a = array('error' => $this->upload->display_errors());
//				$this->session->set_flashdata('log', $a['error']);
//				redirect('member/project/add');
//			}
//			else
//			{
//				$image_data = array('upload_data' => $this->upload->data());
//				$a = $this->m_projects->create($this->session->userdata('user_id'),$image_data['upload_data']);
//				redirect('member/project');
//			}
//		}else{
//			//if user doesn't upload an image, just insert to database
//			$a = $this->m_projects->create($this->session->userdata('user_id'));
//			redirect('member/project');
//		}
//
//		//		$a = $this->m_projects->create($this->session->userdata('user_id'));
//		//		if(isset($a)){
//		//			$this->session->set_flashdata('log', $a['error']);
//		//			echo $a['error'];
//		//		}else{
//		//		redirect('member/project');
//		//		}
//	}
//
//	function project_update_exec()
//	{
//		$this->_auth();
//		//Validate Here to prevent empty form submission
//		
//		//if user uploads an image
//		if($_FILES['photo']['error'] == 0){
//			//$new_post = $this->db->insert_id();
//
//			//set the config to upload the files -> config/upload.php
//	
//			if ( ! $this->upload->do_upload('photo'))
//			{
//				$a = array('error' => $this->upload->display_errors());
//				$this->session->set_flashdata('log', $a['error']);
//				redirect('member/project/edit/'.$this->input->post('project_id'));
//			}
//			else
//			{
//				$image_data = array('upload_data' => $this->upload->data());
//				$update = $this->m_projects->update($image_data['upload_data']);
//				if($update){
//					redirect('member/project');
//				}else{
//					echo "go to hell";	
//				}
//			}
//		}else{
//			//if user doesn't upload an image, just insert to database
//			$update = $this->m_projects->update();
//			if($update){
//				redirect('member/project');
//			}else{
//				echo "go to hell";	
//			}
//		}
//	}

}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */