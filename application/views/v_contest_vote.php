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
							<?php if(date("Y-m-d") < $contest_info->voting_start_date){?>
                            	<h2>Voting Opening Soon!</h2>
                            	<p>Voting will be open on <strong><?php echo clean_date($contest_info->voting_start_date);?></strong></p>
                            <?php }elseif(date("Y-m-d") > $contest_info->voting_end_date){ ?>
                            	<h2>Voting closed! Thanks for participating!</h2>
                            <?php }else{ ?>
                            	<?php if(isset($has_voted)){ ?>
                            	<h2>Thank You For Your Votes!</h2>
                                
                                <?php }else{ ?>
                            	<h2>Cast Your Votes to Your Favorites!</h2>
								
                                <?php if(count($submissions)>0){ ?>
								<?php echo form_open('/contest/vote_exec',array('id' => 'contest_form')); ?>
                                    <p for="project_id">Vote for the hunt you like the most <span class="tx_red">(Remember you can only vote once)</span></p>
                                    <ul id="entries_list" class="vote_list">
                                        <?php 
                                            foreach($submissions as $i=>$r): 
                                        ?>
                                        	<li>
                                            <input type="radio" name="submission_id" id="submission_id<?php echo $i;?>" class="validate[required]" value="<?php echo $r->submission_id;?>" />
                                            <p class="entry_thumb"><img alt="<?php echo $r->title;?>" title="<?php echo $r->title;?>" src="<?php echo content_thumb($r->thumb);?>" /></p>
                                            <p><a target="_blank" href="<?php echo base_url().'project/'.$r->project_id.'/'.pretty_url($r->title);?>"><?php echo $r->title;?></a></p>
                                            <p>by <a target="_blank" href="<?php echo base_url().'user/'.$r->user_name;?>"><?php echo $r->user_name;?></a></p>
                                            </li>
                                        <?php
                                            endforeach;
                                        ?>
                                    </ul>
                					
									<input type="hidden" name="contest_id" value="<?php echo $contest_id;?>" />
                                    <p><input class="contactbutton" type="submit" name="submit" value="submit" /></p>
                                <?php echo form_close();?>
                                
                                <?php }else{ ?>
                                	<p>No Submissions Yet</p>
                                <?php } ?>
                                <?php } ?>
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
