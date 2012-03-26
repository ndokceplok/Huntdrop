<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
  $("#form").validationEngine();

	
});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
				<?php if($action=="add"){?>
                <h1>create a page</h1>
                <?php }else{ ?>
                <h1>Edit page : <?php echo $page_info->title;?></h1>
                <?php } ?>
				
				<?php if($this->session->flashdata('log')){echo $this->session->flashdata('log');}?>
				<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/page/create_exec', array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/page/update_exec', array('id'=>'form'));
                } 
                ?>

                <label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $page_info->title ?>" class="validate[required]" ></p>

				<label for="parent">Parent</label>
                <p>
                <select name="parent" id="parent">
                <option value="">None</option>
                <?php 
                    foreach($parents as $r):
                ?>
                    <option <?php if($action=="edit" && $r->page_id==$page_info->parent){ ?> selected="selected" <?php } ?> value="<?php echo $r->page_id;?>"><?php echo $r->title;?></option>
                <?php
                    endforeach;
                ?>
	            </select>
	            </p>
        
                <p>Content</p>
                <?php ckeditor($action=="add"? set_value('post_content'): $page_info->content,'post_content')?>
                <!--<textarea id="content" name="content"><?php echo $action=="add"? set_value('post_content'): $page_info->content ?></textarea>-->
        


				<?php 
                if($action=="edit"){ 
                echo form_hidden('page_id', $page_info->page_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" /> 
                <a href="<?php echo $admin_link.'page';?>" class="btn">Cancel</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>