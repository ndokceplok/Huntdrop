<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_messages extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function create()
	{
		//INSERT table messages
		if(!($this->input->post('recipient_id')) || !($this->input->post('subject')) || !($this->input->post('message')) ){
			return FALSE;
		}else{
			$data = array(
				'sender_id' => $this->session->userdata('user_id'),
				'recipient_id' => $this->input->post('recipient_id'),
				'reply_to_id' => $this->input->post('reply_to_id'),
				'subject' => $this->input->post('subject'),
				'entry_date' => date('Y-m-d H:i:s'),
				'message' => $this->input->post('message')
			);
			$this->db->insert('messages', $data);
			return $this->db->insert_id();
		}
	}

	function read($id=null)
	{
		if($id) {
			$this->db->where('message_id', $id);
			$q = $this->db->get('messages');
			$r = $q->row();
		} else {
			$q = $this->db->get('messages');
			$r = $q->result();
		}
		return $r;
	}

	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('messages');
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

	function check_author($project_id)
	{
		$this->db->where('ref_id', $project_id);
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$this->db->where('type_id', 3);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}
	
	function delete($message_id,$mode='')
	{
		if(!empty($mode)){
			
			if($mode=="sender"){
				$data = array(
					'sender_remove' => 1
				);
			}else{
				$data = array(
					'recipient_remove' => 1
				);
			}
			$this->db->where('message_id', $message_id);
			$this->db->update('messages',$data);

		}
	}

	function update_read($id)
	{
		$data = array(
			'read' => 1
		);
		$this->db->where('message_id', $id);
		$this->db->update('messages', $data);
	}

	function get_received_messages($recipient_id,$args='')
	{
		$this->db->select('*,messages.entry_date as message_date');
		$this->db->from('messages');
		$this->db->join('accounts','messages.sender_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('recipient_remove',0);
		$this->db->where('recipient_id',$recipient_id);
		if(!empty($args['limit'])){
			if(isset($args['index'])){
				$index = $args['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($args['limit'],$index); 		
		}
		$this->db->order_by("messages.entry_date", 'desc'); 
		$q = $this->db->get();

		$r = $q->result();
		return $r;
	}

	function get_sent_messages($sender_id,$args='')
	{
		$this->db->select('*,messages.entry_date as message_date');
		$this->db->from('messages');
		$this->db->join('accounts','messages.recipient_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('sender_remove',0);
		$this->db->where('sender_id',$sender_id);
		if(!empty($args['limit'])){
			if(isset($args['index'])){
				$index = $args['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($args['limit'],$index); 		
		}
		$this->db->order_by("messages.entry_date", 'desc'); 
		$q = $this->db->get();

		$r = $q->result();
		return $r;
	}

	function read_received_message($id)
	{
		$this->db->select('*,messages.entry_date as message_date');
		$this->db->from('messages');
		$this->db->join('accounts','messages.sender_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('recipient_remove',0);
		$this->db->where('message_id', $id);
		$q = $this->db->get();

		if($q->num_rows()){
			$r = $q->row();
			return $r;
		}else{
			redirect('member/message');
		}
	}

	function read_sent_message($id)
	{
		$this->db->select('*,messages.entry_date as message_date');
		$this->db->from('messages');
		$this->db->join('accounts','messages.recipient_id=accounts.ID');
		$this->db->join('profiles','profiles.account_id=accounts.ID');
		$this->db->where('sender_remove',0);
		$this->db->where('message_id', $id);
		$q = $this->db->get();

		if($q->num_rows()){
			$r = $q->row();
			return $r;
		}else{
			redirect('member/message');
		}
	}

	function count_unread_messages($recipient_id)
	{
		$this->db->where('read',0);
		$this->db->where('recipient_id',$recipient_id);
		$q = $this->db->get('messages');

		$r = $q->num_rows();
		return $r;
	}

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */