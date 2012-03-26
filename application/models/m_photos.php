<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_photos extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function create($post_id, $image_data, $thumb=FALSE)
	{
		$data = array(
			'post_id' => $post_id,
			'account_id' => $this->session->userdata('user_id'),
			'entry_date' => date('Y-m-d H:i:s'),
			'src' => $image_data['file_name']
		);
		if($thumb){
		$data['thumb'] = $image_data['file_name'];	
		}
		$this->db->insert('photos', $data);
	}

	function update($post_id,$image_data, $thumb=FALSE)
	{
		$data = array(
			'src' => $image_data['file_name']
		);
		if($thumb){
		$data['thumb'] = $image_data['file_name'];	
		}
		$this->db->where('post_id', $post_id);
		$this->db->update('photos', $data); 
	}

	function read($id)
	{
		if($id) {
			$this->db->where('post_id', $id);
			$this->db->order_by('ID','asc');   #COMMENT IF THERE ARE ISSUES
			$q = $this->db->get('photos');
			$r = $q->result();	
		}
		return $r;
	}

	function delete($args='') 
	{
		if(!empty($args)){

			if(isset($args['post_id'])) {
				$this->db->where('post_id', $args['post_id']);
				$q = $this->db->delete('photos');
			}

			if(isset($args['photo_id'])) {
				//when deleting photo_id, be sure to only delete photo of the logged-in user
				$this->db->where('account_id', $this->session->userdata('user_id'));
				if($this->session->userdata('user_id')){
					$this->db->where('ID', $args['photo_id']);
					$q = $this->db->delete('photos');
				}
			}

			return TRUE;

		}else{
			return FALSE;
		}


	}
	
	function read_photo_info($photo_id){
		if($photo_id) {
			$this->db->where('ID', $photo_id);
			$q = $this->db->get('photos');
			$r = $q->row();	
			return $r;
		}
	}

	/*
	function delete($id) 
	{

		if($id) {
			$this->db->where('post_id', $id);
			$q = $this->db->delete('photos');
		}

	}*/
}

/* End of file m_photos.php */
/* Location: ./system/application/models/m_photos.php */