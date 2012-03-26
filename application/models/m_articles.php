<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_articles extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create() 
	{
		//INSERT table articles
		$data = array(
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content'),
			'short_desc' => $this->input->post('short_desc'),
			'date' => date("Y-m-d")
		);
		$this->db->insert('articles', $data);
		return $this->db->insert_id();
		
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('article_id', $id);
				$q = $this->db->get('articles');
			if($q->num_rows()>0){
				$r = $q->row();
			}else{
				redirect('404');	
			}
		} else {
			$q = $this->db->get('articles');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('articles');
		$r = $q->result();
		return $r;
	}
	
	function update()
	{
		$data = array(
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content'),
			'short_desc' => $this->input->post('short_desc'),
			'date' => date("Y-m-d")
		);
		
		$this->db->where('article_id', $this->input->post('article_id'));
		$this->db->update('articles', $data); 
		
	}

	function delete($article_id) 
	{

		$this->db->where('article_id', $article_id);
		$this->db->delete('articles'); 
		
	}
	
	function get_articles($args='')
	{
		if(!empty($args['limit'])){
			if(isset($args['index'])){
				$index = $args['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($args['limit'],$index); 		
		}
	
		$q = $this->db->get('articles');
		return $q->result();
	}

}

/* End of file m_blogs.php */
/* Location: ./application/models/m_blogs.php */