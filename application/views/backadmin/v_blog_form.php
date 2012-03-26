<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
	$('#add_new').click(function(){
		addOption($(this).siblings('#series_id'));
	});

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

	function addOption(id){
		var n = prompt("Please input new blog series")
		if(n){
			//add ajax to save the string in the database, needs review!
			$.ajax({
				dataType: 'json',
				data: "series_name="+ n,
				url: "<?php echo $admin_link; ?>blog/create_series_exec",
				success: function(data){
					$("<option />").val(data.id).text(n).appendTo(id);
					if(confirm("do you want to select : "+ n +" ?")){
						id.val(data.id);
					}
				}
			});
			
		}else{
			return false;
		}
	}
	
	
});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
				<?php if($action=="add"){?>
                <h1>create a blog</h1>
                <?php }else{ ?>
                <h1>Edit blog : <?php echo $blog_info->title;?></h1>
                <?php } ?>
				
        <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>
				<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/blog/create_exec',array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/blog/update_exec',array('id'=>'form'));
                } 
                ?>

				        <label for="series_id">Series</label>
				        <p>
				        <select name="series_id" id="series_id" class="validate[required]">
				        	<option value="">None</option>
									<?php 
										foreach($blog_series as $r):
									?>
			            	<option <?php if($action=="edit" && $r->ID==$blog_info->series_id){?> selected="selected" <?php } ?> value="<?php echo $r->ID;?>"><?php echo $r->series_name;?> (<?php echo $r->series_total_blogs;?>)</option>
			            <?php	endforeach; ?>
				        </select>
				        <input class="btn" type="button" value="Add New Series" id="add_new" />
				        </p>

                <label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $blog_info->title ?>" ></p>
        
                <p>Content</p>
                <?php ckeditor($action=="add"? set_value('post_content'): $blog_info->content,'post_content')?>
        
                <label for="tag">Tags</label>
                <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>
                
                <label for="photo">Image</label>
                
                <p>
                <?php if(!empty($blog_photo[0]->thumb)){ ?>
                <img class="content_thumb" height="150" src="<?php echo content_thumb($blog_photo[0]->thumb);?>" alt="<?=$blog_info->title?>"  />
                <a id="<?php echo $blog_photo[0]->ID;?>" href="#" class="delete_image alert" >Remove Image</a>
                <?php }else{ ?>
                <input type="file" id="photo" name="photo" />
                <?php } ?>
                </p>

                
                <?php 
                if($action=="edit"){ 
                echo form_hidden('blog_id', $blog_info->blog_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" /> 
                <a href="<?php echo $admin_link.'blog';?>" class="btn">Cancel</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>