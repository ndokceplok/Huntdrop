                            <div class="contest_box">
                            	<p><img src="<?php echo contest_image($contest_info->image);?>" /></p>

								<?php 
								if($this->session->userdata('logged_in')){ 
									if($user_has_project){
										$vote_link = base_url().'contest/'.$contest_info->contest_id.'/vote';
									}else{
										$vote_link = "#";	
									}
								}else{ 
									$vote_link = base_url().'account/login';
								}
								?>
                                <?php if(!$user_has_project){ ?>
                                    <p><span class="small"><strong>You are not allowed to vote</strong> unless you have at least one project posted on Huntdrop.</span></p>
                                <?php } ?>

								<?php if(!isset($submit)){
									if($this->session->userdata('logged_in')){ 
										$submit_link = base_url().'contest/'.$contest_info->contest_id.'/submit';
									}else{ 
										$submit_link = base_url().'account/login';
									}
								?>
                                <?php if(date("Y-m-d") < $contest_info->submission_start_date){?>
                                <p>Submission will be open on <br><strong><?php echo clean_date($contest_info->submission_start_date);?></strong></p>
                                <?php }elseif(date("Y-m-d") > $contest_info->submission_end_date){ ?>
                                <p>Submission closed! Thanks for your entries!</p>
                                <?php }else{ ?>
                                <p><a class="btn" href="<?php echo $submit_link;?>">Submit Your Entry</a></p>
                                <?php } ?>
								<?php } ?>

                                <?php if(date("Y-m-d") < $contest_info->voting_start_date){?>
                                <p>Voting will be open on <br><strong><?php echo clean_date($contest_info->voting_start_date);?></strong></p>
                                <?php }elseif(date("Y-m-d") > $contest_info->voting_end_date){ ?>
                                <p>Voting closed! Thanks for your votes!</p>
                                <?php }else{ ?>
                                <a class="btn" href="<?php echo $vote_link;?>">Vote and Win</a>  		                    
                                <?php } ?>
                               
                                <p><a class="btn" href="<?php echo base_url().'contest/'.$contest_info->contest_id.'/'.pretty_url($contest_info->title);?>">Overview</a></p>

                                <p><a class="btn" href="<?php echo base_url().'contest/'.$contest_info->contest_id.'/entries';?>">View Entries</a></p>
                                
                                <?php if(date("Y-m-d") > $contest_info->submission_end_date){ ?>
                                <p><a class="btn" href="<?php echo base_url().'contest/'.$contest_info->contest_id.'/result';?>">View Result</a></p>
                                
                                <?php } ?>
                            </div>
