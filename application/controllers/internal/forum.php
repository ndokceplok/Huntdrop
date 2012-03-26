<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Forum Settings';
	private $active = 'forum';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Forum';
		
		$this->load->model(array(
			'm_accounts','m_profiles','m_forums','m_threads'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
		));

      	$this->load->vars(array('active'=>$this->active));
	}

	/*private function _auth()
	{
		if( $this->session->userdata('admin_logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access admin area');
			redirect('backadmin/login');
		}
	}*/
	
	function index()
	{

		$data['add_css'] = array('backadmin/table');
		$data['add_js'] = array('notice');

		$data['forums'] = $this->m_forums->read();

		$this->load->library('pager');
		
		$limit =10;
		//pagination
		$sort = 'latest';
		$data['sort'] = $sort;
		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$config['base_url'] = base_url().'backadmin/forum/page/';
		$config['uri_segment'] = 4;

		$nb_threads = $this->m_threads->get_thread('');

		$config['total_post'] = count($nb_threads);
		$config['limit'] = $limit;

		$this->pager->initialize($config);

		$data['threads'] = $this->m_threads->get_thread('',array('index'=>$index,'limit'=>$limit));
		#$data['threads'] = $this->m_threads->read();

		$data['title'] = $this->title;
		$this->load->view('backadmin/v_forum', $data);
	}

	function create()
	{

		#$data['add_js'] = array('uploadify/swfobject','uploadify/jquery.uploadify.v2.1.4.min');
		#$data['add_css'] = array(/*'uploadify',*/'backadmin/table');
		$data['add_css'] = array('validationEngine.jquery','backadmin/table');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');

		#$data['parents'] = $this->m_pages->read_by('parent',0);

		$data['action'] = 'add';
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_forum_form', $data);
	}
	
	function create_exec()
	{
		
		$this->m_forums->create();
		redirect('backadmin/forum');
		#echo "aaa";
		
	}

	function update()
	{

		$forum_id = $this->uri->segment(4);

		$data['add_css'] = array('jquery.tagsinput','backadmin/table');
		$data['add_js'] = array('jquery.tagsinput');
		
		$data['action'] = 'edit';

		$data['title'] = $this->title;
		$data['forum_info'] = $this->m_forums->read($forum_id);
		$this->load->view('backadmin/v_forum_form', $data);
	}

	function update_exec()
	{
		
		$this->m_forums->update();
		redirect('backadmin/forum');
		#echo "aaa";
		
	}
	
	function delete($forum_id){
		echo $forum_id;
		#$this->m_pages->delete($page_id);
		#redirect('backadmin/page');
	}


	function thread_update()
	{

		$thread_id = $this->uri->segment(4);

		$data['add_css'] = array('backadmin/table');
		
		$data['action'] = 'edit';
		$data['forums'] = $this->m_forums->read();

		$data['title'] = $this->title;
		$data['thread_info'] = $this->m_threads->read($thread_id);
		$this->load->view('backadmin/v_thread_form', $data);
	}

	function thread_update_exec()
	{
		
		$this->m_threads->update();
		redirect('backadmin/forum');
		#echo "aaa";
		
	}
	
	function thread_delete($thread_id){
		echo $thread_id;
		#$this->m_pages->delete($page_id);
		#redirect('backadmin/page');
	}
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */