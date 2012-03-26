<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Hunters List';
	private $active = 'user';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Users';
		
		$this->load->library(array(
			'upload','image_lib','encrypt'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_blogs','m_projects','m_reviews','m_videos','m_posts','m_comments','m_likes','m_messages','m_threads'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

  	$this->load->vars(array('active'=>$this->active));
	}

	function index()
	{
		$data['add_css'] = array('backadmin/table');
		$data['add_js'] = array('notice');

		$this->load->library('pager');
		
		$limit =20;
		//if sort
		if($this->uri->segment(3)=='by'){
			$sort = $this->uri->segment(4);
			$order = $this->uri->segment(5);
			$data['order'] = $order;
			$data['sort'] = $sort;
			$page = $this->uri->segment(6,1);
			if(!empty($order)){
			$page = $this->uri->segment(7,1);
			}
			$index = ($page-1)*$limit;
			$config['base_url'] = $this->admin_link.'user/by/'.$sort.'/page/';
			if(!empty($order)){
			$config['base_url'] = $this->admin_link.'user/by/'.$sort.'/'.$order.'/page/';
			}
			$config['uri_segment'] = 6;
			if(!empty($order)){
			$config['uri_segment'] = 7;
			}
		//pagination
		}else{
			$sort = '';
			$order = 'asc';
			$data['order'] = $order;
			$data['sort'] = $sort;
			$page = $this->uri->segment(4,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = $this->admin_link.'user/page/';
			$config['uri_segment'] = 4;
		}

		if($sort=='total_posts'){
			$sort_by = 'total_posts';
		}elseif($sort=='user_name'){
			$sort_by = 'user_name';
		}elseif($sort=='join_date'){
			$sort_by = 'entry_date';
		}else{
			$sort_by = '';
		}
		$nb_users = $this->m_profiles->get_users(array('sort'=>$sort_by));

		$config['total_post'] = count($nb_users);
		$config['limit'] = $limit;

		$this->pager->initialize($config);

		$data['users'] = $this->m_profiles->get_users(array('sort'=>$sort_by,'order'=>$order,'index'=>$index,'limit'=>$limit,'include_all'=>true));
		#if($this->uri->segment(3)=='by'){
		#	$data['users'] = $this->m_profiles->get_users(array('sort'=>$sort,'order'=>$order));
		#}else{
		#	$data['users'] = $this->m_profiles->get_users();
		#}
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_user', $data);
	}

	function search()
	{
		$data['add_css'] = array('backadmin/table');
		$keyword = $this->input->post('keyword');
		if(empty($keyword)){
			redirect($this->admin_link.'user');
		}
		$data['users'] = $this->m_profiles->get_users(array('keyword'=>$keyword));
		
		$data['keyword'] = $keyword;
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_user', $data);
	}

	function update()
	{
		$account_id = $this->uri->segment(4);

		$data['add_js'] = array('jquery-ui-1.8.5.custom.min',);
		$data['add_css'] = array('jquery.ui/jquery-ui-1.8.5.custom');

		$data['title'] = $this->title.' | Update profile';
		$data['bio'] = $this->m_profiles->read_by_account_id($account_id);
		$this->load->view('backadmin/v_user_form', $data);
	}

	function update_exec()
	{
		$account_id = $this->input->post('account_id');
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
				redirect($this->admin_link.'user/update/'.$account_id);
			}
			else
			{
				//remove the previous image(?)
				$prev_image = $this->m_profiles->read_by_account_id($account_id);
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

				$data = array(
					'first_name' => $this->input->post('first_name'),
					'middle_name' => $this->input->post('middle_name'),
					'last_name' => $this->input->post('last_name'),
					'dob' => $this->input->post('dob'),
					'address' => htmlspecialchars($this->input->post('address')),
					'location' => $this->input->post('location'),
					'website' => $this->input->post('website'),
					'about_me' => htmlspecialchars($this->input->post('about_me')),
					'occupation' => $this->input->post('occupation'),
					'hobby' => $this->input->post('hobby'),
					'interest' => $this->input->post('interest')
				);
				if(!empty($image_data['upload_data'])){
					$data['photo'] = $image_data['upload_data']['file_name'];
				}

				$update = $this->m_profiles->update_by($account_id,$data);
			}
		}else{
			//if user doesn't upload an image, just update the database

			//update profile
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'middle_name' => $this->input->post('middle_name'),
				'last_name' => $this->input->post('last_name'),
				'dob' => $this->input->post('dob'),
				'address' => htmlspecialchars($this->input->post('address')),
				'location' => $this->input->post('location'),
				'website' => $this->input->post('website'),
				'about_me' => htmlspecialchars($this->input->post('about_me')),
				'occupation' => $this->input->post('occupation'),
				'hobby' => $this->input->post('hobby'),
				'interest' => $this->input->post('interest')
			);
			$this->m_profiles->update_by($account_id,$data);
		}
		redirect($this->admin_link.'user');

	}

	function delete()
	{
		$account_id = $this->uri->segment(4);
		if(!empty($account_id)){
			$this->m_accounts->delete($account_id);		
		}

		redirect($this->admin_link.'user');
	}

	function undelete()
	{
		$account_id = $this->uri->segment(4);
		if(!empty($account_id)){
			$this->m_accounts->undelete($account_id);		
		}

		redirect($this->admin_link.'user');
	}

}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */