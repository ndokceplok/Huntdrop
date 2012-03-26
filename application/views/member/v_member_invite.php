<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script src="<?php echo base_url();?>js/notice.js"></script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Invite your friends to HuntDrop</span></h1>
                    </div>
		
                    <div class="content_container box-content">

										<?php 
                    $log = $this->session->flashdata('log');
                    if(!empty($log)){ 
                    ?>
                    <p class="log <?php if(!empty($log['type'])){ echo $log['type'];} ?>"><?php echo $log['msg'];?></p>
                    <?php }?>

			         			<?php echo form_open('member/invite/send'); ?>
			                <label for="email">Invite friends by email</label>
			                <p><textarea class="invite" id="email" name="email"></textarea></p>
                      <label>&nbsp;</label>
			                <p>You can seperate multiple emails by comma</p>
			                
                      <label>&nbsp;</label>
			                <p><input type="submit" value="Send Invitation" class="btn" /> or <a class="btn" href="<?php echo base_url();?>/member">Cancel</a></p>
										<?=form_close()?>
                    </div><!-- .content_container-->

                </div>

                

            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        
		
	</div><!-- #content -->        

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>