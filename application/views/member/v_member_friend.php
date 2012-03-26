<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>


            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Your Hunting Friends</span></h1>
                    </div>
		
                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>
						
                        <p>You want to keep track of hunters you know or like? Follow them and all their updates will appear right here</p>
                        <ul id="hunters_thumbs">
                            <?php foreach ($friends as $i=>$r):?>
                                <li>
                                <?php 
                                $now = now().'<br>';
                                $last_active = human_to_unix($r->last_active).'<br>';
                                //echo date("Y-m-d H:i:s"); //$class="hunter_online"?>
                                <a class="avatar-container <?php if($r->is_online==1 && $now-900<$last_active){?> hunter_online <?php } ?>" href="<?php echo base_url();?>user/<?php echo $r->user_name;?>">
                                <span>
                                    <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar" />
                                </span>
                                </a>
                                <p><a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></p>
                                
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    
                            <div class="pane">
                            <h2>Friends' Activity</h2>
                            <?php if(count($friends)==0){ ?>
                            <p>You have no friends yet</p>
                            <?php }else{ ?>
                            <ul>
                            <?php foreach($posts as $r){ ?>
                            
                                <li>
                                <span class="type_label"><?php echo $type_label[$r->type_id];?></span>
                                <a href="<?php echo base_url().'user/'.$r->user_name;?>"><?php echo $r->user_name;?></a> 
								<?php echo $type_list[$r->type_id];?>
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
                                <a href="<?php echo $link;?>"><?php echo $user_info->user_name;?>'s profile</a>
                                <?php }else{ ?>
                                <a href="<?php echo $link;?>"><?php echo $content->title;?></a>
                                <?php } ?>
                                <span class="fr"><?php echo pretty_date($r->entry_date);?></span>
                                </li>
                                
                            <?php } ?>
                            </ul>
                            <?php } ?>
                    		</div>
                            
                            
                    </div><!-- .content_container-->

                </div>

                

            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        


	</div><!-- #content -->

	<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>