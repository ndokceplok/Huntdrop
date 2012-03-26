<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Public_Controller {
	
	#private $title = 'Huntdrop';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'm_pages', 'm_advertise_requests'
		));
//		$this->load->model(array(
//			'm_profiles','m_posts','m_projects', 'm_blogs', 'm_accounts'
//		));
//		$this->load->helper(array(
//			'pretty_date'
//		));
      	$this->load->vars(array('page_css'=>array('contents')));
	}
	
	function index()
	{
		$page = $this->uri->segment(1);
		if($page=='page'){
			redirect('about/');
		}

		if($page=='about' || $page=='contact'){
		$data['title'] =  ucwords($page).' '.$this->title;
		}elseif($page=='help'){
		$data['title'] =  $this->title.' - How To';
		}elseif($page=='advertise'){
		$data['title'] =  $this->title.' - Advertise With Us';
		}
		if($page=='help'){
			$data['active']= $page;
		}
		if($page=='about' || $page=='help' || $page=='advertise'){
			$data['add_css'] = array('tabs');
			$data['add_js'] = array('tabs');
			
			if($page=='about'){
				$data['pages'] = $this->m_pages->read_by('parent',1);
			}elseif($page=='help'){
				$parent = $this->m_pages->read_by('alias',$page);
				$data['pages'] = $this->m_pages->read_by('parent',$parent[0]->page_id);
			}elseif($page=='advertise'){
				$data['add_css'] = array('contact','validationEngine.jquery','tabs');
				$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en','tabs','contact');
				$data['pages'] = $this->m_pages->read_by('alias','advertise');
			}
		}elseif($page=='contact'){
			$data['add_css'] = array('contact','validationEngine.jquery');
			$data['add_js'] = array('jquery.validationEngine','jquery.validationEngine-en','contact');
		}
		
		$this->load->view('v_'.$page, $data);
	}

	function submit_contact()
	{

		$name = $this->input->post('name');
		$email	= $this->input->post('the_email');
		$homepage	= $this->input->post('homepage');
		$comment = $this->input->post('comment');
		
		if(empty($name) || empty($email) || empty($comment)){
		$this->session->set_flashdata('log','Name,email, and comment must not be empty');
		redirect('contact');
		}

		$to   = $this->config->item('site_email');
		
		$subject = "Comment from $name" ;
		$message = "Name : $name \n";
		$message.= "Email : $email \n";
		if($homepage!=""){
		$message.= "Homepage : $homepage \n";
		}
		$message.= "Message :\n".$comment;
		
		$send = sendmail(array('to'=>$to,'subject'=>$subject,'message'=>$message));
   		if($send=="success"){
		#if(mail($to, $subject, $message, "From: $email")){
			$msg = "Thank you for your comment";
			$type = 'success';
		}else{
			$msg = "Sorry..., your email can't be sent.";
			$type = '';
		}
		
		$this->session->set_flashdata('log',array('msg'=>$msg,'type'=>$type));
		redirect('contact');
	

	}

	function submit_advertise_form()
	{

		$name = $this->input->post('name');
		$email	= $this->input->post('the_email');
		$inquiry = $this->input->post('inquiry');
		
		if(empty($name) || empty($email) || empty($inquiry)){
		$this->session->set_flashdata('log','Name,email, and inquiry must not be empty');
		redirect('advertise');
		}

		#save to database to track
		$create = $this->m_advertise_requests->create();

		$to   = $this->config->item('site_email');
		
		$subject = "Inquiry by $name" ;
		$message = "Name : $name \n";
		$message.= "Email : $email \n";
		$message.= "Inquiry :\n".$inquiry;
		
		$send = sendmail(array('to'=>$to,'subject'=>$subject,'message'=>$message));
   		if($send=="success"){
   		#if(mail($to, $subject, $message, "From: $email")){
			$msg = "Thank you for your inquiry. We'll get back to you as soon as possible";
			$type = 'success';
		}else{
			$msg = "Sorry..., your email can't be sent.";
			$type = '';
		}
		
		$this->session->set_flashdata('log',array('msg'=>$msg,'type'=>$type));
		redirect('advertise');
	

	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */