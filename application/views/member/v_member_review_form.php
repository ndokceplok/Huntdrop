<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
    $('#tags').tagsInput({
            //autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
            //autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
    });

	$('#add_new').click(function(){
		addOption($(this).siblings('#brand_id'));
	});

    $("#form").validationEngine({
        //ajaxFormValidation: true
    });

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
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

            	<div class="box">
                	<div class="box-heading red">
 				    	<?php 
 				    	if($action=="add"){
 				    		$title = "Write A Review";
 				    	}else{
 				    		$title = "Edit Review : ".$review_info->title;
 				    	}
	 				    ?>
                       <h1><span class="title fl"><?php echo $title;?></span></h1>
                    </div>
		
                    <div class="content_container box-content">

                        <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>


				    	<?php 
						if($action=="add"){
				         echo form_open_multipart('member/review/create_exec', array('id'=>'form'));
				        }else{ 
				         echo form_open_multipart('member/review/update_exec', array('id'=>'form'));
				        } 
						?>
				        
				        <label for="object">Object</label>
				        <p><input type="text" id="object" name="object" value="<?php echo $action=="add"? set_value('titobjectle'): $review_info->object ?>" class="validate[required]" ></p>


				        <label for="category_id">Category</label>
				        <p>
			            <select name="category_id" id="category_id" class="validate[required]">
			                <option value="">None</option>
			                <?php 
			                    foreach($categories as $r):
			                ?>
			                    <option <?php if($action=="edit" && $r->category_id==$review_info->category_id){?> selected="selected" <?php } ?> value="<?php echo $r->category_id;?>"><?php echo $r->category_name;?></option>
			                <?php
			                    endforeach;
			                ?>
			            </select>
				        <input class="btn" type="button" value="Add New Series" id="add_new" />
				        </p>

				        <label for="brand_id">Brands</label>
				        <p>
			            <select name="brand_id" id="brand_id" class="validate[required]">
			                <option value="">None</option>
			                <?php 
			                    foreach($brands as $r):
			                ?>
			                    <option <?php if($action=="edit" && $r->brand_id==$review_info->brand_id){?> selected="selected" <?php } ?> value="<?php echo $r->brand_id;?>"><?php echo $r->brand_name;?></option>
			                <?php
			                    endforeach;
			                ?>
			            </select>
				        <input class="btn" type="button" value="Add New Brand" id="add_new" />
				        </p>

				        <label for="title">Title</label>
				        <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $review_info->title ?>" class="validate[required]" ></p>

				        <p>Content</p>
				        <p>
				        <?php ckeditor($action=="add"? set_value('post_content'): $review_info->content,'post_content')?>
				        <!--<textarea id="content" name="content"><?php echo $action=="add"? set_value('post_content'): $review_info->content ?></textarea>-->
				        </p>

				        <label for="tags">Tags</label>
				        <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>

				        <label for="rating">Rate this product</label>
						<p><input type="range" id="rating" name="rating" min="0" max="5" step="1" value="<?=$action=="add"?'':$review_info->rating?>" >
			            <div class="rateit" data-rateit-backingfld="#rating"></div></p>

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


                       	<!--<label for="photo">Image</label>
	                	<?php if(!empty($photo[0]->thumb)){ ?>
	                        <p><img height="150" src="<?php echo content_thumb($photo[0]->thumb);?>" alt="<?=$review_info->title?>" /></p>
	                	<?php } ?>
                        <p><input type="file" id="photo" name="photo" /></p>-->
				        
				        <?php 
						if($action=="edit"){ 
						echo form_hidden('review_id', $review_info->ID);
						}
						?>
				        
				        <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'add': 'update'?>" />
				        <a class="btn" href="<?php echo base_url();?>member/review">Cancel</a>
				        <?=form_close()?>


                    </div><!-- .content_container-->

                </div>

            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        

        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
