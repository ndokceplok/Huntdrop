<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
            	<div class="box">
                	<?php if(!empty($tag)){ $add = '/tag/'.$tag; }else {$add = '';}?>
                	<div class="box-heading red">
                        <h1><span class="title fl">Videos <?php if(!empty($tag)){ echo ' with tag "'.$tag.'"';}?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            <a <?php if($sort=="latest"){?> class="selected" <?php } ?> href="<?php echo base_url();?>video<?php echo $add;?>" >Most Recent</a> 
                            <a <?php if($sort=="view"){?> class="selected" <?php } ?> href="<?php echo base_url();?>video<?php echo $add;?>/by/view">Most Viewed</a> 
                            <a <?php if($sort=="active"){?> class="selected" <?php } ?> href="<?php echo base_url();?>video<?php echo $add;?>/by/active" >Most Discussed</a> 
                            <a <?php if($sort=="popular"){?> class="selected" <?php } ?> href="<?php echo base_url();?>video<?php echo $add;?>/by/popular"  >Most Favorited</a> 
                        </p>

                        <div class="content_sidebar fl">
                            <h2>TOP VIDEO BLOGGERS</h2>
                            <ul>
                            <?php foreach($top_video_bloggers as $r){ ?>
                            
                                <li><a href="<?php echo base_url();?>video/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> (<?php echo $r->total_video_blogs;?>)</li>
                            
                            <?php } ?>        
                    		</ul>
                        </div><!-- .user_box-->

                        <div class="content_box">
                            <?php if(count($videos)==0){
                            if($this->session->userdata('user_id')){
                            $video_link = "member/video/create";
                            }else{
                            $video_link = "account/login";
                            }
                            ?>
                            <p class="no-item">There are no videos yet. <a href="<?php echo base_url().$video_link;?>">Create one</a></p>
                            <?php }else{ ?>
                            <ul class="content_list">
                            <?php
                                foreach($videos as $i=>$r){ ?>
                            	<li>
                                
                                <!--<a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" /></a>-->
                                <a class="blog_list_thumb" href="<?php echo base_url().'user/'.$r->user_name;?>">
                                    <span><img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar" /></span>
                                </a>
                                
                                <div class="blog_list_title">
                                    <h2><a href="<?php echo base_url().'video/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                                    <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>
    
                                    <p><a href="<?php echo base_url().'video/'.$r->ref_id.'/'.$r->alias;?>">Read this entry</a>&raquo;</p>
                                    

                                </div>

                                
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
