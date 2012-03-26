<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends Public_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'm_profiles','m_posts','m_projects', 'm_blogs', 'm_reviews', 'm_videos','m_accounts','m_comments','m_threads'
		));
		$this->load->helper(array(
			'pretty_date','xml'
		));
	}
	
	
	function index()
	{
		$data['encoding'] = 'utf-8';
        $data['feed_name'] = 'Huntdrop';
        $data['feed_url'] = 'http://www.huntdrop.com';
        $data['page_description'] = 'Hunters Unite!';
        $data['page_language'] = 'en-us';
        $data['creator_email'] = 'info@huntdrop.com';
        
		$data['all_posts'] = $this->m_posts->get_latest_posts(20);
		foreach($data['all_posts'] as $r){
			if($r->type_id==1){
				$p = $this->m_reviews->read($r->ref_id);
			}elseif($r->type_id==2){
				$p = $this->m_blogs->read($r->ref_id);
			}elseif($r->type_id==3){
				$p = $this->m_projects->read($r->ref_id);
			}elseif($r->type_id==4){
				$p = $this->m_videos->read($r->ref_id);
			}elseif($r->type_id==5){
				$p = $this->m_threads->read($r->ref_id);
			}
			$data['post'][] = array('title'=>$p->title,'alias'=>$p->alias,'content'=>$p->content);
		}
		#print_r($data['all_posts']);
		$data['type_list'] = array(1=>'Review','Blog','Project','Video','Forum Thread');
		$data['links'] = array(1=>'review','blog','project','video','forum/thread');
		#$data['latest_project'] = $this->m_projects->get_project('',array('limit'=>20));
        
        header("Content-Type: application/rss+xml");
        $this->load->view('feed', $data);

		#$data['latest_blog'] = $this->m_blogs->get_blog('',array('limit'=>20));
		#$data['latest_review'] = $this->m_reviews->get_review('',array('limit'=>5));
		#$data['latest_video'] = $this->m_videos->get_video('',array('limit'=>20));
		#$data['latest_user'] = $this->m_profiles->get_users(array('limit'=>5));

	}
	
}

/* End of file feed.php */
/* Location: ./application/controllers/main.php */