<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends Public_Controller {
	
	private $active = 'forum';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'm_profiles','m_posts', 'm_accounts','m_tags', 'm_photos', 'm_comments', 'm_likes','m_forums','m_threads','m_forums'
		));
		$this->load->helper(array(
			'pretty_date'
		));
		$this->load->helper('like');

      	$this->load->vars(array('active'=>$this->active,'page_css'=>array('contents')));
	}
	
	function index()
	{
		$this->load->library('pager');
		
		$limit =10;
		$tag = '';
		//if tag exist
		if($this->uri->segment(2)=='tag'){
			$sort = 'latest';
			$data['sort'] = $sort;
			$tag = $this->uri->segment(3);
			$data['tag'] = $tag;
			$page = $this->uri->segment(5,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'forum/tag/'.$tag.'/page/';
			$config['uri_segment'] = 5;
		//pagination
		}else{
			$sort = 'latest';
			$data['sort'] = $sort;
			$page = $this->uri->segment(3,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'forum/page/';
			$config['uri_segment'] = 3;
		}

		$nb_threads = $this->m_threads->get_thread('',array('tag'=>$tag));

		$config['total_post'] = count($nb_threads);
		$config['limit'] = $limit;


		$this->pager->initialize($config);

		$data['threads'] = $this->m_threads->get_thread('',array('index'=>$index,'limit'=>$limit,'tag'=>$tag));
		
		$data['add_js'] = array('forum');
		$data['title'] =  $this->title.' - Forum';

		$data['forums'] = $this->m_forums->read();

		
		$this->load->view('v_browse_all_thread', $data);
	}

	function browse()
	{
		$forum_id = $this->uri->segment(2);
		#$data['account'] = $this->m_accounts->read_by('user_name',$user_name);

		#FOR PAGINATION#
		$this->load->library('pager');
		$limit = 10;
		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$nb_threads = $this->m_posts->get_forum_threads($forum_id, 'desc');
		$config['total_post'] = count($nb_threads);
		$config['base_url'] = base_url().'forum/'.$forum_id.'/page/';
		$config['uri_segment'] = 4;
		$config['limit'] = $limit;

		$this->pager->initialize($config);
		#FOR PAGINATION#

		
		$data['threads']  = $this->m_posts->get_forum_threads($forum_id, 'desc',array('index'=>$index,'limit'=>$limit));
		
		$data['forum_info']  = $this->m_forums->read($forum_id);
		#$data['profile'] = $this->m_profiles->read_by_account_id($data['threads']->account_id);
		#$data['user_name'] = $user_name;
		$data['title'] =  $this->title.' - '.$data['forum_info']->forum_name." Forum";
		$data['forum_id'] =  $forum_id;

		$data['forums'] = $this->m_forums->read();
		$data['add_js'] = array('forum');


		$this->load->view('v_browse_forum_thread', $data);
		
	}

	function unanswered()
	{
		$forum_id = $this->uri->segment(2);
		#$forum_id = $this->uri->segment(2);
		#$data['account'] = $this->m_accounts->read_by('user_name',$user_name);
		$tag = '';
		#FOR PAGINATION#
		$this->load->library('pager');
		$limit = 10;
		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		if($forum_id=='unanswered'){
		$nb_threads = $this->m_threads->get_thread('',array('unanswered'=>true));
		}else{
		$nb_threads = $this->m_threads->get_thread('',array('unanswered'=>true,'forum_id'=>$forum_id));
		}
		$config['total_post'] = count($nb_threads);
		$config['base_url'] = base_url().'forum/unanswered/page/';
		$config['uri_segment'] = 4;
		$config['limit'] = $limit;

		$this->pager->initialize($config);
		#FOR PAGINATION#

		if($forum_id=='unanswered'){
		$data['threads'] = $this->m_threads->get_thread('',array('index'=>$index,'limit'=>$limit,'unanswered'=>true));
		}else{
		$data['threads'] = $this->m_threads->get_thread('',array('index'=>$index,'limit'=>$limit,'unanswered'=>true,'forum_id'=>$forum_id));
		}
		
		#$data['forum_info']  = $this->m_forums->read($forum_id);
		#$data['profile'] = $this->m_profiles->read_by_account_id($data['threads']->account_id);
		#$data['user_name'] = $user_name;
		$data['title'] =  $this->title." - Unanswered Threads";
		$data['unanswered'] =  true;

		if($forum_id!='unanswered'){
		$data['forum_id'] =  $forum_id;
		}

		$data['add_js'] = array('forum');
		$data['forums'] = $this->m_forums->read();

		$this->load->view('v_browse_forum_thread', $data);
		
	}


	function thread()
	{
		$id = $this->uri->segment(3);

		$data['post'] = $this->m_posts->get_post_by_type_ref(5, $id); //type_id:5 = forum
		#if deleted
		if($data['post']->deleted ==1){
			#redirect to 404 or denied
			#show_error('The content has been removed');
			redirect('404');
		}
		$this->m_posts->add_view_count(5, $id);  //type_id:5 = forum

		$data['add_css'] = array('fancybox/jquery.fancybox-1.3.1');
		$data['add_js'] = array('fancybox/jquery.fancybox-1.3.1.pack','like');
		
		$data['like_bar'] = build_like($this->session->userdata('user_id'),5,$id);
		
		$data['thread_info'] = $this->m_threads->get_thread($id);
		#$data['thread_info'] = $this->m_threads->read($id);
		$data['forum_info'] = $this->m_forums->read($data['thread_info']->forum_id);
		$data['account'] = $this->m_accounts->read($data['post']->account_id);
		
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['title'] =  $this->title." - ".$data['thread_info']->title;
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		$data['likes'] = count($this->m_likes->read($id)); 

		$tags_arr = array();
		$tags = $this->m_tags->read($data['post']->ID); 
		foreach($tags as $r){
			$tags_arr[] = $r->name;
		}
		#$data['tags'] = implode(', ',$tags_arr);
		$data['tags'] = $tags_arr;
		
		$type_id = 5; // forum
		include('includes/comments_list.php');
		include('includes/comment_form.php');

		$this->load->view('v_thread', $data);
	}


}

/* End of file main.php */
/* Location: ./application/controllers/main.php */