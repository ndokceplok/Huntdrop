<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Article List';
	private $active = 'article';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Articles List';
		
		$this->load->library(array(
			'upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_articles'
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
		//if sort
		if($this->uri->segment(3)=='by'){
			$sort = $this->uri->segment(4);
			$order = $this->uri->segment(5);
			$data['order'] = $order;
			$data['sort'] = $sort;
			$page = $this->uri->segment(6,1);
			#$index = ($page-1)*$limit;
			#$config['base_url'] = base_url().'user/by/'.$sort.'/page/';
			#$config['uri_segment'] = 5;
		}

		if($this->uri->segment(3)=='by'){

			$data['articles'] = $this->m_articles->get_articles(array('sort'=>$sort,'order'=>$order));
		}else{
			$data['articles'] = $this->m_articles->get_articles();
		}
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_article', $data);
	}

	function create()
	{

		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','validationEngine.jquery');
		
		$data['action'] = 'add';
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_article_form', $data);
	}
	
	function create_exec()
	{
		
		$this->m_articles->create();
		redirect('backadmin/article');
		#echo "aaa";
		
	}

	function update()
	{

		$article_id = $this->uri->segment(4);

		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','validationEngine.jquery');
		
		$data['action'] = 'edit';
		$data['title'] = $this->title;
		$data['article_info'] = $this->m_articles->read($article_id);
		$this->load->view('backadmin/v_article_form', $data);
	}

	function update_exec()
	{
		
		$this->m_articles->update();
		redirect('backadmin/article');
		#echo "aaa";
		
	}
	
	function delete(){
		$article_id = $this->uri->segment(4);
		$this->m_articles->delete($article_id);
		redirect('backadmin/article');
	}
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */