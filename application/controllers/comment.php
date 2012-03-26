<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends Public_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'm_posts','m_comments','m_blogs','m_projects','m_reviews','m_accounts','m_threads'
		));
	}
	
	function create()
	{
		$target = $this->input->post('target');
		
		if($target==1 || $target==2){

			//store to comments
			$ref_id = $this->m_comments->create($target);
			//store to posts
			if( ! empty($ref_id)) {
				$post_id = $this->m_posts->create($ref_id,9);	//9 = comments
			}
		
		}
		
		if($target==1){
			$post_type = $this->input->post('post_type');
			$post_id = $this->input->post('post_id');
			if($post_type==1){
				$review_info = $this->m_reviews->read($post_id);
				$redirect = 'review/'.$post_id.'/'.$review_info ->alias;
			}elseif($post_type==2){
				$blog_info = $this->m_blogs->read($post_id);
				$redirect = 'blog/'.$post_id.'/'.$blog_info->alias;
			}elseif($post_type==3){
				$project_info = $this->m_projects->read($post_id);
				$redirect = 'project/'.$post_id.'/'.$project_info->alias;
			}elseif($post_type==5){
				$thread_info = $this->m_threads->read($post_id);
				$redirect = 'forum/thread/'.$post_id.'/'.$thread_info->alias;
			}
			redirect($redirect);
		}else{
			$user_id = $this->input->post('user_id');
			$user_info = $this->m_accounts->read($user_id);
			$redirect = 'user/'.$user_info ->user_name;
			redirect($redirect);
		}
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */