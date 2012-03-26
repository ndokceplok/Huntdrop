<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

                <div class="login_form">
                    <h2>Reset Your Password</h2>
                    <?php
                        $log = $this->session->flashdata('log');
                        if( ! empty($log) ) {
                    ?>
                    <div class="log">
                        <?=$log?>
                    </div><!-- .section -->
                    <?
                        }
                    ?>
                    <?=form_open('account/reset_password_exec', array('id'=>'reset_password'))?>
                        <p>To reset your password, please fill in the form below.</p>

                        <p>
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" value="" >
                        </p>

                        <p>
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" value="" >
                        </p>

                        <input type="hidden" name="hash" value="<?php echo $hash;?>">
                        <p>
                            <input type="submit" name="submit" value="Submit" class="btn" />
                        </p>
                    <?=form_close()?>
                        
                    
                </div>

            </div><!-- #section_left -->        

            <?php include('includes/section_right.php');?>
        </div><!-- #main_section -->        

    </div><!-- #content -->
    

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>