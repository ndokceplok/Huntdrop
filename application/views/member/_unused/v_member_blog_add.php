<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
	<div id="content">
		<h1>Add New Blog Entry</h1>
        
        <?=form_open('member/blog_add_exec');?>
        
        <label for="title">Title</label>
        <p><input type="text" id="title" name="title" value="<?php echo set_value('title');?>" ></p>

        <label for="content">Content</label>
        <p><textarea id="content" name="content"><?php echo set_value('content');?></textarea></p>

        <label for="tag">Tags</label>
        <p><textarea id="tag" name="tag"><?php echo set_value('tag');?></textarea></p>

        <input type="submit" name="submit" value="update" />
        
        <?=form_close()?>
        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
