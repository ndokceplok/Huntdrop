<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_likes extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create($liker_id, $post_type, $post_id)
	{
		//INSERT table likes
		$data = array(
			'liker_id' => $liker_id,
			'post_type' => $post_type,
			'post_id' => $post_id
		);
		$this->db->insert('likes', $data);
		return $this->db->insert_id();
	}

	function read($id)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('likes');
			$r = $q->row();
		}
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('likes');
		$r = $q->result();
		return $r;
	}

	function read_arr($args)
	{
		if(isset($args) && is_array($args)){
			foreach($args as $key=>$value){
				$this->db->where($key, $value);		
			}
		}
		$q = $this->db->get('likes');
		$r = $q->result();
		return $r;
	}

	function update($post_id)
	{
//		$data = array(
//			'name' => $this->input->post('tags')
//		);
//		$this->db->where('post_id', $post_id);
//		$this->db->update('tags', $data);
	}

	function delete_arr($args='') 
	{
		if(isset($args) && is_array($args)){
			foreach($args as $key=>$value){
				$this->db->where($key, $value);		
			}
			$q = $this->db->delete('likes');
		}

	}
	
	function delete($liker_id, $post_type, $post_id) 
	{

		if($liker_id && $post_type && $post_id) {
			$this->db->where('liker_id', $liker_id);
			$this->db->where('post_type', $post_type);
			$this->db->where('post_id', $post_id);
			$q = $this->db->delete('likes');
		}

	}

	function check_like($liker_id, $post_type, $post_id)
	{
		$this->db->where('liker_id', $liker_id);
		$this->db->where('post_type', $post_type);
		$this->db->where('post_id', $post_id);
		$q = $this->db->get('likes');
		$r = $q->num_rows();
		if($r>0){
			return true;
		}
	}

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */