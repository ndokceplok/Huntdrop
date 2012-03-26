<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl"><?php echo $account->user_name."'s Videos";?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            Video by <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>"><?php echo $account->user_name;?></a>
                        </p>
                    
                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>

                            <div class="content_sidebar ">
                            </div><!-- .content_sidebar-->

                        </div><!-- .fl-->
                        
                        <div class="content_box">

                            <?php if(count($videos)==0){ ?>
                            <p class="no-item">There are no videos from this user yet. </p>
                            <?php }else{ ?>
                            <ul class="content_list">
                            <?php
                            foreach($videos as $i=>$r){  ?>
                            	<li>
                                
								<!--<?php if(!empty($r->photo)){ ?>
                                    <a href=""><img class="content_list_thumb" src="<?php echo user_image($r->photo);?>" /></a>
                                <?php } ?>-->
                                
                                <div>
                                    <h2><a href="<?php echo base_url().'video/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comments</p>

                                </div>

                                <!--<br class="clear" />-->

                                <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>

                                <p><a href="<?php echo base_url().'video/'.$r->ref_id.'/'.$r->alias;?>">Read this entry</a>&raquo;</p>
                                
                                
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
