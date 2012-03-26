<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend extends Member_Controller {
	
	#private $title = 'Hunterdrop - Friends';
	private $active = 'friend';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Friends';
		
		$this->load->library(array(
			'encrypt','upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_blogs','m_projects','m_reviews','m_videos','m_posts','m_comments','m_likes','m_messages','m_friends','m_forums','m_threads'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

      	$this->load->vars(array('ql_active'=>$this->active));
	}

	// private function _auth()
	// {
	// 	if( $this->session->userdata('logged_in') != TRUE) {
	// 		$this->session->set_flashdata('ref', uri_string());
	// 		$this->session->set_flashdata('log', 'you are not authorized to access admin area');
	// 		redirect('account/login');
	// 	}
	// }
	
	function index()
	{

		$data['add_css'] = array('contents','profile');
		//$data['add_js'] =  array("jquery.cycle.all.min","profile");

		$data['title'] = $this->title;
		$data['type_label'] = array(1=>'review','blog','project','video','thread',8=>'like',9=>'comment');
		$data['type_list'] = array(1=>'wrote a review','added a blog','added a project','added a video','started a new thread',8=>'liked ',9=>'commented on ');

		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);

		$data['friends'] = $this->m_friends->get_friends($this->session->userdata('user_id'));
		
		$friend_arr = array();
		foreach($data['friends'] as $r){
			$friend_arr[] = $r->account_id;
		}
		if(!empty($friend_arr)){
		$data['posts'] = $this->m_posts->get_user_posts($friend_arr,20);
		}
		//echo $this->db->last_query();

		$this->load->view('member/v_member_friend', $data);
	}


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */