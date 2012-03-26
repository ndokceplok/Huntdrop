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
	
//	$('#photo').uploadify({
//		'uploader'  : '<?php echo base_url(); ?>js/uploadify/uploadify.swf',
//		'script'    : '<?php echo base_url(); ?>js/uploadify/uploadify.php',
//		'cancelImg' : '<?php echo base_url(); ?>js/uploadify/cancel.png',
//		'multi'		: true,
//		'auto'		: true,
//		'removeCompleted' : false,
//		'onError' : function (a, b, c, d) {
//			 if (d.status == 404)
//				alert('Could not find upload script.');
//			 else if (d.type === "HTTP")
//				alert('error '+d.type+": "+d.info);
//			 else if (d.type ==="File Size")
//				alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
//			 else
//				alert('error '+d.type+": "+d.text);
//			},
//		'onComplete'  : function(event, ID, fileObj, response, data) {
//		 // alert(fileObj.name);
//		  $('<img />').attr('src','<?php echo base_url(); ?>file_uploads/'+response).appendTo('.uploaded');
//		  
//		}
//		//'folder'    : '/uploads',
//	  });

	
});
</script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
	<div id="content">
        <div id="main_section">
            <div id="section_left">

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
				         echo form_open_multipart('member/blog/create_exec');
				        }else{ 
				         echo form_open_multipart('member/blog/update_exec');
				        } 
						?>
				        
				        <label for="series_id">Series</label>
				        <p>
				        <select name="series_id" id="series_id">
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
				        <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $blog_info->title ?>" ></p>

				        <p>Content</p>
				        <p>
				        <?php ckeditor($action=="add"? set_value('post_content'): $blog_info->content,'post_content')?>
				        <!--<textarea id="content" name="content"><?php echo $action=="add"? set_value('post_content'): $blog_info->content ?></textarea>-->
				        </p>

				        <label for="tags">Tags</label>
				        <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>
						
				        <?php for($i=0;$i<=2;$i++){ ?>
				            <label for="photo">Image <?php echo $i+1;?></label>
				            <p>
				            <?php if(!empty($photos[$i]->thumb)){ ?><img height="150" src="<?php echo content_thumb($photos[$i]->thumb);?>" alt="<?=$blog_info->title?>"  /><?php } ?>
				            <input type="file" id="photo" name="photo<?php echo $i+1;?>" />
				            </p>
				        
				        <?php } ?>
				        
						
				        <div class="uploaded"></div>
				        
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
