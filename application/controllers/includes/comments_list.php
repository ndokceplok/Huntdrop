<?php
$data['comments'] = $this->m_posts->get_content_comment($id,$type_id);
$arr = NULL;
$days_arr = NULL; 
foreach($data['comments'] as $r){
	$nb_post = $this->m_posts->count_user_posts($r->account_id);
	$nb_days = get_total_days($r->member_since,date("Y-m-d"));
	$arr[] = $nb_post;
	$days_arr[] = $nb_days;
}
$data['commenter_posts'] = $arr;
$data['commenter_days'] = $days_arr;