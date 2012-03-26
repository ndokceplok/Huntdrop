<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tags extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create($post_id)
	{
		$tags_r = explode(",",$this->input->post('tags'));
			foreach($tags_r as $r){
				if(!empty($r)){
				$this->db->set('post_id', $post_id);
				$this->db->set('name', pretty_url(trim($r)));
				$this->db->insert('tags');
				}
			}
	}

	function read($id)
	{
		if($id) {
			$this->db->where('post_id', $id);
			$q = $this->db->get('tags');
			$r = $q->result();
		}
		return $r;
	}

	function update($post_id)
	{
//		$data = array(
//			'name' => $this->input->post('tags')
//		);
//		$this->db->where('post_id', $post_id);
//		$this->db->update('tags', $data);
		$this->delete($post_id);
		$this->create($post_id);
	}
	
	function delete($id) 
	{

		if($id) {
			$this->db->where('post_id', $id);
			$q = $this->db->delete('tags');
		}

	}

	function get_project_tags($args='')
	{
		$this->db->select('*, (SELECT COUNT(x.ID) FROM tags x LEFT JOIN posts ON x.post_id = posts.ID WHERE posts.type_id = 3 AND deleted IS NULL AND x.name=tags.name) as tag_qty');
		$this->db->from('tags');
		$this->db->join('posts','tags.post_id = posts.ID','left');
		$this->db->where('posts.deleted', NULL);
		$this->db->where('type_id',3);
		if(!empty($args['user_id'])){
			$this->db->where('posts.account_id',$args['user_id']);		
		}
		$this->db->group_by('name');
		$q = $this->db->get();
		$r = $q->result();
		return $r;
	}

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */