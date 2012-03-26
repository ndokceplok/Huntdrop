<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
				<?php if($this->session->flashdata('log')){ echo '<p class="log">'.$this->session->flashdata('log').'</p>'; } ?>

            	<div class="box">
                	<div class="box-heading green">
                        <h1><span class="title fl"><?php echo $account->user_name;?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            View <?php echo $account->user_name;?>'s : 
                            <a href="<?php echo base_url();?>project/<?php echo $account->user_name;?>">Hunts</a>
                            <a href="<?php echo base_url();?>video/<?php echo $account->user_name;?>">Videos</a>
                            <a href="<?php echo base_url();?>blog/<?php echo $account->user_name;?>">Blogs</a>
                            <a href="<?php echo base_url();?>review/<?php echo $account->user_name;?>">Reviews</a>
                        </p>
                    
                        <div class="profile fl">
                            <?php 
                            $now = now().'<br>';
                            $last_active = human_to_unix($account->last_active);
                            ?>
                            <img class="profile_image <?php if($account->is_online==1 && $now-900<$last_active){?> hunter_online <?php } ?>" alt="<?php echo $account->user_name;?>'s avatar" title="Photo of <?php echo $account->user_name;?>" src="<?php echo user_image($profile->photo);?>" />
                            
                            <?php
							if($this->session->userdata('user_id')){
								$message_link = 'member/message/compose/'.$account->user_name;
								$add_friend_link = 'user/'.$account->user_name.'/add_friend';
								$remove_friend_link = 'user/'.$account->user_name.'/remove_friend';
							}else{
								$message_link = 'account/login';
								$add_friend_link = 'account/login';
							}
							?>
                            <div class="profile_links">
                            <?php if($this->session->userdata('user_id')!=$account->ID){?>
                            
                            <?php if(!isset($already_friend)){ ?>
                            <p><a class="add-to-buddies" href="<?php echo base_url().$add_friend_link;?>">Follow</a></p>
                            <?php }else{ ?>
                            <p><a class="send-a-message" href="<?php echo base_url().$message_link;?>">Send a message</a></p>
                            <p><a class="add-to-buddies" href="<?php echo base_url().$remove_friend_link;?>">Unfollow</a></p>
                            <?php } ?>
                            
                            <?php } ?>
                            </div>
                            
                            <div class="content_sidebar user_buddies">
                            	<h2>Following <?php if(count($friends)!=0){?> <span class="">| <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>/friends">view all <?php echo count($friends);?></a> &raquo;</span><?php } ?></h2>
                                <?php if(count($friends)==0){?>
                                    <p class="no-item">None so far</p>
                                <?php }else{ ?>
                                <ul>
								<?php foreach ($friends as $i=>$r):?>
                                    <li>
                                    <a class="avatar_thumb" href="<?php echo base_url();?>user/<?php echo $r->user_name;?>">
                                        <span>
                                            <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar"/>
                                        </span>
                                    </a>
                                    <p><a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></p>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                                <?php } ?>
                            </div>
                            
                        </div><!-- .user_box-->
                        
                        <div class="content_box">
							
                            <div class="content_box_left">
                                <div class="content_info">
                                <h3><?php echo $nb_posts;?> posts in <?php echo $nb_days;?> days</h3>
                                <?php if(!empty($profile->address)){?><p>Address : <?php echo $profile->address;?></p><?php } ?>
                                <?php if(!empty($profile->location)){?><p>Location : <?php echo $profile->location;?></p><?php } ?>
                                <?php if(!empty($profile->occupation)){?><p>Occupation : <?php echo $profile->occupation;?></p><?php } ?>
                                <?php if(!empty($profile->hobby)){?><p>Hobby : <?php echo $profile->hobby;?></p><?php } ?>
                                <?php if(!empty($profile->website)){?><p>Website : <a target="_blank" href="http://<?php echo $profile->website;?>"><?php echo $profile->website;?></a></p><?php } ?>
                                </div>
    
                                <div class="profile_desc">
                                <?php echo nl2br($profile->about_me);?>
                                
                                <?php if(!empty($profile->signature)){ ?><p class="signature">--<?php echo $profile->signature;?></p><?php } ?>
                                </div>
                                
                                <div class="pane">
                                <h2>Latest Activity</h2>
                                <ul>
                                <?php if(count($posts)==0){ ?>
                                    <li class="no-item">No Activity Yet</li>
                                <?php } ?>
                                <?php foreach($posts as $r){ ?>
                                
                                    <li>
                                    <span class="fl type_label"><?php echo $type_label[$r->type_id];?></span>
                                    <!--<?php echo $type_list[$r->type_id];?> - -->
                                    <?php
                                    if($r->type_id==1){
                                        $content = $this->m_reviews->read($r->ref_id);
                                        $link = base_url().'review/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==2){
                                        $content = $this->m_blogs->read($r->ref_id);
                                        $link = base_url().'blog/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==3){
                                        $content = $this->m_projects->read($r->ref_id);
                                        $link = base_url().'project/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==4){
                                        $content = $this->m_videos->read($r->ref_id);
                                        $link = base_url().'video/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==5){
                                        $content = $this->m_threads->read($r->ref_id);
                                        $link = base_url().'forum/thread/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==8 || $r->type_id==9){
                                        if($r->type_id==8){
                                        $info = $this->m_likes->read($r->ref_id);
                                        }else{
                                        $info = $this->m_comments->read($r->ref_id);
                                        $user_id = $info->user_id;
                                        }
                                        $post_id = $info->post_id;				
                                        $post_type = $info->post_type;
                                        if(!empty($user_id)){
                                            $user_info = $this->m_accounts->read($user_id);
                                            $link = base_url().'user/'.$user_info->user_name;
                                        }
                                        if($post_type==1){
                                            $content = $this->m_reviews->read($info->post_id);
                                            $link = base_url().'review/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==2){
                                            $content = $this->m_blogs->read($info->post_id);
                                            $link = base_url().'blog/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==3){
                                            $content = $this->m_projects->read($info->post_id);
                                            $link = base_url().'project/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==4){
                                            $content = $this->m_videos->read($info->post_id);
                                            $link = base_url().'video/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==5){
                                            $content = $this->m_threads->read($info->post_id);
                                            $link = base_url().'forum/thread/'.$info->post_id.'/'.$content->alias;
                                        }
                                    }
                                    ?>
                                    
                                    <?php if(!empty($user_id)){ ?>
                                    <a class="fl activity_title" href="<?php echo $link;?>"><?php echo $user_info->user_name;?>'s profile</a>
                                    <?php }else{ ?>
                                    <a class="fl activity_title" href="<?php echo $link;?>"><?php echo $content->title;?></a>
                                    <?php } ?>
                                    
                                    <span class="fr activity_date"><?php echo pretty_date($r->entry_date);?></span>
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                </div>
                            </div><!-- .content_box_left -->
                            
                            
                            <div class="content_box_right">
                                <?php if(!$this->session->userdata('logged_in')){ ?>
                            	<p class="center"><a href="<?php echo base_url().'account/register';?>"><img src="<?php echo assets_url();?>images/join.jpg" alt="join now link" /></a></p>
                                <?php } ?>

                                <div class="pane project_pane">
                                <h2>Latest Hunts <?php if(count($projects)!=0){?> <span class="links">| <a href="<?php echo base_url().'project/'.$account->user_name;?>">view all <?php echo count($projects);?></a> &raquo;</span><?php } ?></h2>
                                <?php if(count($projects)>1){ ?>
                                <div class="pane_nav">
                                <a class="left" id="project_prev" href="#">Prev</a>
                                <a class="right" id="project_next" href="#">Next</a>
                                </div>
                                <?php } ?>
                                <?php if(count($projects)==0){ ?>
                                    <p class="no-item">No hunts yet</p>
                                <?php }else{ ?>
                                <ul class="project_list">
                                <?php foreach($projects as $i=>$r){ ?>
                                
                                    <li>
                                    <a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><img src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo htmlspecialchars($r->title);?>" /></a>
                                    <p><a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></p>
                                    <p><?php echo pretty_date($r->entry_date);?></p>
                                    <p><?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?></p>
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                                </div>

                                <div class="pane blog_pane">
                                <h2>Latest Blogs <?php if(count($blogs)!=0){?> <span class="links">| <a href="<?php echo base_url().'blog/'.$account->user_name;?>">view all <?php echo count($blogs);?></a> &raquo;</span><?php } ?></h2>
                                <?php if(count($blogs)>1){ ?>
                                <div class="pane_nav">
                                    <a class="left" id="blog_prev" href="#">Prev</a>
                                    <a class="right" id="blog_next" href="#">Next</a>
                                </div>
                                <?php } ?>
                                <?php if(count($blogs)==0){ ?>
                                    <p class="no-item">No blogs yet</p>
                                <?php }else{ ?>
                                <ul class="blog_slide blog_list">
                                <?php foreach($blogs as $i=>$r){ ?>
                                
                                    <li>
                                        <p class="blog_thumb">
                                            <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar" />
                                        </p>
                                        <p class="blog_title">
                                            <a class="thumbs_title" href="<?php echo base_url().'blog/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                            <span class="blog_date"><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></span>
                                        </p>
                                        
                                        <br class="clear" />
                                        
                                        <p class="blog_shortdesc"><?php echo substr(strip_tags($r->content),0,150);?></p>
                                        
                                        <p class="quick_stat"><?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <a href="<?php echo base_url().'blog/'. $r->ref_id;?>/<?php echo $r->alias;?>">Continue reading&raquo;</a> </p>
                                        
                                    <!--<?php echo pretty_date($r->entry_date);?> - <a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a>-->
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                                </div>
    
                                <div class="pane blog_pane">
                                <h2>Latest Videos <?php if(count($videos)!=0){?> <span class="links">| <a href="<?php echo base_url().'video/'.$account->user_name;?>">view all <?php echo count($videos);?></a> &raquo;</span><?php } ?></h2>
                                <?php if(count($videos)>1){ ?>
                                <div class="pane_nav">
                                    <a class="left" id="video_prev" href="#">Prev</a>
                                    <a class="right" id="video_next" href="#">Next</a>
                                </div>
                                <?php } ?>
                                <?php if(count($videos)==0){ ?>
                                    <p class="no-item">No videos yet</p>
                                <?php }else{ ?>
                                <ul class="video_list blog_list">
                                <?php foreach($videos as $i=>$r){ ?>
                               
                                    <li>
                                        <p class="blog_thumb">
                                            <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar"/>
                                        </p>
                                        <p class="blog_title">
                                            <a class="thumbs_title" href="<?php echo base_url().'video/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                            <span class="blog_date"><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></span>
                                        </p>
                                        
                                        <br class="clear" />
                                        
                                        <p class="blog_shortdesc"><?php echo substr(strip_tags($r->content),0,150);?></p>
                                        
                                        <p class="quick_stat"><?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <a href="<?php echo base_url().'video/'. $r->ref_id;?>/<?php echo $r->alias;?>">Continue reading&raquo;</a> </p>
                                        
                                    <!--<?php echo pretty_date($r->entry_date);?> - <a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a>-->
                                    </li>
    
                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                                </div>
                                
                        		<!--
                                <div class="pane">
                                <h2>Latest Reviews</h2>
                                <ul>
                                <?php foreach($reviews as $r){ ?>
                                
                                    <li>
                                    <?php echo pretty_date($r->entry_date);?> - <a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a>
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                </div>
                                -->
                            </div><!-- .content_box_left -->

                        </div><!-- .content_box-->
                    </div>
                    
                    <?php $this->load->view('includes/comments.php',array('user_comment'=>true)); ?>
            
                </div>

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
        
        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
