<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_stats extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }
  
  function count_total(){
    $this->db->select('(SELECT COUNT(*) FROM accounts WHERE status = 1 ) as total_users');
    $this->db->select('(SELECT COUNT(*) FROM posts JOIN projects ON posts.ref_id = projects.ID AND type_id=3 WHERE deleted IS NULL ) as total_projects');
    $this->db->select('(SELECT COUNT(*) FROM posts JOIN blogs ON posts.ref_id = blogs.ID AND type_id=2 WHERE deleted IS NULL ) as total_blogs');
    $this->db->select('(SELECT COUNT(*) FROM posts JOIN reviews ON posts.ref_id = reviews.ID AND type_id=1 WHERE deleted IS NULL ) as total_reviews');
    $this->db->select('(SELECT COUNT(*) FROM posts JOIN comments ON posts.ref_id = comments.ID AND type_id=9 WHERE hidden =0 ) as total_comments');
    $r = $this->db->get();
    return $r->row();
  }

}

/* End of file m_tags.php */
/* Location: ./system/application/models/m_tags.php */