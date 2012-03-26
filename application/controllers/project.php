<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends Public_Controller {
	
	#private $title = 'Hunterdrop - Projects';

	private $active = 'project';
	
	function __construct()
	{
		parent::__construct();
		#$this->title = $this->title.' - Hunts';
		$this->load->model(array(
			'm_profiles','m_posts', 'm_projects', 'm_accounts','m_tags', 'm_photos','m_comments', 'm_likes'
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
		
		$limit = 12;
		$tag = '';
		
		//if sort
		if($this->uri->segment(2)=='by'){
			$sort = $this->uri->segment(3);
			$data['sort'] = $sort;
			$page = $this->uri->segment(5,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'project/by/'.$sort.'/page/';
			$config['uri_segment'] = 5;
		
		//if tag exist
		}elseif($this->uri->segment(2)=='tag'){
			//if sort exists
			if($this->uri->segment(4)=='by'){
				$sort = $this->uri->segment(5);
				$data['sort'] = $sort;
				$tag = $this->uri->segment(3);
				$data['tag'] = $tag;
				$page = $this->uri->segment(7,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'project/tag/'.$tag.'/by/'.$sort.'/page/';
				$config['uri_segment'] = 7;
			//sort doesn't exist
			}else{
				$sort = 'latest';
				$data['sort'] = $sort;
				$tag = $this->uri->segment(3);
				$data['tag'] = $tag;
				$page = $this->uri->segment(5,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'project/tag/'.$tag.'/page/';
				$config['uri_segment'] = 5;
			}

		//pagination
		}else{
			$sort = 'latest';
			$data['sort'] = $sort;
			$page = $this->uri->segment(3,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'project/page/';
			$config['uri_segment'] = 3;
		}

		if($sort=='view'){
			$sort_by = 'posts.view';
		}elseif($sort=='active'){
			$sort_by = 'nb_comments';
		}elseif($sort=='popular'){
			$sort_by = 'nb_likes';
		}else{
			$sort_by = '';
		}
		$nb_posts = $this->m_projects->get_project('',array('sort'=>$sort_by,'tag'=>$tag));

		$config['total_post'] = count($nb_posts);
		$config['limit'] = $limit;

		$this->pager->initialize($config);

		$data['projects'] = $this->m_projects->get_project('',array('sort'=>$sort_by,'index'=>$index,'limit'=>$limit,'tag'=>$tag));

		/*foreach($data['projects'] as $r){
			#$photo = $this->m_photos->read($r->post_id); 
			#$photo_arr[] = $photo;
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = $comment;
		}
		#$data['photos'] = $photo_arr;
		$data['nb_comments'] = $comment_arr;
		*/
		$data['title'] =  $this->title.' - Hunts';
		if(!empty($tag)){
			$data['title'] .= " with tag'".$tag."'";
		}
		$data['tags'] =  $this->m_tags->get_project_tags();
		
		$this->load->view('v_browse_all_project', $data);
		
	}

	function read()
	{
		$id = $this->uri->segment(2);

		$data['post'] = $this->m_posts->get_post_by_type_ref(3, $id); //type_id:3 = project

		#if deleted
		if($data['post']->deleted ==1){
			#redirect to 404 or denied
			#show_error('The content has been removed');
			redirect('404');
		}

		$this->m_posts->add_view_count(3, $id); //type_id:3 = project

		$data['add_css'] = array('fancybox/jquery.fancybox-1.3.1');
		$data['add_js'] = array('fancybox/jquery.fancybox-1.3.1.pack','like');

		$data['like_bar'] = build_like($this->session->userdata('user_id'),3,$id);

		$data['project_info'] = $this->m_projects->read($id);
		$data['account'] = $this->m_accounts->read($data['post']->account_id);
		$data['photos'] = $this->m_photos->read($data['post']->ID);
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);

		$data['other_projects'] = $this->m_posts->get_user_projects($data['account']->ID, 'desc',array('limit'=>5));

		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		$data['likes'] = count($this->m_likes->read_arr(array('post_id'=>$data['project_info']->ID,'post_type'=>3)));
		#$data['likes'] = count($this->m_likes->read_arr(array($data['post']->ID)); 

		$tags_arr = array();
		$tags = $this->m_tags->read($data['post']->ID); 
		foreach($tags as $r){
			$tags_arr[] = $r->name;
		}
		#$data['tags'] = implode(', ',$tags_arr);
		$data['tags'] = $tags_arr;


		#$data['title'] =  $this->title.' - Hunts | '.$data['project_info']->title;
		$data['title'] =  $this->title.' - '.$data['project_info']->title.' by '.$data['account']->user_name;
		$data['page_description'] =  substr(trim(strip_tags($data['project_info']->content)),0,150);

		$type_id = 3; // project
		include('includes/comments_list.php');
		include('includes/comment_form.php');

		$this->load->view('v_project', $data);
	}

	function browse()
	{
		$user_name = $this->uri->segment(2);
		
		$data['account'] = $this->m_accounts->read_by('user_name',$user_name);

		#FOR PAGINATION#
		$this->load->library('pager');
		$limit = 10;
		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$nb_posts = $this->m_posts->get_user_projects($data['account']->ID, 'desc');
		$config['total_post'] = count($nb_posts);
		$config['base_url'] = base_url().'project/'.$user_name.'/page/';
		$config['uri_segment'] = 4;
		$config['limit'] = $limit;

		$this->pager->initialize($config);
		#FOR PAGINATION#
		
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['projects'] = $this->m_posts->get_user_projects($data['account']->ID, 'desc',array('index'=>$index,'limit'=>$limit));
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['user_name'] = $user_name;
		$data['title'] =  $this->title.' - '.$data['account']->user_name."'s Hunts";
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		/*foreach($data['projects'] as $r){
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = $comment;
		}
		$data['nb_comments'] = $comment_arr*/

		$this->load->view('v_browse_user_project', $data);
		
	}


}

/* End of file main.php */
/* Location: ./application/controllers/main.php */