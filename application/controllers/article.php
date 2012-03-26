<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends Public_Controller {
	
	#private $title = 'Huntdrop Articles';
	private $active = 'article';
	
	function __construct()
	{
		parent::__construct();
		$this->title = $this->title.' - Articles';
		$this->load->model(array(
			'm_articles'
		));
		$this->load->helper(array(
			'pretty_url'
		));
      	$this->load->vars(array('active'=>$this->active,'page_css'=>array('contents')));
	}
	
	function index()
	{
		$article_id = $this->uri->segment(2);

		$data['title'] =  $this->title;
		$data['article_id'] =  $article_id;
		
		if(empty($article_id)){
		$data['articles'] = $this->m_articles->read();
		}else{
		$data['articles'] = $this->m_articles->read($article_id);
		}
		$this->load->view('v_article', $data);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */