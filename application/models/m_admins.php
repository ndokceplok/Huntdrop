<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_admins extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create()
	{
		$hash = $this->encrypt->sha1(time());
		$data = array(
			'user_name' => $this->input->post('user_name'),
			'hash' => $hash,
			'pass' => $this->encrypt->sha1($this->input->post('pass') . $hash),
			#'pass' => /*$this->encrypt->*/sha1($this->input->post('pass')),
			'user_group' => $this->input->post('user_group')
		);
		
		$this->db->insert('admins', $data);
		return $this->db->insert_id();
	}

	function update()
	{
		$hash = $this->encrypt->sha1(time());
		// $data = array(
		// 	'user_name' => $this->input->post('user_name'),
		// 	'hash' => $hash,
		// 	'pass' => $this->encrypt->sha1($this->input->post('pass') . $hash),
		// 	#'pass' => /*$this->encrypt->*/sha1($this->input->post('pass')),
		// 	'user_group' => $this->input->post('user_group')
		// );
		if($this->input->post('user_name')){
			$data['user_name'] = $this->input->post('user_name');
		}
		if($this->input->post('pass')){
			$data['hash'] = $hash;
			$data['pass'] = $this->encrypt->sha1($this->input->post('pass') . $hash);
		}
		if($this->input->post('user_group')){
			$data['user_group'] = $this->input->post('user_group');
		}
		$this->db->where('ID',$this->input->post('admin_id'));
		$r = $this->db->update('admins', $data);
		return $r;
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

	function read($id=null)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('admins');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			$r = FALSE;
			#redirect('404');	
			}
		} else {
			$q = $this->db->get('admins');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('admins');
		if($q->num_rows()>0){
		$r = $q->row();
		}else{
		#redirect('404');	
		}
		return $r;
	}

	function update_last_login($account_id, $now)
	{
		$data = array(
			'last_login' => $now
		);

		$this->db->where('ID', $account_id);
		$this->db->update('admins', $data);
	}

	function do_login(){
		$user_name = $this->input->post('user_name');
		$pass = $this->input->post('pass');

		$this->db->where('user_name', $user_name);
		#$this->db->where('pass', sha1($pass));
		$q = $this->db->get('admins');
		$r = $q->row();
		$real_pass = $this->encrypt->sha1($pass . $r->hash); 
		#return $real_pass;

		if($real_pass == $r->pass) {
			return $r;		
		}
	}

	function delete($admin_id){
		$this->db->where('ID', $admin_id);
		$this->db->delete('admins'); 
	}


}

/* End of file m_accounts.php */
/* Location: ./application/models/m_accounts.php */