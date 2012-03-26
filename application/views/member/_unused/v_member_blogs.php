<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script src="<?php echo base_url();?>js/blog.js"></script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

	<div id="content">
		<h1>This is The List of Your Blogs</h1>
        <?php 
		if(isset($blog_list)){
		?>
        <a href="<?php echo base_url();?>member/blog/add">Add New Entry</a>
        <?php
			foreach($blog_list as $r):
		?>
        	<p><a href="<?php echo base_url().'user/'. $this->m_accounts->get_user_name($r->account_id);?>/blog/<?php echo $r->alias;?>"><?php echo $r->title;?></a> - <a href="<?php echo base_url();?>member/blog/edit/<?php echo $r->ID;?>">Edit</a> - <a class="delete" href="<?php echo base_url();?>member/blog/delete/<?php echo $r->ID;?>">Delete</a></p>
		<?php
			endforeach;
        }else{
		?>
        
        
			<p>You have not created any blogs. Start creating one now? Click <a href="<?php echo base_url();?>member/blog/add">Here</a></p>
		<?php
        }
		?>
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>