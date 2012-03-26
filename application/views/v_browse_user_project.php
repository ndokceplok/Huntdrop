<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl"><?php echo $account->user_name."'s Hunts";?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            Project by <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>"><?php echo $account->user_name;?></a>
                        </p>
                    
                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>


                        </div><!-- .fl-->
                        
                        <div class="content_box">

                            <?php if(count($projects)==0){ ?>
                            <p class="no-item">There are no projects from this user yet. </p>
                            <?php }else{ ?>
                            <ul class="projects_list">
                            <?php
                            foreach($projects as $i=>$r){ ?>
                            	<li>
                                
                                	<div class="projects_list_thumb">
                                    <a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><img src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo htmlspecialchars($r->title);?>" /></a>
                                    </div>
                                    
                                    <p><a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></p>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></p>
									<p><?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?></p>

                            	</li>
                            <?php } 
                            }
                            ?> 
                            </ul>
                            <?php if($this->pager->create_links()){ ?>
                            <div class="pagination">
                            <?php echo $this->pager->create_links(); ?>
                            </div>
                            <?php } ?>
                        </div><!-- .content_box-->
                    </div>
                    
                </div>

                

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
