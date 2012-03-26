<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
	$('#add_new').click(function(){
		addOption($(this).siblings('#series_id'));
	});

	$('#tags').tagsInput({
		//autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
		//autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
	});

    $("#form").validationEngine({
        //ajaxFormValidation: true
    });

	function addOption(id){
		var n = prompt("Please input new blog series")
		if(n){
			//add ajax to save the string in the database, needs review!
			$.ajax({
				dataType: 'json',
				data: "series_name="+ n,
				url: "<?php echo base_url(); ?>member/blog/create_series_exec",
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
	
  $('.delete_image').click(function(e){
      $this = $(this);
      e.preventDefault()
      var a = confirm("Are you sure you want to delete this image ?");
      if(a){
          $.ajax({
           type: "POST",
           url: base_url+'member/photo/remove_image',
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
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
            	<div class="box">
                	<div class="box-heading red">
 				    	<?php 
 				    	if($action=="add"){
 				    		$title = "Add New Blog Entry";
 				    	}else{
 				    		$title = "Edit Blog Entry : ".$blog_info->title;
 				    	}
	 				    ?>
                       <h1><span class="title fl"><?php echo $title;?></span></h1>
                    </div>
		
                    <div class="content_container box-content">

                        <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>


				    	<?php 
						if($action=="add"){
				         echo form_open_multipart('member/blog/create_exec', array('id'=>'form'));
				        }else{ 
				         echo form_open_multipart('member/blog/update_exec', array('id'=>'form'));
				        } 
						?>
				        
				        <label for="series_id">Series</label>
				        <p>
				        <select name="series_id" id="series_id" class="validate[required]">
				        	<option value="">None</option>
							<?php 
								foreach($blog_series as $r):
							?>
				            	<option <?php if($action=="edit" && $r->ID==$blog_info->series_id){?> selected="selected" <?php } ?> value="<?php echo $r->ID;?>"><?php echo $r->series_name;?></option>
				            <?php
								endforeach;
				            ?>
				        </select>
				        <input class="btn" type="button" value="Add New Series" id="add_new" />
				        </p>

				        <label for="title">Title</label>
				        <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $blog_info->title ?>" class="validate[required]" ></p>

				        <p>Content</p>
				        <p>
				        <?php ckeditor($action=="add"? set_value('post_content'): $blog_info->content,'post_content')?>
				        <!--<textarea id="content" name="content"><?php echo $action=="add"? set_value('post_content'): $blog_info->content ?></textarea>-->
				        </p>

				        <label for="tags">Tags</label>
				        <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>
						
		            <label for="photo">Image</label>
		            <p>
		            <?php if(!empty($photos[0]->thumb)){ ?>
		            <img class="content_thumb" height="150" src="<?php echo content_thumb($photos[0]->thumb);?>" alt="<?=$blog_info->title?>"  />
                <a id="<?php echo $photos[0]->ID;?>" href="#" class="delete_image alert" >Remove Image</a>
		            <?php }else{ ?>
		            <input type="file" id="photo" name="photo" />
		            <?php } ?>
		            </p>
				        
				        
						
				        
				        <?php 
						if($action=="edit"){ 
						echo form_hidden('blog_id', $blog_info->ID);
						}
						?>
				        
				        <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'add': 'update'?>" />
				        <a class="btn" href="<?php echo base_url();?>member/blog">Cancel</a>
				        <?=form_close()?>


                    </div><!-- .content_container-->

                </div>

            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        

        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
