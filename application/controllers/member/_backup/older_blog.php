<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

	private $title = 'Hunterdrop - Member Blogs';
	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->load->library(array(
			'upload'
		));
		$this->load->model(array(
			'm_posts', 'm_blogs', 'm_accounts','m_tags', 'm_photos'
		));
		$this->load->helper(array(
			'pretty_url','create_thumb','ckeditor'
		));

      	$this->load->vars(array('active'=>'blog'));
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
		$data['title'] = $this->title;
		$blog_list = $this->m_blogs->get_user_blog($this->session->userdata('user_id'));
		if(count($blog_list)>0){
		$data['blog_list'] = $blog_list;
		}
		$this->load->view('member/v_member_blog', $data);
	}
	
	function create()
	{
		$data['add_css'] = array('uploadify');
		$data['add_js'] = array('uploadify/swfobject','uploadify/jquery.uploadify.v2.1.4.min');
		$data['title'] = $this->title.' | Create a Blog';
		$data['action'] = 'add';
		$data['blog_series'] = $this->m_blogs->get_blog_series($this->session->userdata('user_id'));
		$this->load->view('member/v_member_blog_form', $data);

	}

	
	function create_exec()
	{
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
		echo "go to hell";
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

		$this->load->view('member/v_member_blog_form', $data);
		}
	}
	
	function update_exec()
	{
		if($this->m_blogs->check_author($this->input->post('blog_id'))==0){
			echo "go to hell";
		}else{
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
			echo "go to hell";
		}else{
			
			//delete blogs
			$delete = $this->m_blogs->delete($blog_id);

			//get post_id from blog_id
			$post = $this->m_posts->get_post_by_type_ref(2, $blog_id); //type_id:2 = blog

			//remove the previous image(?)
			$prev_image = $this->m_photos->read($post->ID);
			if(is_file('./uploads/'.$prev_image[0]->src)){
				unlink('./uploads/'.$prev_image[0]->src);
			}
			if(is_file('./uploads/thumbs/'.$prev_image[0]->thumb)){
				unlink('./uploads/thumbs/'.$prev_image[0]->thumb);
			}

			//DELETE table photos
			$this->m_photos->delete($post->ID);

			//DELETE table tags
			$this->m_tags->delete($post->ID);

			//DELETE table posts
			$this->m_posts->delete($post->ID);

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