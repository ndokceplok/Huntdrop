<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_reviews extends CI_Model {

	/**
	 * reviews constructor
	 *
	 * @return void
	 * @author author
	 **/
	function __construct()
	{
		parent::__construct();

	}
	
	function create()
	{
		if(!($this->input->post('title')) || !($this->input->post('category_id')) || !($this->input->post('brand_id')) || !($this->input->post('object')) || !($this->input->post('content')) ){
			return FALSE;
		}else{
			$data = array(
				'title' => $this->input->post('title'),
				'alias' => pretty_url($this->input->post('title')),
				'category_id' => $this->input->post('category_id'),
				'brand_id' => $this->input->post('brand_id'),
				'object' => $this->input->post('object'),
				'rating' => $this->input->post('rating'),
				'content' => $this->input->post('post_content')
			);
			$this->db->insert('reviews', $data);
			return $this->db->insert_id();
		}
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('reviews');

			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			redirect('404');	
			}
		} else {
			$q = $this->db->get('reviews');
			$r = $q->result();
		}
		return $r;
	}
	
	function update()
	{
		$data = array(
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'object' => $this->input->post('object'),
			'category_id' => $this->input->post('category_id'),
			'brand_id' => $this->input->post('brand_id'),
			'rating' => $this->input->post('rating'),
			'content' => $this->input->post('post_content')
		);
		$this->db->where('ID', $this->input->post('review_id'));
		$this->db->update('reviews', $data);
	}
	
	function delete($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete('reviews');
	}

	function get_review($id='',$args='')
	{
		$this->db->select('*, reviews.ID as review_id, posts.ID as post_id,posts.entry_date as entry_date,posts.ID as post_id,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=1 AND x.post_id = reviews.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=1 AND y.post_id = reviews.ID) as nb_likes');
		$this->db->from('reviews');
		$this->db->join('posts','posts.ref_id=reviews.ID','left');
		$this->db->join('photos','posts.ID=photos.post_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->join('brands','brands.brand_id=reviews.brand_id','left');
		if(!empty($args['tag'])){
			$this->db->join('tags','tags.post_id=posts.ID','left');
		}
		if(!empty($args['category'])){
			$this->db->join('product_categories','product_categories.category_id=reviews.category_id','left');
		}
		if(!empty($args['keyword'])){
			$where = "(";
				$where.= "reviews.title LIKE '%".$args['keyword']."%'";
				if(!empty($args['search_all'])){
					$where.= " OR reviews.content LIKE '%".$args['keyword']."%'";
				}
			$where.= ")";
			$this->db->where($where);
			#$this->db->or_like('reviews.title',$args['keyword']);
		}
		$this->db->where('type_id',1);

		#$this->db->where('posts.deleted',NULL);
		# ADMIN DISPLAY ALL
		if(empty($args['admin'])){
			$this->db->where('posts.deleted',NULL);
		}else{
			$this->db->select('posts.deleted as post_deleted');
			$this->db->select('(SELECT user_name FROM accounts WHERE ID = posts.deleted_by) AS deleter');
		}

		if(empty($id)){
			if(!empty($args['tag'])){
				$this->db->where('tags.name',$args['tag']); 
			}
			if(!empty($args['category'])){
				$this->db->where('product_categories.category_id',$args['category']); 
			}
			if(!empty($args['brand'])){
				$this->db->where('brands.brand_id',$args['brand']); 
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
		$this->db->where('reviews.ID',$id);
		}
		$this->db->group_by('reviews.ID');
		$q = $this->db->get();
		if(empty($id)){
			return $q->result();
		}else{
			return $q->row();
		}
	}

	function get_user_review($account_id,$order='asc')
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('reviews','posts.ref_id=reviews.ID');
		$this->db->where('account_id',$account_id);
		$this->db->where('type_id',1);
		$this->db->order_by("reviews.ID", $order); 
		$q = $this->db->get();
		return $q->result();
	}

	function check_author($review_id)
	{
		$this->db->where('ref_id', $review_id);
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$this->db->where('type_id', 1);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function count_review()
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('reviews','posts.ref_id = reviews.ID AND posts.type_id=1');
		$this->db->where('deleted',NULL);
		$q = $this->db->get();
		$r = $q->num_rows();
		return $r;
	}

}

/* End of file m_reviews.php */
/* Location: ./system/application/models/m_reviews.php */