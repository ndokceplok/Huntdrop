<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(function(){

  $("#form").validationEngine();


});

</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
		<?php if($action=="add"){?>
                <h1>create a forum</h1>
                <?php }else{ ?>
                <h1>Edit forum : <?php echo $forum_info->forum_name;?></h1>
                <?php } ?>
				
                <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>
		<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/forum/create_exec',array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/forum/update_exec',array('id'=>'form'));
                } 
                ?>

                <label for="forum_name">Forum Name</label>
                <p><input type="text" id="forum_name" name="forum_name" value="<?php echo $action=="add"? set_value('forum_name'): $forum_info->forum_name ?>" class="validate[required]"></p>
        
                <label for="description">Description</label>
                <p>
                <textarea id="description" name="description"><?php echo $action=="add"? set_value('description'): $forum_info->description ?></textarea>
                </p>
        


		<?php 
                if($action=="edit"){ 
                echo form_hidden('forum_id', $forum_info->forum_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" />
                <a class="btn" href="<?php echo $this->admin_link;?>forum">Back</a>
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>