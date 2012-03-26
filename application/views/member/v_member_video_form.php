<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
    $('#tags').tagsInput({
            //autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
            //autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
    });
	$('#youtube_id').blur(function(){
		$.ajax({
		 type: "POST",
		 url: base_url+'member/video/check_youtube',
		 data: {youtube_id: $(this).attr('value')},
		 success: function(msg){
			 //alert($('#youtube_id').siblings('.status').html('That is'));
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

    $("#form").validationEngine({
        //ajaxFormValidation: true
    });
});
</script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

            	<div class="box">
                	<div class="box-heading red">
 				    	<?php 
 				    	if($action=="add"){
 				    		$title = "Add New Video Entry";
 				    	}else{
 				    		$title = "Edit Video Entry : ".$video_info->title;
 				    	}
	 				    ?>
                       <h1><span class="title fl"><?php echo $title;?></span></h1>
                    </div>
		
                    <div class="content_container box-content">

                        <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>


				    	<?php 
						if($action=="add"){
				         echo form_open_multipart('member/video/create_exec', array('id'=>'form'));
				        }else{ 
				         echo form_open_multipart('member/video/update_exec', array('id'=>'form'));
				        } 
						?>
				        
				        <label for="title">Title</label>
				        <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $video_info->title ?>" class="validate[required]"></p>

				        <p>Content</p>
				        <p>
				        <?php ckeditor($action=="add"? set_value('post_content'): $video_info->content,'post_content')?>
				        <!--<textarea id="content" name="content"><?php echo $action=="add"? set_value('post_content'): $video_info->content ?></textarea>-->
				        </p>

				        <label for="tags">Tags</label>
				        <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>

				        <label for="youtube_id">Youtube ID</label>
				        <p><input type="text" id="youtube_id" name="youtube_id" value="<?php echo $action=="add"? set_value('youtube_id'): $video_info->youtube_id ?>" class="validate[required]"> <span class="status"></span></p>
						
				        <?php 
						if($action=="edit"){ 
						echo form_hidden('video_id', $video_info->ID);
						}
						?>
				        
				        <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'add': 'update'?>" />
				        <a class="btn" href="<?php echo base_url();?>member/video">Cancel</a>
				        
				        <?=form_close()?>

                    </div><!-- .content_container-->

                </div>

            </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        
        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
