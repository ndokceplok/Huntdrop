<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends Admin_Controller {

  function __construct()
  {
    parent::__construct();
    $this->_auth();
    $this->load->model(array(
      'm_photos', 'm_posts'
    ));
    $this->load->helper(array(
      'pretty_date','pretty_url'
    ));

  }
  
  function remove_image()
  {
    $photo_id = $this->input->post('photo_id');

    if(empty($photo_id)){
      die;
    }

    #remove the images from server
    $photo_info = $this->m_photos->read_photo_info($photo_id);
    //remove the previous image(?)
    if(is_file('./uploads/'.$photo_info->src)){
      #echo "ada photo"
      unlink('./uploads/'.$photo_info->src);
    }
    if(is_file('./uploads/thumbs/'.$photo_info->thumb)){
      unlink('./uploads/thumbs/'.$photo_info->thumb);
    }   

    #remove the image record from table photos
    $del = $this->m_photos->delete(array('photo_id'=>$photo_id));
    if(!$del){
      echo "failed";
      #if delete failed, do something
    }else{
      echo "success";
      #redirect('member/project')
    }

  }

}

/* End of file review.php */
/* Location: ./system/application/controllers/review.php */