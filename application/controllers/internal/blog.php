<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Blogs List';
	private $active = 'blog';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Blogs List';
		
		$this->load->library(array(
			'upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_blogs','m_posts','m_tags','m_photos'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
		));

  	$this->load->vars(array('active'=>$this->active));
	}

	function index()
	{

		$data['add_css'] = array('backadmin/table');
		$data['add_js'] = array('notice');

		$this->load->library('pager');
		
		$limit =10;
		$sort = 'latest';
		$data['sort'] = $sort;
		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$config['base_url'] = $this->admin_link.'blog/page/';
		$config['uri_segment'] = 4;

		$sort_by = '';
		$nb_blogs = $this->m_blogs->get_blog('',array('sort'=>$sort_by));
		$config['total_post'] = count($nb_blogs);
		$config['limit'] = $limit;
		$this->pager->initialize($config);

		$data['blogs'] = $this->m_blogs->get_blog('',array('sort'=>$sort_by,'index'=>$index,'limit'=>$limit,'admin'=>TRUE));

		#$data['blogs'] = $this->m_blogs->get_blog();
		
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_blog', $data);
	}

	function update()
	{

		$blog_id = $this->uri->segment(4);

		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery','backadmin/table');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');
		
		$data['action'] = 'edit';
		$data['title'] = $this->title;
		$data['blog_info'] = $this->m_blogs->get_blog($blog_id,array('admin'=>TRUE));
		$data['blog_photo'] = $this->m_photos->read($data['blog_info']->post_id); 
		$data['blog_series'] = $this->m_blogs->get_blog_series();
		$tags = $this->m_tags->read($data['blog_info']->post_id); 
		$data['tags'] ='';
		$i = 1;
		foreach($tags as $r){
			if($i>1){
				$data['tags']  .= ", ";
			}
			$data['tags']  .= $r->name;
			$i++;
		}

		$this->load->view('backadmin/v_blog_form', $data);
	}

	function update_exec()
	{
		//if user uploads an image
		if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
			//$new_post = $this->db->insert_id();

			//set the config to upload the files -> config/upload.php
	
			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect($this->admin_link.'blog/update/'.$this->input->post('blog_id'));
			}
			else
			{
				$image_data = array('upload_data' => $this->upload->data());
				//update blogs
				$update = $this->m_blogs->update();

				//update post
				$this->m_posts->update();
		
				//update tags
				$post = $this->m_posts->get_post_by_type_ref(2, $this->input->post('blog_id')); //type_id:2 = blog
				$this->m_tags->update($post->ID);

				//update image
				//check if project has photo in table photos
				$prev_image = $this->m_photos->read($post->ID);
				if(count($prev_image)>0){
				//yes, update
					
					//remove the previous image(?)
					//$prev_image = $this->m_photos->read($post->ID);
					if(is_file('./uploads/'.$prev_image[0]->src)){
						unlink('./uploads/'.$prev_image[0]->src);
					}
					if(is_file('./uploads/thumbs/'.$prev_image[0]->thumb)){
						unlink('./uploads/thumbs/'.$prev_image[0]->thumb);
					}
					
					$thumb = create_thumb($image_data['upload_data']['file_name']);
					$this->m_photos->update($post->ID,$image_data['upload_data'],$thumb);
					
				}else{
				//no, insert
					
					$thumb = create_thumb($image_data['upload_data']['file_name']);
					$post_info = $this->m_posts->get_post_by_type_ref(2, $this->input->post('blog_id'));
					$this->m_photos->create($post_info->ID,$image_data['upload_data'],$thumb);
				}

				redirect($this->admin_link.'blog');
			}
		}else{
			//if user doesn't upload an image, just update the database
			
			//update projects
			$update = $this->m_blogs->update('',true);

			//update post
			$this->m_posts->update();
	
			//update tags
			$post = $this->m_posts->get_post_by_type_ref(2, $this->input->post('blog_id')); //type_id:2 = blog
			$ch_tag = $this->m_tags->read($post->ID);
			if(!empty($ch_tag)){
				$this->m_tags->update($post->ID);
			}else{
				$this->m_tags->create($post->ID);
			}

			redirect($this->admin_link.'blog');
		}
		
	}

	function search()
	{

		$data['add_css'] = array('backadmin/table');
		$keyword = $this->input->post('keyword');
		if(empty($keyword)){
			redirect($this->admin_link.'blog');
		}
		$data['blogs'] = $this->m_blogs->get_blog('',array('keyword'=>$keyword));
		
		$data['keyword'] = $keyword;
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_blog', $data);
	}

	function delete()
	{
		$blog_id = $this->uri->segment(4);
		
		if(empty($blog_id)){
			redirect($this->admin_link.'blog');
		}

		#soft delete
		$post = $this->m_posts->read_by_type_ref(2, $blog_id);
		if(empty($post->deleted)){
			$this->m_posts->delete_by_type_ref(2, $blog_id, TRUE); //type_id:2 = blog
		}
		redirect($this->admin_link.'blog');
		
		/*
		//delete blogs
		$delete = $this->m_projects->delete($project_id);

		//get post_id from project_id
		$post = $this->m_posts->get_post_by_type_ref(3, $project_id); //type_id:3 = project

		//remove the previous image(?)
		$prev_image = $this->m_photos->read($post->ID);
		if(is_file('./uploads/'.$prev_image[0]->src)){
			unlink('./uploads/'.$prev_image[0]->src);
		}
		if(is_file('./uploads/thumbs/'.$prev_image[0]->thumb)){
			unlink('./uploads/thumbs/'.$prev_image[0]->thumb);
		}

		//DELETE table photos
		$this->m_photos->delete(array('post_id'=>$post->ID));

		//DELETE table tags
		$this->m_tags->delete($post->ID);

		//DELETE table posts
		$this->m_posts->delete($post->ID);
		*/

		#redirect($this->admin_link.'project');
	}

	function create_series_exec()
	{
		//Validate Here to prevent empty form submission
		
		$res = $this->m_blogs->create_series($this->session->userdata('user_id'));
		if($res){
			$data = array(
				'id' => $res->ID,
				'name' => $res->series_name
			);
			echo json_encode($data);
		}else{
			echo "0";	
		}
	}


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */