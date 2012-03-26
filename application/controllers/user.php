<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Public_Controller {
	
	#private $title = 'Hunterdrop - User Profile';
	private $active = 'user';

	function __construct()
	{
		parent::__construct();
		#$this->title = $this->title;
		$this->load->model(array(
			'm_profiles','m_posts', 'm_projects', 'm_accounts', 'm_reviews', 'm_blogs', 'm_projects','m_videos','m_comments','m_likes','m_friends','m_threads'
		));
		$this->load->helper(array(
			'pretty_date','link_helper'
		));

      	$this->load->vars(array('active'=>$this->active,'page_css'=>array('contents','profile')));
	}
	
	function index()
	{
		$sort = $this->uri->segment(3);
		$data['title'] =  $this->title." - Hunters";
		$data['add_css'] =  array("users");


		$this->load->library('pager');
		
		$limit =20;
		$tag = '';
		//if sort
		if($this->uri->segment(2)=='by'){
			$sort = $this->uri->segment(3);
			$data['sort'] = $sort;
			$page = $this->uri->segment(5,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'user/by/'.$sort.'/page/';
			$config['uri_segment'] = 5;

		//pagination
		}else{
			$sort = 'latest';
			$data['sort'] = $sort;
			$page = $this->uri->segment(3,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'user/page/';
			$config['uri_segment'] = 3;
		}
		
		if($sort=='active'){
			$sort_by = 'total_posts';
		}else{
			$sort_by = '';
		}
		if($sort=='online'){
			$nb_users = $this->m_profiles->get_users(array('online'=>true));
		}else{
			$nb_users = $this->m_profiles->get_users(array('sort'=>$sort_by));
		}

		$config['total_post'] = count($nb_users);
		$config['limit'] = $limit;

		$this->pager->initialize($config);

		if($sort=='online'){
			$data['users'] = $this->m_profiles->get_users(array('online'=>true,'index'=>$index,'limit'=>$limit));
		}else{
			$data['users'] = $this->m_profiles->get_users(array('sort'=>$sort_by,'index'=>$index,'limit'=>$limit));
		}
		/*foreach($data['users'] as $r){
			$nb_post = $this->m_posts->count_user_posts($r->account_id);
			$arr[] = $nb_post;
		}
		$data['total_posts'] = $arr;*/
		$this->load->view('v_all_user', $data);
	}

	function add_friend()
	{
		$username = $this->uri->segment(2);
		$data['account'] = $this->m_accounts->read_by('user_name',$username);
		
		//if user doesn't exist
		if(count($data['account'])==0){
			redirect('404');
		}
		//check if the user is adding himself as friend
		if($data['account']->ID!=$this->session->userdata('user_id')){
			//check if user has friended the friendee
			if(count($this->m_friends->check_friend($data['account']->ID))>0){
				echo 'friend exists';
				die();
			}else{
				//echo 'added friend';
				$this->m_friends->create($data['account']->ID);	
				$log = 'You have followed '.$username;
			}
		}else{
			//echo "why are you friending yourself?";
		}
		#$this->session->set_flashdata('log', $log);
		redirect('user/'.$username);
	}

	function remove_friend()
	{
		$username = $this->uri->segment(2);
		$data['account'] = $this->m_accounts->read_by('user_name',$username);
		
		//if user doesn't exist
		if(count($data['account'])==0){
			redirect('404');
		}
		//check if the user is removing himself as friend
		if($data['account']->ID!=$this->session->userdata('user_id')){
			//check if user has friended the friendee
				//echo 'added friend';
				$this->m_friends->remove_friend($data['account']->ID);	
				$log = 'You have unfollowed '.$username;
		}else{
			//echo "why are you removing yourself?";
		}
		#$this->session->set_flashdata('log', $log);
		redirect('user/'.$username);
	}
	
	function read()
	{
		$username = $this->uri->segment(2);

		$data['add_js'] =  array("jquery.cycle.all.min","profile");
		
		$data['account'] = $this->m_accounts->read_by('user_name',$username);

		//if user doesn't exist
		if(count($data['account'])==0){
			redirect('404');
		}

		if(count($this->m_friends->check_friend($data['account']->ID))>0){
			$data['already_friend'] = true;
		}

		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);

		$data['posts'] = $this->m_posts->get_user_posts($data['account']->ID);
		#$data['total_posts'] = count($data['posts']);

		$data['blogs'] = $this->m_posts->get_user_blogs($data['account']->ID,'desc');
		$data['videos'] = $this->m_posts->get_user_videos($data['account']->ID,'desc');
		$data['projects'] = $this->m_posts->get_user_projects($data['account']->ID,'desc');
		$data['reviews'] = $this->m_posts->get_user_reviews($data['account']->ID,'desc');
		$data['friends'] = $this->m_friends->get_friends($data['account']->ID);
		
		#$data['title'] =  $this->title. ' | '.$data['profile']->first_name.' '.$data['profile']->last_name.'\'s Profile';
		$data['title'] =  $this->title. ' | '.$data['account']->user_name.'\'s Profile';

		$data['type_label'] = array(1=>'review','blog','project','video','thread',8=>'like',9=>'comment');
		$data['type_list'] = array(1=>'Wrote a review','Added blog entry','Added a project','Added a video','Start A New Thread',8=>'Liked ',9=>'Commented on ');

		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		$data['comments'] = $this->m_posts->get_profile_comment($data['account']->ID); 
		$arr = NULL;
		$days_arr = NULL; 
		foreach($data['comments'] as $r){
			$nb_post = $this->m_posts->count_user_posts($r->account_id);
			$nb_days = get_total_days($r->member_since,date("Y-m-d"));
			$arr[] = $nb_post;
			$days_arr[] = $nb_days;
		}
		$data['commenter_posts'] = $arr;
		$data['commenter_days'] = $days_arr;
		
		include('includes/comment_form.php');
		
		$this->load->view('v_user', $data);
	}

	function blog()
	{
		$username = $this->uri->segment(2);
		
		$data['account'] = $this->m_accounts->read_by('user_name',$username);
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);

		$data['total_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['posts'] = $this->m_posts->get_user_posts($data['account']->ID);

		$data['blogs'] = $this->m_posts->get_user_blogs($data['account']->ID,'desc');
		$data['projects'] = $this->m_posts->get_user_projects($data['account']->ID,'desc');
		$data['reviews'] = $this->m_posts->get_user_reviews($data['account']->ID,'desc');
		
		$data['title'] =  $this->title. ' | '.$data['profile']->first_name.' '.$data['profile']->last_name;
		
		$data['type_list'] = array(1=>'Review','Blog','Project');

		$this->load->view('v_user', $data);
	}

	function friend(){
		$username = $this->uri->segment(2);
		$data['account'] = $this->m_accounts->read_by('user_name',$username);
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);

		$data['friends'] = $this->m_friends->get_friends($data['account']->ID);
		#print_r($data['friends']);

		$friend_arr = array();
		foreach($data['friends'] as $r){
			$friend_arr[] = $r->account_id;
		}
		if(!empty($friend_arr)){
		$data['posts'] = $this->m_posts->get_user_posts($friend_arr,20);
		}

		$data['type_label'] = array(1=>'review','blog','project','video','thread',8=>'like',9=>'comment');
		$data['type_list'] = array(1=>'wrote a review','added a blog','added a project','added a video','started a new thread',8=>'liked ',9=>'commented on ');

		$data['title'] =  $this->title. ' | '.$data['profile']->first_name.' '.$data['profile']->last_name.'\'s Buddies';
		$this->load->view('v_user_friend', $data);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */