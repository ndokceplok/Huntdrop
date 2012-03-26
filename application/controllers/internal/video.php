<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Videos List';
	private $active = 'video';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Videos List';
		
		$this->load->library(array(
			'upload'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_videos','m_posts','m_tags','m_photos'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
		));

      	$this->load->vars(array('active'=>$this->active));
	}

	function check_youtube()
	{
		$youtube_id= $this->input->post('youtube_id');
		if(preg_match('/\?v=([a-z0-9\-_]+)\&?/i',$youtube_id,$a) || preg_match('/([a-z0-9\-_]+)/i',$youtube_id,$a)){
			$id = $a[1];
			
			$headers = get_headers('http://gdata.youtube.com/feeds/api/videos/' . $id);
			if (!strpos($headers[0], '200')) {
				echo "invalid";
			}
		}else{
			echo "invalid";
		}
	}
	
	function index()
	{
		$data['add_css'] = array('backadmin/table');
		$data['add_js'] = array('notice');

		$this->load->library('pager');
		
		$limit =10;
		$sort = 'latest';
		$data['sort'] = $sort;
		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$config['base_url'] = $this->admin_link.'video/page/';
		$config['uri_segment'] = 4;

		$sort_by = '';
		$nb_videos = $this->m_videos->get_video('',array('sort'=>$sort_by));
		$config['total_post'] = count($nb_videos);
		$config['limit'] = $limit;
		$this->pager->initialize($config);

		$data['videos'] = $this->m_videos->get_video('',array('sort'=>$sort_by,'index'=>$index,'limit'=>$limit,'admin'=>true));

		#$data['videos'] = $this->m_videos->get_video();
		
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_video', $data);
	}

	function update()
	{

		$video_id = $this->uri->segment(4);

		$data['add_css'] = array('backadmin/table','jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');
		
		$data['action'] = 'edit';
		$data['title'] = $this->title;
		$data['video_info'] = $this->m_videos->get_video($video_id,array('admin'=>true));

		$tags = $this->m_tags->read($data['video_info']->post_id); 
		$data['tags'] ='';
		$i = 1;
		foreach($tags as $r){
			if($i>1){
				$data['tags']  .= ", ";
			}
			$data['tags']  .= $r->name;
			$i++;
		}

		$this->load->view('backadmin/v_video_form', $data);
	}

	function update_exec()
	{
		//update blogs
		$update = $this->m_videos->update();

		//update post
		$this->m_posts->update();

		//update tags
		$post = $this->m_posts->get_post_by_type_ref(4, $this->input->post('video_id')); //type_id:4 = video
		$ch_tag = $this->m_tags->read($post->ID);
		if(!empty($ch_tag)){
			$this->m_tags->update($post->ID);
		}else{
			$this->m_tags->create($post->ID);
		}

		redirect($this->admin_link.'video');
	}

	function search()
	{

		$data['add_css'] = array('backadmin/table');
		$keyword = $this->input->post('keyword');
		if(empty($keyword)){
			redirect($this->admin_link.'video');
		}
		$data['videos'] = $this->m_videos->get_video('',array('keyword'=>$keyword));
		
		$data['keyword'] = $keyword;
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_video', $data);
	}

	function delete()
	{
		$video_id = $this->uri->segment(4);
		#$video_id = $this->input->post('video_id');

		if(empty($video_id)){
			redirect($this->admin_link.'video');
		}

		#soft delete
		$post = $this->m_posts->read_by_type_ref(4, $video_id);
		if(empty($post->deleted)){
			$this->m_posts->delete_by_type_ref(4, $video_id, TRUE); //type_id:4 = video
		}
		redirect($this->admin_link.'video');
		
	}


}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */