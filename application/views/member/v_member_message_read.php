<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl">Messages</span></h1>
                    </div>

                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>
                        <p class="stat_bar">
                            <a href="<?php echo base_url();?>member/message" <?php if($m_type=="received"){ ?> class="selected" <?php } ?> >Received Messages</a> 
                            <a href="<?php echo base_url();?>member/message/sent" <?php if($m_type=="sent"){ ?> class="selected" <?php } ?>>Sent Messages</a> 
                            <a href="<?php echo base_url();?>member/message/compose" <?php if($m_type=="compose"){ ?> class="selected" <?php } ?>>Write New Message</a> 
                        </p>

                        <div class="messages_box message_content">
    						
                        	<?php if($mode=='sent'){ ?>
                                <p><a href="<?php echo base_url().'member/message/sent';?>" class="btn">back to sent messages</a></p>

                                <label>To</label>
                                <p><a target="_blank" href="<?php echo base_url().'user/'.$message_detail->user_name;?>"><?php echo $message_detail->first_name.' '.$message_detail->last_name;?></a></p>
                                
                                <label>Sent</label>
                                <p><?php echo pretty_date($message_detail->message_date);?></p>

                                <label>Subject</label>
                                <p><strong><?php echo $message_detail->subject;?></strong></p>
     
                                <label>Message</label>
                                <p><?php echo nl2br($message_detail->message);?></p>

                                <label>Action</label>
                                <p>
                                <a class="delete btn bg_red" href="<?php echo base_url().'member/message/'.$message_detail->message_id.'/remove_outbox';?>">Delete this message</a>
                                </p>
                                                       
                            <?php }else{ ?>
                            	
                                <p><a class="btn" href="<?php echo base_url().'member/message';?>">back to received messages</a></p>

                                <label>To</label>
                                <p><a href="<?php echo base_url().'user/'.$message_detail->user_name;?>"><?php echo $message_detail->first_name.' '.$message_detail->last_name;?></a></p>
                                
                                <label>Sent</label>
                                <p><?php echo pretty_date($message_detail->message_date);?></p>

                                <label>Subject</label>
                                <p><strong><?php echo $message_detail->subject;?></strong></p>
     
                                <label>Message</label>
                                <p><?php echo nl2br($message_detail->message);?></p>

                                <label>Action</label>
                                <p>
                                <a class="btn bg_green" href="<?php echo base_url().'member/message/'.$message_detail->message_id.'/reply';?>">Reply</a>
                                <a class="delete btn bg_red" href="<?php echo base_url().'member/message/'.$message_detail->message_id.'/remove_inbox';?>">Delete this message</a><br />
                                </p>

                                
                            <?php } ?>
                            
                        </div><!-- .messages_box-->
                    </div>
                    
            
                </div>

            </div><!-- #section_left -->        

            <?php $this->load->view('includes/section_right.php');?>

		</div><!-- #main_section -->        
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>