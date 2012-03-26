<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

                <div class="login_form">
                    <h2>Forgot Password ?</h2>
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
                    <?=form_open('account/forgot_password_exec', array('id'=>'forgot_password'))?>
                        <p>To reset your password, please type the email address you used when you register to Huntdrop. Bear in mind, this <strong>IS NOT</strong> the form to change your Facebook password.</p>
                        <p>
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" />
                        </p>
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