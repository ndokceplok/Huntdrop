<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_blogs extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create($account_id,$image_data='') 
	{
		//INSERT table blogs
		if(!($this->input->post('title')) || !($this->input->post('series_id')) || !($this->input->post('post_content')) ){
			return FALSE;
		}else{
		$data = array(
			'series_id' => $this->input->post('series_id'),
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content'),
			'tag' => $this->input->post('tag')
		);
		$this->db->insert('blogs', $data);
		return $this->db->insert_id();
		}
	}
	
	function read($id=null,$series_id=false)
	{
		if($id) {
			$this->db->select('*,blogs.ID as ID');
			$this->db->from('blogs');
			if($series_id){
			$this->db->join('blog_series','blog_series.ID=blogs.series_id','left');
			}
			$this->db->where('blogs.ID', $id);
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
		$q = $this->db->get('blogs');
		$r = $q->result();
		return $r;
	}
	
	function read_by_account_id($account_id)
	{
		$this->db->where('account_id', $account_id);
		$q = $this->db->get('blogs');
		$r = $q->row();
		return $r;
	}

	function count_user_blog($account_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->where('type_id', 2);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function get_blog_by_series($series_id, $order='desc',$limit='')
	{
		$this->db->select('*, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=2 AND x.post_id = blogs.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=2 AND y.post_id = blogs.ID) as nb_likes');
		$this->db->from('blogs');
		$this->db->join('posts','posts.ref_id=blogs.ID','left');
		$this->db->join('blog_series','blog_series.ID=blogs.series_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID','left');
		$this->db->join('photos','posts.ID=photos.post_id','left','left');
		$this->db->join('profiles','profiles.account_id=accounts.ID','left');
		$this->db->where('series_id', $series_id);
		$this->db->where('type_id',2);
			if(!empty($limit)){
				if(isset($limit['index'])){
					$index = $limit['index'];
				}else{
					$index = 0;
				}
				$this->db->limit($limit['limit'],$index); 		
			}
		$this->db->group_by("blogs.ID"); 
		$this->db->order_by("blogs.ID", $order); 
		$q = $this->db->get();
		$r = $q->result();
		return $r;
	}

	function get_user_blog($account_id,$order='asc')
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('blogs','posts.ref_id=blogs.ID');
		$this->db->where('account_id',$account_id);
		$this->db->where('type_id',2);
		$this->db->order_by("blogs.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function check_author($blog_id)
	{
		$this->db->where('ref_id', $blog_id);
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$this->db->where('type_id', 2);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function check_series_author($series_id)
	{
		$this->db->where('ID', $series_id);
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$q = $this->db->get('blog_series');
		$r = $q->num_rows();
		return $r;
	}

	function update($image_data='')
	{
			$data = array(
				'series_id' => $this->input->post('series_id'),
				'title' => $this->input->post('title'),
				'alias' => pretty_url($this->input->post('title')),
				'content' => $this->input->post('post_content')/*,
				'tag' => $this->input->post('tag')*/
			);
			
			$this->db->where('ID', $this->input->post('blog_id'));
			$this->db->update('blogs', $data); 
			
	}

	function delete($blog_id) 
	{

		$this->db->where('ID', $blog_id);
		$this->db->delete('blogs'); 
		
	}


	function get_blog_series($account_id=NULL)
	{
		if($account_id) {
			$this->db->select('*,blog_series.ID as ID, COUNT(blogs.ID) as series_total_blogs ');
			$this->db->from('blog_series');
			$this->db->join('blogs','blog_series.ID = blogs.series_id');
			$this->db->join('posts','blogs.ID = posts.ref_id AND posts.type_id=2');
			$this->db->where('posts.deleted', NULL);
			$this->db->where('blog_series.account_id', $account_id);
			$this->db->group_by('blog_series.ID');
			$q = $this->db->get();
			$r = $q->result();
		} else {
			$this->db->select('*, (SELECT COUNT(ID) FROM `blogs` b WHERE b.series_id = blog_series.ID ) as series_total_blogs ');
			$this->db->from('blog_series');
			$q = $this->db->get();
			$r = $q->result();
		}
		return $r;

	}

	function get_blog_series_detail($series_id)
	{
		$this->db->where('ID', $series_id);
		$q = $this->db->get('blog_series');
		$r = $q->row();
		return $r;
	}

	function get_post($blog_id)
	{
		$this->db->where('ref_id', $blog_id);
		$this->db->where('type_id', 2);
		$q = $this->db->get('posts');
		$r = $q->row();

		return $r;

	}

	function get_blog_photo($blog_id)
	{
		$r = $this->get_post($blog_id);

		$this->db->where('post_id', $r->ID);
		$q = $this->db->get('photos');
		$r = $q->row();
		return $r;

	}

	function create_series($account_id) 
	{
		//INSERT table blog_series
		$data = array(
			'series_name' => mysql_real_escape_string($this->input->get('series_name')), //wondering why still use mysql_escape_string ?
			'account_id' => $account_id
		);
		$this->db->insert('blog_series', $data);
		$new = $this->db->insert_id();
		
		//GET the new inserted ID
		$this->db->where('ID', $new);
		$q = $this->db->get('blog_series');
		$r = $q->row();
		return $r;
	}

	function count_blog()
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('blogs','posts.ref_id = blogs.ID AND posts.type_id=2');
		$this->db->where('deleted',NULL);
		$q = $this->db->get();
		$r = $q->num_rows();
		return $r;
	}

	function get_blog($id='',$args='')
	{
		$this->db->select('*, blogs.ID as blog_id, posts.ID as post_id, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=2 AND x.post_id = blogs.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=2 AND y.post_id = blogs.ID) as nb_likes');
		$this->db->from('blogs');
		$this->db->join('posts','posts.ref_id=blogs.ID','left');
		$this->db->join('blog_series','blog_series.ID=blogs.series_id','left');
		$this->db->join('photos','posts.ID=photos.post_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		if(!empty($args['tag'])){
			$this->db->join('tags','tags.post_id=posts.ID','left');
		}

		# ADMIN DISPLAY ALL
		if(empty($args['admin'])){
			$this->db->where('posts.deleted',NULL);
		}else{
			$this->db->select('posts.deleted as post_deleted');
			$this->db->select('(SELECT user_name FROM accounts WHERE ID = posts.deleted_by) AS deleter');
		}
		#$this->db->where('posts.deleted',NULL);
		
		if(!empty($args['keyword'])){
			$where = "(";
				$where.= "blogs.title LIKE '%".$args['keyword']."%'";
				if(!empty($args['search_all'])){
					$where.= " OR blogs.content LIKE '%".$args['keyword']."%'";
				}
			$where.= ")";
			$this->db->where($where);
			#$this->db->or_like('blogs.title',$args['keyword']);
			#if(!empty($args['search_all'])){
			#	$this->db->or_like('blogs.content',$args['keyword']);
			#}
		}
		$this->db->where('type_id',2);
		if(empty($id)){

			if(!empty($args['tag'])){
				$this->db->where('tags.name',$args['tag']); 
			}
			
			$this->db->group_by("blogs.ID"); 
			
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
		$this->db->where('blogs.ID',$id);
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

	function get_top_bloggers()
	{
		$q = $this->db->query('SELECT *, COUNT(account_id) as total_blogs FROM `posts` b
					LEFT JOIN accounts a ON b.account_id = a.ID
					WHERE type_id = 2
					AND b.deleted IS NULL
					GROUP BY account_id');
		return $q->result();
	}

	function unset_series($blog_id) 
	{

		$data = array(
			'series_id' => ''
		);
		
		$this->db->where('ID', $blog_id);
		$this->db->update('blogs', $data); 
	
	}

	function delete_series($series_id) 
	{

		$this->db->where('ID', $series_id);
		$this->db->delete('blog_series'); 
		
	}

}

/* End of file m_blogs.php */
/* Location: ./application/models/m_blogs.php */