<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Back Admin Contest List';
	private $active = 'contest';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Contest List';
		
		$this->load->library(array(
			'upload','image_lib'
		));

		$this->load->model(array(
			'm_accounts','m_profiles','m_contests','m_submissions'
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url','create_thumb','ckeditor'
		));

  	$this->load->vars(array('active'=>$this->active));
	}
	
	function index()
	{
		$data['add_css'] = array('backadmin/table');
		$data['add_js'] = array('notice');

		$data['contests'] = $this->m_contests->read('',true);
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_contest', $data);
	}

	function create()
	{

		$data['add_js'] = array('jquery-ui-1.8.5.custom.min','jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','jquery.ui/jquery-ui-1.8.5.custom','validationEngine.jquery');
		
		$data['action'] = 'add';
		$data['title'] = $this->title;
		$this->load->view('backadmin/v_contest_form', $data);
	}
	
	function create_exec()
	{
	
		//if user uploads an image
		if($_FILES['photo']['error'] == 0){
			//$new_post = $this->db->insert_id();

			//set the config to upload the files -> config/upload.php
			$config['upload_path'] = './uploads/contest/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '200';
			#$config['max_width']  = '500';
			#$config['max_height']  = '500';

			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect($this->admin_link.'contest/create');
			}
			else
			{
				$image_data = array('upload_data' => $this->upload->data());

				$path = './uploads/contest/';
				$config['source_image'] =  $path.$image_data['upload_data']['file_name'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 240;
				$config['height'] = 160;
				$config['create_thumb'] = FALSE;
				//$config['new_image'] = $path.;

				$this->image_lib->initialize($config); 
				if ( ! $this->image_lib->resize())
				{
					// an error occured
				}

				#print_r($image_data);
				//update contests
				$update = $this->m_contests->create($image_data['upload_data']);

				//update image

				#redirect($this->admin_link.'contest');
			}
		}else{
			//if user doesn't upload an image, just update the database
			
			//update projects
			$update = $this->m_contests->create();

			#redirect($this->admin_link.'contest');
		}
		redirect($this->admin_link.'contest');
		
	}

	function update()
	{

		$contest_id = $this->uri->segment(4);
		
		$data['add_js'] = array('jquery-ui-1.8.5.custom.min','jquery.validationEngine','jquery.validationEngine-en');
		$data['add_css'] = array('backadmin/table','jquery.ui/jquery-ui-1.8.5.custom','validationEngine.jquery');
		
		$data['action'] = 'edit';
		$data['title'] = $this->title;
		$data['contest_info'] = $this->m_contests->read($contest_id,true);
		$this->load->view('backadmin/v_contest_form', $data);
	}

	function update_exec()
	{

		//if user uploads an image
		if($_FILES['photo']['error'] == 0){
			//$new_post = $this->db->insert_id();

			//set the config to upload the files -> config/upload.php
			$config['upload_path'] = './uploads/contest/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '200';
			$config['max_width']  = '500';
			$config['max_height']  = '500';

			$this->upload->initialize($config);
	
			if ( ! $this->upload->do_upload('photo'))
			{
				$a = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('log', $a['error']);
				redirect($this->admin_link.'contest/update/'.$this->input->post('contest_id'));
			}
			else
			{
				$image_data = array('upload_data' => $this->upload->data());
				//update blogs
				$update = $this->m_contests->update($image_data['upload_data']);

				#redirect($this->admin_link.'contest');
			}
		}else{
			//if user doesn't upload an image, just update the database
			
			//update projects
			$update = $this->m_contests->update();

			#redirect($this->admin_link.'contest');
		}
		
		redirect($this->admin_link.'contest');
		
	}
	
	function delete(){
		$contest_id = $this->uri->segment(4);
		#echo $contest_id;
		$this->m_contests->delete($contest_id);
		redirect($this->admin_link.'contest');
	}

	function entries()
	{
		$data['add_css'] = array('backadmin/table');

		$contest_id = $this->uri->segment(4);
		#$data['contest_info'] = $this->m_contests->read($contest_id);
		
		$data['submissions']= $this->m_submissions->get_winners($contest_id);
		
		#$data['title'] =  $data['contest_info']->title/*.' Contest Entries'*/;
		$data['title'] =  $this->title.' | Entries';
		
		$this->load->view('backadmin/v_contest_entries', $data);
	}

}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */