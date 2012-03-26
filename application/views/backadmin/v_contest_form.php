<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){

  $('.date').datepicker({dateFormat:'yy-mm-dd'});
  $("#form").validationEngine();

});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
		<?php if($action=="add"){?>
                <h1>create a contest</h1>
                <?php }else{ ?>
                <h1>Edit contest : <?php echo $contest_info->title;?></h1>
                <?php } ?>
				
                <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>
		<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/contest/create_exec',array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/contest/update_exec',array('id'=>'form'));
                } 
                ?>

                <label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $contest_info->title ?>" class="validate[required]"></p>

                <label for="submission_start_date">Submission Start Date</label>
                <p><input type="text" class="date validate[required]" id="submission_start_date" name="submission_start_date" value="<?php echo $action=="add"? set_value('submission_start_date'): $contest_info->submission_start_date ?>" ></p>

                <label for="submission_end_date">Submission End Date</label>
                <p><input type="text" class="date validate[required]" id="submission_end_date" name="submission_end_date" value="<?php echo $action=="add"? set_value('submission_end_date'): $contest_info->submission_end_date ?>" ></p>

                <label for="voting_start_date">Voting Start Date</label>
                <p><input type="text" class="date validate[required]" id="voting_start_date" name="voting_start_date" value="<?php echo $action=="add"? set_value('voting_start_date'): $contest_info->voting_start_date ?>" ></p>

                <label for="voting_end_date">Voting End Date</label>
                <p><input type="text" class="date validate[required]" id="voting_end_date" name="voting_end_date" value="<?php echo $action=="add"? set_value('voting_end_date'): $contest_info->voting_end_date ?>" ></p>
        
                <p>Content</p>
                <?php ckeditor($action=="add"? set_value('post_content'): $contest_info->content,'post_content')?>
                <!--<textarea id="content" name="content"><?php echo $action=="add"? set_value('post_content'): $contest_info->content ?></textarea>-->
        
                
                <label for="photo">Image</label>
                
                <?php if(!empty($contest_info->image)){ ?>
                <p><img height="150" src="<?php echo contest_image($contest_info->image);?>" alt="<?=$contest_info->title?>" title="<?=$contest_info->title?>" /></p>
                <?php } ?>
                <p><input type="file" id="photo" name="photo" /></p>

				<?php 
                if($action=="edit"){ 
                echo form_hidden('contest_id', $contest_info->contest_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" /> 
                <a href="<?php echo $admin_link.'contest';?>" class="btn">Cancel</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>