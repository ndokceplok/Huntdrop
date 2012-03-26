<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_videos extends CI_Model {

	private $type = 4;

	function __construct(){
		parent::__construct();
	}

	function create($account_id) 
	{
		//INSERT table blogs
		if(!($this->input->post('title')) || !($this->input->post('youtube_id')) || !($this->input->post('post_content')) ){
			return FALSE;
		}else{
			$youtube_id= $this->input->post('youtube_id');
			preg_match('/\?v=([a-z0-9\-_]+)\&?/i',$youtube_id,$a) || preg_match('/([a-z0-9\-_]+)/i',$youtube_id,$a);
			$id = $a[1];

			$data = array(
				'title' => $this->input->post('title'),
				'alias' => pretty_url($this->input->post('title')),
				'youtube_id' => $id,
				'content' => $this->input->post('post_content'),
			);
			$this->db->insert('videos', $data);
			return $this->db->insert_id();
		}
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->select('*');
			$this->db->from('videos');
			$this->db->where('videos.ID', $id);
			$q = $this->db->get();
			
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			redirect('404');	
			}
		} else {
			$q = $this->db->get('blogs');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('videos');
		$r = $q->result();
		return $r;
	}
	
	function count_user_video($account_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->where('type_id', $this->type);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function get_user_video($account_id,$order='asc')
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('videos','posts.ref_id=videos.ID');
		$this->db->where('account_id',$account_id);
		$this->db->where('type_id',$this->type);
		$this->db->order_by("videos.ID", $order); 
		$q = $this->db->get();
		return $q->result();
		
	}

	function check_author($video_id)
	{
		$this->db->where('ref_id', $video_id);
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$this->db->where('type_id', $this->type);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function update()
	{
		//check if the blog author is the one who's logged in
		##### EXPERIMENTAL : COMMENT TO ENABLE ADMIN UPDATE. UNCOMMENT IF THERE'S PROBLEM
		#if($this->check_author($this->input->post('video_id'))>0){
			//yes -> update
			
			//check if series_id submitted is in ID or in String
			//if in ID, insert new row to  table blog_series
			//check for duplicate

			$youtube_id= $this->input->post('youtube_id');
			preg_match('/\?v=([a-z0-9\-_]+)\&?/i',$youtube_id,$a) || preg_match('/([a-z0-9\-_]{11})/i',$youtube_id,$a);
			$id = $a[1];
		
			$data = array(
				'title' => $this->input->post('title'),
				'alias' => pretty_url($this->input->post('title')),
				'youtube_id' => $id,
				'content' => $this->input->post('post_content')
			);
			
			$this->db->where('ID', $this->input->post('video_id'));
			$this->db->update('videos', $data); 
			
		##### EXPERIMENTAL : COMMENT TO ENABLE ADMIN UPDATE. UNCOMMENT IF THERE'S PROBLEM
		#}
		
	}

	function delete($video_id) 
	{

		$this->db->where('ID', $video_id);
		$this->db->delete('videos'); 
		
	}

	function get_post($video_id)
	{
		$this->db->where('ref_id', $video_id);
		$this->db->where('type_id', $this->type);
		$q = $this->db->get('posts');
		$r = $q->row();

		return $r;

	}

	function count_blog()
	{
		$q = $this->db->get('videos');
		$r = $q->num_rows();
		return $r;
	}

	function get_video($id='',$args='')
	{
		$this->db->select('*, videos.ID as video_id, posts.ID as post_id, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type='.$this->type.' AND x.post_id = videos.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type='.$this->type.' AND y.post_id = videos.ID) as nb_likes');
		$this->db->from('videos');
		$this->db->join('posts','posts.ref_id=videos.ID','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		if(!empty($args['tag'])){
			$this->db->join('tags','tags.post_id=posts.ID','left');
		}
		if(!empty($args['keyword'])){
			$where = "(";
				$where.= "videos.title LIKE '%".$args['keyword']."%'";
				if(!empty($args['search_all'])){
					$where.= " OR videos.content LIKE '%".$args['keyword']."%'";
				}
			$where.= ")";
			$this->db->where($where);
			#$this->db->or_like('videos.title',$args['keyword']);
			#if(!empty($args['search_all'])){
			#	$this->db->or_like('videos.content',$args['keyword']);
			#	#$this->db->group_by('videos.ID');
			#}
		}

		# ADMIN DISPLAY ALL
		if(empty($args['admin'])){
			$this->db->where('posts.deleted',NULL);
		}else{
			$this->db->select('posts.deleted as post_deleted');
			$this->db->select('(SELECT user_name FROM accounts WHERE ID = posts.deleted_by) AS deleter');
		}
		#$this->db->where('posts.deleted',NULL);
		
		$this->db->where('type_id',$this->type);
		if(empty($id)){

			if(!empty($args['tag'])){
				$this->db->where('tags.name',$args['tag']); 
			}
			
			if(!empty($args['sort'])){
				$this->db->order_by($args['sort'],'desc'); 
			}else{
				$this->db->order_by("posts.entry_date", "desc");
			}
			
			if(!empty($args['limit'])){
				if(isset($args['index'])){
					$index = $args['index'];
				}else{
					$index = 0;
				}
				$this->db->limit($args['limit'],$index); 		
			}

		}else{
		$this->db->where('videos.ID',$id);
		}

		$q = $this->db->get();
		if(empty($id)){
			return $q->result();
		}else{
			return $q->row();
		}
	}


	function get_top_video_bloggers()
	{
		$q = $this->db->query('SELECT *, COUNT(account_id) as total_video_blogs FROM `posts` b
					LEFT JOIN accounts a ON b.account_id = a.ID
					WHERE type_id = '.$this->type.' 
					AND b.deleted IS NULL
					GROUP BY account_id');
		return $q->result();
	}

}

/* End of file m_blogs.php */
/* Location: ./application/models/m_blogs.php */