<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends Member_Controller {

	#private $title = 'Hunterdrop - Member Projects';
	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Member Projects';
		$this->load->library(array(
			'upload'
		));
		$this->load->model(array(
			'm_posts', 'm_projects', 'm_accounts','m_tags', 'm_photos', 'm_profiles', 'm_comments', 'm_likes'
		));
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
		));

      	$this->load->vars(array('ql_active'=>'project','page_css'=>array('contents')));
	}

	function index()
	{
		$data['title'] = $this->title;
		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		$data['add_js'] = array('notice');

		$this->load->library('pager');
		
		$limit =10;
		$tag ='';

		//if tag exist
		if($this->uri->segment(3)=='tag'){
			$tag = $this->uri->segment(4);
			$page = $this->uri->segment(6,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'member/project/tag/'.$tag.'/page/';
			$config['uri_segment'] = 6;

		}else{
			$page = $this->uri->segment(4,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'member/project/page/';
			$config['uri_segment'] = 4;
		}

		$nb_projects = $this->m_posts->get_user_projects($data['account']->ID, 'desc',array('tag'=>$tag));
		
		$config['total_post'] = count($nb_projects);
		$config['limit'] = $limit;

		$this->pager->initialize($config);


		$project_list = $this->m_posts->get_user_projects($data['account']->ID, 'desc',array('tag'=>$tag,'index'=>$index,'limit'=>$limit));
		if(count($project_list)>0){
		$data['project_list'] = $project_list;
		#print_r($project_list);
			foreach($project_list as $i){
				$data['post_tags'][] = $this->m_tags->read($i->ID);
			}
		}

		if(!empty($tag)){
			$data['browse_tag'] = TRUE;
			$data['tag'] = $tag;
		}

		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));
		
		$data['tags'] = $this->m_tags->get_project_tags(array('user_id'=>$this->session->userdata('user_id')));

		$this->load->view('member/v_member_project', $data);
	}
	
	function create()
	{
		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');
		$data['title'] = $this->title.' | Create a Project';
		$data['action'] = 'add';
		$this->load->view('member/v_member_project_form', $data);

	}
	
	function create_exec()
	{
		//set count not empty upload
		$not_empty_upload = 0;
		//upload loop
		#foreach($_FILES['photo'] as $key => $value){
		for($i=1;$i<=count($_FILES);$i++){
			
			//if user uploads an image
			if(!empty($_FILES['photo'.$i]['name'])){
				//$new_post = $this->db->insert_id();
				//set the config to upload the files -> config/upload.php
		
				if ( ! $this->upload->do_upload('photo'.$i))
				{
					$a[] = array('error' => $this->upload->display_errors());
					$errors = true;
					#$a = array('error' => $this->upload->display_errors());
					#$this->session->set_flashdata('log', $a['error']);
					#redirect('member/blog/create');
				}
				else
				{
					#$image_data = array('upload_data' => $this->upload->data());
					$files[] = $this->upload->data();
					
				}
				$not_empty_upload +=1;
			}
		
		}
		#echo $not_empty_upload; 
		if($not_empty_upload==0){
			//user doesn't uplaod anything
			//store to projects
			$ref_id = $this->m_projects->create($this->session->userdata('user_id'));

			//store to post
			if( ! empty($ref_id)) {
				$post_id = $this->m_posts->create($ref_id,3);
				//store tags
				$this->m_tags->create($post_id);
			}else{
				$this->session->set_flashdata('log','Fields must not be empty!');
				redirect('member/project/create');
			}

			redirect('member/project');
		}else{
			if(isset($a) && count($a)==$not_empty_upload){
				$this->session->set_flashdata('log', $a[$not_empty_upload-1]['error']);
				redirect('member/project/create');
			}
			elseif(isset($files)){
				//print_r($files);
				//store to projects
				$ref_id = $this->m_projects->create($this->session->userdata('user_id'));
	
				//store to post
				if( ! empty($ref_id)) {
					$post_id = $this->m_posts->create($ref_id,3);
					//store tags
					$this->m_tags->create($post_id);
					//store image
					foreach($files as $r){
						$thumb = create_thumb($r['file_name']);
						$this->m_photos->create($post_id,$r,$thumb);
					}
				}else{
					$this->session->set_flashdata('log','Fields must not be empty!');
					redirect('member/project/create');
				}
				redirect('member/project');
			}
		}

	}
	
	function read()
	{
		$id = $this->uri->segment(3);
		echo $id;
	}
	
	function update()
	{

		$project_id = $this->uri->segment(4);
		if($this->m_projects->check_author($project_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
		$data['title'] = $this->title.' | Edit Project';
		$data['action'] = 'edit';
		$data['project_info'] = $this->m_projects->read($project_id);
		//$data['project_photo'] = $this->m_projects->get_project_photo($project_id);

		$data['post'] = $this->m_posts->get_post_by_type_ref(3, $project_id); //type_id:3 = blog
		$data['project_photo'] = $this->m_photos->read($data['post']->ID); 
		$tags = $this->m_tags->read($data['post']->ID); 
		$data['tags'] ='';
		$i = 1;
		foreach($tags as $r){
			if($i>1){
				$data['tags']  .= ", ";
			}
			$data['tags']  .= $r->name;
			$i++;
		}

		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');

		$this->load->view('member/v_member_project_form', $data);
		}
	}
	
	function update_exec()
	{
		if($this->m_projects->check_author($this->input->post('project_id'))==0){
			#echo "go to hell";
			redirect('denied');
		}else{

			$not_empty_upload = 0;
			//upload loop (max 3 photos)
			#foreach($_FILES['photo'] as $key => $value){
			for($i=1;$i<=3;$i++){
				
				//if user uploads an image
				if(!empty($_FILES['photo'.$i]['name'])){
					//$new_post = $this->db->insert_id();
					//set the config to upload the files -> config/upload.php
			
					if ( ! $this->upload->do_upload('photo'.$i))
					{
						$a[] = array('error' => $this->upload->display_errors());
						$errors = true;
						#$a = array('error' => $this->upload->display_errors());
						#$this->session->set_flashdata('log', $a['error']);
						#redirect('member/blog/create');
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
				//user doesn't uplaod anything
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

				redirect('member/project');
			}else{
				if(isset($a) && count($a)==$not_empty_upload){
					#print_r($a);
					$this->session->set_flashdata('log', $a[$not_empty_upload-1]['error']);
					redirect('member/project/update/'.$this->input->post('project_id'));
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
						
						#$thumb = create_thumb($r['file_name']);
						#$this->m_photos->create($post_id,$r,$thumb);
					}
					/*
					//update image
					//check if project has photo in table photos
					$a = $this->m_photos->read($data['post']->ID);
					if(count($a)>0){
					//yes, update
						
						//remove the previous image(?)
						$prev_image = $this->m_photos->read($data['post']->ID);
						if(is_file('./uploads/'.$prev_image[0]->src)){
							unlink('./uploads/'.$prev_image[0]->src);
						}
						if(is_file('./uploads/thumbs/'.$prev_image[0]->thumb)){
							unlink('./uploads/thumbs/'.$prev_image[0]->thumb);
						}
						
						$thumb = create_thumb($image_data['upload_data']['file_name']);
						$this->m_photos->update($data['post']->ID,$image_data['upload_data'],$thumb);
						
					}else{
					//no, insert
						
						$thumb = create_thumb($image_data['upload_data']['file_name']);
						$post_info = $this->m_posts->get_post_by_type_ref(3, $this->input->post('project_id'));
						$this->m_photos->create($post_info->ID,$image_data['upload_data'],$thumb);
					}
					*/

					redirect('member/project');
				}
			}


		}
	}
	
	function delete()
	{
		#$project_id = $this->uri->segment(4);
		$project_id = $this->input->post('project_id');

		if(empty($project_id)){
			redirect('denied');
		}

		if($this->m_projects->check_author($project_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			#soft delete
			#$post = $this->m_posts->get_post_by_type_ref(3, $project_id); //type_id:3 = project
			$this->m_posts->delete_by_type_ref(3, $project_id); //type_id:3 = project

		// if($this->m_projects->check_author($project_id)==0){
		// 	#echo "go to hell";
		// 	redirect('denied');
		// }else{
		// 	//delete blogs
		// 	$delete = $this->m_projects->delete($project_id);

		// 	//get post_id from project_id
		// 	$post = $this->m_posts->get_post_by_type_ref(3, $project_id); //type_id:3 = project

		// 	//remove the previous image(?)
		// 	$prev_image = $this->m_photos->read($post->ID);
		// 	if(is_file('./uploads/'.$prev_image[0]->src)){
		// 		unlink('./uploads/'.$prev_image[0]->src);
		// 	}
		// 	if(is_file('./uploads/thumbs/'.$prev_image[0]->thumb)){
		// 		unlink('./uploads/thumbs/'.$prev_image[0]->thumb);
		// 	}

		// 	//DELETE table photos
		// 	$this->m_photos->delete($post->ID);

		// 	//DELETE table tags
		// 	$this->m_tags->delete($post->ID);

		// 	//DELETE post comments
		// 	$comments = $this->m_comments->read_arr(array('target'=>1,'post_type'=>3,'post_id'=>$project_id));
		// 	foreach($comments as $r){
		// 		#delete comments records in posts
		// 		$this->m_posts->delete_by_type_ref(9,$r->ID);
		// 	}
		// 	#delete the comments
		// 	$this->m_comments->delete(array('target'=>1,'post_type'=>3,'post_id'=>$project_id));

		// 	//DELETE post likes
		// 	$likes = $this->m_likes->read_arr(array('post_type'=>3,'post_id'=>$project_id));
		// 	foreach($likes as $r){
		// 		#delete likes records in posts
		// 		$this->m_posts->delete_by_type_ref(8,$r->ID);
		// 	}
		// 	#delete the likes
		// 	$this->m_likes->delete_arr(array('post_type'=>3,'post_id'=>$project_id));

		// 	//DELETE table posts
		// 	$this->m_posts->delete($post->ID);


			redirect('member/project');
		}

	}

}

/* End of file review.php */
/* Location: ./system/application/controllers/review.php */