<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_contests extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create($image_data='')
	{
		//INSERT table contests
		$data = array(
			'title' => $this->input->post('title'),
			'submission_start_date' => $this->input->post('submission_start_date'),
			'submission_end_date' => $this->input->post('submission_end_date'),
			'voting_start_date' => $this->input->post('voting_start_date'),
			'voting_end_date' => $this->input->post('voting_end_date'),
			'content' => $this->input->post('post_content')
		);
		if(!empty($image_data)){
			$data['image'] = $image_data['file_name'];
		}		
		$this->db->insert('contests', $data);
		return $this->db->insert_id();
	}

	function read($id=null,$admin=null)
	{
		if(!$admin){
			$this->db->where('deleted', NULL);
		}
		if($id) {
			$this->db->where('contest_id', $id);
			$q = $this->db->get('contests');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			redirect('404');	
			}
		} else {
			$this->db->select('*, contests.contest_id as contest_id, (SELECT COUNT(submission_id) FROM submissions a WHERE a.contest_id = contests.contest_id ) as total_submissions');
			$this->db->from('contests');
			$this->db->join('submissions','contests.contest_id = submissions.contest_id','left');
			$this->db->group_by('contests.contest_id');
			$q = $this->db->get();
			$r = $q->result();
		}
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('contests');
		$r = $q->result();
		return $r;
	}

	function update($image_data='')
	{
		$data = array(
			'title' => $this->input->post('title'),
			'submission_start_date' => $this->input->post('submission_start_date'),
			'submission_end_date' => $this->input->post('submission_end_date'),
			'voting_start_date' => $this->input->post('voting_start_date'),
			'voting_end_date' => $this->input->post('voting_end_date'),
			'content' => $this->input->post('post_content')
		);
		if(!empty($image_data)){
			//remove the previous image(?)
			$prev_image = $this->read($this->input->post('contest_id'));
			if(is_file('./uploads/contest/'.$prev_image->image)){
				unlink('./uploads/contest/'.$prev_image->image);
			}
			$data['image'] = $image_data['file_name'];
		}
		$this->db->where('contest_id', $this->input->post('contest_id'));
		$this->db->update('contests', $data);
	}
	
	function delete($contest_id) 
	{

		$this->db->set('deleted', 1);
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		$this->db->where('contest_id', $contest_id);
		$this->db->update('contests'); 
		#$this->db->delete('contests'); 

	}

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */