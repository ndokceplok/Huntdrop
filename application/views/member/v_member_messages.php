<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script src="<?php echo base_url();?>js/notice.js"></script>
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

    						<?php if(count($messages)<=0){?>
                                <p><em>No messages</em></p>
                            <?php }else{ ?>
                    
                        	<table width="100%" class="lists">
                            	<thead>
                                    <tr>
                                        <th>Status</th>
                                        <th><?php echo $m_type=="sent"?"Recipient":"Sender";?></th>
                                        <th>Subject</th>
                                        <th>Received Date</th>
                                    </tr>
                                </thead>
                                <tbody>
    									<?php foreach($messages as $r){ ?>
                                        <tr <?php if($m_type!="sent" && $r->read==0){ ?> class="strong"<?php } ?>>
                                        	<td><?php if($m_type!="sent" && $r->read==0){ echo "Unread";}else{ echo "Read";} ?></td>
                                        	<td><a target="_blank" href="<?php echo base_url().'user/'.$r->user_name;?>"><?php echo $r->first_name.' '.$r->last_name;?></a></td>
                                        	<td><a href="<?php echo base_url().'member/message/'.$r->message_id;?>"><?php echo $r->subject;?></a></td>
                                        	<td><?php echo pretty_date($r->message_date);?></td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
    						<?php } ?>

                            <?php if(isset($this->pager) && ($this->pager->create_links())){ ?>
                            <div class="pagination">
                            <?php echo $this->pager->create_links(); ?>
                            </div>
                            <?php } ?>

                            
                        </div><!-- .content_box-->
                    </div>
                
        
                </div>

            </div><!-- #section_left -->        

            <?php $this->load->view('includes/section_right.php');?>

		</div><!-- #main_section -->        
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>