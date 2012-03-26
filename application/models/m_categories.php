<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_categories extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create()
	{
		//INSERT table product_categories
		return $this->db->insert_id();
	}

	function read($id=null)
	{
		if($id) {
			$this->db->where('category_id', $id);
			$q = $this->db->get('product_categories');
			$r = $q->row();
		} else {
			$q = $this->db->get('product_categories');
			$r = $q->result();
		}
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('product_categories');
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