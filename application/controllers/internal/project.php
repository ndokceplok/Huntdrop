<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Projects List';
	private $active = 'project';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Projects List';
		
		$this->load->library(array(
			'upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_projects','m_posts','m_tags','m_photos'
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
		$config['base_url'] = $this->admin_link.'project/page/';
		$config['uri_segment'] = 4;

		$sort_by = '';
		$nb_projects = $this->m_projects->get_project('',array('sort'=>$sort_by));
		$config['total_post'] = count($nb_projects);
		$config['limit'] = $limit;
		$this->pager->initialize($config);

		$data['projects'] = $this->m_projects->get_project('',array('sort'=>$sort_by,'index'=>$index,'limit'=>$limit,'admin'=>TRUE));

		#$data['projects'] = $this->m_projects->get_project();
		
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_project', $data);
	}

	function update()
	{

		$project_id = $this->uri->segment(4);

		$data['add_css'] = array('backadmin/table','jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');
		
		$data['action'] = 'edit';
		$data['title'] = $this->title;
		$data['project_info'] = $this->m_projects->get_project($project_id,array('admin'=>true));
		$data['project_photo'] = $this->m_photos->read($data['project_info']->post_id); 

		$tags = $this->m_tags->read($data['project_info']->post_id); 
		$data['tags'] ='';
		$i = 1;
		foreach($tags as $r){
			if($i>1){
				$data['tags']  .= ", ";
			}
			$data['tags']  .= $r->name;
			$i++;
		}

		$this->load->view('backadmin/v_project_form', $data);
	}

	function update_exec()
	{
		
			$not_empty_upload = 0;
			//upload loop (max 3 photos)
			#foreach($_FILES['photo'] as $key => $value){
			for($i=1;$i<=3;$i++){
				
				//if user uploads an image
				if(!empty($_FILES['photo'.$i]['name'])){
					//set the config to upload the files -> config/upload.php
			
					if ( ! $this->upload->do_upload('photo'.$i))
					{
						$a[] = array('error' => $this->upload->display_errors());
						$errors = true;
					}
					else
					{
						#$image_data = array('upload_data' => $this->upload->data());
						$files[] = $this->upload->data();
						
					}
					$not_empty_upload +=1;
				}
			
			}

			if($not_empty_upload==0){
				//user doesn't upload anything
				//update projects
				$update = $this->m_projects->update();

				//update post
				$this->m_posts->update();
		
				//update tags
				$post = $this->m_posts->get_post_by_type_ref(3, $this->input->post('project_id')); //type_id:3 = project
				$ch_tag = $this->m_tags->read($post->ID);
				if(!empty($ch_tag)){
					$this->m_tags->update($post->ID);
				}else{
					$this->m_tags->create($post->ID);
				}

				redirect($this->admin_link.'project');
			}else{
				if(isset($a) && count($a)==$not_empty_upload){
					#print_r($a);
					$this->session->set_flashdata('log', $a[$not_empty_upload-1]['error']);
					redirect($this->admin_link.'project/update/'.$this->input->post('project_id'));
				}
				elseif(isset($files)){
					
					#$image_data = array('upload_data' => $this->upload->data());
					//update projects
					$update = $this->m_projects->update();

					//update post
					$this->m_posts->update();
			
					//update tags
					$data['post'] = $this->m_posts->get_post_by_type_ref(3, $this->input->post('project_id')); //type_id:3 = project
					$this->m_tags->update($data['post']->ID);

					foreach($files as $r){
						$thumb = create_thumb($r['file_name']);
						$post_info = $this->m_posts->get_post_by_type_ref(3, $this->input->post('project_id'));
						$this->m_photos->create($post_info->ID,$r,$thumb);
					}

					redirect($this->admin_link.'project');
				}
			}


		//if user uploads an image
		/*
		if($_FILES['photo']['error'] == 0){
			//$new_post = $this->db->insert_id();

			//set the config to upload the files -> config/upload.php
	
			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect($this->admin_link.'project/update/'.$this->input->post('project_id'));
			}
			else
			{
				$image_data = array('upload_data' => $this->upload->data());
				//update blogs
				$update = $this->m_projects->update();

				//update post
				$this->m_posts->update();
		
				//update tags
				$post = $this->m_posts->get_post_by_type_ref(3, $this->input->post('project_id')); //type_id:3 = project
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
					$post_info = $this->m_posts->get_post_by_type_ref(3, $this->input->post('project_id'));
					$this->m_photos->create($post_info->ID,$image_data['upload_data'],$thumb);
				}

				redirect($this->admin_link.'project');
			}
		}else{
			//if user doesn't upload an image, just update the database
			
			//update projects
			$update = $this->m_projects->update('',true);

			//update post
			$this->m_posts->update();
	
			//update tags
			$post = $this->m_posts->get_post_by_type_ref(3, $this->input->post('project_id')); //type_id:3 = project
			$ch_tag = $this->m_tags->read($post->ID);
			if(!empty($ch_tag)){
				$this->m_tags->update($post->ID);
			}else{
				$this->m_tags->create($post->ID);
			}

			redirect($this->admin_link.'project');
		}
		*/
		
	}

	function search()
	{

		$data['add_css'] = array('backadmin/table');
		$keyword = $this->input->post('keyword');
		if(empty($keyword)){
			redirect($this->admin_link.'project');
		}
		$data['projects'] = $this->m_projects->get_project('',array('keyword'=>$keyword));
		
		$data['keyword'] = $keyword;
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_project', $data);
	}

	function delete()
	{
		$project_id = $this->uri->segment(4);
		#$project_id = $this->input->post('project_id');

		if(empty($project_id)){
			redirect($this->admin_link.'project');
		}

		#soft delete
		$post = $this->m_posts->read_by_type_ref(3, $project_id);
		if(empty($post->deleted)){
			$this->m_posts->delete_by_type_ref(3, $project_id, TRUE); //type_id:3 = project
		}
		redirect($this->admin_link.'project');

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


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */