<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
		<?php if($action=="add"){?>
                <h1>create a thread</h1>
                <?php }else{ ?>
                <h1>Edit thread : <?php echo $thread_info->title;?></h1>
                <?php } ?>
				
				<?php if($this->session->flashdata('log')){echo $this->session->flashdata('log');}?>
				<?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/forum/thread_create_exec');
                }else{ 
                 echo form_open_multipart('backadmin/forum/thread_update_exec');
                } 
                ?>

                <label for="forum_id">Forum</label>
                <p>
                <select name="forum_id" id="forum_id">
                        <option value="">None</option>
                                <?php 
                                        foreach($forums as $r):
                                ?>
                        <option <?php if($action=="edit" && $r->forum_id==$thread_info->forum_id){?> selected="selected" <?php } ?> value="<?php echo $r->forum_id;?>"><?php echo $r->forum_name;?></option>
                    <?php
                                        endforeach;
                    ?>
                </select>
                </p>

                <label for="title">Title</label>
                <p><input type="text" id="title" name="title" value="<?php echo $action=="add"? set_value('title'): $thread_info->title ?>" ></p>
        
                <p>Content</p>
                <p>
                <?php ckeditor($action=="add"? set_value('post_content'): $thread_info->content,'post_content')?>
                </p>
        


		<?php 
                if($action=="edit"){ 
                echo form_hidden('thread_id', $thread_info->ID);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'create': 'update'?>" />
                <a class="btn" href="<?php echo $this->admin_link;?>forum">Back</a>
                
                <?=form_close()?>

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>