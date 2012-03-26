<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	           
                <?php if($stat->total_users>0){?>
                <h2>We are <strong><a href="<?php echo base_url();?>user"><?php echo $stat->total_users;?></a></strong> hunters making <strong><?php echo $stat->total_comments;?></strong> comments on <strong><a href="<?php echo base_url();?>project"><?php echo $stat->total_projects;?></a></strong> projects, <strong><a href="<?php echo base_url();?>blog"><?php echo $stat->total_blogs;?></a></strong> blogs, and <strong><a href="<?php echo base_url();?>review"><?php echo $stat->total_reviews;?></a></strong> reviews.</h2>
                <?php } ?>


                <?php if(isset($random_user_projects)){ ?>
            	<div class="random_box">
                	<!-- <a class="random_btn" href="">View Another</a>
                    <p class="loading hidden">Loading...</p> -->
                    
                    <div class="random_big_image">
                	   <a href="<?php echo base_url().'project/'.$random_user_projects[0]->ref_id.'/'.$random_user_projects[0]->alias;?>">
                       <img title="<?php echo htmlspecialchars($random_user_projects[0]->title);?>" alt="<?php echo htmlspecialchars($random_user_projects[0]->title);?>" src="<?php echo content_image($random_user_projects[0]->src);?>"/>
                       <p class="random_big_image_caption"><?php echo $random_user_projects[0]->title;?></p>
                       </a>
                    </div>
                    <div class="fl random_text">
                    	<div class="random_top random_id" id="<?php echo $random_user->account_id;?>">
                            <a class="fl user_link random_photo" title="View the profile of <?php echo $random_user->user_name;?>" href="<?php echo base_url();?>user/<?php echo $random_user->user_name;?>">
                                <img src="<?php echo user_image($random_user->photo);?>" alt="<?php echo $random_user->user_name;?>'s avatar" />
                            </a>
                            <p class="fl">
                            <a class="user_link" title="View the profile of <?php echo $random_user->user_name;?>" href="<?php echo base_url();?>user/<?php echo $random_user->user_name;?>"><span><?php echo $random_user->user_name;?></span></a><br>
                            dropped <br>
                            <a class="random_project_count" href="<?php echo base_url().'project/'.$random_user->user_name;?>"><span><?php echo $count_random_user_projects;?> Hunt<?php echo plural($count_random_user_projects);?></span></a>
                            </p>
                        </div>
                        
                        
                        <div class="random_thumbs">
						<?php foreach ($random_user_projects as $i=>$r){ ?>
                            <a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>" <?php if(($i+1)%2==0){ ?> class="last" <?php } ?> >
                                <img title="<?php echo htmlspecialchars($r->title);?>" alt="<?php echo htmlspecialchars($r->title);?>" class="<?php if(($i+1)==1){ ?> active <?php } ?> " src="<?php echo content_thumb($r->thumb);?>" data-big-image="<?php echo content_image($r->src);?>" />
                            </a>
                        <?php } ?>
                        </div>
                        
                    </div>
                </div>
                <?php } ?>


                <!-- PROJECTS start here -->
            	<div class="box hunts-box">
                	<div class="box-heading <?php if(count($latest_project)>3){?> home-heading <?php } ?> brown">
                        <span class="title fl">Hunts</span>
    
                        <span class="links2 fr">
                        View <a href="<?php echo base_url();?>project">all</a> | <a href="<?php echo base_url();?>project/by/active">most discussed</a> | <a href="<?php echo base_url();?>project/by/view">most viewed</a> | <a href="<?php echo base_url();?>project/by/popular">most favorite</a>
                        </span>

                    </div>
                    
                    <?php if(count($latest_project)==0){
                        if($this->session->userdata('user_id')){
                        $project_link = "member/project/create";
                        }else{
                        $project_link = "account/login";
                        }
                        ?>
                        <p class="no-item">There are no hunts yet. <a href="<?php echo base_url().$project_link;?>">Create one</a></p>
                        <?php }else{ ?>
                    <ul id="hunts_thumbs" <?php if(count($latest_project)>3){?> class="carou jcarousel-skin-tango" <?php } ?>>
						<?php foreach ($latest_project as $r): ?>
                            <li>
                            <img src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo $r->title;?>" />
                            <p>
                                <a class="thumbs_title" href="<?php echo base_url().'project/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                <?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> <br />
                                <?php echo $r->view;?> views | <?php echo $r->nb_comments;?> comments
                            </p>

                            </li>
                        <?php endforeach; ?>
                    	
                    </ul>
                    <?php } ?>
                    
                </div>
                <!-- PROJECTS end here -->
    
                <h2 class="center">We write about our favorite hunting adventures and showcase our trophies</h2>
                <!-- BLOGS start here -->
            	<div class="box">
                	<div class="box-heading <?php if(count($latest_blog)>3){?> home-heading <?php } ?> green">
                        <span class="title fl">Blogs</span>
    
                        <span class="links2 fr">
                        View <a href="<?php echo base_url();?>blog/">all</a> | <a href="<?php echo base_url();?>blog/by/active">most discussed</a> | <a href="<?php echo base_url();?>blog/by/view">most viewed</a> | <a href="<?php echo base_url();?>blog/by/popular">most favorite</a>
                        </span>

                    </div>

                    <?php if(count($latest_blog)==0){
                        if($this->session->userdata('user_id')){
                        $blog_link = "member/blog/create";
                        }else{
                        $blog_link = "account/login";
                        }
                        ?>
                        <p class="no-item">There are no hunting blogs yet. <a href="<?php echo base_url().$blog_link;?>">Create one</a></p>
                    <?php }else{ ?>
                    <ul id="blog_thumbs" <?php if(count($latest_blog)>3){?> class="carou jcarousel-skin-tango" <?php } ?>>
						 <?php foreach ($latest_blog as $r): ?>
                            <li>
                        	<p class="blog_thumb">
                                <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar" title="<?php echo $r->user_name;?>'s avatar"/>
                            </p>
                            <p class="blog_title">
                                <a class="thumbs_title" href="<?php echo base_url().'blog/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                <span class="blog_date"><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></span>
                            </p>
                            
                            <br class="clear" />
                            
                            <p class="blog_shortdesc"><?php echo substr(strip_tags($r->content),0,147); if(strlen(strip_tags($r->content))>150){ echo "...";}?> </p>

                            <p class="quick_stat"><?php echo $r->view;?> reads | <?php echo $r->nb_comments;?> comments | <a href="<?php echo base_url().'blog/'. $r->ref_id;?>/<?php echo $r->alias;?>">Continue reading&raquo;</a> </p>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php } ?>
                    
                </div>
                <!-- BLOGS end here -->

                <h2 class="center">We record our hunting experiences and share them to you</h2>
    
            	<div class="box">
                	<div class="box-heading <?php if(count($latest_video)>3){?> home-heading <?php } ?> green">
                        <span class="title fl">Videos</span>
    
                        <span class="links2 fr">
                        View <a href="<?php echo base_url();?>video/">all</a> | <a href="<?php echo base_url();?>video/by/active">most discussed</a> | <a href="<?php echo base_url();?>video/by/view">most viewed</a> | <a href="<?php echo base_url();?>video/by/popular">most favorite</a>
                        </span>

                    </div>
                    
                    <?php if(count($latest_video)==0){
                        if($this->session->userdata('user_id')){
                        $video_link = "member/video/create";
                        }else{
                        $video_link = "account/login";
                        }
                        ?>
                        <p class="no-item">There are no hunting videos yet. <a href="<?php echo base_url().$video_link;?>">Create one</a></p>
                    <?php }else{ ?>
                    <ul id="video_thumbs" <?php if(count($latest_video)>3){?> class="carou jcarousel-skin-tango" <?php } ?>>
						 <?php foreach ($latest_video as $r): ?>
                            <li>
                            <p class="blog_thumb">
                                <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar" title="<?php echo $r->user_name;?>'s avatar"/>
                            </p>
                            <p class="blog_title">
                                <a class="thumbs_title" href="<?php echo base_url().'video/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                <span class="blog_date"><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></span>
                            </p>
                            
                            <br class="clear" />
                            
                            <p class="blog_shortdesc"><?php echo substr(strip_tags($r->content),0,150);?> </p>

                            <p class="quick_stat"><?php echo $r->view;?> reads | <?php echo $r->nb_comments;?> comments | <a href="<?php echo base_url().'blog/'. $r->ref_id;?>/<?php echo $r->alias;?>">Continue reading&raquo;</a> </p>

                            </li>
                        <?php endforeach; ?>
                   	
                        
                    </ul>
                    <?php } ?>
                    
                </div>

                <h2 class="center">We review about hunting equipments</h2>
    
            	<div class="box">
                	<div class="box-heading red">
                        <span class="title fl">Product Reviews</span>

                        <span class="links2 fr">
                        View <a href="<?php echo base_url();?>review/">all</a> | <a href="<?php echo base_url();?>review/by/active">most discussed</a> | <a href="<?php echo base_url();?>review/by/view">most viewed</a> | <a href="<?php echo base_url();?>review/by/popular">most favorite</a>
                        </span>
                        
                    </div>
                    
                    <?php if(count($latest_review)==0){
                        if($this->session->userdata('user_id')){
                        $review_link = "member/review/create";
                        }else{
                        $review_link = "account/login";
                        }
                        ?>
                        <p class="no-item">There are no product reviews yet. <a href="<?php echo base_url().$review_link;?>">Create one</a></p>
                    <?php }else{ ?>
                    <ul id="review_posts">

						<?php foreach ($latest_review as $r): ?>
                        <li>
                        	<span class="review_thumb"><img src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo $r->title;?>" title="<?php echo $r->title;?>"/></span>
                            <p class="review_desc">
                                <!-- <a class="review_title" href=""><?php echo $r->object;?></a> --> 
                                <strong><?php echo $r->object;?></strong><br />
                                <a class="review_title" href="<?php echo base_url().'review/'. $r->ref_id;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a> <br />
                                <span class="blog_date"><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo ($r->user_name);?></a></span><br>
                                <span class="blog_shortdesc"><?php echo substr(strip_tags($r->content),0,147); if(strlen(strip_tags($r->content))>150){ echo "...";}  ?></span>
                            </p>
                            
                                <div class="rateit review_rating" data-rateit-value="<?php echo $r->rating;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                        </li>
                        <?php endforeach; ?>
                        
                    </ul>
                    <?php } ?>
                    
                </div>


                <?php if (count($pulse) >0){ ?>
            	<div class="box">
                	<div class="box-heading red">
                        <span class="title">Huntdrop Pulse</span>
                    </div>
                    
                    <ul id="pulse_list">
						<?php foreach ($pulse as $r): ?>
                        <li>
                        	<?php
                                $comment_info = $this->m_comments->read($r->ref_id);
                                $post_type = $comment_info->post_type;
                                $user_id = $comment_info->user_id;
							?>
                            <span class="fl type_label"><?php if(!empty($user_id)){echo 'Profile';}else{ echo $type_label[$post_type];}?></span>

                            <?php #if($r->type_id==9 && $post_type==5){ echo "replied on "; }else{ echo $type_list[$r->type_id];}?> 
							<?php #if(empty($r->user_id)){ echo $type_list[$r->post_type]; }?>
                            <?php
                                if(!empty($user_id)){
                                    $user_info = $this->m_accounts->read($user_id);
                                    $link = base_url().'user/'.$user_info->user_name;
                                }
                                if($post_type==1){
                                    $content = $this->m_reviews->read($comment_info->post_id);
                                    $link = base_url().'review/'.$comment_info->post_id.'/'.$content->alias;
                                }elseif($post_type==2){
                                    $content = $this->m_blogs->read($comment_info->post_id);
                                    $link = base_url().'blog/'.$comment_info->post_id.'/'.$content->alias;
                                }elseif($post_type==3){
                                    $content = $this->m_projects->read($comment_info->post_id);
                                    $link = base_url().'project/'.$comment_info->post_id.'/'.$content->alias;
                                }elseif($post_type==4){
                                    $content = $this->m_videos->read($comment_info->post_id);
                                    $link = base_url().'video/'.$comment_info->post_id.'/'.$content->alias;
                                }elseif($post_type==5){
                                    $content = $this->m_threads->read($comment_info->post_id);
                                    $link = base_url().'forum/thread/'.$comment_info->post_id.'/'.$content->alias;
                                }
                            ?>
                            <?php if(!empty($user_id)){ ?>
                            <a href="<?php echo $link;?>"><?php echo $user_info->user_name;?>'s profile</a>
                            <?php }else{ ?>
                            <a href="<?php echo $link;?>"><?php echo $content->title;?></a>
                            <?php } ?>

                            <span class="fr"> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> <?php echo pretty_date($r->entry_date);?></span>
                            <span class="fr"></span>
                            
                        </li>
                        <?php endforeach; ?>
                        
                    </ul>
                    
                </div>
                <?php } ?>
    
            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
