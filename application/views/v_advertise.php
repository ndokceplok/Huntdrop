<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl">Advertising</span></h1>
                    </div>

                    <div class="content_container box-content">

                        <ul class="tabs">
                            <li><a href="#tab1">Advertise With Us</a></li>
                            <li><a href="#tab2">All Advertisers</a></li>
                        </ul>
                        
                        <div class="tab_container">
                            <div id="tab1" class="tab_content">
                                <h2>Advertise With Us</h2>
                                <?php
                                    $log = $this->session->flashdata('log');
                                    if( ! empty($log) ) {
                                ?>
                                <div class="log <?php if(!empty($log['type'])){ echo $log['type']; }?>">
                                    <?=$log['msg']?>
                                </div><!-- .log -->
                                <?
                                    }
                                ?>
                                
                                <?php echo form_open('page/submit_advertise_form',array('id' => 'advertise_form')); ?>

                                    <label for="name">Your Name <span class="required">*</span>
                                    <p><input type="text" id="name" name="name" class="contacttext narrow validate[required]" /></p>
                                    </label>
                                    
                                    <label for="email">Email <span class="required">*</span>
                                    <p><input type="text" id="the_email" name="the_email" class="contacttext narrow validate[required,custom[email]]" /></p>
                                    </label>

                                    <label for="inquiry">Inquiry <span class="required">*</span>
                                    <p><textarea name="inquiry" id="inquiry" wrap="virtual" class="contacttext narrow contacttextarea validate[required]"></textarea></p>
                                    </label>

                                    <label for="verify">Verify <span class="required">*</span>
                                    <?php
                                    $a = rand(1,10);
                                    $b = rand(1,10);
                                    $op = rand(0,1);
                                    if($op == 0){
                                    $op = "+";
                                    $result = $a + $b;
                                    }else{
                                    $op = "x";
                                    $result = $a * $b;
                                    }
                                    ?>
                                   
                                    <input type="hidden" name="result" id="result" value="<?php echo $result;?>" />
                                    <p><?php echo $a;?> <?php echo $op;?> <?php echo $b;?> = <input type="text" id="verify" name="verify" class="number validate[required,confirm[result]]" /></p>
                                    </label>
                                    
                                    <input type="submit" value="Send" class="btn" />
                                
                                <?php echo form_close(); ?>
                            </div>

                            <div id="tab2" class="tab_content">
                                <h2>All Advertisers</h2>
                                <?php if(!empty($pages)){ echo $pages[0]->content;}?>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
