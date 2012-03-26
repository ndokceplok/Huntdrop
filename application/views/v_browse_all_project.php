<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
            	<div class="box">
                	<?php if(!empty($tag)){ $add = '/tag/'.$tag; }else {$add = '';}?>
                	<div class="box-heading red">
                        <h1><span class="title fl">Hunts <?php if(!empty($tag)){ echo ' with tag "'.$tag.'"';}?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            <a <?php if($sort=="latest"){?> class="selected" <?php } ?> href="<?php echo base_url();?>project<?php echo $add;?>" >Most Recent</a> 
                            <a <?php if($sort=="view"){?> class="selected" <?php } ?> href="<?php echo base_url();?>project<?php echo $add;?>/by/view">Most Viewed</a> 
                            <a <?php if($sort=="active"){?> class="selected" <?php } ?> href="<?php echo base_url();?>project<?php echo $add;?>/by/active" >Most Discussed</a> 
                            <a <?php if($sort=="popular"){?> class="selected" <?php } ?> href="<?php echo base_url();?>project<?php echo $add;?>/by/popular"  >Most Favorited</a> 
                        </p>

                        <div class="content_sidebar fl">
                            <h2>Browse Tags</h2>
                            <ul>
                            <?php foreach($tags as $r){ ?>
                            
                                <li>
                                <?php if(isset($tag) && $tag==$r->name){
                                ?>
                                    <strong><?php echo $r->name; ?> (<?php echo $r->tag_qty;?>)</strong>
                                <?php }else{ ?>
                                <a href="<?php echo base_url();?>project/tag/<?php echo $r->name;?>"><?php echo $r->name;?></a> (<?php echo $r->tag_qty;?>)
                                <?php } ?>
                                </li>
                            
                            <?php } ?>        
                            </ul>
                        </div><!-- .user_box-->

                        <div class="content_box">
							
                            <?php if(count($projects)==0){
                            if($this->session->userdata('user_id')){
                            $project_link = "member/project/create";
                            }else{
                            $project_link = "account/login";
                            }
                            ?>
                            <p class="no-item">There are no projects yet. <a href="<?php echo base_url().$project_link;?>">Create one</a></p>
                            <?php }else{?>
                            <ul class="projects_list">
                            <?php
                                foreach($projects as $i=>$r){ ?>
                            	<li>
                                
                                	<div class="projects_list_thumb">
                                    <a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><img src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo htmlspecialchars($r->title);?>" /></a>
                                    </div>
                                    
                                    <p><a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></p>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></p>
									<p><?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                            	</li>
                            <?php } 
                            }
                            ?> 
                            </ul>

                            <div class="pagination">
                            <?php echo $this->pager->create_links(); ?>
                            </div>
                            
                    	</div>
                    </div>
                    
            	</div><!-- .box -->
          	</div><!--#section_left-->
          
			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
