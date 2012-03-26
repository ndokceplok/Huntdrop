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
                            <a class="btn" href="<?php echo base_url();?>member/message" <?php if($m_type=="received"){ ?> class="selected" <?php } ?> >Received Messages</a> 
                            <a class="btn" href="<?php echo base_url();?>member/message/sent" <?php if($m_type=="sent"){ ?> class="selected" <?php } ?>>Sent Messages</a> 
                            <a class="btn" href="<?php echo base_url();?>member/message/compose" <?php if($m_type=="compose"){ ?> class="selected" <?php } ?>>Write New Message</a> 
                        </p>

                        <div class="messages_box message_content">

                            <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>
                            <?php echo form_open('member/message/send', array('id'=>'message_form')); ?>
                                <label for="from">From</label>
                                <p><?php echo $account->user_name;?></p>
                                <input type="hidden" name="sender_id" value="<?php echo $account->ID;?>" />
                                <input type="hidden" name="reply_to_id" value="<?php echo $message_detail->message_id;?>" />

                                <label for="recipient_id">To</label>
                                <p><?php echo $message_detail->user_name;?></p>
                                <input type="hidden" name="recipient_id" value="<?php echo $message_detail->sender_id;?>" />

                                <label>Original Message</label>
                                <div class="fl">
                                <a class="show" href="">Show Original Message</a><br>
    							<p class="hidden"><?php echo nl2br($message_detail->message);?></p>
                                </div>
                                
                                <label for="subject">Subject</label>
                                <p><input type="text" name="subject" id="subject" class="validate[required]"  value="Re: <?php echo $message_detail->subject;?>"/></p>

                                <label for="message">Message</label>
                                <p><textarea id="message" name="message" class="validate[required]"></textarea></p>
                                
                                <br class="clear" />
                                <p><input class="btn" type="submit" value="Send Message" /> or <a class="btn" href="<?php echo base_url();?>member/message">Cancel</a></p>
                            <?=form_close()?>
                                        
                        </div><!-- .content_box-->
                    </div>
                    
            
                </div>

            </div><!-- #section_left -->        

            <?php $this->load->view('includes/section_right.php');?>

		</div><!-- #main_section -->        
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>