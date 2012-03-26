<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Dashboard</span></h1>
                    </div>
		
                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>

                        <?php
                            $notif = $this->session->flashdata('notif');
                            if( ! empty($notif) ) {
                        ?>
                        <p class="log">
                            <?=$notif?>
                        </p>
                        <?php
                            }
                        ?>

                        <ul id="actions">
                        	<p class="message_notif"><a <?php if($unread>0){?> class="strong" <?php } ?> href="<?php echo base_url().'member/message/';?>"><?php if($unread>0){ echo $unread;}else{ echo "No";}?> unread message<?php if($unread>1){?>s<?php }?></a></p>
                        	<h1>Welcome, <?php echo $account->user_name;?></h1>
                           	<li>
                                <a href="<?php echo base_url();?>member/project/create">Add new project</a>
                                <p>Showcase your hunting projects</p>
                            </li>
                
                            <li>
                                <a href="<?php echo base_url();?>member/blog/create">Post a new blog entry</a>
                                <p>Journal your personal hunting experiences</p>
                            </li>
                
                            <li>
                                <a href="<?php echo base_url();?>member/review/create">Post a review</a>
                                <p>Review your favorite hunting stuffs</p>
                            </li>

                            <li>
                                <a href="<?php echo base_url();?>member/forum/create">Start a forum thread</a>
                                <p>Start a discussion of hunting in our forum</p>
                            </li>
                        </ul>
            
                    
                        <div class="profile fl">
                            <img class="profile_image" alt="Photo of <?php echo $account->user_name;?>" title="Photo of <?php echo $account->user_name;?>" src="<?php echo user_image($profile->photo);?>" />

                            <p><a href="<?php echo base_url();?>member/profile/update">Edit my profile</a></p>
                            <p><a href="<?php echo base_url();?>member/profile/setting">Change account settings</a></p>
                            <p><a href="<?php echo base_url();?>member/invite">Invite your friends</a></p>
                            
                        </div><!-- .user_box-->

                        <div class="content_box">

                            <div class="content_box_left">
                                <div class="content_info">
                                    <h3><?php echo $nb_posts;?> posts in <?php echo $nb_days;?> days</h3>
                                    <!-- <p>Member since : <?php echo pretty_date($profile->member_since);?></p> -->
                                    <p>Address : <?php echo $profile->address;?></p>
                                    <p>Location : <?php echo $profile->location;?></p>
                                    <p>Occupation : <?php echo $profile->occupation;?></p>
                                    <p>Hobby : <?php echo $profile->hobby;?></p>
                                    <p>Website : <?php echo $profile->website;?></p>
                        		</div>

                                <div class="profile_desc">
    								<?php echo nl2br($profile->about_me);?>
                                    
                                    <?php if(!empty($profile->signature)){ ?><p class="signature">--<?php echo $profile->signature;?></p><?php } ?>
                                </div>
                
                                <div class="pane">
                                <h2>Latest Activity</h2>
                                <?php if(count($posts)==0){?>
                                <p class="no-item">No activity yet</p>
                                <?php }else{ ?>
                                <ul>
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
                                            $content = $this->m_reviews->read($post_id);
                                            $link = base_url().'review/'.$post_id.'/'.$content->alias;
                                        }elseif($post_type==2){
                                            $content = $this->m_blogs->read($post_id);
                                            $link = base_url().'blog/'.$post_id.'/'.$content->alias;
                                        }elseif($post_type==3){
                                            $content = $this->m_projects->read($post_id);
                                            $link = base_url().'project/'.$post_id.'/'.$content->alias;
                                        }elseif($post_type==4){
                                            $content = $this->m_videos->read($post_id);
                                            $link = base_url().'video/'.$post_id.'/'.$content->alias;
    									}elseif($post_type==5){
    										$content = $this->m_threads->read($post_id);
    										$link = base_url().'forum/thread/'.$post_id.'/'.$content->alias;
                                        }
                                    }
                                    ?>
                                    <?php if(!empty($user_id)){ ?>
                                    <a class="fl activity_title" href="<?php echo $link;?>"><?php echo $user_info->user_name;?>'s profile</a>
                                    <?php }else{ ?>
                                    <a class="fl activity_title" href="<?php echo $link;?>"><?php echo $content->title;?></a>
                                    <?php } ?>
                                    <!-- - -->
                                    <span class="fr activity_date"><?php echo pretty_date($r->entry_date);?></span>
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                        		</div>
                            </div>
                            
                            <div class="content_box_right">

                                <div class="pane project_pane">
                                <h2>Latest Hunts <span class="links"><a href="<?php echo base_url().'project/'.$account->user_name;?>">view all <?php echo count($projects);?></a> &raquo;</span></h2>
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
                                    <a title="<?php echo $r->title;?>" href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><img src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo $r->title;?>" /></a>
                                    <p><a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></p>
                                    <p><?php echo pretty_date($r->entry_date);?></p>
                                    <p><?php echo $r->view;?> views | <?php echo $r->nb_comments;?> comments</p>
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                                </div>

                                <div class="pane blog_pane">
                                <h2>Latest Blogs <span class="links"><a href="<?php echo base_url().'blog/'.$account->user_name;?>">view all <?php echo count($blogs);?></a> &raquo;</span></h2>
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
                                            <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar"/>
                                        </p>
                                        <p class="blog_title">
                                            <a class="thumbs_title" href="<?php echo base_url().'blog/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                            <span class="blog_date"><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></span>
                                        </p>
                                        
                                        <br class="clear" />
                                        
                                        <p class="blog_shortdesc"><?php echo substr(strip_tags($r->content),0,150);?></p>
    									
                                        <p class="quick_stat"><?php echo $r->view;?> reads | <?php echo $r->nb_comments;?> comments | <a href="<?php echo base_url().'blog/'. $r->ref_id;?>/<?php echo $r->alias;?>">Continue reading&raquo;</a> </p>
                                        
                                    <!--<?php echo pretty_date($r->entry_date);?> - <a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a>-->
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                        		</div>
                       
                                <div class="pane blog_pane">
                                <h2>Latest Videos <span class="links"><a href="<?php echo base_url().'video/'.$account->user_name;?>">view all <?php echo count($videos);?></a> &raquo;</span></h2>
                                <?php if(count($videos)>1){ ?>
                                <div class="pane_nav">
                                    <a class="left" id="video_prev" href="#">Prev</a>
                                    <a class="right" id="video_next" href="#">Next</a>
                                </div>
                                <?php } ?>
                                <?php if(count($videos)==0){ ?>
                                    <p class="no-item">No videos yet</p>
                                <?php }else{?>
                                <ul class="video_list blog_list">                                
                                <?php foreach($videos as $i=>$r){ ?>
                                
                                    <li>
                                        <p class="blog_thumb">
                                            <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar" />
                                        </p>
                                        <p class="blog_title">
                                            <a class="thumbs_title" href="<?php echo base_url().'video/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                            <span class="blog_date"><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></span>
                                        </p>
                                        
                                        <br class="clear" />
                                        
                                        <p class="blog_shortdesc"><?php echo substr(strip_tags($r->content),0,150);?></p>
    									
                                        <p class="quick_stat"><?php echo $r->view;?> reads | <?php echo $r->nb_comments;?> comments | <a href="<?php echo base_url().'video/'. $r->ref_id;?>/<?php echo $r->alias;?>">Continue reading&raquo;</a> </p>
                                        
                                    <!--<?php echo pretty_date($r->entry_date);?> - <a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a>-->
                                    </li>

                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                        		</div>
                        
                                <div class="pane">
                                <h2>Latest Reviews</h2>
                                <?php if(count($reviews)==0){ ?>
                                    <p class="no-item">No reviews yet</p>
                                <?php }else{ ?>
                                <ul>                                
                                <?php foreach($reviews as $r){ ?>
                                
                                    <li>
                                    <?php echo pretty_date($r->entry_date);?> - <a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a>
                                    </li>
                                    
                                <?php } ?>
                                </ul>
                                <?php } ?>
                        		</div>
                            </div>

                        </div><!-- .content_box-->
                    </div>

                </div>

                

            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        


	</div><!-- #content -->

	<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>