<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
    $('#tags').tagsInput();
    $("#form").validationEngine();

    $('.delete_image').click(function(e){
        $this = $(this);
        e.preventDefault();
        var a = confirm("Are you sure you want to delete this image ?");
        if(a){
            $.ajax({
             type: "POST",
             url: base_url+'backadmin/photo/remove_image',
             data: {photo_id: $(this).attr('id')},
             success: function(msg){

                 //alert($('#youtube_id').siblings('.status').html('That is'));
                 if(msg=='failed'){
                    alert('Sorry, we cannot delete this image at this moment. Please try again and contact us if the problem persists.')
                 }else{

                    $this.siblings('img').fadeOut(500,function(){
                        $(this).remove();
                    });
                    $this.fadeOut(500,function(){
                        the_id = $this.parent().prev('label').attr('for');
                        $('<input type="file" name="'+the_id+'" id="'+the_id+'">').appendTo($this.parent());
                        
                        $(this).remove();
                    });

                }
                 
             }
            });
        }
    });
	
});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
    				<?php if($action=="add"){?>
                <h1>create a project</h1>
                <?php }else{ ?>
                <h1>Edit project : <?php echo $project_info->title;?></h1>
                <?php } ?>
				
                <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>
				<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/project/create_exec', array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/project/update_exec', array('id'=>'form'));
                } 
                ?>

                <label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): htmlspecialchars($project_info->title) ?>" class="validate[required]"></p>
        
                <p>Content</p>
                <?php ckeditor($action=="add"? set_value('post_content'): $project_info->content,'post_content')?>
        
                <label for="tag">Tags</label>
                <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>
                
                <p><strong>Upload up to 3 images for this project</strong></p>
                <?php 
                    for($i=0;$i<=2;$i++){ 
                ?>
                    <label for="photo<?php echo $i+1;?>">Image <?php echo $i+1;?></label>
                    <p>
                    <?php if(!empty($project_photo[$i]->thumb)){ ?>
                    <img class="content_thumb" height="150" src="<?php echo content_thumb($project_photo[$i]->thumb);?>" alt="<?=$project_info->title?>"  />
                    <a id="<?php echo $project_photo[$i]->ID;?>" href="#" class="delete_image alert" >Remove Image</a>
                    <?php }else{ ?>
                    <input type="file" id="photo<?php echo $i+1;?>" name="photo<?php echo $i+1;?>" />
                    <?php } ?>
                    </p>
                
                <?php 
                }
                ?>

                <?php 
                if($action=="edit"){ 
                echo form_hidden('project_id', $project_info->project_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" /> 
                <a href="<?php echo $admin_link.'project';?>" class="btn">Cancel</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>