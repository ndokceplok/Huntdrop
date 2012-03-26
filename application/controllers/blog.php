<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Public_Controller {
	
	#private $title = 'Hunterdrop - Blogs';
	private $active = 'blog';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'm_profiles','m_posts', 'm_blogs', 'm_accounts','m_tags', 'm_photos', 'm_comments', 'm_likes'
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
		//if sort
		if($this->uri->segment(2)=='by'){
			$sort = $this->uri->segment(3);
			$data['sort'] = $sort;
			$page = $this->uri->segment(5,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'blog/by/'.$sort.'/page/';
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
				$config['base_url'] = base_url().'blog/tag/'.$tag.'/by/'.$sort.'/page/';
				$config['uri_segment'] = 7;
			//sort doesn't exist
			}else{
				$sort = 'latest';
				$data['sort'] = $sort;
				$tag = $this->uri->segment(3);
				$data['tag'] = $tag;
				$page = $this->uri->segment(5,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'blog/tag/'.$tag.'/page/';
				$config['uri_segment'] = 5;
			}
		//pagination
		}else{
			$sort = 'latest';
			$data['sort'] = $sort;
			$page = $this->uri->segment(3,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'blog/page/';
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
		$nb_blogs = $this->m_blogs->get_blog('',array('sort'=>$sort_by,'tag'=>$tag));

		
		$config['total_post'] = count($nb_blogs);
		$config['limit'] = $limit;


		$this->pager->initialize($config);


		$data['blogs'] = $this->m_blogs->get_blog('',array('sort'=>$sort_by,'index'=>$index,'limit'=>$limit,'tag'=>$tag));
		
		$data['title'] =  $this->title.' - Blogs';
		$data['top_bloggers'] = $this->m_blogs->get_top_bloggers();

		/*foreach($data['blogs'] as $r){
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = $comment;
		}
		$data['nb_comments'] = $comment_arr;
		*/
		$this->load->view('v_browse_all_blog', $data);
	}

	function read()
	{
		$id = $this->uri->segment(2);
		$data['post'] = $this->m_posts->get_post_by_type_ref(2, $id); //type_id:2 = blog

		#if deleted
		if($data['post']->deleted ==1){
			#redirect to 404 or denied
			redirect('404');
		}

		$this->m_posts->add_view_count(2, $id);  //type_id:2 = blog

		$data['add_css'] = array('fancybox/jquery.fancybox-1.3.1');
		$data['add_js'] = array('fancybox/jquery.fancybox-1.3.1.pack','like');
		
		/*$like['has_like'] =	$this->m_likes->check_like($this->session->userdata('user_id'),2,$id);
		$like['post_type'] = 2;
		$like['id'] = $id;
		$data['like_bar'] = $this->load->view('includes/like_bar.php',$like,true); 
		*/
		$data['like_bar'] = build_like($this->session->userdata('user_id'),2,$id);
		
		$data['blog_info'] = $this->m_blogs->read($id,true);
		$data['account'] = $this->m_accounts->read($data['post']->account_id);
		
		$data['photos'] = $this->m_photos->read($data['post']->ID); 
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		$data['other_blogs'] = $this->m_posts->get_user_blogs($data['account']->ID, 'desc',array('limit'=>3));
		$data['likes'] = count($this->m_likes->read_arr(array('post_id'=>$data['blog_info']->ID,'post_type'=>2)));
		//print_r($data['likes']); 
		$data['title'] =  $this->title.' - '.$data['blog_info']->title.' by '.$data['account']->user_name;
		$data['page_description'] =  substr(trim(strip_tags($data['blog_info']->content)),0,150);
		
		$tags_arr = array();
		$tags = $this->m_tags->read($data['post']->ID); 
		foreach($tags as $r){
			$tags_arr[] = $r->name;
		}
		#$data['tags'] = implode(', ',$tags_arr);
		$data['tags'] = $tags_arr;
		
		$type_id = 2; // blog
		include('includes/comments_list.php');
		include('includes/comment_form.php');

		$this->load->view('v_blog', $data);
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
		$nb_blogs = $this->m_posts->get_user_blogs($data['account']->ID, 'desc');
		$config['total_post'] = count($nb_blogs);
		$config['base_url'] = base_url().'blog/'.$user_name.'/page/';
		$config['uri_segment'] = 4;
		$config['limit'] = $limit;

		$this->pager->initialize($config);
		#FOR PAGINATION#

		
		
		$data['blogs'] = $this->m_posts->get_user_blogs($data['account']->ID, 'desc',array('index'=>$index,'limit'=>$limit));
		$data['blog_series'] = $this->m_blogs->get_blog_series($data['account']->ID);
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['user_name'] = $user_name;
		$data['title'] =  $this->title.' - '.$data['account']->user_name."'s Blogs";
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		/*foreach($data['blogs'] as $r){
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = $comment;
		}
		$data['nb_comments'] = $comment_arr;*/

		$this->load->view('v_browse_user_blog', $data);
		
	}

	function series()
	{
		$series_id = $this->uri->segment(3);
		$ser = $this->m_blogs->get_blog_series_detail($series_id);
		$data['account'] = $this->m_accounts->read($ser->account_id);
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		$data['user_name'] = $data['account']->user_name;
		$data['blog_series'] = $this->m_blogs->get_blog_series($data['account']->ID);

		#FOR PAGINATION#
		$this->load->library('pager');
		$limit = 10;
		$page = $this->uri->segment(5,1);
		$index = ($page-1)*$limit;
		$nb_blogs = $this->m_blogs->get_blog_by_series($series_id);
		$config['total_post'] = count($nb_blogs);
		$config['base_url'] = base_url().'blog/series/'.$series_id.'/page/';
		$config['uri_segment'] = 5;
		$config['limit'] = $limit;

		$this->pager->initialize($config);
		#FOR PAGINATION#

		$data['blogs'] = $this->m_blogs->get_blog_by_series($series_id,'',array('index'=>$index,'limit'=>$limit));
		
		/*if(!empty($data['blogs'])){
			foreach($data['blogs'] as $r){
				$comment = $this->m_posts->get_content_comment($r->ref_id); 
				$comment_arr[] = $comment;
			}
			$data['nb_comments'] = $comment_arr;
		}*/

		$data['title'] =  $this->title.' - '.$ser->series_name." Blog Series by".$data['account']->user_name;
		$data['series_detail'] =  $ser;

		$this->load->view('v_browse_user_blog_series', $data);
		
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */