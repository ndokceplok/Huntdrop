<?php

		if($this->session->userdata('logged_in')){ 
			$data['loggedin_profile'] = $this->m_profiles->read_by_account_id($this->session->userdata('user_id')); 
			$data['loggedin_account'] = $this->m_accounts->read($this->session->userdata('user_id')); 
			$data['loggedin_posts'] = $this->m_posts->count_user_posts($data['loggedin_profile']->account_id);
			$data['loggedin_days'] = get_total_days($data['loggedin_profile']->member_since,date("Y-m-d"));
		}
