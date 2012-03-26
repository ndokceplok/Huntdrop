<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

                <div class="login_form">
                    <h2>Log in</h2>
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
                    <?=form_open('account/login_exec', array('id'=>'login', 'class'=>''))?>
                        <p>
                            <label for="user_name">Username</label>
                            <input type="text" name="user_name" id="user_name" />
                        </p>
                        <p>
                            <label class="fl" for="pass">Password</label>
                            <span class="fr forgot"><?=anchor('account/forgot_password', 'forgot your password ?')?></span>
                            <input type="password" name="pass" id="pass" />
                        </p>
                        <p>
                            <input type="submit" name="login" value="Login" class="btn" /> or <?=anchor('account/register', 'Sign up for Huntdrop')?>
                        </p>
                    <?=form_close()?>
                        
                    
                    <!--<p>don't have account ? <?=anchor('account/register', 'sign up')?></p>-->
                    
                    <?php if( ! empty($login_url)) { ?>
                    <p><a class="fb-login" href="<?=$login_url?>">Login with Facebook</a></p>
                    <?php } ?>
                </div>

                <!--<div class="log">
                    <pre><?=print_r($_SESSION)?></pre>
                </div>
                
                <div class="log">
                    <pre><?=print_r($_COOKIE)?></pre>
                </div>-->
		
            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>