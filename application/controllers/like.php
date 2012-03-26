<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Like extends Public_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'm_posts','m_likes','m_blogs','m_projects','m_reviews','m_accounts'
		));
	}
	
	function add()
	{
		$liker_id = $this->session->userdata('user_id');
		$post_type = $this->input->post('type');
		$post_id = $this->input->post('id');
		
		//check like
		$c = $this->m_likes->check_like($liker_id,$post_type,$post_id);
		if(!isset($c)){
			//if never liked, store to likes
			$ref_id = $this->m_likes->create($liker_id,$post_type,$post_id);

			//store to posts
			if( ! empty($ref_id)) {
				$post_id = $this->m_posts->create($ref_id,8);	//8 = likes
			}

		}else{
			echo 'no good';
		}
		
	}

	function remove()
	{
		$liker_id = $this->session->userdata('user_id');
		$post_type = $this->input->post('type');
		$post_id = $this->input->post('id');
		
		//check like
		$c = $this->m_likes->check_like($liker_id,$post_type,$post_id);
		if(isset($c)){
			//if there's a like, remove it
			$this->m_likes->delete($liker_id,$post_type,$post_id);
		}else{
			echo 'no good';
		}
		
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */