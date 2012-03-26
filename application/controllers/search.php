<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Public_Controller {
	
	#private $title = 'Search Huntdrop';
	private $active = 'search';
	
	function __construct()
	{
		parent::__construct();
		$this->title = $this->title.' - Search Result';
		$this->load->model(array(
			'm_profiles','m_posts','m_projects', 'm_blogs', 'm_reviews', 'm_videos','m_accounts','m_comments','m_threads','m_articles','m_brands'
		));
		$this->load->helper(array(
			'pretty_url','pretty_date'
		));
      	$this->load->vars(array('active'=>$this->active,'page_css'=>array('contents')));
	}
	
	function index()
	{
		$q = $this->input->post("q");
		$t = $this->input->post("search_type");
		$data['qword'] = $q;
		$data['search_type'] = $t;

		if(!empty($q)){
			if(empty($t) || $t=="project"){
			$data['projects'] = $this->m_projects->get_project('',array('keyword'=>$q,'search_all'=>true,'limit'=>3));
			}
			if(empty($t) || $t=="blog"){
			$data['blogs'] = $this->m_blogs->get_blog('',array('keyword'=>$q,'search_all'=>true,'limit'=>3));
			}
			if(empty($t) || $t=="video"){
			$data['videos'] = $this->m_videos->get_video('',array('keyword'=>$q,'search_all'=>true,'limit'=>3));
			}
			if(empty($t) || $t=="review"){
			$data['reviews'] = $this->m_reviews->get_review('',array('keyword'=>$q,'search_all'=>true,'limit'=>3));
			}
			if(empty($t) || $t=="thread"){
			$data['threads'] = $this->m_threads->get_thread('',array('keyword'=>$q,'search_all'=>true,'limit'=>5));
			}
			if(empty($t) || $t=="user"){
			$data['users'] = $this->m_profiles->get_users(array('keyword'=>$q,'search_all'=>true,'limit'=>10));
			}
			#echo $this->db->last_query();
			#print_r($data['videos']);

		}


		$data['title'] =  $this->title;
		$this->load->view('v_search', $data);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */