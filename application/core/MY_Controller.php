<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
	  parent::__construct();

    if($this->session->userdata('logged_in')){
      $this->db->set('last_active', date('Y-m-d H:i:s'));
      $this->db->where('ID', $this->session->userdata('user_id'));
      $this->db->update('accounts');
    }

	  $configs = $this->db->get('site_configs')->result();
	  $this->configs = $configs;
    foreach($configs as $r){
      if($r->key == 'description' || $r->key == 'keywords'){
        $r->key = 'site_'.$r->key;
      }
      $this->{$r->key} = $r->value;
    }
	  #$this->title = $configs->title;
	  #$this->site_description = $configs->description;
	  #$this->site_keywords = $configs->keywords;
 	}


}