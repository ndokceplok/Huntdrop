<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
            	<div class="box">
                	<?php if(!empty($tag)){ $add = '/tag/'.$tag; }else {$add = '';}?>
                	<div class="box-heading red">
                        <h1><span class="title fl"><?php echo isset($forum_info)?$forum_info->forum_name." Forum":"Unanswered Threads" #$title;?> <?php if(!empty($tag)){ echo ' with tag "'.$tag.'"';}?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                        	
                        	<?php 
							if($this->session->userdata('user_id')){
							$thread_link = "member/forum/create";
                            if(isset($forum_id)){
                                $thread_link.= "/".$forum_id;
                            }
							}else{
							$thread_link = "account/login";
							}
							?>
                            <a href="<?php echo base_url().$thread_link;?>">Start A New Thread</a> 
                            <?php if(isset($unanswered)){ ?>
                            <a href="<?php echo base_url();?>forum<?php if(!empty($forum_id)){ echo "/".$forum_id; }?>">View All Threads</a> 
                            <?php }else { ?>
                            <a href="<?php echo base_url();?>forum<?php if(!empty($forum_id)){ echo "/".$forum_id; }?>/unanswered">View Unanswered Threads</a> 
                            <?php } ?>
                            <?php if(isset($forum_id)){ ?>
                            <a href="<?php echo base_url();?>forum">Forum Main Page</a> 
                            <?php } ?>

                        </p>


                        <a class="btn show-forums">Show Forums</a>
                        <table class="lists forum_lists forums hidden">
                            <thead>
                                <tr>
                                    <th>Forums</th>
                                    <th>Threads</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($forums as $i=>$r){  ?>
                                    <tr>
                                        <td>
                                        <h2><a href="<?php echo base_url().'forum/'.$r->forum_id;?>"><?php echo $r->forum_name;?></a></h2>
                                        <p class="short_desc"><?php echo substr(strip_tags($r->description),0,150);?></p>
                                        </td>
                                        <td class="center total"><?php echo $r->total_threads;?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

						
                        <?php
						if(count($threads)==0){
							if(isset($unanswered)){
						?>
                        <p class="no-item">No Unanswered Threads. <a href="<?php echo base_url();?>forum<?php if(!empty($forum_id)){ echo "/".$forum_id; }?>">View All Threads</a> </p>
                        <?php
							}else{
						?>
                        <p class="no-item">No Threads Yet. <a href="<?php echo base_url().$thread_link;?>">Start A New Thread</a></p>
                        <?php
							}
						}else{
						?>
						
                    	<table class="lists forum_lists">
                        	<thead>
                                <tr>
                                    <th>Threads</th>
                                    <th class="center">Replies</th>
                                    <th class="center">Last Post</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php foreach($threads as $i=>$r){  ?>
                                    <tr>
                                    	<td>
                                        <a class="blog_list_thumb" href="<?php echo base_url().'user/'.$r->user_name;?>">
                                            <span><img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar" /></span>
                                        </a>
                                        <div class="blog_list_title">
                                            <h2><a href="<?php echo base_url().'forum/thread/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                            
                                            <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> in <a href="<?php echo base_url();?>forum/<?php echo $r->forum_id; ?>"><?php echo $r->forum_name;?></a></p>
            
                                            <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>
            
                                        </div>
                                        </td>
                                    	<td class="center"><p class="total"><?php echo $r->nb_comments;?></p></td>
                                    	<td class="center"><p><?php if(!empty($r->latest_reply)){ echo pretty_date($r->latest_reply); }else{ echo "-"; }?></p></td>
                                    </tr>
								<?php } ?>
                            </tbody>
                        </table>

                        <div class="pagination">
                        <?php echo $this->pager->create_links(); ?>
                        </div>

                        <?php
						}
						?>
                        
                    	</div>
                    
            	</div><!-- .box -->
          	</div><!--#section_left-->
          
			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
