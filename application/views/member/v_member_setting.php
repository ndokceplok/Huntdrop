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
    
                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl">Change Account Settings</span></h1>
                    </div>
        
                    <div class="content_container box-content">
 
                        <?php if($this->session->flashdata('log')){ ?>
                        <p class="log"><?=$this->session->flashdata('log')?></p>
                        <?php } ?>
                        <?=form_open_multipart('member/profile/setting_update_exec', array('id'=>'register', 'class'=>''));?>
                        
                        <?=form_hidden('account_id', $this->session->userdata('user_id'))?>
                
                        <?php if($this->session->userdata('from_fb')){ ?>
                        <p class="log">Because you register from Facebook, we generate this username from your Facebook profile name. You can change this if you like. But remember, you can do this only <strong>once</strong>. <br><br>
                        You can also add password so you can also login without Facebook</p>

                        <label for="user_name">Username</label>
                        <p><input type="text" id="user_name" name="user_name" value="<?=$account->user_name?>" class="validate[required,custom[onlyLetterNumber],ajax[ajaxUserExcludeSelf]]" ></p>
                        <?php }else{ ?>
                        <label>Username</label>
                        <p><?=$account->user_name?></p>
                        <?php } ?>

                        <?php if(!$this->session->userdata('from_fb')){ ?>

                        <label for="old_password">Old Password</label>
                        <p><input type="password" id="old_password" name="old_password" value="" ></p>
                        
                        <?php } ?>

                        <label for="new_password"><?php if(!$this->session->userdata('from_fb')){ ?>New <?php } ?>Password</label>
                        <p><input type="password" id="new_password" name="new_password" value="" class="validate[minSize[6],maxSize[12]]"></p>

                        <label for="confirm_password">Confirm <?php if(!$this->session->userdata('from_fb')){ ?>New <?php } ?>Password</label>
                        <p><input type="password" id="confirm_password" name="confirm_password" value="" class="validate[equals[new_password],minSize[6],maxSize[12]]"></p>
                
                        <input class="btn" type="submit" name="submit" value="update" /> 
                        <?php if(!$this->session->userdata('from_fb')){ ?>
                        <a class="btn" href="<?php echo base_url();?>member">Cancel</a>
                        <?php } ?>
                        <?=form_close()?>
        
                    </div><!-- .content_container-->

                </div>

            </div><!-- #section_left -->        

            <?php $this->load->view('includes/section_right.php');?>
        </div><!-- #main_section -->        

    </div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
