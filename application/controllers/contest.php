<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends Public_Controller {
	
	private $active = 'contest';
	
	function __construct()
	{
		parent::__construct();
		$this->title = $this->title.' - Contests';
		$this->load->model(array(
			'm_contests', 'm_accounts','m_projects','m_submissions','m_votes'
		));
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));
      	$this->load->vars(array('active'=>$this->active,'page_css'=>array('contents')));
	}
	
	function index()
	{
		$data['title'] =  $this->title;

		$data['add_css'] = array('contest');
		
		$data['contests'] = $this->m_contests->read();
		
		$this->load->view('v_all_contest', $data);
	}

	function read()
	{
		$id = $this->uri->segment(2);
		$data['add_css'] = array('fancybox/jquery.fancybox-1.3.1');
		$data['add_js'] = array('fancybox/jquery.fancybox-1.3.1.pack','like');

		$data['contest_info'] = $this->m_contests->read($id);
		
		$data['user_project'] = $this->m_projects->get_user_project($this->session->userdata('user_id'));
		if(count($data['user_project'])>0){
		$data['user_has_project'] = true;	
		}else{
		$data['user_has_project'] = false;	
		}
		
		$data['title'] =  $this->title.' | '.$data['contest_info']->title;
		
		$this->load->view('v_contest', $data);
	}

	function submit()
	{
		$data['add_css'] = array('validationEngine.jquery');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en','contest_submit');

		if( $this->session->userdata('logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access this page without logging in');
			redirect('account/login');
		}
		
		$contest_id = $this->uri->segment(2);
		$data['contest_info'] = $this->m_contests->read($contest_id);
		
		$data['user_project'] = $this->m_projects->get_user_project($this->session->userdata('user_id'));
		if(count($data['user_project'])>0){
		$data['user_has_project'] = true;	
		}else{
		$data['user_has_project'] = false;	
		}
		
		$data['submit'] = true;
		$data['contest_id'] = $contest_id;
		
		$data['user_submission']= $this->m_submissions->check_submission($this->session->userdata('user_id'),$contest_id);
		if(count($data['user_submission'])>0){
			$data['project_info'] = $this->m_projects->get_project($data['user_submission']->project_id);
		}
		
		$data['title'] =  $this->title.' | '.$data['contest_info']->title.' - Submit Your Hunts';
		
		$this->load->view('v_contest', $data);
	}

	function submit_exec(){
		$project_id = $this->input->post('project_id');
		$contest_id = $this->input->post('contest_id');

		if($this->m_projects->check_author($project_id)==0){
			#echo "huh? is this yours?";
			redirect('denied');

		}else{
			#echo "welcome to heaven";
			//submit to table submissions
			$this->m_submissions->create();
		}

		$contest_info = $this->m_contests->read($contest_id);
		
		redirect('contest/'.$contest_info->contest_id.'/'.pretty_url($contest_info->title));
	}


	function entries()
	{
		$data['add_css'] = array('contest');

		$contest_id = $this->uri->segment(2);
		$data['contest_info'] = $this->m_contests->read($contest_id);
		
		$data['user_project'] = $this->m_projects->get_user_project($this->session->userdata('user_id'));
		if(count($data['user_project'])>0){
		$data['user_has_project'] = true;	
		}else{
		$data['user_has_project'] = false;	
		}
		
		$data['submissions']= $this->m_submissions->get_submissions($contest_id);
		
		#$data['title'] =  $data['contest_info']->title/*.' Contest Entries'*/;
		$data['title'] =  $this->title.' | '.$data['contest_info']->title.' - Contest Entries';
		
		$this->load->view('v_contest_entries', $data);
	}

	function result()
	{
		$data['add_css'] = array('contest');

		$contest_id = $this->uri->segment(2);
		$data['contest_info'] = $this->m_contests->read($contest_id);
		
		$data['user_project'] = $this->m_projects->get_user_project($this->session->userdata('user_id'));
		if(count($data['user_project'])>0){
		$data['user_has_project'] = true;	
		}else{
		$data['user_has_project'] = false;	
		}
		
		$data['submissions']= $this->m_submissions->get_winners($contest_id);
		#$data['title'] =  $data['contest_info']->title/*.' Contest Entries'*/;
		$data['title'] =  $this->title.' | '.$data['contest_info']->title.' - Contest Result';
		
		$this->load->view('v_contest_result', $data);
	}

	function vote()
	{
		if( $this->session->userdata('logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access this page without logging in');
			redirect('account/login');
		}

		$data['add_css'] = array('validationEngine.jquery','contest');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en','contest_submit');

		$contest_id = $this->uri->segment(2);
		$data['contest_info'] = $this->m_contests->read($contest_id);
		
		$data['user_project'] = $this->m_projects->get_user_project($this->session->userdata('user_id'));
		if(count($data['user_project'])>0){
		$data['user_has_project'] = true;	
		}else{
		$data['user_has_project'] = false;	
		}

		$has_vote = $this->m_votes->check_votes($this->session->userdata('user_id'),$contest_id);
		if(count($has_vote)>0){
			$data['has_voted'] = TRUE;
		}
		
		$data['submissions']= $this->m_submissions->get_submissions($contest_id,array('exclude_self'=>true));
		$data['contest_id'] = $contest_id;
		
		#$data['title'] =  $data['contest_info']->title.' Submit Your Vote';
		$data['title'] =  $this->title.' | '.$data['contest_info']->title.' - Submit Your Vote';
		
		$this->load->view('v_contest_vote', $data);
	}

	function vote_exec(){
		if( $this->session->userdata('logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access this page without logging in');
			redirect('account/login');
		}

		$this->m_votes->create();
		#if($this->m_projects->check_author($project_id)==0){
		#	echo "huh? is this yours?";
		#}else{
			#echo "welcome to heaven";
			//submit to table submissions
		#	$this->m_submissions->create();
		#}

		$contest_id = $this->input->post('contest_id');
		$contest_info = $this->m_contests->read($contest_id);
		
		redirect('contest/'.$contest_info->contest_id.'/'.pretty_url($contest_info->title));
	}


}

/* End of file main.php */
/* Location: ./application/controllers/main.php */