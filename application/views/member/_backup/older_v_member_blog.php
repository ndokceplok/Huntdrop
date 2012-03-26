<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script src="<?php echo base_url();?>js/notice.js"></script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

	<div id="content">
        <div id="main_section">
        
            <div id="section_left">

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Your Hunting Blogs</span></h1>
                    </div>
		
                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>

                        <div class="fl">
                            <div class="user_box">
                                <img class="user_image" alt="Photo of <?php echo $profile->first_name;?>" title="Photo of <?php echo $profile->first_name;?>" src="<?php echo user_image($profile->photo);?>" />
                                
                                <div class="user_info">
                                    <h2><?php echo $account->user_name;?></h2>
                                    <p><?php echo $nb_posts;?> posts <br />in <?php echo $nb_days;?> days</p>
                                </div>
                                <br class="clear" />
    
                                <p class="user_links"><a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>">home</a> | <a href="<?php echo base_url();?>project/<?php echo $account->user_name;?>">projects</a> | <a href="<?php echo base_url();?>review/<?php echo $account->user_name;?>">reviews</a></p>
    
                                
                            </div><!-- .user_box-->

                            <div class="content_sidebar ">
                                <h2><?php echo $account->user_name;?>'s Blog Series</h2>
                                <ul>
                                <?php foreach($blog_series as $r){ ?>
                                
                                    <li><a href="<?php echo base_url();?>blog/series/<?php echo $r->ID;?>"><?php echo $r->series_name;?></a></li>
                                
                                <?php } ?>        
                                </ul>
                            </div><!-- .content_sidebar-->

                        </div><!-- .fl-->

                        <div class="content_box">

					        <?php 
							if(isset($blog_list)){
							?>
					        <a class="btn" href="<?php echo base_url();?>member/blog/create">Add New Entry</a>

                            <ul class="content_list">
					        <?php
								foreach($blog_list as $r):
							?>
                            	<li>
                                
                                <div>
                                    <h2><a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>
    
                                    <p>
							            <a href="<?php echo base_url();?>member/blog/update/<?php echo $r->ID;?>">Edit</a>
							             - 
							            <a class="tx_red delete" href="<?php echo base_url();?>member/blog/delete/<?php echo $r->ID;?>">Delete</a>
									</p>                                

                                </div>

                                
                            	</li>

								<div class="section">
						        	<a href="<?php echo base_url().'blog/'. $r->ID;?>/<?php echo $r->alias;?>"><?php echo $r->title;?></a>
						            <div class="small">
						            <a href="<?php echo base_url();?>member/blog/update/<?php echo $r->ID;?>">Edit</a>
						             - 
						            <a class="tx_red delete" href="<?php echo base_url();?>member/blog/delete/<?php echo $r->ID;?>">Delete</a>
						            </div>
						        </div>
							<?php
								endforeach;
							?>
							</ul>
							<?php
					        }else{
							?>
					        
								<p>You have not created any blogs. Start creating one now? Click <a href="<?php echo base_url();?>member/blog/create">Here</a></p>
							<?php
					        }
							?>

                        </div><!-- .content_box-->

                    </div><!-- .content_container-->

                </div>

            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        
						
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>