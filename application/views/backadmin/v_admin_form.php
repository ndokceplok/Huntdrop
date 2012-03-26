<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
    $("#form").validationEngine({
        //ajaxFormValidation: true
    });

    $("#change_pass").change(function(){
        if($(this).attr('checked')== 'checked' ){
               $('#pass').attr('disabled',false).val('').focus();
        }else{
                $('#pass').attr('disabled','disabled');
        }
    })

});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
		<?php if($action=="add"){?>
                <h1>add an admin</h1>
                <?php }else{ ?>
                <h1>Edit admin : <?php echo $admin_info->user_name;?></h1>
                <?php } ?>
				
                <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>
		<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/admin/create_exec', array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/admin/update_exec', array('id'=>'form'));
                } 
                ?>

                <label for="user_name">Username</label>
                <p><input type="text" id="user_name" class="validate[required]" name="user_name" value="<?php echo $action=="add"? set_value('user_name'): $admin_info->user_name ?>" ></p>

                <label for="pass">Password</label>
                <p>
                <input type="password" id="pass" <?php if($action=="edit"){ echo 'disabled="disabled"'; } ?> class="validate[required]" name="pass" value="<?php echo $action=="add"? set_value('pass'): $admin_info->pass ?>" >
                <?php if($action=="edit"){ ?>
                <input type="checkbox" name="change_pass" id="change_pass" value="1" > Change Password
                <?php } ?>
                </p>

                <?php if($this->session->userdata('admin_group')=='superadmin'){?>
                <label for="user_group">Group</label>
                <p>
                <select name="user_group" id="user_group" class="validate[required]" >
                        <?php 
                            foreach($groups as $i=>$r):
                        ?>
                            <option <?php if($action=="edit" && $r['label']==$admin_info->user_group){ ?> selected="selected" <?php } ?> value="<?php echo $r['label'];?>"><?php echo $r['title'];?></option>
                        <?php
                            endforeach;
                        ?>
                        </select>
                </p>
                <?php } ?>
        
                

                <?php 
                if($action=="edit"){ 
                echo form_hidden('admin_id', $admin_info->ID);
                }
                ?>
                
                <input type="submit" class="btn" name="submit" value="<?php echo $action=="add"? 'add': 'update'?>" />
                <a class="btn" href="<?php echo $admin_link; ?>admin">Back</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>