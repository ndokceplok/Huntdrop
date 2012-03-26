<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_submissions extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create()
	{
		//INSERT table submissions
		$data = array(
			'contest_id' => $this->input->post('contest_id'),
			'account_id' => $this->session->userdata('user_id'),
			'project_id' => $this->input->post('project_id')
		);
		$this->db->insert('submissions', $data);
		return $this->db->insert_id();
		//return $data;
	}

	function read($id=null)
	{
		if($id) {
			$this->db->where('submission_id', $id);
			$q = $this->db->get('submissions');
			$r = $q->row();
		} else {
			$q = $this->db->get('submissions');
			$r = $q->result();
		}
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('submissions');
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

	function check_submission($account_id, $contest_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->where('contest_id', $contest_id);
		$q = $this->db->get('submissions');
		$r = $q->row();
		return $r;
	}

	function get_submissions($contest_id,$args='')
	{
		$this->db->select('*');
		$this->db->from('submissions');
		$this->db->join('projects','submissions.project_id=projects.ID','left');
		$this->db->join('posts','projects.ID=posts.ref_id AND posts.type_id=3','left');
		$this->db->join('photos','photos.post_id=posts.ID','left');
		$this->db->join('accounts','submissions.account_id=accounts.ID','left');
		$this->db->where('submissions.contest_id', $contest_id);
		if(isset($args['exclude_self'])){
		$this->db->where('submissions.account_id !=', $this->session->userdata('user_id'));			
		}
		$q = $this->db->get();
		$r = $q->result();
		return $r;
	}

	function get_winners($contest_id,$args='')
	{
		$this->db->select('*, (SELECT COUNT(*) FROM votes WHERE votes.submission_id = submissions.submission_id ) as total_votes');
		$this->db->from('submissions');
		#$this->db->join('votes','submissions.submission_id=votes.submission_id','left');
		$this->db->join('projects','submissions.project_id=projects.ID','left');
		$this->db->join('posts','projects.ID=posts.ref_id AND posts.type_id=3','left');
		$this->db->join('photos','photos.post_id=posts.ID','left');
		$this->db->join('accounts','submissions.account_id=accounts.ID','left');
		$this->db->where('submissions.contest_id', $contest_id);
		$this->db->order_by('total_votes', 'desc');
		$q = $this->db->get();
		$r = $q->result();
		return $r;
	}

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */