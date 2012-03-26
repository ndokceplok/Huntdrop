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
                <h1>create an article</h1>
                <?php }else{ ?>
                <h1>Edit article : <?php echo $article_info->title;?></h1>
                <?php } ?>
				
				<?php if($this->session->flashdata('log')){echo $this->session->flashdata('log');}?>
				<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/article/create_exec',array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/article/update_exec',array('id'=>'form'));
                } 
                ?>

                <label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $article_info->title ?>" class="validate[required]"></p>
        
                <p>Content</p>
                <?php ckeditor($action=="add"? set_value('post_content'): $article_info->content,'post_content')?>
                <!--<textarea id="content" name="content"><?php echo $action=="add"? set_value('post_content'): $article_info->content ?></textarea>-->
        
                <label for="short_desc">Short Desc</label>
                <p><textarea id="short_desc" name="short_desc"><?php echo $action=="add"? set_value('short_desc'): isset($article_info->short_desc)?$article_info->short_desc:'' ?></textarea></p>
                

				<?php 
                if($action=="edit"){ 
                echo form_hidden('article_id', $article_info->article_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" /> 
                <a href="<?php echo $admin_link.'article';?>" class="btn">Cancel</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>