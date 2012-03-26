<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Member_Controller {
	
	#private $title = 'Hunterdrop - Messages';
	private $active = 'message';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title . ' - Member Messages';
		$this->load->model(array(
			'm_accounts','m_profiles','m_messages','m_friends'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

      	$this->load->vars(array('ql_active'=>$this->active,'page_css'=>array('contents')));
	}

	function index()
	{
		$data['title'] = $this->title.' | Received Messages';
		
		$message_type = $this->uri->segment(3);
		if(empty($message_type)){
			$message_type = 'received';	
		}

		if($message_type=='received'){
			$data['m_type'] = 'received';
		}
		
		if($message_type=='sent'){
			$data['m_type'] = 'sent';
		}

		$this->load->library('pager');
		$limit =10;

		$page = $this->uri->segment(5,1);
		$index = ($page-1)*$limit;
		$config['base_url'] = base_url().'member/message/'.$message_type.'/page/';
		$config['uri_segment'] = 5;

		if($message_type=='received'){
			$nb_messages = $this->m_messages->get_received_messages($this->session->userdata('user_id'));
		}else{
			$nb_messages = $this->m_messages->get_sent_messages($this->session->userdata('user_id'));
		}
		
		$config['total_post'] = count($nb_messages);
		$config['limit'] = $limit;

		$this->pager->initialize($config);

		
		if($message_type=='received'){
			$data['messages'] = $this->m_messages->get_received_messages($this->session->userdata('user_id'),array('index'=>$index,'limit'=>$limit));
		}else{
			$data['messages'] = $this->m_messages->get_sent_messages($this->session->userdata('user_id'),array('index'=>$index,'limit'=>$limit));
		}

		$this->load->view('member/v_member_messages', $data);
	}

	function read()
	{
		$message_id = $this->uri->segment(3);
		
		$message_info = $this->m_messages->read($message_id);
		
		if($message_info->sender_id != $this->session->userdata('user_id') && $message_info->recipient_id != $this->session->userdata('user_id') ){
			redirect('member/message');
		}
		
		if($message_info->sender_id==$this->session->userdata('user_id')){

			$data['mode'] = 'sent';
			$data['title'] = 'Sent Message';
			$data['message_detail'] = $this->m_messages->read_sent_message($message_id);
			$data['m_type'] = 'sent';
		}else{
			//update read
			$this->m_messages->update_read($message_id);

			$data['mode'] = 'received';
			$data['title'] = 'Received Message';
			$data['message_detail'] = $this->m_messages->read_received_message($message_id);
			$data['m_type'] = 'received';
		}

			$data['add_js'] = array('notice');

		#$data['title'] = $data['message_detail']->subject ;
		$this->load->view('member/v_member_message_read', $data);
	}

	function reply()
	{
		$message_id = $this->uri->segment(3);
		$data['title'] = 'Write A Message';
		$data['m_type'] = 'compose';
		$data['mode'] = 'reply';

		$message_info = $this->m_messages->read($message_id);

		if( $message_info->recipient_id != $this->session->userdata('user_id') ){
			redirect('member/message');
		}

		$data['message_detail'] = $this->m_messages->read_received_message($message_id);


		$data['add_css'] = array('validationEngine.jquery');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en','message');

		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		
		#SHOULD BE LIST OF FRIENDS, BUT FOR NOW LIST OF ALL USERS
		#$data['recipients'] = $this->m_profiles->read_by('account_id !=',$this->session->userdata('user_id'));

		$this->load->view('member/v_member_message_reply', $data);
	}

	function compose()
	{
		$data['title'] = 'Write A Message';
		$data['m_type'] = 'compose';

		$send_to = $this->uri->segment(4);
		$data['selected_recipient'] = $this->m_accounts->read_by('user_name',$send_to);
		
		$data['add_css'] = array('validationEngine.jquery');
		$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en','message');

		$data['account'] = $this->m_accounts->read($this->session->userdata('user_id'));
		
		#SHOULD BE LIST OF FRIENDS, BUT FOR NOW LIST OF ALL USERS
		$data['recipients'] = $this->m_friends->get_friends($this->session->userdata('user_id'));

		$this->load->view('member/v_member_message_create', $data);
	}

	function send()
	{
		$account = $this->m_accounts->read($this->session->userdata('user_id'));
		
		//store to messages
		$cr = $this->m_messages->create();
		
		if($cr){
			redirect('member/message');			
		}else{
			$this->session->set_flashdata('log','Fields must not be empty!');
			if($this->input->post('reply_to_id')){
			redirect('member/message/'.$this->input->post('reply_to_id').'/reply');
			}else{
			redirect('member/message/compose');
			}
		}
	}


	function remove_inbox()
	{

		$message_id = $this->uri->segment(3);

		$message_info = $this->m_messages->read($message_id);
		
		if($message_info->sender_id != $this->session->userdata('user_id') && $message_info->recipient_id != $this->session->userdata('user_id') ){
			redirect('member/message');
		}
		
		//remove from inbox = recipient_remove = true
		$this->m_messages->delete($message_id,'recipient');
		
		redirect('member/message');
	}

	function remove_outbox()
	{
		$message_id = $this->uri->segment(3);

		$message_info = $this->m_messages->read($message_id);
		
		if($message_info->sender_id != $this->session->userdata('user_id') && $message_info->recipient_id != $this->session->userdata('user_id') ){
			redirect('member/message');
		}

		$account = $this->m_accounts->read($this->session->userdata('user_id'));
		
		//remove from outbox = sender_remove = true
		$this->m_messages->delete($message_id,'sender');
		
		redirect('member/message/sent');
	}
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */