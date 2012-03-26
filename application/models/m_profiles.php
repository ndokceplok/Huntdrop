<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profiles extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create($account_id) //$account_id can't be null
	{
		$data = array(
			'account_id' => $account_id,
			'member_since' => date('Y-m-d H:i:s')
		);
				
		$this->db->insert('profiles', $data);
	}
		
	function read($id=null)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('profiles');
			$r = $q->row();
		} else {
			$q = $this->db->get('profiles');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('profiles');
		$r = $q->result();
		return $r;
	}
	
	function read_by_account_id($account_id)
	{
		$this->db->where('account_id', $account_id);
		$q = $this->db->get('profiles');
		$r = $q->row();
		return $r;
	}

	function update($image_data='')
	{

		$byear = $this->input->post('byear');
		$bmonth = $this->input->post('bmonth');
		$bdate = $this->input->post('bdate');
		if($bdate<10){
			$bdate = "0".$bdate;
		}

		$data = array(
			'first_name' => $this->input->post('first_name'),
			'middle_name' => $this->input->post('middle_name'),
			'last_name' => $this->input->post('last_name'),
			'dob' => $byear ."-". $bmonth ."-". $bdate,
			'address' => htmlspecialchars($this->input->post('address')),
			'location' => $this->input->post('location'),
			'website' => $this->input->post('website'),
			'about_me' => htmlspecialchars($this->input->post('about_me')),
			'occupation' => $this->input->post('occupation'),
			'hobby' => $this->input->post('hobby'),
			'interest' => $this->input->post('interest')
		);
		
		if(!empty($image_data)){
			$data['photo'] = $image_data['file_name'];
		}
		
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$this->db->update('profiles', $data); 
	}

	/* this is the new update function, will update old method to this one for more flexibility */
	function update_by($account_id='',$data='')
	{
		if(empty($account_id) || empty($data)){
			exit;
		}

		$this->db->where('account_id', $account_id);
		$this->db->update('profiles', $data); 
	}

	function get_avatar()
	{
		$this->db->select('photo');
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$q = $this->db->get('profiles');
		$r = $q->row();
		return $r;

	}

	function get_users($args='')
	{
		$this->db->select('*, (SELECT COUNT(ID) FROM posts WHERE account_id=profiles.account_id AND type_id!=8 AND deleted IS NULL) as total_posts');
		$this->db->from('profiles');
		$this->db->join('accounts','accounts.ID=profiles.account_id');

		if(!isset($args['include_all'])){
			$this->db->where('status',1); 
			#$this->db->where('deleted',NULL); 
		}

		if(isset($args['online'])){
			$now = now();
			#$last_active = human_to_unix($r->last_active);
			
			$this->db->where('is_online',1); 
			$this->db->where('last_active >',date('Y-m-d H:i:s',strtotime(unix_to_human($now-900)))); 
		}

		if(!empty($args['keyword'])){
			$where = "(";
				$where.= "profiles.first_name LIKE '%".$args['keyword']."%' OR profiles.last_name LIKE '%".$args['keyword']."%' OR accounts.email LIKE '%".$args['keyword']."%' OR accounts.user_name LIKE '%".$args['keyword']."%'";
				if(!empty($args['search_all'])){
					$where.= " OR accounts.user_name LIKE '%".$args['keyword']."%'";
				}
			$where.= ")";
			$this->db->where($where);
			#$this->db->or_like('reviews.title',$args['keyword']);
		}

		$sort = "desc";
		if(!empty($args['order'])){
			$sort = $args['order'];
		}
		if(!empty($args['sort'])){
			$this->db->order_by($args['sort'],$sort); 
		}else{
			$this->db->order_by("profiles.account_id", $sort);
		}
		
		if(!empty($args['limit'])){
			if(isset($args['index'])){
				$index = $args['index'];
			}else{
				$index = 0;
			}
			$this->db->limit($args['limit'],$index); 		
		}
		$q = $this->db->get();
		return $q->result();
	}

	function get_random_user($args='')
	{
		$this->db->select('*');
		$this->db->from('profiles');
		$this->db->join('accounts','accounts.ID=profiles.account_id');
		$this->db->join('posts','posts.account_id=accounts.ID','left');
		$this->db->join('projects','posts.ref_id=projects.ID','left');
		$this->db->where('type_id',3);
		if(!empty($args['not'])){
			$this->db->where('profiles.account_id != ',$args['not']);
		}
		$this->db->order_by('RAND()'); 
		$this->db->limit(1);

		$q = $this->db->get();
		return $q->row();
	}

}

/* End of file m_profiles.php */
/* Location: ./application/models/m_profiles.php */