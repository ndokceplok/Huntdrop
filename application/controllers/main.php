<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Public_Controller {
	
	#private $title = 'Hunterdrop';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'm_profiles','m_posts','m_projects', 'm_blogs', 'm_reviews', 'm_videos','m_accounts','m_comments','m_threads','m_banners','m_stats'
		));
		$this->load->helper(array(
			'pretty_date'
		));
      	$this->load->vars(array('active'=>'home'));
	}
	
	function get_random_user(){
		$not = $this->input->post('not');
		if(!empty($not)){
			$data['random_user'] = $this->m_profiles->get_random_user(array('not'=>$not));
		}else{
			$data['random_user'] = $this->m_profiles->get_random_user();
		}
		
		$data['random_user_projects'] = $this->m_posts->get_user_projects($data['random_user']->account_id,'desc',array('limit'=>4));
		$data['count_random_user_projects'] = count($this->m_posts->get_user_projects($data['random_user']->account_id)).' Hunt';
		if($data['count_random_user_projects'] > 1){
			$data['count_random_user_projects'] .='s';
		}
		$data['random_big_image'] = "<a href='".base_url().'project/'.$data['random_user_projects'][0]->ref_id.'/'.$data['random_user_projects'][0]->alias."'><img title='".$data['random_user_projects'][0]->title."'' alt='".$data['random_user_projects'][0]->title."'' src='". content_thumb($data['random_user_projects'][0]->thumb)."'/><p class='random_big_image_caption'>".$data['random_user_projects'][0]->title."</p></a>";
		$data['random_big_image_caption'] = "<p class='random_big_image_caption'>".$data['random_user_projects'][0]->title."</p></a>";

		$data['random_thumbs'] = '';
		foreach ($data['random_user_projects'] as $i=>$r){ 
			$c = '';
			if(($i+1)==1){
				$c.= "active";
			}
			if(($i+1)%2==0){ 
				$c.= "last";
			}
		$data['random_thumbs'] .= "<a href='".base_url().'project/'.$r->ref_id.'/'.$r->alias."'><img title='".$r->title."' alt='".$r->title."' class='".$c."' src='".content_thumb($r->thumb)."' /></a>";
		} 
		
		#$data['random_photo'] = base_url().(!empty($data['random_user']->photo && file_exists('assets/avatar/'.$photo) )?'assets/avatar/'.$data['random_user']->photo:'images/no-photo.jpg'); 
		$data['random_photo'] = base_url().(!empty($data['random_user']->photo) && file_exists('assets/avatar/'.$data['random_user']->photo)?'assets/avatar/'.$data['random_user']->photo:'images/no-avatar.jpg');
      /*             
			<a title="<?php echo $random_user->first_name.' '.$random_user->last_name;?>" href="<?php echo base_url();?>user/<?php echo $random_user->user_name;?>"><img class="fl random_photo" src="<?php echo user_image($random_user->photo);?>" /></a>
			<p class="fl">
			<a title="<?php echo $random_user->first_name.' '.$random_user->last_name;?>" href="<?php echo base_url();?>user/<?php echo $random_user->user_name;?>"><?php echo $random_user->first_name.' '.$random_user->last_name;?></a><br>
			Dropped <br>
			<a href="<?php echo base_url().'project/'.$random_user->user_name;?>"><?php echo $count_random_user_projects;?> Hunts</a>
			</p>
		*/
		
		echo json_encode($data);
	}
	
	function index()
	{
		$data['title'] =  $this->title;
		
		$data['add_css'] = array('rateit','carousel/tango/skin','carousel/ie7/skin');
		$data['add_js'] = array('jquery.rateit.min','jquery.jcarousel.min','jquery.mousewheel','jquery.easing.1.3','home');
		
		$data['stat'] = $this->m_stats->count_total();

		$data['latest_project'] = $this->m_projects->get_project('',array('limit'=>20));
		$data['latest_blog'] = $this->m_blogs->get_blog('',array('limit'=>20));
		$data['latest_review'] = $this->m_reviews->get_review('',array('limit'=>5));
		$data['latest_video'] = $this->m_videos->get_video('',array('limit'=>20));

		$data['pulse'] = $this->m_posts->get_pulse(20);
		#$data['type_label'] = array(1=>'review','blog','project','video','thread',8=>'like',9=>'comment');
		$data['type_label'] = array(1=>'review','blog','project','video','thread');
		$data['type_list'] = array(1=>'review','blog','project','video','thread',9=>'commented on ');
		
		$data['latest_user'] = $this->m_profiles->get_users(array('limit'=>12));

		$data['random_user'] = $this->m_profiles->get_random_user();
		if(!empty($data['random_user'])){
		$data['random_user_projects'] = $this->m_posts->get_user_projects($data['random_user']->account_id,'desc',array('limit'=>4));
		$data['count_random_user_projects'] = count($this->m_posts->get_user_projects($data['random_user']->account_id));
		}

		#$data['home_side_banners'] = $this->m_banners->read_by_arr(array('banner_page'=>'home','banner_position'=>'sidebar'));

		$this->load->view('v_main', $data);
	}

	function save_subscription(){
		$email = $this->input->post('email');
		$this->load->library('form_validation');

		if($this->form_validation->valid_email($email)){
			
			$this->db->where('email',$email);
			$sub = $this->db->get('subscriptions');
			if($sub->num_rows()>0){
				echo "exist";
			}else{
				$this->db->insert('subscriptions',array('email'=>$email));
				echo $email;
			}
		}else{
				echo "invalid";
		}

	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */