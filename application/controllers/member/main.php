<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Member_Controller {
	
	#private $title = 'Hunterdrop - Member';
	private $active = 'dashboard';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Member Dashboard';
		
		$this->load->library(array(
			'encrypt','upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_blogs','m_projects','m_reviews','m_videos','m_posts','m_comments','m_likes','m_messages','m_threads'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

      	$this->load->vars(array('ql_active'=>$this->active));
	}

	function index()
	{

		$data['add_css'] = array('contents','profile');
		$data['add_js'] =  array("jquery.cycle.all.min","profile");

		$data['title'] = $this->title;
		$data['type_label'] = array(1=>'review','blog','project','video','thread',8=>'like',9=>'comment');
		$data['type_list'] = array(1=>'Wrote a review','Added blog entry','Added a project','Added a video','Start A New Thread',8=>'Liked ',9=>'Commented on ');

		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['posts'] = $this->m_posts->get_user_posts($data['account']->ID,20);
		#$data['total_posts'] = count($data['posts']);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		$data['unread'] = $this->m_messages->count_unread_messages($this->session->userdata('user_id'));

		$data['blogs'] = $this->m_posts->get_user_blogs($data['account']->ID,'desc');
		/*foreach($data['blogs'] as $r){
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = count($comment);
		$data['blog_nb_comments'] = $comment_arr;
		}*/

		$data['videos'] = $this->m_posts->get_user_videos($data['account']->ID,'desc');
		/*foreach($data['videos'] as $r){
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$comment_arr[] = count($comment);
		$data['video_nb_comments'] = $comment_arr;
		}*/

		$data['projects'] = $this->m_posts->get_user_projects($data['account']->ID,'desc');
		/*foreach($data['projects'] as $r){
			$comment = $this->m_posts->get_content_comment($r->ref_id); 
			$project_comment_arr[] = count($comment);
		$data['project_nb_comments'] = $project_comment_arr;
		}*/
		$data['reviews'] = $this->m_posts->get_user_reviews($data['account']->ID,'desc');

		$this->load->view('member/v_member_dashboard', $data);
	}


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */