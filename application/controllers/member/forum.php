<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends Member_Controller {

	#private $title = 'Hunterdrop - Member Forum Posts';
	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Member Forum Posts';
		$this->load->library(array(
			'upload'
		));
		$this->load->model(array(
			'm_posts', 'm_forums', 'm_threads','m_accounts','m_tags', 'm_photos', 'm_profiles'
		));
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
		));

      	$this->load->vars(array('ql_active'=>'forum','page_css'=>array('contents')));
	}
	
	function index()
	{
		$data['title'] = $this->title;
		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		$data['add_js'] = array('notice');

		$this->load->library('pager');
		
		$limit =10;

		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$config['base_url'] = base_url().'member/forum/page/';
		$config['uri_segment'] = 4;

		$nb_threads = $this->m_posts->get_user_threads($data['account']->ID, 'desc');
		
		$config['total_post'] = count($nb_threads);
		$config['limit'] = $limit;

		$this->pager->initialize($config);



		$thread_list = $this->m_posts->get_user_threads($data['account']->ID, 'desc',array('index'=>$index,'limit'=>$limit));
		#print_r($thread_list);
		#$blog_list = $this->m_blogs->get_user_blog($this->session->userdata('user_id'));
		if(count($thread_list)>0){
		$data['thread_list'] = $thread_list;
		}
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));
		#$data['blog_series'] = $this->m_blogs->get_blog_series($data['account']->ID);

		$this->load->view('member/v_member_forum', $data);

		#redirect('member/forum/create');
	}
	
	function create()
	{
		$data['forum_id'] = $this->uri->segment(4);
		
		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');
		$data['title'] = $this->title.' | Start a new forum topic';
		$data['action'] = 'add';
		$data['forums'] = $this->m_forums->read();
		$this->load->view('member/v_member_forum_form', $data);

	}

	
	function create_exec()
	{
		//store to threads
		if(!($this->input->post('forum_id')) || !($this->input->post('title')) || !($this->input->post('post_content')) ){
			$this->session->set_flashdata('log','Fields must not be empty!');
			redirect('member/forum/create');
		}else{
			$ref_id = $this->m_threads->create();

			//store to post
			if( ! empty($ref_id)) {
				$post_id = $this->m_posts->create($ref_id,5); //type 5 = forum topic post
				//store tags
				$this->m_tags->create($post_id);
			}
			redirect('forum/thread/'.$ref_id);
		}
	}
	
	function read()
	{
		$id = $this->uri->segment(3);
		echo $id;
	}
	
	function update()
	{
		$thread_id = $this->uri->segment(4);
		if($this->m_threads->check_author($thread_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
		$data['title'] = $this->title.' | Edit Thread';
		$data['action'] = 'edit';
		$data['thread_info'] = $this->m_threads->read($thread_id);
		//$data['project_photo'] = $this->m_projects->get_project_photo($project_id);

		$data['post'] = $this->m_posts->get_post_by_type_ref(5, $thread_id); //type_id:3 = blog

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

		$data['forums'] = $this->m_forums->read();
		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');

		$this->load->view('member/v_member_forum_form', $data);
		}

	}
	
	function update_exec()
	{
		if($this->m_threads->check_author($this->input->post('thread_id'))==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			//update blogs
			$update = $this->m_threads->update();

			//update post
			$this->m_posts->update();
	
			//update tags
			$post = $this->m_posts->get_post_by_type_ref(5, $this->input->post('thread_id')); //type_id:5 = threads
			$ch_tag = $this->m_tags->read($post->ID);
			if(!empty($ch_tag)){
				$this->m_tags->update($post->ID);
			}else{
				$this->m_tags->create($post->ID);
			}

			redirect('member/forum');
		}
	}
	
	function delete()
	{
		#$thread_id = $this->uri->segment(4);
		$thread_id = $this->input->post('thread_id');

		if($this->m_threads->check_author($thread_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			#soft delete
			#$post = $this->m_posts->get_post_by_type_ref(4, $thread_id); //type_id:5 = threads
			$this->m_posts->delete_by_type_ref(5, $thread_id); //type_id:5 = threads

			redirect('member/forum');

		}
	}

}

/* End of file review.php */
/* Location: ./system/application/controllers/review.php */