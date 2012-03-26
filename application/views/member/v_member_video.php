<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>


  	<div class="box">
    	<div class="box-heading red">
        <h1><span class="title fl">Your Hunting Videos</span></h1>
      </div>

      <div class="content_container box-content">
        <?php $this->load->view('includes/member/member_quick_links.php');?>

        <div class="fl">
            <?php $this->load->view('includes/user_box');?>

        </div><!-- .fl-->

        <div class="content_box">

        <?php 
				if(isset($video_list)){
				?>
		        <a class="btn" href="<?php echo base_url();?>member/video/create">Add New Video</a>

            <ul class="content_list">
		        <?php
    					foreach($video_list as $a=>$r):
    				?>
          	<li>
              
              <p class="fl member_content_with_thumbnail">
                  <img src="<?php echo youtube_thumb($r->youtube_id);?>" />
              </p>

              <div>
                  <h2><a href="<?php echo base_url().'video/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>

                  <p>Tags : 
                  	<strong><?php foreach($post_tags[$a] as $i=>$t){ if($i!=0){ echo ', '; } echo $t->name.' '; }?></strong>
                  </p>
                  
                  <p><?php echo pretty_date($r->entry_date);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                  <?php
                  /*<p>
                    <a href="<?php echo base_url();?>member/video/update/<?php echo $r->ref_id;?>">Edit</a>
                     - 
                    <a class="tx_red delete" href="<?php echo base_url();?>member/video/delete/<?php echo $r->ref_id;?>">Delete</a>
                  </p>                                
                  */ ?>

                  <?php 
                  echo form_open(base_url('member/video/delete')) ;
                  echo form_hidden('video_id', $r->ref_id);
                  ?>
                  <a class="btn bg_green" href="<?php echo base_url();?>member/video/update/<?php echo $r->ref_id;?>">Edit</a>
                  <?php
                  echo form_submit(array('class'=>'btn bg_red delete','value'=>'Delete'));
                  echo form_close();
                  ?>

                  <?php ?>
                  

              </div>

              
          	</li>
      			<?php
      				endforeach;
      			?>
    				</ul>

            <?php if(isset($this->pager) && ($this->pager->create_links())){ ?>
            <div class="pagination">
            <?php echo $this->pager->create_links(); ?>
            </div>
            <?php } ?>

				<?php
        }else{
				?>
		        
		        
				<p>You have not added any videos. Start adding one now? Click <a href="<?php echo base_url();?>member/video/create">Here</a></p>
				<?php
		        }
				?>

    </div><!-- .content_box-->


    </div><!-- .content_container-->

  </div>

      </div><!-- #section_left -->        

			<?php $this->load->view('includes/section_right.php');?>
		</div><!-- #main_section -->        
  
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>