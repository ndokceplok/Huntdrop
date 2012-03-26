<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

            	<div class="box">
                	<?php if(!empty($tag)){ $add = '/tag/'.$tag; }else {$add = '';}?>
                	<div class="box-heading red">
                        <h1><span class="title fl"><?php echo $title;?> <?php if(!empty($tag)){ echo ' with tag "'.$tag.'"';}?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                        	
                        	<?php 
							if($this->session->userdata('user_id')){
							$thread_link = "member/forum/create";
							}else{
							$thread_link = "account/login";
							}
							?>
                            <a href="<?php echo base_url().$thread_link;?>">Start A New Thread</a> 
                            <a href="">View Unanswered Threads</a> 
                        </p>
						
                        <?php
						if(count($threads)==0){
						?>
                        <p>No Threads Yet. <a href="">Start A New Thread</a></p>
                        <?php
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
                                            <span><img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar"/></span>
                                        </a>
                                        <div class="blog_list_title">
                                            <h2><a href="<?php echo base_url().'forum/thread/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                            
                                            <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> in <a href="<?php echo base_url();?>forum/<?php echo $r->forum_id; ?>"><?php echo $r->forum_name;?></a></p>
            
                                            <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>
            
                                        </div>
                                        </td>
                                    	<td class="center"><?php echo $r->nb_comments;?></td>
                                    	<td class="center"><?php if(!empty($r->latest_reply)){ echo pretty_date($r->latest_reply); }else{ echo "-"; }?></td>
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
