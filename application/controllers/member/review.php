<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends Member_Controller {

	#private $title = 'Hunterdrop - Review';
	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Member Reviews';
		$this->load->library(array(
			'upload'
		));
		$this->load->model(array(
			'm_posts', 'm_reviews', 'm_accounts', 'm_tags', 'm_photos', 'm_brands','m_categories', 'm_profiles', 'm_comments', 'm_likes'
		));
		$this->load->helper(array(
			'pretty_url', 'pretty_date','create_thumb','ckeditor'
		));

      	$this->load->vars(array('ql_active'=>'review','page_css'=>array('contents')));
	}
	
	function index()
	{
		$data['add_css'] = array('rateit');
		$data['add_js'] = array('jquery.rateit.min','notice');

		$data['title'] = $this->title;
		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));

		$this->load->library('pager');
		
		$limit =10;

		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$config['base_url'] = base_url().'member/review/page/';
		$config['uri_segment'] = 4;

		$nb_reviews = $this->m_posts->get_user_reviews($data['account']->ID, 'desc');
		
		$config['total_post'] = count($nb_reviews);
		$config['limit'] = $limit;

		$this->pager->initialize($config);


		$review_list = $this->m_posts->get_user_reviews($data['account']->ID, 'desc',array('index'=>$index,'limit'=>$limit));
		if(count($review_list)>0){
		$data['review_list'] = $review_list;
		#print_r($review_list);
			foreach($review_list as $i){
				$data['post_tags'][] = $this->m_tags->read($i->ID);
			}
			#echo $this->db->last_query();
			#print_r($data['post_tags']);
		}
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));
		
		#$data['tags'] = $this->m_tags->get_project_tags(array('user_id'=>$this->session->userdata('user_id')));

		$this->load->view('member/v_member_review', $data);

		#$data['review'] = $this->m_reviews->get_user_review($this->session->userdata('user_id'));
		#$this->load->view('member/v_review', $data);
	}
	
	function create()
	{
		$data['title'] = $this->title;
		$data['add_css'] = array('rateit','jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.rateit.min','jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');

		$data['action'] = "add";

		$data['brands'] = $this->m_brands->read();
		$data['categories'] = $this->m_categories->read();
		$this->load->view('member/v_member_review_form', $data);
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
			//store to reviews
			$ref_id = $this->m_reviews->create($this->session->userdata('user_id'));

			//store to post
			if( ! empty($ref_id)) {
				$post_id = $this->m_posts->create($ref_id,1);
				//store tags
				$this->m_tags->create($post_id);
			}else{
				$this->session->set_flashdata('log','Fields must not be empty!');
				redirect('member/review/create');
			}

			redirect('member/review');
		}else{
			if(isset($a) && count($a)==$not_empty_upload){
				$this->session->set_flashdata('log', $a[$not_empty_upload-1]['error']);
				redirect('member/review/create');
			}
			elseif(isset($files)){
				//store to reviews
				$ref_id = $this->m_reviews->create($this->session->userdata('user_id'));
	
				//store to post
				if( ! empty($ref_id)) {
					$post_id = $this->m_posts->create($ref_id,1);
					//store tags
					$this->m_tags->create($post_id);
					//store image
					foreach($files as $r){
						$thumb = create_thumb($r['file_name']);
						$this->m_photos->create($post_id,$r,$thumb);
					}
				}else{
					$this->session->set_flashdata('log','Fields must not be empty!');
					redirect('member/review/create');
				}
				redirect('member/review');
			}
		}

	}
	
	function read()
	{
		$data['title'] = $this->title;
		$id = $this->uri->segment(4);
		$data['review'] = $this->m_posts->get_review($id);
		$data['photo'] = $this->m_photos->read($data['review']->post_id);
		if( ! empty($data['review'])) {
			$this->load->view('member/v_review_read', $data);
		} else {
			show_404();
		}
	}
	
	private function _check_author($account_id, $post_id, $ref_id)
	{
		$data = $this->m_posts->check_author($account_id, $post_id, $ref_id);
		if( empty($data)) {
			show_404();
		}
	}
	
	function update()
	{
		$id = $this->uri->segment(4);
		if($this->m_reviews->check_author($id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			$data['action'] = "edit";
			$data['title'] = $this->title;

			$data['add_css'] = array('rateit','jquery.tagsinput','validationEngine.jquery');
			$data['add_js'] = array('jquery.rateit.min','jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');

			$data['brands'] = $this->m_brands->read();
			$data['categories'] = $this->m_categories->read();

			$data['review_info'] = $this->m_posts->get_review($id);
			$data['review_photo'] = $this->m_photos->read($data['review_info']->post_id);
			//$data['rating'] = $this->m_ratings->read($data['post']->ID); //type_id:1 = review
			//$data['tags'] = $this->m_tags->read($data['post']->ID); //type_id:1 = review
			$tags = $this->m_tags->read($data['review_info']->post_id); 
			$data['tags']='';
			$i = 1;
			foreach($tags as $r){
				if($i>1){
					$data['tags'] .= ", ";
				}
				$data['tags'] .= $r->name;
				$i++;
			}

			$this->_check_author($this->session->userdata('user_id'), $data['review_info']->post_id, $id);
			$this->load->view('member/v_member_review_form', $data);
		}
	}
	
	function update_exec()
	{
		
		if($this->m_reviews->check_author($this->input->post('review_id'))==0){
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
				//update reviews
				$update = $this->m_reviews->update();

				//update post
				$this->m_posts->update();
		
				//update tags
				$post = $this->m_posts->get_post_by_type_ref(1, $this->input->post('review_id')); //type_id:1 = review
				$ch_tag = $this->m_tags->read($post->ID);
				if(!empty($ch_tag)){
					$this->m_tags->update($post->ID);
				}else{
					$this->m_tags->create($post->ID);
				}

				redirect('member/review');
			}else{
				if(isset($a) && count($a)==$not_empty_upload){
					#print_r($a);
					$this->session->set_flashdata('log', $a[$not_empty_upload-1]['error']);
					redirect('member/review/update/'.$this->input->post('review_id'));
				}
				elseif(isset($files)){
					
					//update reviews
					$update = $this->m_reviews->update();

					//update post
					$this->m_posts->update();
			
					//update tags
					$data['post'] = $this->m_posts->get_post_by_type_ref(1, $this->input->post('review_id')); //type_id:1 = review
					$this->m_tags->update($data['post']->ID);

					foreach($files as $r){
						$thumb = create_thumb($r['file_name']);
						$post_info = $this->m_posts->get_post_by_type_ref(1, $this->input->post('review_id'));
						$this->m_photos->create($post_info->ID,$r,$thumb);
					}
	
					redirect('member/review');
				}
			}

		}
	}
	
	function delete()
	{
		#$id = $this->uri->segment(4);
		$review_id = $this->input->post('review_id');

		if(empty($review_id)){
			redirect('denied');
		}

		if($this->m_reviews->check_author($review_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			#soft delete
			#$post = $this->m_posts->get_post_by_type_ref(1, $review_id); //type_id:1 = review
			$this->m_posts->delete_by_type_ref(1, $review_id); //type_id:1 = review

		// //check whether the author or not, if not show_404()
		// //prevent abuse from firebug or inspect element
		// $data['post'] = $this->m_posts->get_post_by_type_ref(1, $id); //type_id:1 = review
		// $this->_check_author($this->session->userdata('user_id'), $data['post']->ID, $id);

		// //delete review
		// $this->m_reviews->delete($id);

		// //remove the previous image(?)
		// $prev_image = $this->m_photos->read($post->ID);
		// if(is_file('./uploads/'.$prev_image[0]->src)){
		// 	unlink('./uploads/'.$prev_image[0]->src);
		// }
		// if(is_file('./uploads/thumbs/'.$prev_image[0]->thumb)){
		// 	unlink('./uploads/thumbs/'.$prev_image[0]->thumb);
		// }

		// //DELETE table photos
		// $this->m_photos->delete($post->ID);

		// //DELETE table tags
		// $this->m_tags->delete($post->ID);
		
		// //delete post, delete(type_id, ref_id)
		// $this->m_posts->delete_by_type_ref(1, $id); //type_id:1 = review
		
		redirect('member/review');
		}
	}

	function create_brand_exec()
	{
		$this->_auth();
		//Validate Here to prevent empty form submission

		$res = $this->m_brands->create();
		if($res){
			$data = array(
				'id' => $res->brand_id,
				'name' => $res->brand_name
			);
			echo json_encode($data);
		}else{
			echo "0";	
		}
		
	}

}

/* End of file review.php */
/* Location: ./system/application/controllers/review.php */