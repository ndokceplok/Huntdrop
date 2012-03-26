<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_posts extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create($ref_id,$type_id='')
	{
		$data = array(
			'type_id' => (isset($type_id))?$type_id:$this->input->post('type'),
			'ref_id' => $ref_id,
			'account_id' => $this->session->userdata('user_id'),
			'entry_date' => date('Y-m-d H:i:s')
		);
		$this->db->insert('posts', $data);
		return $this->db->insert_id();
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('posts');
			$r = $q->row();
		} else {
			$q = $this->db->get('posts');
			$r = $q->result();
		}
		return $r;
	}

	function read_by_arr($args='')
	{
		if(isset($args) && is_array($args)){
			foreach($args as $key=>$value){
				$this->db->where($key, $value);		
			}
		}
		$q = $this->db->get('posts');
		$r = $q->result();
		return $r;
	}
	
	function update()
	{
		$data = array(
			'last_update' => date('Y-m-d H:i:s')
		);
		$this->db->where('ID', $this->input->post('post_id'));
		$this->db->update('posts', $data);
	}
	
	function delete($id)
	{
		#use soft delete

		$this->db->set('deleted', 1);
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		$this->db->set('deleted_by', $this->session->userdata('user_id'));
		$this->db->where('ID', $id);
		$this->db->update('posts');
		#$this->db->delete('posts');
	}
	
	function delete_by_type_ref($type_id, $ref_id, $admin_mode)
	{
		#use soft delete
		$this->db->set('deleted', 1);
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		if(isset($admin_mode)){
		$this->db->set('deleted_by', '-1');			
		}else{
		$this->db->set('deleted_by', $this->session->userdata('user_id'));			
		}
		$this->db->where('type_id', $type_id);
		$this->db->where('ref_id', $ref_id);
		$this->db->update('posts');
		
		#$this->db->delete('posts');
	}
	
	function check_author($account_id, $post_id, $ref_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->where('ID', $post_id);
		$this->db->where('ref_id', $ref_id);
		$q = $this->db->get('posts');
		return $q->row();
	}
	
	function get_review($id=null)
	{
		$query = "SELECT reviews.*,
			posts.ID as post_id, posts.account_id as account_id, posts.entry_date as entry_date,
			accounts.user_name as author
			FROM reviews
			LEFT JOIN posts ON reviews.ID = posts.ref_id
			LEFT JOIN accounts ON accounts.ID = posts.account_id
			WHERE posts.type_id=1";
			
		if($id) {
			$query .= " AND reviews.ID=$id";
			$q = $this->db->query($query);
			return $q->row();
		} else {
			$q = $this->db->query($query);
			return $q->result();
		}
	}
	
	function get_post_by_type_ref($type_id, $ref_id)
	{
		$this->db->where('type_id', $type_id);
		$this->db->where('ref_id', $ref_id);
		$q = $this->db->get('posts');
		return $q->row();
	}
	
	function count_user_posts($account_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->where('type_id !=', '8');
		$this->db->where('deleted',NULL);
		$q = $this->db->get('posts');
		return $q->num_rows();
	}

	function get_user_posts($account_id='',$limit=10)
	{
		if(is_array($account_id)){
			$this->db->select('*, posts.entry_date as entry_date');
			$this->db->from('posts');
			$this->db->join('accounts','posts.account_id = accounts.ID','left');
			$this->db->where('posts.deleted', NULL);
			$this->db->where_in('posts.account_id', $account_id);
			$this->db->order_by("posts.entry_date", 'desc'); 
			$this->db->limit($limit);
			$q = $this->db->get();
		}else{
			if(!empty($account_id)){
				$this->db->where('account_id', $account_id);
			}
			$this->db->where('posts.deleted', NULL);
			$this->db->order_by("entry_date", "desc");
			$this->db->limit($limit);
			$q = $this->db->get('posts');
		}
		return $q->result();
	}

	function get_user_reviews($account_id,$order='asc',$limit='')
	{
		$this->db->select('*, posts.ID as ID, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=1 AND x.post_id = reviews.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=1 AND y.post_id = reviews.ID) as nb_likes');
		$this->db->from('reviews');
		$this->db->join('brands','brands.brand_id=reviews.brand_id','left');
		$this->db->join('product_categories','product_categories.category_id=reviews.category_id','left');
		$this->db->join('posts','posts.ref_id=reviews.ID');
		$this->db->join('photos','posts.ID=photos.post_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('posts.account_id',$account_id);
		$this->db->where('type_id',1);
		$this->db->where('posts.deleted',NULL);
		if(!empty($limit)){
			if(isset($limit['index'])){
				$index = $limit['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($limit['limit'],$index); 		
		}
		$this->db->group_by("reviews.ID"); 
		$this->db->order_by("reviews.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function get_user_blogs($account_id,$order='asc',$args='')
	{
		$this->db->select('*, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=2 AND x.post_id = blogs.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=2 AND y.post_id = blogs.ID) as nb_likes');
		$this->db->from('blogs');
		$this->db->join('posts','posts.ref_id=blogs.ID');
		$this->db->join('blog_series','blog_series.ID=blogs.series_id','left');
		$this->db->join('photos','posts.ID=photos.post_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('posts.account_id',$account_id);
		$this->db->where('type_id',2);
		$this->db->where('posts.deleted',NULL);
		if(!empty($args['series'])){
			if($args['series']=='na'){
				$this->db->where('series_id','');
			}else{
				$this->db->where('series_id',$args['series']);			
			}
		}
		if(!empty($args['limit'])){
			if(isset($args['index'])){
				$index = $args['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($args['limit'],$index); 		
		}
		$this->db->group_by("blogs.ID"); 
		$this->db->order_by("blogs.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function get_user_projects($account_id,$order='asc',$args='')
	{
		$this->db->select('*, posts.ID as ID, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=3 AND x.post_id = projects.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=3 AND y.post_id = projects.ID) as nb_likes');
		$this->db->from('projects');
		$this->db->join('posts','posts.ref_id=projects.ID');
		$this->db->join('photos','posts.ID=photos.post_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		if(!empty($args['tag'])){
			$this->db->join('tags','tags.post_id=posts.ID','left');
		}
		$this->db->where('posts.account_id',$account_id);
		$this->db->where('type_id',3);
		$this->db->where('posts.deleted',NULL);
		if(!empty($args['tag'])){
			$this->db->where('tags.name',$args['tag']); 
		}
		if(!empty($args['limit'])){
			if(isset($args['index'])){
				$index = $args['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($args['limit'],$index); 		
		}
		$this->db->group_by("projects.ID"); 
		$this->db->order_by("projects.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function get_user_videos($account_id,$order='asc',$limit='')
	{
		$this->db->select('*, posts.ID as ID, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=4 AND x.post_id = videos.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=4 AND y.post_id = videos.ID) as nb_likes');
		$this->db->from('videos');
		$this->db->join('posts','posts.ref_id=videos.ID');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('posts.account_id',$account_id);
		$this->db->where('type_id',4);
		$this->db->where('posts.deleted',NULL);
		if(!empty($limit)){
			if(isset($limit['index'])){
				$index = $limit['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($limit['limit'],$index); 		
		}
		$this->db->order_by("videos.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function get_user_threads($account_id,$order='asc',$limit='')
	{
		$this->db->select('*, posts.ID as ID, posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=5 AND x.post_id = threads.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=4 AND y.post_id = threads.ID) as nb_likes');
		$this->db->from('threads');
		$this->db->join('posts','posts.ref_id=threads.ID');
		$this->db->join('forums','forums.forum_id=threads.forum_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('posts.account_id',$account_id);
		$this->db->where('type_id',5);
		$this->db->where('posts.deleted',NULL);
		if(!empty($limit)){
			if(isset($limit['index'])){
				$index = $limit['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($limit['limit'],$index); 		
		}
		$this->db->order_by("threads.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function get_forum_threads($forum_id,$order='asc',$limit='')
	{
		$this->db->select('*, posts.entry_date as entry_date, threads.title as title,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=5 AND x.post_id = threads.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=5 AND y.post_id = threads.ID) as nb_likes, (SELECT MAX(entry_date) FROM posts y LEFT JOIN comments x ON y.type_id = 9 AND y.ref_id = x.ID WHERE x.post_type=5 AND x.post_id = threads.ID) as latest_reply');
		$this->db->from('threads');
		$this->db->join('posts','posts.ref_id=threads.ID');
		$this->db->join('forums','forums.forum_id=threads.forum_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('threads.forum_id',$forum_id);
		$this->db->where('type_id',5);
		$this->db->where('posts.deleted',NULL);
		if(!empty($limit)){
			if(isset($limit['index'])){
				$index = $limit['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($limit['limit'],$index); 		
		}
		$this->db->group_by("threads.ID"); 
		$this->db->order_by("threads.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}


	function get_content_comment($post_id,$post_type,$order='desc')
	{
		$this->db->select('*,posts.entry_date as entry_date');
		$this->db->from('posts');
		$this->db->join('comments','posts.ref_id=comments.ID');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('comments.post_id',$post_id);
		$this->db->where('comments.post_type',$post_type);
		$this->db->where('type_id',9);
		#$this->db->where('hidden !=',1);
		$this->db->order_by("comments.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function get_profile_comment($user_id,$order='desc')
	{
		$this->db->select('*,posts.entry_date as entry_date');
		$this->db->from('comments');
		$this->db->join('posts','posts.ref_id=comments.ID');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('type_id', 9);
		#$this->db->where('hidden !=',1);
		$this->db->where('comments.user_id',$user_id);
		$this->db->where('comments.target',2);
		$this->db->order_by("comments.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function get_pulse($limit=10){
		$this->db->select('*, posts.entry_date as entry_date');
		#EXPERIMENTAL GROUP BY
		#$this->db->select('CASE WHEN post_id=\'\' THEN user_id ELSE post_id END AS grouper',FALSE);
		#$this->db->select('(SELECT DISTINCT(user_id)) as dis_user_id, (SELECT DISTINCT(post_id)) as dis_post_id');
		$this->db->from('posts');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('comments','posts.ref_id=comments.ID');
		$this->db->where('type_id', 9);
		#$this->db->where('hidden !=',1);
		#EXPERIMENTAL GROUP BY
		#$this->db->group_by("grouper");
		#$this->db->group_by("dis_post_id,dis_user_id");
		$this->db->order_by("posts.entry_date", "desc");
		$this->db->limit($limit);
		$q = $this->db->get();
		return $q->result();
	}

	function add_view_count($type_id, $ref_id)
	{
		$this->db->set('view', 'view + 1', FALSE);
		$this->db->where('type_id', $type_id);
		$this->db->where('ref_id', $ref_id);
		$this->db->update('posts');
	}

	function get_latest_posts($limit=10){
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where('type_id !=',8);
		$this->db->where('type_id !=',9);
		#$this->db->join('reviews','posts.ref_id=reviews.ID AND posts.type_id=1');
		#$this->db->join('blogs','posts.ref_id=blogs.ID AND posts.type_id=2');
		#$this->db->join('projects','posts.ref_id=projects.ID AND posts.type_id=3');
		#$this->db->group_by("post_id");
		$this->db->order_by("posts.entry_date", "desc");
		$this->db->limit($limit);
		$q = $this->db->get();
		return $q->result();
	}
	
	function read_by_type_ref($type_id, $ref_id)
	{
		$this->db->where('type_id', $type_id);
		$this->db->where('ref_id', $ref_id);
		$q = $this->db->get('posts');
		return $q->row();
	}

}

/* End of file m_posts.php */
/* Location: ./system/application/models/m_posts.php */