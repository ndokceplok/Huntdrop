<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>


            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Your Hunting Product Reviews</span></h1>
                    </div>
		
                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>

                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>

                        </div><!-- .fl-->

                        <div class="content_box">

					        <?php 
							if(isset($review_list)){
							?>
					        <a class="btn" href="<?php echo base_url();?>member/review/create">Write New Review</a>

                            <ul class="content_list">
					        <?php
								foreach($review_list as $a=>$r):
							?>
                            	<li>
                                
                                <p class="fl member_content_with_thumbnail">
                                    <img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo $r->title;?>" />
                                </p>

                                <div class="content_list_title review_list_title">
                                    <p class="highlight_bar">
                                        <a href="<?php echo base_url().'review/brand/'.$r->brand_id;?>"><?php echo $r->brand_name;?></a> <?php echo $r->object;?>
                                    </p>
                                     <div class="content_list_rating rateit" data-rateit-value="<?php echo $r->rating;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>

                                    <h2><a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>

                                    <p>Tags : 
                                    	<strong><?php foreach($post_tags[$a] as $i=>$t){ if($i!=0){ echo ', '; } echo $t->name.' '; }?></strong>
                                    </p>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>
    
                                    <?php
                                    /*<p>
							            <a href="<?php echo base_url();?>member/review/update/<?php echo $r->ref_id;?>">Edit</a>
							             - 
							            <a class="tx_red delete" href="<?php echo base_url();?>member/review/delete/<?php echo $r->ref_id;?>">Delete</a>
									</p>*/ 
                                    ?>                             


                                    <?php 
                                    echo form_open(base_url('member/review/delete')) ;
                                    echo form_hidden('review_id', $r->ref_id);
                                    ?>
                                    <a class="btn bg_green" href="<?php echo base_url();?>member/review/update/<?php echo $r->ref_id;?>">Edit</a>
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
					        
					        
								<p>You have not written any reviews. Start writing one now? Click <a href="<?php echo base_url();?>member/review/create">Here</a></p>
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