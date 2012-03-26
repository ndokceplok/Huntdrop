<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends Admin_Controller {
  
  #private $title = 'Hunterdrop - Back Admin Blogs List';
  private $active = 'comment';

  function __construct()
  {
    parent::__construct();
    $this->_auth();
    $this->title = $this->title.' - Comments List';
    
    $this->load->library(array(
      'upload'
    ));

    $this->load->model(array(
      'm_accounts','m_profiles','m_blogs','m_reviews','m_videos','m_posts','m_tags','m_comments'
    ));
    
    $this->load->helper(array(
      'pretty_date','pretty_url','ckeditor'
    ));

    $this->load->vars(array('active'=>$this->active));
  }
  
  function index()
  {

    $data['add_css'] = array('backadmin/table');
    $data['add_js'] = array('jquery.jeditable','notice');
    $data['type_label'] = array(1=>'review','blog','project','video','thread');

    $this->load->library('pager');
    $limit =100;

    $only = '';

    #showing only certain types
    if($this->uri->segment(3)=='only'){
      $only = $this->uri->segment(4);
      $page = $this->uri->segment(6,1);
      $index = ($page-1)*$limit;
      $config['base_url'] = $this->admin_link.'comment/only/'.$only.'/page/';
      $config['uri_segment'] = 6;
    }else{
      $page = $this->uri->segment(4,1);
      $index = ($page-1)*$limit;
      $config['base_url'] = $this->admin_link.'comment/page/';
      $config['uri_segment'] = 4;
    }

    $data['only'] = $only;

    if($only != 'profile'){
      $only = array_search($only,$data['type_label']);
    }
    $nb_comments = $this->m_comments->get_all_comments(array('only'=>$only));
    $config['total_post'] = count($nb_comments);
    $config['limit'] = $limit;
    $this->pager->initialize($config);

    $data['comments'] = $this->m_comments->get_all_comments(array('index'=>$index,'limit'=>$limit,'only'=>$only));

   
    $data['title'] = $this->title;
    $this->load->view('backadmin/v_comment', $data);
  }

  function update()
  {
    //update the item POSTed
    $comment_id = $this->input->post('id');
    $value = $this->input->post('value');

    $this->db->set('content',strip_tags($value));
    $this->db->where('ID',$comment_id);
    $this->db->update('comments');

    $r = $this->m_comments->read($comment_id);

    echo $r->content;

  }

  function search()
  {

    $data['add_css'] = array('backadmin/table');
    $keyword = $this->input->post('keyword');
    if(empty($keyword)){
      redirect($this->admin_link.'blog');
    }
    $data['blogs'] = $this->m_blogs->get_blog('',array('keyword'=>$keyword));
    
    $data['keyword'] = $keyword;
    $data['title'] = $this->title;
    $this->load->view('backadmin/v_blog', $data);
  }

  function hide()
  {
    $comment_id = $this->uri->segment(4);
    $toggle = $this->m_comments->toggle_comment($comment_id,'hide');
    if($toggle){
      echo "success";      
    }
    #redirect($this->admin_link.'comment');
  }

  function show()
  {
    $comment_id = $this->uri->segment(4);
    $toggle = $this->m_comments->toggle_comment($comment_id,'show');
    if($toggle){
      echo "success";      
    }
    #redirect($this->admin_link.'comment');
  }


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */