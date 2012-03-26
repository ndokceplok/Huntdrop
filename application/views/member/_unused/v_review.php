<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script src="<?php echo base_url();?>js/notice.js"></script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

	<div id="content">
		<h1>Review</h1>
		
		<div class="section">
			<?=anchor('member/review/create', 'create new', array('class'=>'btn'))?>
		</div><!-- .section -->
		
		<?php
			if( empty($review)) {
		?>
		<div class="section">
			You have not created any reviews. Start creating one now? Click <?=anchor('member/review/create', 'here')?>
		</div><!-- .section -->
		<?
			}
		?>
		
		<?php 
			foreach($review as $r) {
		?>
		<div class="section">
			<?=anchor('review/'. $r->ID.'/'.$r->alias, $r->title, 'target="_blank"')?>
			<!--<div class="small_info">
				posted <?//=pretty_date($r->entry_date)?> by <?//=$r->author?> 
			</div>-->
			<?php if($r->account_id == $this->session->userdata('user_id')) { ?>
			<div class="small">
				<?=anchor('member/review/update/'. $r->ID, 'update')?>
				<?=anchor('member/review/delete/'. $r->ID, 'delete', array('class'=>'tx_red delete'))?>
			</div>
			<?php } ?>
		</div><!-- .section -->
		<?php
			} 
		?>
		
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>