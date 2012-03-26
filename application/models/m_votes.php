<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_votes extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create()
	{
		//INSERT table votes
		$data = array(
			'voter_id' => $this->session->userdata('user_id'),
			'contest_id' => $this->input->post('contest_id'),
			'submission_id' => $this->input->post('submission_id')
			//'project_id' => $this->input->post('project_id')
		);
		$this->db->insert('votes', $data);
		return $this->db->insert_id();
		//return $data;
	}

	function read($id=null)
	{
		if($id) {
			$this->db->where('vote_id', $id);
			$q = $this->db->get('votes');
			$r = $q->row();
		} else {
			$q = $this->db->get('votes');
			$r = $q->result();
		}
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('votes');
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
	
	function delete() 
	{


	}

	function check_votes($voter_id, $contest_id)
	{
		$this->db->where('voter_id', $voter_id);
		$this->db->where('contest_id', $contest_id);
		$q = $this->db->get('votes');
		$r = $q->row();
		return $r;
	}


}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */