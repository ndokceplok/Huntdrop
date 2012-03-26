<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
	$('#add_new').click(function(){
		addOption($(this).siblings('#brand_id'));
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

	<div id="content">
		<h1>Write a Review</h1>
		<?php if($this->session->flashdata('log')){ ?>
		<div class="log">
			<?=$this->session->flashdata('log')?>
		</div>
		<?php } ?>
		<?=form_open_multipart('member/review/create_exec')?>
		<?=form_hidden('type', '1')?>
		<div class="section">
			<div class="small_info">
				Object
			</div>
			<input type="text" name="object" placeholder="object ..." />
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
                    <option value="<?php echo $r->category_id;?>"><?php echo $r->category_name;?></option>
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
                    <option value="<?php echo $r->brand_id;?>"><?php echo $r->brand_name;?></option>
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
			<input type="text" name="title" placeholder="title ..." />
		</div><!-- .section -->

		<div class="section">
			<?php ckeditor('','post_content')?>
			<!--<textarea name="content" placeholder="content ..."></textarea>-->
		</div><!-- .section -->
		<div class="section">
			<input type="text" name="tags" placeholder="tags ..." />
			<div class="small_info">
				multiple tags separated by comma
			</div>
		</div><!-- .section -->
		<div class="section">
			<div class="small_info">
				Rate product 1 - 5
			</div>
			<input type="range" id="rating" name="rating" min="0" max="5" step="1" value="0">
            <div class="rateit" data-rateit-backingfld="#rating"></div>
		</div><!-- .section -->
		<div class="section">
			<div class="small_info">
				Picture
			</div>
			<input type="file" name="photo" />
		</div><!-- .section -->
		<div class="section">
			<input type="submit" value="Submit" />
		</div><!-- .section -->
		<?=form_close()?>

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>
<?php $this->load->view('includes/_bottom.php');?>