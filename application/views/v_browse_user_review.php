<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl"><?php echo $account->user_name."'s Reviews";?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            Review by <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>"><?php echo $account->user_name;?></a>
                        </p>

                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>


                        </div><!-- .fl-->

                        <div class="content_box">
							
                            <?php if(count($reviews)==0){ ?>
                            <p class="no-item">There are no reviews from this user yet. </p>
                            <?php }else{ ?>
                            <ul class="content_list">
                            <?php
                            foreach($reviews as $i=>$r){  ?>
                            	<li>
                                
                                <p class="fl member_content_with_thumbnail">
                                    <a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" /></a>
                                </p>

                                
                                <div class="content_list_title review_list_title">
                                    <p class="highlight_bar">
                                        <!--<a href="<?php echo base_url().'review/brand/'.$r->brand_id;?>">-->
                                        <?php if(!empty($r->brand_id)){?><strong><?php echo $r->brand_name;?> </strong> - <?php } ?>
                                        <!--</a>-->
                                        <?php echo $r->object;?>
                                    </p>
                                    <div class="content_list_rating rateit" data-rateit-value="<?php echo $r->rating;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                   
                                    <h2><a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                                </div>

                                <br class="clear" />

                                <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>

                                <p><a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>">Read this review</a>&raquo;</p>
                                
                                
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
                                                        
                    	</div>
                    </div>
                    
            	</div><!-- .box -->
          	</div><!--#section_left-->
          
			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
