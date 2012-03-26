<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
  $('#tags').tagsInput();
  $("#form").validationEngine();

	$('#add_new').click(function(){
		addOption($(this).siblings('#brand_id'));
	});

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
		var n = prompt("Please input new brand")
		if(n){
			//add ajax to save the string in the database, needs review!
			$.ajax({
				dataType: 'json',
				data: "brand_name="+ n,
				url: "<?php echo base_url(); ?>member/review/create_brand_exec",
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
                <h1>create a review</h1>
                <?php }else{ ?>
                <h1>Edit review : <?php echo $review_info->title;?></h1>
                <?php } ?>
				
                <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>
        				<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/review/create_exec', array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/review/update_exec', array('id'=>'form'));
                } 
                ?>

                <label for="object">Object</label>
                <p><input type="text" id="object" name="object" value="<?php echo $action=="add"? set_value('object'): $review_info->object ?>" class="validate[required]"></p>
        		
            		<label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $review_info->title ?>" class="validate[required]"></p>


        				<label for="category">Category</label>
                <p>
                <select name="category_id" id="category_id">
                <option value="">None</option>
                <?php 
                    foreach($categories as $r):
                ?>
                    <option <?php if($r->category_id==$review_info->category_id){ ?> selected="selected" <?php } ?> value="<?php echo $r->category_id;?>"><?php echo $r->category_name;?></option>
                <?php
                    endforeach;
                ?>
  	            </select>
  	            </p>

        				<label for="brand">Brand</label>
                <p>
        				<select name="brand_id" id="brand_id">
	                <option value="">None</option>
	                <?php 
	                    foreach($brands as $r):
	                ?>
	                    <option <?php if($r->brand_id==$review_info->brand_id){ ?> selected="selected" <?php } ?>value="<?php echo $r->brand_id;?>"><?php echo $r->brand_name;?></option>
	                <?php
	                    endforeach;
	                ?>
  	            </select>
  	            <input type="button" class="btn" value="Add New Brand" id="add_new" />
  	            </p>

                <p>Content</p>
                <?php ckeditor($action=="add"? set_value('post_content'): $review_info->content,'post_content')?>
        
                <label for="tag">Tags</label>
                <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>
                
                <p><strong>Upload up to 3 images for this review</strong></p>
                <?php 
                    for($i=0;$i<=2;$i++){ 
                ?>
                    <label for="photo<?php echo $i+1;?>">Image <?php echo $i+1;?></label>
                    <p>
                    <?php if(!empty($review_photo[$i]->thumb)){ ?>
                    <img class="content_thumb" height="150" src="<?php echo content_thumb($review_photo[$i]->thumb);?>" alt="<?=$review_info->title?>"  />
                    <a id="<?php echo $review_photo[$i]->ID;?>" href="#" class="delete_image alert" >Remove Image</a>
                    <?php }else{ ?>
                    <input type="file" id="photo<?php echo $i+1;?>" name="photo<?php echo $i+1;?>" />
                    <?php } ?>
                    </p>
                
                <?php 
                }
                ?>

<!--                 <label for="photo">Image</label>
                
                <?php if(!empty($review_photo[0]->thumb)){ ?>
                <p><img height="150" src="<?php echo content_thumb($review_photo[0]->thumb);?>" alt="<?=$review_info->title?>" /></p>
                <?php } ?>
                <p><input type="file" id="photo" name="photo" /></p>
 -->                
                <?php 
                if($action=="edit"){ 
                echo form_hidden('review_id', $review_info->review_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" /> 
                <a href="<?php echo $admin_link.'review';?>" class="btn">Cancel</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>