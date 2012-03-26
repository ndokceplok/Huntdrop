<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_threads extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create() 
	{
		//INSERT table threads
		$data = array(
			'forum_id' => $this->input->post('forum_id'),
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content')
		);
		$this->db->insert('threads', $data);
		return $this->db->insert_id();
		
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('threads');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			redirect('404');	
			}
		} else {
			$q = $this->db->get('threads');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('threads');
		$r = $q->result();
		return $r;
	}
	
	function update()
	{
		$data = array(
			'forum_id' => $this->input->post('forum_id'),
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content')
		);
			
		$this->db->where('ID', $this->input->post('thread_id'));
		$this->db->update('threads', $data); 
		
	}

	function delete($thread_id) 
	{

		$this->db->where('ID', $thread_id);
		$this->db->delete('threads'); 
		
	}

	function check_author($thread_id)
	{
		$this->db->where('ref_id', $thread_id);
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$this->db->where('type_id', 5);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function get_thread($id='',$args='')
	{
		$this->db->select('*, threads.title as title, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=5 AND x.post_id = threads.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=5 AND y.post_id = threads.ID) as nb_likes, (SELECT MAX(entry_date) FROM posts y LEFT JOIN comments x ON y.type_id = 9 AND y.ref_id = x.ID WHERE x.post_type=5 AND x.post_id = threads.ID) as latest_reply');
		$this->db->from('threads');
		$this->db->join('posts','posts.ref_id=threads.ID','left');
		$this->db->join('forums','forums.forum_id=threads.forum_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		if(!empty($args['tag'])){
			$this->db->join('tags','tags.post_id=posts.ID','left');
		}
		if(!empty($args['keyword'])){
			$where = "(";
				$where.= "threads.title LIKE '%".$args['keyword']."%'";
				if(!empty($args['search_all'])){
					$where.= " OR threads.content LIKE '%".$args['keyword']."%'";
				}
			$where.= ")";
			$this->db->where($where);
			#$this->db->or_like('reviews.title',$args['keyword']);
		}
		$this->db->where('type_id',5);
		$this->db->where('posts.deleted',NULL);
		if(isset($args['forum_id'])){
		$this->db->where('threads.forum_id',$args['forum_id']);
		}
		if(isset($args['unanswered'])){
		$this->db->where('(SELECT COUNT(ID) FROM comments x WHERE x.post_type=5 AND x.post_id = threads.ID) =',0);
		}
		if(empty($id)){

			if(!empty($args['tag'])){
				$this->db->where('tags.name',$args['tag']); 
			}
			
			$this->db->group_by("threads.ID"); 
			
			$this->db->order_by("posts.entry_date", "desc");
			
			if(!empty($args['limit'])){
				if(isset($args['index'])){
					$index = $args['index'];
				}else{
					$index = 0;
				}
				$this->db->limit($args['limit'],$index); 		
			}
		}else{
		$this->db->where('threads.ID',$id);
		}

		$q = $this->db->get();
		if(empty($id)){
			return $q->result();
			#echo $this->db->last_query();  exit;
			#print_r($args);exit();
		}else{
			return $q->row();
		}
	}

}

/* End of file m_blogs.php */
/* Location: ./application/models/m_blogs.php */