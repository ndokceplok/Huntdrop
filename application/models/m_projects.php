<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_projects extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function create($account_id,$image_data='') 
	{
		//INSERT table projects
		if(!($this->input->post('title')) || !($this->input->post('post_content')) ){
			return FALSE;
		}else{
		$data = array(
			'title' => $this->input->post('title'),
			'alias' => pretty_url($this->input->post('title')),
			'content' => $this->input->post('post_content'),
			'tag' => $this->input->post('tag')
		);
		$this->db->insert('projects', $data);
		return $this->db->insert_id();
		}

	}
	
	function read($id=null)
	{
		if($id) {
			$this->db->where('ID', $id);
			$q = $this->db->get('projects');
			if($q->num_rows()>0){
			$r = $q->row();
			}else{
			redirect('404');	
			}
		} else {
			$q = $this->db->get('projects');
			$r = $q->result();
		}
		return $r;
	}
	
	function read_by($field, $value)
	{
		$this->db->where($field, $value);
		$q = $this->db->get('projects');
		$r = $q->result();
		return $r;
	}
	
	function read_by_account_id($account_id)
	{
		$this->db->where('account_id', $account_id);
		$q = $this->db->get('projects');
		$r = $q->row();
		return $r;
	}

	function count_user_project($account_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->where('type_id', 3);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function get_user_project($account_id)
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('projects','posts.ref_id=projects.ID');
		$this->db->where('account_id',$account_id);
		$this->db->where('type_id',3);
		$this->db->order_by("projects.ID", "asc"); 
		$q = $this->db->get();
		return $q->result();
	}

	function check_author($project_id)
	{
		$this->db->where('ref_id', $project_id);
		$this->db->where('account_id', $this->session->userdata('user_id'));
		$this->db->where('type_id', 3);
		$q = $this->db->get('posts');
		$r = $q->num_rows();
		return $r;
	}

	function update($image_data='')
	{
		//need review
		//BUGS : I can use firebugs to edit other people's projects
		//SOLUTION : Check if the project is really the logged in user's project
		//STATUS : DONE
		
		//check if the project author is the one who's logged in
		##### EXPERIMENTAL : COMMENT TO ENABLE ADMIN UPDATE. UNCOMMENT IF THERE'S PROBLEM
		#if($this->check_author($this->input->post('project_id'))>0){
			//yes -> update
			
			//check if series_id submitted is in ID or in String
			//if in ID, insert new row to  table project_series
			//check for duplicate

		if(!($this->input->post('title')) || !($this->input->post('post_content')) ){
			return FALSE;
		}else{
		
			$data = array(
				'title' => $this->input->post('title'),
				'alias' => pretty_url($this->input->post('title')),
				'content' => $this->input->post('post_content'),
				'tag' => $this->input->post('tag')
			);
			
			$this->db->where('ID', $this->input->post('project_id'));
			$this->db->update('projects', $data); 
			
			//if there's an image uploaded
			if(!empty($image_data)){
				//check if project has photo in table photos
				$a = $this->get_project_photo($this->input->post('project_id'));
				
				if(count($a)>0){
				//yes, update
					
					//remove the previous image(?)
					$prev_image = $this->get_project_photo($this->input->post('project_id'));
					if(is_file('uploads/'.$prev_image->src)){
						unlink('uploads/'.$prev_image->src);
					}

					$data = array(
						'src' => $image_data['file_name']
					);
					$this->db->where('ID', $prev_image->ID);
					$this->db->update('photos', $data); 
					
				}else{
				//no, insert
					$post_info = $this->get_post($this->input->post('project_id'));
					$data = array(
						'post_id' => $post_info->ID,
						'account_id' => $this->session->userdata('user_id'),
						'entry_date' => date('Y-m-d H:i:s'),
						'src' => $image_data['file_name']
					);
					$this->db->insert('photos', $data);
				}
				
			}
			return true;
		}
		##### EXPERIMENTAL : COMMENT TO ENABLE ADMIN UPDATE. UNCOMMENT IF THERE'S PROBLEM
		#}
		
	}

	function delete($project_id) 
	{
		##### EXPERIMENTAL : COMMENT TO ENABLE ADMIN UPDATE. UNCOMMENT IF THERE'S PROBLEM
		#if($this->check_author($project_id)>0){

			//DELETE table projects
			$this->db->where('ID', $project_id);
			$this->db->delete('projects'); 

		##### EXPERIMENTAL : COMMENT TO ENABLE ADMIN UPDATE. UNCOMMENT IF THERE'S PROBLEM
		#}
	}


	function get_post($project_id)
	{
		$this->db->where('ref_id', $project_id);
		$this->db->where('type_id', 3);
		$q = $this->db->get('posts');
		$r = $q->row();

		return $r;

	}

	function get_project_photo($project_id)
	{
		$r = $this->get_post($project_id);

		$this->db->where('post_id', $r->ID);
		$q = $this->db->get('photos');
		$r = $q->row();
		return $r;

	}

	function count_project()
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('projects','posts.ref_id = projects.ID AND posts.type_id=3');
		$this->db->where('deleted',NULL);
		$q = $this->db->get();
		$r = $q->num_rows();
		return $r;
	}

	function get_project($id='',$args='')
	{
		$this->db->select('*, projects.ID as project_id, posts.ID as post_id,posts.entry_date as entry_date,posts.view as view, (SELECT COUNT(ID) FROM comments x WHERE x.post_type=3 AND x.post_id = projects.ID) as nb_comments, (SELECT COUNT(ID) FROM likes y WHERE y.post_type=3 AND y.post_id = projects.ID) as nb_likes');
		$this->db->from('posts');
		$this->db->join('projects','posts.ref_id=projects.ID');
		$this->db->join('photos','posts.ID=photos.post_id','left');
		$this->db->join('accounts','posts.account_id=accounts.ID');
		if(!empty($args['tag'])){
			$this->db->join('tags','tags.post_id=posts.ID','left');
		}

		# ADMIN DISPLAY ALL
		if(empty($args['admin'])){
			$this->db->where('posts.deleted',NULL);
		}else{
			$this->db->select('posts.deleted as post_deleted');
			$this->db->select('(SELECT user_name FROM accounts WHERE ID = posts.deleted_by) AS deleter');
		}

		if(!empty($args['keyword'])){
			$where = "(";
				$where.= "projects.title LIKE '%".$args['keyword']."%'";
				if(!empty($args['search_all'])){
					$where.= " OR projects.content LIKE '%".$args['keyword']."%'";
				}
			$where.= ")";
			$this->db->where($where);
			#$this->db->or_like('projects.title',$args['keyword']);
			#if(!empty($args['search_all'])){
			#	$this->db->or_like('projects.content',$args['keyword']);
			#}
		}
		$this->db->where('type_id',3);
		if(empty($id)){
			if(!empty($args['tag'])){
				$this->db->where('tags.name',$args['tag']); 
			}
			
			if(!empty($args['sort'])){
				$this->db->order_by($args['sort'],'desc'); 
			}else{
				$this->db->order_by("posts.entry_date", "desc");
			}

			if(!empty($args['limit'])){
				if(isset($args['index'])){
					$index = $args['index'];
				}else{
					$index = 0;
				}
				$this->db->limit($args['limit'],$index); 		
			}
		}else{
		$this->db->where('projects.ID',$id);
		}
		$this->db->group_by('projects.ID');
		$q = $this->db->get();
		if(empty($id)){
			return $q->result();
		}else{
			return $q->row();
		}
	}



}

/* End of file m_projects.php */
/* Location: ./application/models/m_projects.php */