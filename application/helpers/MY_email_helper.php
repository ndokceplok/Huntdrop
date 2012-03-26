<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sendmail($data)
{		
	if(!empty($data)){
		
		$CI =& get_instance();
		$CI->load->library('email');
		$CI->email->set_newline("\r\n");

		#$CI->email->from($data['from_email'],$data['from_name']);
		$CI->email->from('service@huntdrop.com','Huntdrop');
		$CI->email->to($data['to']);

		if(isset($data['bcc'])){
			$CI->email->bcc($data['bcc']);
		}
		$CI->email->subject($data['subject']);
		$CI->email->message($data['message']);


		if (!$CI->email->send()){
		
		#if(mail($data['to'], $data['subject'], $data['message'], "From: Huntdrop <service@huntdrop.com>"){

		  #show_error($CI->email->print_debugger());
		  log_message('error','somethings wrong with the sendmail helper');
		  return "error";
		}
		else{
		  #echo 'Your e-mail has been sent!';
		  return "success";
		}

		#mail($data['to'], $data['subject'], $data['message'], "From: Huntdrop <service@huntdrop.com>");

	}
}