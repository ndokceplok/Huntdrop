<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

	<div id="content">
	
		<h1>Review</h1>
		<div class="section">
			<h2><?=$review->title?></h2>
			<div class="small_info">
				posted <?=pretty_date($review->entry_date)?> by <?=$review->author?> 
			</div>
			<?php
				if (! empty($photo->src)) {
			?>
			<div class="photo">
				<img src="<?=base_url() .'uploads/'. $photo->src?>" alt="<?=$review->title?>" />
			</div>
			<?php
				}
			?>
			<?=$review->content?>
		</div><!-- .section -->

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>