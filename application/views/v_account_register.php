<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){

    $("#register").validationEngine({
        //ajaxFormValidation: true
    });
    
});

</script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

                <div class="login_form">
                    <h2>Sign up</h2>

    				<?=form_open('account/register_exec', array('id'=>'register'))?>
                        <p>
                            <label for="user_name">username</label>
                            <input type="text" name="user_name" id="user_name" class="validate[required,custom[onlyLetterNumber],ajax[ajaxUser]]" />
                        </p>
                        <p>
                            <label for="pass">password</label>
                            <input type="password" name="pass" id="pass" class="validate[required,minSize[6],maxSize[12]]" />
                        </p>
                        <p>
                            <label for="pass_c">confirm password</label>
                            <input type="password" name="pass_c" id="pass_c" class="validate[required,equals[pass]]" />
                        </p>
                        <p>
                            <label for="email">email</label>
                            <input type="text" name="email" id="email" class="validate[required,custom[email],ajax[ajaxEmail]]"/>
                        </p>
                        <p>
                            <label for="first_name">first name</label>
                            <input type="text" name="first_name" id="first_name" class="validate[required]"/>
                        </p>
                        <p>
                            <label for="last_name">last name</label>
                            <input type="text" name="last_name" id="last_name" class="validate[required]"/>
                        </p>
                        <p>
                            <input class="btn" type="submit" name="signup" value="Join" /> Already have an account? <?=anchor('account/login', 'login here')?>
                        </p>
                    <?=form_close()?>
            
                    <?php if( ! empty($login_url)) { ?>
                    <p><a class="fb-login" href="<?=$login_url?>">Login with Facebook</a></p>
                    <?php } ?>
                    
                    <!--<p><?=anchor('account/login', '<< back to login page')?></p>-->
		        </div>
            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>