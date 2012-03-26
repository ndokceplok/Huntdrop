<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends Member_Controller {

	#private $title = 'Hunterdrop - Member Videos';
	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Member Videos';
		$this->load->library(array(
			'upload'
		));
		$this->load->model(array(
			'm_posts', 'm_videos', 'm_accounts','m_tags', 'm_photos', 'm_profiles', 'm_comments', 'm_likes'
		));
		$this->load->helper(array(
			'pretty_date','pretty_url','ckeditor'
		));

      	$this->load->vars(array('ql_active'=>'video','page_css'=>array('contents')));
	}
	
	function index()
	{
		$data['title'] = $this->title;
		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		$data['add_js'] = array('notice');

		$this->load->library('pager');
		
		$limit =10;

		$page = $this->uri->segment(4,1);
		$index = ($page-1)*$limit;
		$config['base_url'] = base_url().'member/video/page/';
		$config['uri_segment'] = 4;

		$nb_videos = $this->m_posts->get_user_videos($data['account']->ID, 'desc');
		
		$config['total_post'] = count($nb_videos);
		$config['limit'] = $limit;

		$this->pager->initialize($config);


		$video_list = $this->m_posts->get_user_videos($data['account']->ID, 'desc',array('index'=>$index,'limit'=>$limit));
		if(count($video_list)>0){
		$data['video_list'] = $video_list;
		#print_r($video_list);
			foreach($video_list as $i){
				$data['post_tags'][] = $this->m_tags->read($i->ID);
			}
			#print_r($data['post_tags']);
		}
		$data['profile'] = $this->m_profiles->read_by_account_id($data['account']->ID);
		$data['nb_posts'] = $this->m_posts->count_user_posts($data['account']->ID);
		$data['nb_days'] = get_total_days($data['profile']->member_since,date("Y-m-d"));

		
		#$data['tags'] = $this->m_tags->get_project_tags(array('user_id'=>$this->session->userdata('user_id')));

		$this->load->view('member/v_member_video', $data);
	}
	
	function create()
	{
		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');
		$data['title'] = $this->title.' | Create a Video Entry';
		$data['action'] = 'add';
		$this->load->view('member/v_member_video_form', $data);

	}

	function check_youtube()
	{
		//echo $_POST['youtube_id'];  http://www.youtube.com/watch?v=_YtzsUdSC_I&feature=feedrec_grec_index
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
	
	function create_exec()
	{
		//store to videos
		
		$ref_id = $this->m_videos->create($this->session->userdata('user_id'));

		//store to post
		if( ! empty($ref_id)) {
			$post_id = $this->m_posts->create($ref_id,4);
			//store tags
			$this->m_tags->create($post_id);
		}else{
			$this->session->set_flashdata('log','Fields must not be empty!');
			redirect('member/video/create');
		}
		redirect('member/video');
		
	}
	
	function read()
	{
		$id = $this->uri->segment(3);
		echo $id;
	}
	
	function update()
	{

		$video_id = $this->uri->segment(4);
		if($this->m_videos->check_author($video_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
		$data['title'] = $this->title.' | Update Video';
		$data['action'] = 'edit';
		
		$data['video_info'] = $this->m_videos->read($video_id);
		$data['post'] = $this->m_posts->get_post_by_type_ref(4, $video_id); //type_id:4 = video
		$tags = $this->m_tags->read($data['post']->ID); 
		$data['tags']='';
		$i = 1;
		foreach($tags as $r){
			if($i>1){
				$data['tags'] .= ", ";
			}
			$data['tags'] .= $r->name;
			$i++;
		}

		$data['add_css'] = array('jquery.tagsinput','validationEngine.jquery');
		$data['add_js'] = array('jquery.tagsinput','jquery.validationEngine','jquery.validationEngine-en');

		$this->load->view('member/v_member_video_form', $data);
		}
	}
	
	function update_exec()
	{
		if($this->m_videos->check_author($this->input->post('video_id'))==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			//update videos
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

			redirect('member/video');
		}
	}
	
	function delete()
	{
		$video_id = $this->input->post('video_id');

		if(empty($video_id)){
			redirect('denied');
		}

		if($this->m_videos->check_author($video_id)==0){
			#echo "go to hell";
			redirect('denied');
		}else{
			#soft delete
			#$post = $this->m_posts->get_post_by_type_ref(4, $project_id); //type_id:4 = video
			$this->m_posts->delete_by_type_ref(4, $video_id); //type_id:4 = video

			redirect('member/video');

		}

	}

}

/* End of file review.php */
/* Location: ./system/application/controllers/review.php */