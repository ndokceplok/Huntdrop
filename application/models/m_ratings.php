<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ratings extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create($post_id)
	{
		$this->db->set('post_id', $post_id);
		$this->db->set('rate', $this->input->post('rate'));
		$this->db->insert('ratings');
	}

	function read($id)
	{
		if($id) {
			$this->db->where('post_id', $id);
			$q = $this->db->get('ratings');
			$r = $q->row();
		}
		return $r;
	}
	
	function update($id)
	{	
		$this->db->set('rate', $this->input->post('rate'));
		$this->db->where('post_id', $id);
		$this->db->update('ratings');
	}
	
}

/* End of file m_ratings.php */
/* Location: ./system/application/models/m_ratings.php */