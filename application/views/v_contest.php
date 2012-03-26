<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl"><?php echo $title;?></span></h1>
                    </div>

                    <div class="content_container box-content">

                        <div class="fl">
                        	<?php $this->load->view('includes/contest_sidebar.php');?>
                        </div><!-- .user_box-->

                        <div class="content_box">
							
                            <h2>Contest Information</h2>

                            <?php if(isset($submit)){?>
                            	
                                <?php if(count($user_submission)>0){ //user has submitted a project for this contest ?>
								<h2>Your Submission for This Contest</h2>
                                
                                	<div class="projects_list_thumb">
                                    <a href="<?php echo base_url().'project/'.$project_info->ref_id.'/'.$project_info->alias;?>"><img src="<?php echo content_thumb($project_info->thumb);?>" /></a>
                                    </div>
                                    
                                    <p><a href="<?php echo base_url().'project/'.$project_info->ref_id.'/'.$project_info->alias;?>"><?php echo $project_info->title;?></a></p>
                                    
                                    <p><?php echo pretty_date($project_info->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $project_info->user_name;?>"><?php echo $project_info->user_name;?></a></p>
									<p><?php echo $project_info->nb_comments;?> comments | <?php echo $project_info->view;?> views | <?php echo $project_info->nb_likes;?> likes</p>

                                
								<?php }else{ ?>
                                <h2>Submit your Entry</h2>
                                
								<?php echo form_open('/contest/submit_exec',array('id' => 'contest_form')); ?>
                                    <label for="project_id">Submit One of Your Project (Remember you can only submit one and can't change it)</label>
                                    <p>
                                    <select name="project_id" id="project_id" class="chzn-select validate[required]">
                                        <option value="">None</option>
                                        <?php 
                                            foreach($user_project as $r):
                                        ?>
                                            <option value="<?php echo $r->ID;?>"><?php echo $r->title;?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                    </p>
                					
									<input type="hidden" name="contest_id" value="<?php echo $contest_id;?>" />
                                    <p><input class="contactbutton" type="submit" name="submit" value="submit" /></p>
                                <?php echo form_close();?>
                                
								<?php } ?>

                            <?php }else{ ?>
                                <div class="contest_info">
								<?php echo $contest_info->content;?>
                                </div>
                                
                                <!-- AddThis Button BEGIN -->
                                <div class="addthis_toolbox addthis_default_style ">
                                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                                <a class="addthis_button_tweet"></a>
                                <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                                <a class="addthis_counter addthis_pill_style"></a>
                                </div>
                                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4eca518f1b67b3ee"></script>
                                <!-- AddThis Button END -->
                            
                            
                            <?php } ?>
                            
                        </div>
                    </div>
                    
        		</div>

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
