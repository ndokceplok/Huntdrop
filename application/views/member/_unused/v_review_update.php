<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

	<div id="content">
		<h1>Review</h1>
		<div class="section">
			update
		</div><!-- .section -->
		<?php if($this->session->flashdata('log')){ ?>
		<div class="log">
			<?=$this->session->flashdata('log')?>
		</div>
		<?php } ?>

		<?=form_open_multipart('member/review/update_exec')?>
		<?=form_hidden('review_id', $review->ID)?>
		<?=form_hidden('post_id', $review->post_id)?>

		<div class="section">
			<div class="small_info">
				Object
			</div>
			<input type="text" name="object" value="<?=$review->object?>" />
		</div><!-- .section -->

		<div class="section">
			<div class="small_info">
				Category
			</div>
            <select name="category_id" id="category_id">
                <option value="">None</option>
                <?php 
                    foreach($categories as $r):
                ?>
                    <option <?php if($r->category_id==$review->category_id){ ?> selected="selected" <?php } ?> value="<?php echo $r->category_id;?>"><?php echo $r->category_name;?></option>
                <?php
                    endforeach;
                ?>
            </select>
		</div><!-- .section -->

		<div class="section">
			<div class="small_info">
				Brand
			</div>
            <select name="brand_id" id="brand_id">
                <option value="">None</option>
                <?php 
                    foreach($brands as $r):
                ?>
                    <option <?php if($r->brand_id==$review->brand_id){ ?> selected="selected" <?php } ?>value="<?php echo $r->brand_id;?>"><?php echo $r->brand_name;?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <input type="button" value="Add New Brand" id="add_new" />
		</div><!-- .section -->

		<div class="section">
			<div class="small_info">
				Title
			</div>
			<input type="text" name="title" value="<?=$review->title?>" />
		</div><!-- .section -->

		<div class="section">
			<?php ckeditor($review->content,'post_content')?>
			<!--<textarea name="content"><?=$review->content?></textarea>-->
		</div><!-- .section -->


		<div class="section">
			<input type="text" name="tags" value="<?=(isset($tags)?$tags:'')?>" />
			<div class="small_info">
				multiple tags separated by comma
			</div>
		</div><!-- .section -->
		<div class="section">
			<div class="small_info">
				Rate product 1 - 5
			</div>
			<input type="range" id="rating" name="rating" min="0" max="5" step="1" value="<?=$review->rating?>" >
            <div class="rateit" data-rateit-backingfld="#rating"></div>
		</div><!-- .section -->
		<div class="section">
			<div class="small_info">
				Current Photo
			</div>
			<div class="c_photo">
				<?php if(isset($photo[0]->thumb)){ ?><img src="<?php echo content_thumb($photo[0]->thumb);?>" alt="<?=$review->title?>" height="150" /> <?php } ?>
			</div>
			<input type="file" name="photo" />
		</div><!-- .section -->

		<div class="section">
			<input type="submit" value="submit" />
		</div><!-- .section -->
		<?=form_close()?>

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>