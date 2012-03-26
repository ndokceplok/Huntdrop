<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Controller extends Public_Controller {
  
  function __construct()
  {
    parent::__construct();

  }

  public function _remap($method)
  {
      if(method_exists($this,$method)){
        $this->$method();
      }else{
          #$this->index();
          #or show 404
          show_404();
      }
  }

  function _auth()
  {
    if( $this->session->userdata('logged_in') != TRUE) {
      $this->session->set_flashdata('ref', uri_string());
      $this->session->set_flashdata('log', 'Please login to access member area');
      redirect('account/login');
    }
  }


}