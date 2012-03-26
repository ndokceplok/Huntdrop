<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends Public_Controller {
	
	#private $title = 'Hunterdrop - Reviews';
	private $active = 'review';
	
	function __construct()
	{
		parent::__construct();
		#$this->title = $this->title.' - Reviews';
		$this->load->model(array(
			'm_profiles','m_posts', 'm_reviews', 'm_accounts','m_tags', 'm_photos','m_comments', 'm_likes','m_categories','m_brands'
		));
		$this->load->helper(array(
			'pretty_date'
		));
		$this->load->helper('like');
		
      	$this->load->vars(array('active'=>$this->active,'page_css'=>array('contents')));
	}
	
	function index()
	{
		$data['add_css'] = array('rateit','narrow_tabs');
		$data['add_js'] = array('jquery.rateit.min','tabs');

		$this->load->library('pager');
		
		$limit = 10;
		$category = $brand = $tag = '';
		
		//if sort
		if($this->uri->segment(2)=='by'){
			$sort = $this->uri->segment(3);
			$data['sort'] = $sort;
			$page = $this->uri->segment(5,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'review/by/'.$sort.'/page/';
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
				$config['base_url'] = base_url().'review/tag/'.$tag.'/by/'.$sort.'/page/';
				$config['uri_segment'] = 7;
			//sort doesn't exist
			}else{
				$sort = 'latest';
				$data['sort'] = $sort;
				$tag = $this->uri->segment(3);
				$data['tag'] = $tag;
				$page = $this->uri->segment(5,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'review/tag/'.$tag.'/page/';
				$config['uri_segment'] = 5;
			}

		//if category exist
		}elseif($this->uri->segment(2)=='category'){
			//if sort exists
			if($this->uri->segment(4)=='by'){
				$sort = $this->uri->segment(5);
				$data['sort'] = $sort;
				$category = $this->uri->segment(3);
				$data['category'] = $category;
				$page = $this->uri->segment(7,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'review/category/'.$category.'/by/'.$sort.'/page/';
				$config['uri_segment'] = 7;
			//sort doesn't exist
			}else{
				$sort = 'latest';
				$data['sort'] = $sort;
				$category = $this->uri->segment(3);
				$data['category'] = $category;
				$page = $this->uri->segment(5,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'review/category/'.$category.'/page/';
				$config['uri_segment'] = 5;
			}

		//if brand exist
		}elseif($this->uri->segment(2)=='brand'){
			//if sort exists
			if($this->uri->segment(4)=='by'){
				$sort = $this->uri->segment(5);
				$data['sort'] = $sort;
				$brand = $this->uri->segment(3);
				$data['brand'] = $brand;
				$page = $this->uri->segment(7,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'review/brand/'.$brand.'/by/'.$sort.'/page/';
				$config['uri_segment'] = 7;
			//sort doesn't exist
			}else{
				$sort = 'latest';
				$data['sort'] = $sort;
				$brand = $this->uri->segment(3);
				$data['brand'] = $brand;
				$page = $this->uri->segment(5,1);
				$index = ($page-1)*$limit;
				$config['base_url'] = base_url().'review/brand/'.$category.'/page/';
				$config['uri_segment'] = 5;
			}
		
		
		//pagination
		}else{
			$sort = 'latest';
			$data['sort'] = $sort;
			$page = $this->uri->segment(3,1);
			$index = ($page-1)*$limit;
			$config['base_url'] = base_url().'review/page/';
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
		$nb_posts = $this->m_reviews->get_review('',array('sort'=>$sort_by,'tag'=>$tag,'category'=>$category,'brand'=>$brand));

		$config['total_post'] = count($nb_posts);
		$config['limit'] = $limit;

		$this->pager->initialize($config);

		$data['reviews'] = $this->m_reviews->get_review('',array('sort'=>$sort_by,'index'=>$index,'limit'=>$limit,'tag'=>$tag,'category'=>$category,'brand'=>$brand));
		
		
		/*foreach($data['reviews'] as $r){
			$photo = $this->m_photos->read($r->post_id); 
			$photo_arr[] = $photo;
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = $comment;
		}
		$data['photos'] = $photo_arr;
		$data['nb_comments'] = $comment_arr;
		*/
		$data['title'] =  $this->title.' - Reviews';
		$data['categories'] = $this->m_categories->read();
		$data['brands'] = $this->m_brands->read();


		$this->load->view('v_browse_all_review', $data);
		
	}

	function read()
	{
		$id = $this->uri->segment(2);

		$data['post'] = $this->m_posts->get_post_by_type_ref(1, $id); //type_id:1 = review
		
		#if deleted
		if($data['post']->deleted ==1){
			#redirect to 404 or denied
			#show_error('The content has been removed');
			redirect('404');
		}

		$this->m_posts->add_view_count(1, $id); //type_id:1 = review

		$data['add_css'] = array('rateit','fancybox/jquery.fancybox-1.3.1');
		$data['add_js'] = array('jquery.rateit.min','fancybox/jquery.fancybox-1.3.1.pack','like');

		$data['like_bar'] = build_like($this->session->userdata('user_id'),1,$id);

		$data['review_info'] = $this->m_reviews->read($id);
		#$data['post'] = $this->m_posts->get_post_by_type_ref(1, $id); //type_id:1 = review
		$data['account'] = $this->m_accounts->read($data['post']->account_id);
		#$data['tags'] = $this->m_tags->read($data['post']->ID); 
		$data['photos'] = $this->m_photos->read($data['post']->ID); 
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		#$data['likes'] = count($this->m_likes->read($data['post']->ID)); 
		$data['likes'] = count($this->m_likes->read_arr(array('post_id'=>$data['review_info']->ID,'post_type'=>1)));

		$tags_arr = array();
		$tags = $this->m_tags->read($data['post']->ID); 
		foreach($tags as $r){
			$tags_arr[] = $r->name;
		}
		#$data['tags'] = implode(', ',$tags_arr);
		$data['tags'] = $tags_arr;

		#$data['title'] =  $data['review_info']->object.' - '.$data['review_info']->title;
		$data['title'] =  $this->title.' - '.$data['review_info']->object.' - '.$data['review_info']->title.' Review by '.$data['account']->user_name;
		$data['page_description'] =  substr(trim(strip_tags($data['review_info']->content)),0,150);
		
		$type_id = 1; // review
		include('includes/comments_list.php');
		include('includes/comment_form.php');
		$this->load->view('v_review', $data);
	}

	function browse()
	{
		$user_name = $this->uri->segment(2);
		
		$data['add_css'] = array('rateit');
		$data['add_js'] = array('jquery.rateit.min');
		$data['account'] = $this->m_accounts->read_by('user_name',$user_name);

		#FOR PAGINATION#
		$this->load->library('pager');
		$limit = 10;
		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$nb_posts = $this->m_posts->get_user_reviews($data['account']->ID, 'desc');
		$config['total_post'] = count($nb_posts);
		$config['base_url'] = base_url().'review/'.$user_name.'/page/';
		$config['uri_segment'] = 4;
		$config['limit'] = $limit;

		$this->pager->initialize($config);
		#FOR PAGINATION#
		
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['reviews'] = $this->m_posts->get_user_reviews($data['account']->ID, 'desc',array('index'=>$index,'limit'=>$limit));
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['user_name'] = $user_name;
		$data['title'] =  $this->title.' - '.$data['account']->user_name."'s Reviews";
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		/*foreach($data['reviews'] as $r){
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = $comment;
		}
		$data['nb_comments'] = $comment_arr;
		*/
		$this->load->view('v_browse_user_review', $data);
		
	}


}

/* End of file main.php */
/* Location: ./application/controllers/main.php */