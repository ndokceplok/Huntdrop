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

                        <div class="messages_box">

                            <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>
                            <?php echo form_open('member/message/send', array('id'=>'message_form')); ?>
                                <label for="from">From</label>
                                <p><?php echo $account->user_name;?></p>
                                <input type="hidden" name="sender_id" value="<?php echo $account->ID;?>" />

                                <label for="recipient_id">To</label>
                                <p>
    							<select name="recipient_id" id="recipient_id" class="validate[required]">
                                	<option value="">Select one of your friends</option>
                                <?php
    							foreach($recipients as $r){ 
    							?>
                                	<option <?php if(isset($selected_recipient) && $r->account_id==$selected_recipient->ID){?> selected="selected" <?php } ?> value="<?php echo $r->ID;?>"><?php echo $r->user_name;?></option>
                                <?php
    							}
    							?>
                                </select>
                                </p>
                                
                                <label for="subject">Subject</label>
                                <p><input type="text" name="subject" id="subject" class="validate[required]" /></p>

                                <label for="message">Message</label>
                                <p><textarea id="message" name="message" class="validate[required]"></textarea></p>
                                
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