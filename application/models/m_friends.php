<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_friends extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create($friended_id)
	{
		//INSERT table friends
		$data = array(
			'friender_id'=>$this->session->userdata('user_id'),
			'friended_id'=>$friended_id,
			'status'=>1
		);
		$this->db->insert('friends', $data);
		return $this->db->insert_id();
	}

	function remove_friend($friended_id)
	{
		//DELETE FROM table friends
		$this->db->where('friender_id', $this->session->userdata('user_id'));
		$this->db->where('friended_id', $friended_id);
		$this->db->delete('friends');
	}

	function check_friend($friended_id)
	{
		$this->db->where('friender_id', $this->session->userdata('user_id'));
		$this->db->where('friended_id', $friended_id);
		$q = $this->db->get('friends');
		$r = $q->result();
		return $r;
	}

	function get_friends($friender_id)
	{
		$this->db->select('*');
		$this->db->from('friends');
		$this->db->join('accounts','friends.friended_id = accounts.ID','left');
		$this->db->join('profiles','accounts.ID = profiles.account_id','left');
		$this->db->where('friender_id', $friender_id);
		$q = $this->db->get();
		$r = $q->result();
		return $r;
	}

	function read($id=null)
	{
		$q = $this->db->get('friends');
		$r = $q->result();
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('friends');
		$r = $q->result();
		return $r;
	}

	function update($post_id)
	{
	}
	
	function delete() 
	{


	}

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */