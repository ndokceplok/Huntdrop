<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_comments extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create($target)
	{
		//INSERT table comments
		if($target==1){
			$data = array(
				'target' => $target,
				'post_type' => $this->input->post('post_type'),
				'post_id' => $this->input->post('post_id'),
				'content' => strip_tags($this->input->post('comment'))
			);
		}else{
			$data = array(
				'target' => $target,
				'user_id' => $this->input->post('user_id'),
				'content' => strip_tags($this->input->post('comment'))
			);
		}
		if($this->input->post('comment')){
		$this->db->insert('comments', $data);
		}
		return $this->db->insert_id();
	}

	function read($id)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('comments');
			$r = $q->row();
		}
		return $r;
	}

	/*function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('comments');
		$r = $q->result();
		return $r;
	}*/

	function read_arr($args='')
	{
		if(isset($args) && is_array($args)){
			foreach($args as $key=>$value){
				$this->db->where($key, $value);		
			}
		}
		$q = $this->db->get('comments');
		$r = $q->result();
		return $r;
	}

	function update($comment_id)
	{
	}
	
	/*function delete($id) 
	{

		if($id) {
			$this->db->where('post_id', $id);
			$q = $this->db->delete('tags');
		}

	}*/

	function delete($args='') 
	{
		if(isset($args) && is_array($args)){
			foreach($args as $key=>$value){
				$this->db->where($key, $value);		
			}
			$q = $this->db->delete('comments');
		}

	}

	function count_comment()
	{
		$this->db->where('hidden !=',1);
		$q = $this->db->get('comments');
		$r = $q->num_rows();
		return $r;
	}

	function get_all_comments($args='')
	{
		$this->db->select('*,comments.ID as ID,posts.entry_date as entry_date');
		#$this->db->select('(SELECT title FROM (CASE WHEN post_type=3 THEN blogs END) p WHERE comments.target=1 AND comments.post_id = p.ID) as post_title');
		$this->db->select('(SELECT user_name FROM accounts WHERE comments.target=2 AND comments.user_id = accounts.ID) as whose_profile');
		$this->db->from('comments');
		$this->db->join('posts','posts.ref_id=comments.ID AND posts.type_id=9');
		$this->db->join('accounts','posts.account_id=accounts.ID ');
		#$this->db->where('type_id', 9);
		if(!empty($args['only'])){
			if($args['only']=='profile'){
				$this->db->where('comments.target','2');
			}else{
				$this->db->where('comments.post_type',$args['only']);
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

		$this->db->order_by("posts.entry_date", 'desc'); 
		$q = $this->db->get();
		return $q->result();
	
		
	}

	function toggle_comment($comment_id,$action)
	{
		if(!empty($comment_id) && !empty($action)){
			
			$data = array(
				'hidden' => ($action=='hide'?1:0)
			);
			$this->db->where('ID', $comment_id);
			$this->db->update('comments', $data);

			return TRUE;
		}
		
	}

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */