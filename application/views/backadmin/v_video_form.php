<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
    $('#tags').tagsInput();

    $("#form").validationEngine();
    
	$('#youtube_id').blur(function(){
		$.ajax({
		 type: "POST",
		 url: base_url+'backadmin/video/check_youtube',
		 data: {youtube_id: $(this).attr('value')},
		 success: function(msg){
			 //alert($('#youtube_id').siblings('.status').html('That is'));
                         alert(msg);
			 if(msg=='invalid'){
			 	status = 'That is not youtube' ;
				add_class = 'bad';
			 }else{
				status = 'That is youtube';
				add_class = 'good';
			 }
			 $('#youtube_id').siblings('.status').removeClass('bad').removeClass('good').addClass(add_class).html(status);
		 }
		});
	});

});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
				<?php if($action=="add"){?>
                <h1>create a video</h1>
                <?php }else{ ?>
                <h1>Edit video : <?php echo $video_info->title;?></h1>
                <?php } ?>
				
                <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>
		<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/video/create_exec', array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/video/update_exec', array('id'=>'form'));
                } 
                ?>

                <label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): htmlspecialchars($video_info->title) ?>" class="validate[required]" ></p>
        
                <p>Content</p>
                <?php ckeditor($action=="add"? set_value('post_content'): $video_info->content,'post_content')?>
        
                <label for="tag">Tags</label>
                <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>
                
                <label for="youtube_id">Youtube ID</label>
                <p><img src="<?php echo youtube_thumb($video_info->youtube_id);?>"  /></p>
                <label>&nbsp;</label>
                <p><input type="text" id="youtube_id" name="youtube_id" value="<?php echo $action=="add"? set_value('youtube_id'): $video_info->youtube_id ?>" class="validate[required]" > <span class="status"></span></p>
                
                <?php 
                if($action=="edit"){ 
                echo form_hidden('video_id', $video_info->video_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" /> 
                <a href="<?php echo $admin_link.'video';?>" class="btn">Cancel</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>