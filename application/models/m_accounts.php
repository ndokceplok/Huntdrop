<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_accounts extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function login()
	{
		$this->db->where();
		$q = $this->db->get('accounts')->limit(1);
	}
	
	function create()
	{
		$hash = $this->encrypt->sha1(time());
		$data = array(
			'user_name' => $this->input->post('user_name'),
			'user_group' => 'member',
			'email' => $this->input->post('email'),
			'nid' => $this->input->post('nid'),
			'phone' => $this->input->post('phone'),
			'hash' => $hash,
			'pass' => $this->encrypt->sha1($this->input->post('pass') . $hash),
			'status' => 0,
			'entry_date' => date('Y-m-d H:i:s')
		);
		
		//send email verification
		/*
		$this->load->library('email');

		$this->email->from('admin@hunterdrop.com', 'hunterdrop admin');
		$this->email->to($this->input->post('email')); 

		$this->email->subject('hunterdrop account verification');
		$this->email->message('please verify your account '. site_url('account/verify/'. $hash));	

		$this->email->send();
		*/
		
		$this->db->insert('accounts', $data);
		return $this->db->insert_id();
	}

	function change_pass()
	{
		$hash = $this->encrypt->sha1(time());
		$data = array(
			'hash' => $hash,
			'pass' => $this->encrypt->sha1($this->input->post('new_password') . $hash)
		);

		if($this->session->userdata('from_fb')){
			$data['user_name'] = $this->input->post('user_name');
		}
		
		$this->db->where('ID', $this->session->userdata('user_id'));
		$this->db->update('accounts', $data);
	}

	function reset_pass($account_id)
	{
		$hash = $this->encrypt->sha1(time());
		$data = array(
			'hash' => $hash,
			'pass' => $this->encrypt->sha1($this->input->post('new_password') . $hash)
		);

		$this->db->where('ID', $account_id);
		$this->db->update('accounts', $data);
	}

	function verify($hash)
	{
		$this->db->where('hash', $hash);
		$this->db->set('status', 1);
		$this->db->update('accounts');
	}
	
	function check($data)
	{
		foreach($data as $k => $v) {
			$this->db->or_where($k, $v);
		}
		$q = $this->db->get('accounts');
		if($q->num_rows()){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('accounts');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			redirect('404');	
			}
		} else {
			$q = $this->db->get('accounts');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$this->db->where('status', 1);
		$q = $this->db->get('accounts');
		if($q->num_rows()>0){
		$r = $q->row();
		}else{
		redirect('404');	
		}
		return $r;
	}

	function ajax_read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('accounts');
		$r = $q->row();
		return $r;
	}

	function ajax_check_exclude_self($user_name)
	{
		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->where('user_name', $user_name);
		$this->db->where('ID !=', $this->session->userdata('user_id'));
		$q = $this->db->get();
		$r = $q->row();
		return $r;
	}
	
	function update_last_login($account_id, $now)
	{
		$data = array(
			'last_login' => $now
		);

		$this->db->where('ID', $account_id);
		$this->db->update('accounts', $data);
	}

	function get_user_name($account_id)
	{
		$this->db->select('user_name');
		$this->db->where('ID', $account_id);
		$q = $this->db->get('accounts');
		$r = $q->row();
		return $r->user_name;
	}

	function count_user()
	{
		$this->db->where('status',1);
		$q = $this->db->get('accounts');
		$r = $q->num_rows();
		return $r;
	}

	function delete($account_id){
		$this->db->set('deleted',1);
		$this->db->set('deleted_at',date('Y-m-d H:i:s'));
		$this->db->where('ID', $account_id);
		$this->db->update('accounts');
	}

	function undelete($account_id){
		$this->db->set('deleted',NULL);
		$this->db->set('deleted_at',NULL);
		$this->db->where('ID', $account_id);
		$this->db->update('accounts');
	}


}

/* End of file m_accounts.php */
/* Location: ./application/models/m_accounts.php */