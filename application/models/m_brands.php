<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_brands extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create()
	{
		//INSERT table brands
		$data = array(
			'brand_name' => mysql_real_escape_string($this->input->get('brand_name'))
		);
		$this->db->insert('brands', $data);
		$new = $this->db->insert_id();

		//GET the new inserted ID
		$this->db->where('brand_id', $new);
		$q = $this->db->get('brands');
		$r = $q->row();
		return $r;

		//return $this->db->insert_id();
	}

	function read($id=null)
	{
		if($id) {
			$this->db->where('brand_id', $id);
			$q = $this->db->get('brands');
			$r = $q->row();
		} else {
			$q = $this->db->get('brands');
			$r = $q->result();
		}
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('brands');
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

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */