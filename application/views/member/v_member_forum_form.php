<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
    $('#tags').tagsInput({
            //autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
            //autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
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
                            $title = "Start New Forum Topic";
                        }else{
                            $title = "Edit Forum Entry : ".$thread_info->title;
                        }
                        ?>
                       <h1><span class="title fl"><?php echo $title;?></span></h1>
                    </div>
        
                    <div class="content_container box-content">

                		<?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>


                        <?php 
                        if($action=="add"){
                         echo form_open_multipart('member/forum/create_exec', array('id'=>'form', 'class'=>''));
                        }else{ 
                         echo form_open_multipart('member/forum/update_exec', array('id'=>'form', 'class'=>''));
                        } 
                        ?>
                        
                        <label for="forum_id">Forum</label>
                        <p>
                        <select name="forum_id" id="forum_id" class="validate[required]">
                        	<option value="">None</option>
                			<?php 
                				foreach($forums as $r):
                			?>
                                <option <?php if( ($action=="edit" && $r->forum_id==$thread_info->forum_id) || ($action=="add" && $forum_id == $r->forum_id) ){?> selected="selected" <?php } ?> value="<?php echo $r->forum_id;?>"><?php echo $r->forum_name;?></option>
                            <?php
                				endforeach;
                            ?>
                        </select>
                        </p>

                        <label for="title">Title</label>
                        <p><input type="text" id="title" name="title" class="validate[required]" value="<?php echo $action=="add"? set_value('title'): $thread_info->title ?>" ></p>

                        <p>Content</p>
                        <p>
                        <?php ckeditor($action=="add"? set_value('post_content'): $thread_info->content,'post_content')?>
                        </p>

                        <label for="tags">Tags</label>
                        <p><textarea id="tags" name="tags"><?php echo $action=="add"? set_value('tags'): isset($tags)?$tags:'' ?></textarea></p>
                		
                        <?php 
                        if($action=="edit"){ 
                        echo form_hidden('thread_id', $thread_info->ID);
                        }
                        ?>

                        <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'add': 'update'?>" />
                        <a class="btn" href="<?php echo base_url();?>member/forum">Cancel</a>
                       
                        <?=form_close()?>

                    </div><!-- .content_container-->

                </div>

            </div><!-- #section_left -->        

            <?php $this->load->view('includes/section_right.php');?>
        </div><!-- #main_section -->        
        
        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
