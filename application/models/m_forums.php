<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_forums extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create() 
	{
		//INSERT table forums
		$data = array(
			'forum_name' => $this->input->post('forum_name'),
			'description' => $this->input->post('description')
		);
		$this->db->insert('forums', $data);
		return $this->db->insert_id();
		
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('forum_id', $id);
			$q = $this->db->get('forums');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			redirect('404');	
			}
		} else {
			$this->db->select('*, forums.forum_id as forum_id, (SELECT COUNT(threads.ID) FROM threads LEFT JOIN posts ON threads.ID = posts.ref_id AND posts.type_id = 5 WHERE threads.forum_id = forums.forum_id AND posts.deleted IS NULL ) as total_threads');
			$this->db->from('forums');
			$this->db->join('threads','forums.forum_id = threads.forum_id','left');
			$q = $this->db->get();
			#$q = $this->db->get('forums');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('forums');
		$r = $q->result();
		return $r;
	}
	
	function update()
	{
		$data = array(
			'forum_name' => $this->input->post('forum_name'),
			'description' => $this->input->post('description')
		);
		
		$this->db->where('forum_id', $this->input->post('forum_id'));
		$this->db->update('forums', $data); 
		
	}

	function delete($forum_id) 
	{

		$this->db->where('forum_id', $forum_id);
		$this->db->delete('forums'); 
		
	}

}

/* End of file m_blogs.php */
/* Location: ./application/models/m_blogs.php */