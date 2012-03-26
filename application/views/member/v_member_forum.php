<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script src="<?php echo base_url();?>js/notice.js"></script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Your Post in our Hunting Forums</span></h1>
                    </div>
		
                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>

                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>

                        </div><!-- .fl-->

                        <div class="content_box">

					        <?php 
							if(isset($thread_list)){
							?>
					        <a class="btn" href="<?php echo base_url();?>member/forum/create">Add New Entry</a>

                            <ul class="content_list">
			        <?php
								foreach($thread_list as $r):
							?>
              	<li>
                  
                  <div>
                      <h2><a href="<?php echo base_url().'forum/thread/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>

                      <p>Forum : <a href="<?php echo base_url().'forum/'.$r->forum_id;?>"><?php echo $r->forum_name;?></a></p>
                      
                      <p><?php echo pretty_date($r->entry_date);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                      <?php
                      /*
                      <p>
                        <a href="<?php echo base_url();?>member/forum/update/<?php echo $r->ref_id;?>">Edit</a>
                         - 
                        <a class="tx_red delete" href="<?php echo base_url();?>member/forum/delete/<?php echo $r->ref_id;?>">Delete</a>
                  		</p>                                
                      */
                      ?>

                      <?php 
                      echo form_open(base_url('member/forum/delete')) ;
                      echo form_hidden('thread_id', $r->ref_id);
                      ?>
                      <a class="btn bg_green" href="<?php echo base_url();?>member/forum/update/<?php echo $r->ref_id;?>">Edit</a>
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
					        
								<p>You have not created any forum thread. Start creating one now? Click <a href="<?php echo base_url();?>member/forum/create">Here</a></p>
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