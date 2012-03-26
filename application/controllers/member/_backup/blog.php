<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Member_Controller {

	#private $title = 'Hunterdrop - Member Blogs';
	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Member Blogs';
		$this->load->library(array(
			'upload'
		));
		$this->load->model(array(
			'm_posts', 'm_blogs', 'm_accounts','m_tags', 'm_photos', 'm_profiles', 'm_comments', 'm_likes'
		));
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
		));

      	$this->load->vars(array('ql_active'=>'blog','page_css'=>array('contents')));
	}
	
	function index()
	{
		$data['title'] = $this->title;
		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));


		$this->load->library('pager');
		
		$limit =10;
		$series ='';

		if($this->uri->segment(3)=='series'){
			$series = $this->uri->segment(4);
			#$sort = $this->uri->segment(3);
			#$data['sort'] = $sort;
			$page = $this->uri->segment(6,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'member/blog/series/'.$series.'/page/';
			$config['uri_segment'] = 6;

		//if tag exist
		}else{
			#$sort = 'latest';
			#$data['sort'] = $sort;
			$page = $this->uri->segment(4,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'member/blog/page/';
			$config['uri_segment'] = 4;
		}

		#$nb_blogs = $this->m_blogs->get_blog('',array('sort'=>$sort_by,'tag'=>$tag));
		$nb_blogs = $this->m_posts->get_user_blogs($data['account']->ID, 'desc',array('series'=>$series));
		
		$config['total_post'] = count($nb_blogs);
		$config['limit'] = $limit;

		$this->pager->initialize($config);

		$blog_list = $this->m_posts->get_user_blogs($data['account']->ID, 'desc',array('series'=>$series,'index'=>$index,'limit'=>$limit));

		if(!empty($series)){
			$data['browse_series'] = TRUE;
			if($series!='na'){
				$data['series_detail'] = $this->m_blogs->get_blog_series_detail($series);				
			}else{
				$data['series_detail']->series_name = 'No Series';
			}
		}

		#$blog_list = $this->m_posts->get_user_blogs($data['account']->ID, 'desc');

		if(count($blog_list)>0){
		$data['blog_list'] = $blog_list;
		}
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));
		$data['blog_series'] = $this->m_blogs->get_blog_series($data['account']->ID);
		$data['no_series'] = $this->m_posts->get_user_blogs($data['account']->ID, 'desc',array('series'=>'na'));

		$this->load->view('member/v_member_blog', $data);
	}

	// function browse()
	// {
	// 	$series = $this->uri->segment(4);
		

	// 	if($series=='na'){
	// 		$blog_list = $this->m_blogs->get_blog_by_series('', 'desc');
	// 	}else{
	// 		$blog_list = $this->m_blogs->get_blog_by_series($series, 'desc');
	// 	}
	// 	#$blog_list = $this->m_blogs->get_user_blog($this->session->userdata('user_id'));
	// 	if(count($blog_list)>0){
	// 	$data['blog_list'] = $blog_list;
	// 	}


	// 	$data['title'] = $this->title;
	// 	$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
	// 	$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
	// 	$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
	// 	$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));
	// 	$data['blog_series'] = $this->m_blogs->get_blog_series($data['account']->ID);
	// 	$data['no_series'] = $this->m_posts->get_user_blogs($data['account']->ID, 'desc',array('series'=>'na'));

	// 	$this->load->view('member/v_member_blog', $data);
	// }
	
	function create()
	{
		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');
		$data['title'] = $this->title.' | Create a Blog';
		$data['action'] = 'add';
		$data['blog_series'] = $this->m_blogs->get_blog_series($this->session->userdata('user_id'));
		$this->load->view('member/v_member_blog_form', $data);

	}

	
	function create_exec()
	{
		/*
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
		
		if($not_empty_upload==0){
			//user doesn't uplaod anything
			//store to blogs
			$ref_id = $this->m_blogs->create($this->session->userdata('user_id'));

			//store to post
			if( ! empty($ref_id)) {
				$post_id = $this->m_posts->create($ref_id,2);
				//store tags
				$this->m_tags->create($post_id);
			}else{
				$this->session->set_flashdata('log','Fields must not be empty!');
				redirect('member/blog/create');
			}
			redirect('member/blog');
		}else{
			if(count($a)==$not_empty_upload){
				print_r($a);
				$this->session->set_flashdata('log', $a[$not_empty_upload-1]['error']);
				redirect('member/blog/create');
			}
			elseif(isset($files)){
				//print_r($files);
				//store to blogs
				$ref_id = $this->m_blogs->create($this->session->userdata('user_id'));
	
				//store to post
				if( ! empty($ref_id)) {
					$post_id = $this->m_posts->create($ref_id,2);
					//store tags
					$this->m_tags->create($post_id);
					//store image
					foreach($files as $r){
						$thumb = create_thumb($r['file_name']);
						$this->m_photos->create($post_id,$r,$thumb);
					}
				}
				redirect('member/blog');
			}
		}
		*/

		
		//if user uploads an image
		if($_FILES['photo']['error'] == 0){
			//$new_post = $this->db->insert_id();

			//set the config to upload the files -> config/upload.php
	
			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect('member/blog/create');
			}
			else
			{
				$image_data = array('upload_data' => $this->upload->data());
				//store to blogs
				$ref_id = $this->m_blogs->create($this->session->userdata('user_id'));

				//store to post
				if( ! empty($ref_id)) {
					$post_id = $this->m_posts->create($ref_id,2);
					//store tags
					$this->m_tags->create($post_id);
					//store image
					$thumb = create_thumb($image_data['upload_data']['file_name']);
					$this->m_photos->create($post_id,$image_data['upload_data'],$thumb);
				}

				redirect('member/blog');

			}
		}else{
			//if user doesn't upload an image, just insert to database
			//store to blogs
			$ref_id = $this->m_blogs->create($this->session->userdata('user_id'));

			//store to post
			if( ! empty($ref_id)) {
				$post_id = $this->m_posts->create($ref_id,2);
				//store tags
				$this->m_tags->create($post_id);
			}else{
				$this->session->set_flashdata('log','Fields must not be empty!');
				redirect('member/blog/create');
			}
			redirect('member/blog');
		}
		
	}
	
	function read()
	{
		$id = $this->uri->segment(3);
		echo $id;
	}
	
	function update()
	{

		$blog_id = $this->uri->segment(4);
		if($this->m_blogs->check_author($blog_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
		$data['title'] = $this->title.' | Update Blog';
		$data['action'] = 'edit';
		
		$data['blog_info'] = $this->m_blogs->read($blog_id);
		$data['post'] = $this->m_posts->get_post_by_type_ref(2, $blog_id); //type_id:2 = blog
		$tags = $this->m_tags->read($data['post']->ID); 
		$data['tags']='';
		$i = 1;
		foreach($tags as $r){
			if($i>1){
				$data['tags'] .= ", ";
			}
			$data['tags'] .= $r->name;
			$i++;
		}

		$data['photos'] = $this->m_photos->read($data['post']->ID); 
		$data['blog_series'] = $this->m_blogs->get_blog_series($this->session->userdata('user_id'));
		$data['add_css'] = array('jquery.tagsinput');
		$data['add_js'] = array('jquery.tagsinput');

		$this->load->view('member/v_member_blog_form', $data);
		}
	}
	
	function update_exec()
	{
		if($this->m_blogs->check_author($this->input->post('blog_id'))==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			/*
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
						$files[$i] = $this->upload->data();
						
					}
					$not_empty_upload +=1;
				}
			
			}


			if($not_empty_upload==0){
				//user doesn't uplaod anything
				//update blogs
				$update = $this->m_blogs->update();

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

				redirect('member/blog');
			}else{
				if(count($a)==$not_empty_upload){
					print_r($a);
					$this->session->set_flashdata('log', $a[$not_empty_upload-1]['error']);
					redirect('member/blog/update/'.$this->input->post('blog_id'));
				}
				elseif(isset($files)){
					
					#$image_data = array('upload_data' => $this->upload->data());
					//update blogs
					$update = $this->m_blogs->update();

					//update post
					$this->m_posts->update();
			
					//update tags
					$data['post'] = $this->m_posts->get_post_by_type_ref(2, $this->input->post('blog_id')); //type_id:2 = blog
					$this->m_tags->update($data['post']->ID);

					//update image
					//check if blog has photo in table photos
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
						$post_info = $this->m_posts->get_post_by_type_ref(2, $this->input->post('blog_id'));
						$this->m_photos->create($post_info->ID,$image_data['upload_data'],$thumb);
					}

					redirect('member/blog');
				}
			}
			*/
			
			//if user uploads an image
			if($_FILES['photo']['error'] == 0){
				//$new_post = $this->db->insert_id();
	
				//set the config to upload the files -> config/upload.php
		
				if ( ! $this->upload->do_upload('photo'))
				{
					$a = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('log', $a['error']);
					redirect('member/blog/update/'.$this->input->post('blog_id'));
				}
				else
				{
					$image_data = array('upload_data' => $this->upload->data());
					//update blogs
					$update = $this->m_blogs->update();

					//update post
					$this->m_posts->update();
			
					//update tags
					$data['post'] = $this->m_posts->get_post_by_type_ref(2, $this->input->post('blog_id')); //type_id:2 = blog
					$this->m_tags->update($data['post']->ID);

					//update image
					//check if blog has photo in table photos
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
						$post_info = $this->m_posts->get_post_by_type_ref(2, $this->input->post('blog_id'));
						$this->m_photos->create($post_info->ID,$image_data['upload_data'],$thumb);
					}

					redirect('member/blog');
				}
			}else{
				//if user doesn't upload an image, just update the database
				//update blogs
				$update = $this->m_blogs->update();

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

				redirect('member/blog');
			}
		}
	}
	
	function delete()
	{
		$blog_id = $this->uri->segment(4);
		if($this->m_blogs->check_author($blog_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			
			//delete blogs
			$delete = $this->m_blogs->delete($blog_id);

			//get post_id from blog_id
			$post = $this->m_posts->get_post_by_type_ref(2, $blog_id); //type_id:2 = blog

			//remove the previous image(?)
			$prev_image = $this->m_photos->read($post->ID);
			foreach($prev_image as $r){
			if(is_file('./uploads/'.$r->src)){
				unlink('./uploads/'.$r->src);
			}
			if(is_file('./uploads/thumbs/'.$r->thumb)){
				unlink('./uploads/thumbs/'.$r->thumb);
			}
			}

			//DELETE table photos
			$this->m_photos->delete($post->ID);

			//DELETE table tags
			$this->m_tags->delete($post->ID);

			//DELETE post comments
			$comments = $this->m_comments->read_arr(array('target'=>1,'post_type'=>2,'post_id'=>$blog_id));
			foreach($comments as $r){
				#delete comments records in posts
				$this->m_posts->delete_by_type_ref(9,$r->ID);
			}
			#delete the comments
			$this->m_comments->delete(array('target'=>1,'post_type'=>2,'post_id'=>$blog_id));

			//DELETE post likes
			$likes = $this->m_likes->read_arr(array('post_type'=>2,'post_id'=>$blog_id));
			foreach($likes as $r){
				#delete likes records in posts
				$this->m_posts->delete_by_type_ref(8,$r->ID);
			}
			#delete the likes
			$this->m_likes->delete_arr(array('post_type'=>2,'post_id'=>$project_id));

			//DELETE table posts
			$this->m_posts->delete($post->ID);

			redirect('member/blog');

		}

	}

	function delete_series()
	{
		$series_id = $this->uri->segment(4);
		if($this->m_blogs->check_series_author($series_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			
			//update all blogs inside the series to have series_id = ''
			#$series_id;
			$series_blog = $this->m_blogs->get_blog_by_series($series_id);
			foreach($series_blog as $r){
				$this->m_blogs->unset_series($r->ref_id);
			}

			//DELETE table blog_series
			$this->m_blogs->delete_series($series_id);

			redirect('member/blog');

		}

	}

	function create_series_exec()
	{
		$this->_auth();
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

/* End of file review.php */
/* Location: ./system/application/controllers/review.php */