<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscription extends Admin_Controller {
	
	#private $title = 'Hunterdrop - Subscription';
	private $active = 'subscription';

	function __construct()
	{
		parent::__construct();
		$this->_auth();
		$this->title = $this->title.' - Subscription';

		$this->load->model(array(
		));
		
		$this->load->helper(array(
			'pretty_date','pretty_url'
		));

  	$this->load->vars(array('active'=>$this->active));
	}

	/*private function _auth()
	{
		if( $this->session->userdata('admin_logged_in') != TRUE) {
			$this->session->set_flashdata('ref', uri_string());
			$this->session->set_flashdata('log', 'you are not authorized to access admin area');
			redirect('backadmin/login');
		}
	}*/

	function index()
	{

		$data['add_js'] = array('notice');
		$data['add_css'] = array('backadmin/table');
		

		$data['subscriptions'] = $this->db->get('subscriptions')->result();

		$data['title'] = $this->title;
		$this->load->view('backadmin/v_subscription', $data);
	}

	function delete(){
		#echo $subscription_id;
		$subscription_id = $this->uri->segment(4);
		$this->db->where('ID',$subscription_id);
		$r = $this->db->delete('subscriptions');
	}

}

/* End of file member.php */
/* Location: ./system/application/controllers/member.php */