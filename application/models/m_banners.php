<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_banners extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create($image_data='')
	{
		$data = array(
			'banner_title' => $this->input->post('banner_title'),
			'banner_position' => $this->input->post('banner_position'),
			'banner_page' => $this->input->post('banner_page'),
			'banner_link' => $this->input->post('banner_link'),
			'banner_status' => 1,
			'banner_start_date' => $this->input->post('banner_start_date').' 00:00:00',
			'banner_end_date' => $this->input->post('banner_end_date').' 23:59:59'
		);
		if(!empty($image_data)){
			$data['banner_image'] = $image_data['file_name'];
		}		
		
		$this->db->insert('banners', $data);
		return $this->db->insert_id();
	}

	function update($image_data='')
	{
		$data = array(
			'banner_title' => $this->input->post('banner_title'),
			'banner_position' => $this->input->post('banner_position'),
			'banner_page' => $this->input->post('banner_page'),
			'banner_link' => $this->input->post('banner_link'),
			'banner_status' => $this->input->post('banner_status'),
			'banner_start_date' => $this->input->post('banner_start_date').' 00:00:00',
			'banner_end_date' => $this->input->post('banner_end_date').' 23:59:59'
		);
		if(!empty($image_data)){
			$data['banner_image'] = $image_data['file_name'];
		}		
		$this->db->where('banner_id', $this->input->post('banner_id'));
		$this->db->update('banners', $data);

	}

	function read($id=null)
	{
		if($id) {
			$this->db->where('banner_id', $id);
			$q = $this->db->get('banners');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			$r = FALSE;
			#redirect('404');	
			}
		} else {
			$q = $this->db->get('banners');
			$r = $q->result();
		}
		return $r;
	}
	
	// function read_by($field, $value)
	// {
	// 	$this->db->where($field, $value);
	// 	$q = $this->db->get('banners');
	// 	if($q->num_rows()>0){
	// 	$r = $q->result();
	// 	}else{
	// 	$r = FALSE;
	// 	#redirect('404');	
	// 	}
	// 	return $r;
	// }

	function get_active_banners($args='')
	{
		if(!is_array($args)){
			return FALSE;
		}

		foreach($args as $key=>$value){
			$this->db->where($key, $value);			
		}
		$this->db->where('banner_status',1);
		$this->db->where('banner_start_date <=',date('Y-m-d H:i:s'));
		$this->db->where('banner_end_date >=',date('Y-m-d H:i:s'));
		$q = $this->db->get('banners');
		
		if($q->num_rows()>0){
		$r = $q->result();
		}else{
		$r = FALSE;
		#redirect('404');	
		}
		return $r;
	}

	function delete($banner_id){
		$this->db->where('banner_id', $banner_id);
		$this->db->delete('banners'); 
	}


}

/* End of file m_accounts.php */
/* Location: ./application/models/m_accounts.php */