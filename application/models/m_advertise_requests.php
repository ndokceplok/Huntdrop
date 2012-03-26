<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_advertise_requests extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create()
	{
		$data = array(
			'requester_name' => $this->input->post('name'),
			'requester_email' => $this->input->post('the_email'),
			'inquiry' => $this->input->post('inquiry'),
			'request_date' => date('Y-m-d H:i:s'),
			'requester_ip' => get_ip_address()
		);
		
		$this->db->insert('advertise_requests', $data);
		return $this->db->insert_id();
	}

	function update()
	{
	}

	function read($id=null)
	{
		if($id) {
			$this->db->where('request_id', $id);
			$q = $this->db->get('advertise_requests');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			$r = FALSE;
			#redirect('404');	
			}
		} else {
			$this->db->order_by('request_id','desc');
			$q = $this->db->get('advertise_requests');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('advertise_requests');
		if($q->num_rows()>0){
		$r = $q->row();
		}else{
		#redirect('404');	
		}
		return $r;
	}

	function mark_as_read($request_id){
		if(!empty($request_id)){
			$this->db->set('request_read',1);
			$this->db->where('request_id',$request_id);
			$this->db->update('advertise_requests');
		}
	}

}

/* End of file m_accounts.php */
/* Location: ./application/models/m_accounts.php */