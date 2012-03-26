<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl"><?php echo $series_detail->series_name;?> Blog Series by <?php echo $account->user_name;?></span></h1>
                    </div>
        
                    <div class="content_container box-content">
                        <p class="stat_bar">
                            Blog by <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>"><?php echo $account->user_name;?></a>
                        </p>
                    
                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>

                            <div class="content_sidebar ">
                                <h2><?php echo $user_name;?>'s Blog Series</h2>
                                <ul>
                                <?php foreach($blog_series as $r){ ?>
                                
                                    <li><a href="<?php echo base_url();?>blog/series/<?php echo $r->ID;?>"><?php echo $r->series_name;?></a></li>
                                
                                <?php } ?>        
                                </ul>
                            </div><!-- .content_sidebar-->

                        </div><!-- .fl-->
                        
                        <div class="content_box">
                            <?php if(count($blogs)==0){ ?>
                            <p class="no-item">There are no blogs of this series yet. </p>
                            <?php }else{ ?>
                            <ul class="content_list">
                            <?php
                            foreach($blogs as $i=>$r){ ?>
                            	<li>
                                
                                <div>
                                    <h2><a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comments | <?php echo $r->view;?> views | <?php echo $r->nb_likes;?> likes</p>

                                    <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>
    
                                    <p><a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>">Read this entry</a>&raquo;</p>

                                </div>

                                
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
