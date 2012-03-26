<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Banner Management';
	private $active = 'banner';

	function __construct()
	{
		parent::__construct();
		$this->_auth();

		$this->title = $this->title.' - Banner Management';
		
		$this->load->library(array(
			'upload'
		));

		$this->load->model(array(
			'm_banners'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

  	$this->load->vars(array('active'=>$this->active));
	}

	function index()
	{
		$data['add_js'] = array('notice');
		$data['add_css'] = array('backadmin/table');
		$data['banners'] = $this->m_banners->read();
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_banner', $data);
	}

	function create(){

		$data['add_js'] = array('jquery-ui-1.8.5.custom.min','jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','jquery.ui/jquery-ui-1.8.5.custom','validationEngine.jquery');
		
		$data['action'] = 'add';
		$data['banner_positions'] = array('top','sidebar');
		$data['banner_pages'] = array('home','others');
		$data['banner_types'] = array('fixed','rotating');

		$data['title'] = $this->title;
		$this->load->view('backadmin/v_banner_form', $data);
	}

	function create_exec()
	{
		//if user uploads an image
		if($_FILES['photo']['error'] == 0){

			//set the config to upload the files -> config/upload.php
			$config['upload_path'] = './uploads/banners/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '200';
			#$config['max_width']  = '500';
			#$config['max_height']  = '500';

			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect($this->admin_link.'banner/create');
			}
			else
			{
				$image_data = array('upload_data' => $this->upload->data());

				$update = $this->m_banners->create($image_data['upload_data']);

				redirect($this->admin_link.'banner');
			}
		}else{
			//if user doesn't upload an image, back to banner add page
			
			$this->session->set_flashdata('log', 'please upload the banner image');
			redirect($this->admin_link.'banner/create');
		}

	}

	function update(){
		$banner_id = $this->uri->segment(4);
		
		$data['add_js'] = array('jquery-ui-1.8.5.custom.min','jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','jquery.ui/jquery-ui-1.8.5.custom','validationEngine.jquery');
		
		$data['action'] = 'edit';
		$data['banner_positions'] = array('top','sidebar');
		$data['banner_pages'] = array('home','others');
		$data['banner_types'] = array('fixed','rotating');
		$data['banner_info'] = $this->m_banners->read($banner_id);

		
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_banner_form', $data);
	}

	function update_exec(){
		//if user uploads an image
		if(!empty($_FILES['photo'])){
			//$new_post = $this->db->insert_id();

			//set the config to upload the files -> config/upload.php
			$config['upload_path'] = './uploads/banners/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '200';
			#$config['max_width']  = '500';
			#$config['max_height']  = '500';

			$this->upload->initialize($config);
	
			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect($this->admin_link.'banner/update/'.$this->input->post('banner_id'));
			}
			else
			{
				$image_data = array('upload_data' => $this->upload->data());
				//update banners
				$update = $this->m_banners->update($image_data['upload_data']);

				redirect($this->admin_link.'banner');
			}
		}else{
			//if user doesn't upload an image, back to banner add page
			
			$update = $this->m_banners->update();
			redirect($this->admin_link.'banner');
		}

	}

  function remove_banner_image()
  {
    $banner_id = $this->input->post('banner_id');

    #remove the images from server
    $banner_info = $this->m_banners->read($banner_id);
    //remove the previous image(?)
    if(is_file('./uploads/banners/'.$banner_info->banner_image)){
      unlink('./uploads/banners/'.$banner_info->banner_image);
    }   

    #remove the image record from table photos
		$this->db->where('banner_id', $banner_id);
		$del = $this->db->update('banners', array('banner_image'=>''));
		#$del = $this->m_banners->update(array('banner_image'=>''));
    if(!$del){
      echo "failed";
    }else{
      echo "success";
    }

  }

	function delete(){
		echo $this->uri->segment(4);
	}
}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */