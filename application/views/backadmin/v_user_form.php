<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
  $('.date').datepicker({dateFormat:'yy-mm-dd'});
});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


  <div id="content">
    
        <div id="main_section">
        
            <div id="section_left">
                <h1>Edit Profile</h1>

                <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>

                <?=form_open_multipart('backadmin/user/update_exec');?>
                
                <?=form_hidden('account_id', $this->session->userdata('user_id'))?>
        
                <label for="first_name">First name</label>
                <p><input type="text" id="first_name" name="first_name" value="<?=$bio->first_name?>" ></p>
        
                <label for="middle_name">Middle name</label>
                <p><input type="text" id="middle_name" name="middle_name" value="<?=$bio->middle_name?>" ></p>
        
                <label for="last_name">Last name</label>
                <p><input type="text" id="last_name" name="last_name" value="<?=$bio->last_name?>" ></p>
        
                <label for="dob">DOB</label>
                <p><input type="text" class="date validate[required]" id="dob" name="dob" value="<?php echo $bio->dob; ?>" ></p>

                <label for="address">Address</label>
                <p><textarea id="address" name="address"><?=nl2br($bio->address)?></textarea></p>
        
                <label for="location">Location</label>
                <p><input type="text" id="location" name="location" value="<?=$bio->location?>" ></p>
        
                <label for="website">Website</label>
                <p><input type="text" id="website" name="website" value="<?=$bio->website?>" ></p>
        
                <label for="about_me">About Me</label>
                <p><textarea id="about_me" name="about_me"><?=nl2br($bio->about_me)?></textarea></p>
        
                <label for="occupation">Occupation</label>
                <p><input type="text" id="occupation" name="occupation" value="<?=$bio->occupation?>" ></p>
        
                <label for="hobby">Hobby</label>
                <p><input type="text" id="hobby" name="hobby" value="<?=$bio->hobby?>" ></p>
        
                <label for="interest">Interest</label>
                <p><input type="text" id="interest" name="interest" value="<?=$bio->interest?>" ></p>
        
                <label for="photo">Photo</label>
                <?php if(!empty($bio->photo)){ ?><p><img src="<?php echo base_url(); ?>assets/avatar/<?php echo $bio->photo;?>" /></p><?php } ?>

                <label>&nbsp;</label>
                <p><small>Note : Max size <strong>100KB</strong>; Max dimension <strong>500px</strong>; Your photo will be resized so as not being wider than <strong>150px</strong></small></p>

                
                <p><input type="file" id="photo" name="photo" /></p>
                
                <input type="hidden" name="account_id" value="<?php echo $bio->account_id;?>">
                <input class="btn" type="submit" name="submit" value="update" /> 
                <a class="btn" href="<?php echo base_url();?>member">Cancel</a>
                
                <?=form_close()?>
  
            </div><!-- #section_left -->        

    </div><!-- #main_section -->        

  </div><!-- #content -->
  

<?php $this->load->view('includes/backadmin/_bottom.php');?>