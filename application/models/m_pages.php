<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pages extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create() 
	{
		//INSERT table articles
		$data = array(
			'parent' => $this->input->post('parent'),
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content'),
			'last_update' => date("Y-m-d H:i:s")
		);
		$this->db->insert('pages', $data);
		return $this->db->insert_id();
		
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('page_id', $id);
				$q = $this->db->get('pages');
			if($q->num_rows()>0){
				$r = $q->row();
			}else{
				redirect('404');	
			}
		} else {
			$this->db->select('*, (SELECT title FROM pages a WHERE a.page_id = pages.parent) as parent_name');
			$this->db->from('pages');
			$q = $this->db->get();
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('pages');
		$r = $q->result();
		return $r;
	}
	
	function update()
	{
		$data = array(
			'parent' => $this->input->post('parent'),
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content'),
			'last_update' => date("Y-m-d H:i:s")
		);
		
		$this->db->where('page_id', $this->input->post('page_id'));
		$this->db->update('pages', $data); 
		
	}

	function delete($page_id) 
	{

		$this->db->where('page_id', $page_id);
		$this->db->delete('pages'); 
		
	}
	

}

/* End of file m_blogs.php */
/* Location: ./application/models/m_blogs.php */