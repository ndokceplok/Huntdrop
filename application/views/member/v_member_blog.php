<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Your Hunting Blogs</span></h1>
                    </div>
		
                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>

                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>

                            <div class="content_sidebar ">
                                <h2><?php echo $account->user_name;?>'s Blog Series</h2>
                                <ul>
                                <?php foreach($blog_series as $r){ ?>
                                    <li><a href="<?php echo base_url();?>member/blog/series/<?php echo $r->ID;?>"><?php echo $r->series_name;?> (<?php echo $r->series_total_blogs;?>)</a> 
                                    <span class="fr">
                                    <a class="tx_red delete_series" id="<?php echo $r->ID;?>" href="#">Delete</a>
                                    </span>
                                    </li>
                                
                                <?php } ?>
                                    <li><a href="<?php echo base_url();?>member/blog/series/na">No Series(<?php echo count($no_series);?>)</a> </li>    
                                </ul>
                            </div><!-- .content_sidebar-->

                        </div><!-- .fl-->

                        <div class="content_box">

					        <?php 
							if(isset($blog_list)){
							?>

                            <p>
                                <?php if(!empty($browse_series)){?>
                                <strong>Displaying Blog Series : <?php echo $series_detail->series_name;?></strong> <a class="btn" href="<?php echo base_url();?>member/blog">View All Blogs</a>
                                <?php } ?>
                                <a class="btn" href="<?php echo base_url();?>member/blog/create">Add New Entry</a>

                            </p>

                            <ul class="content_list">
					        <?php
								foreach($blog_list as $r):
							?>
                            	<li>
                                
                                <p class="fl member_content_with_thumbnail">
                                    <img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo $r->title;?>" />
                                </p>
                                <div>
                                    <h2><a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>

                                    <p>Series : <a href="<?php echo base_url().'member/blog/series/'.$r->series_id;?>"><?php echo $r->series_name;?></a></p>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>
    
                                    <?php 
                                    echo form_open(base_url('member/blog/delete')) ;
                                    echo form_hidden('blog_id', $r->ref_id);
                                    ?>
                                    <a class="btn bg_green" href="<?php echo base_url();?>member/blog/update/<?php echo $r->ref_id;?>">Edit</a>
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
                               if(isset($browse_series)){
                            ?>     
                                <p>You have not created any blogs for this series. Create one now? Click <a href="<?php echo base_url();?>member/blog/create">Here</a></p>                            
                            <?php
                               }else{
							?>
					        
								<p>You have not created any blogs. Start creating one now? Click <a href="<?php echo base_url();?>member/blog/create">Here</a></p>
							<?php                                   
                               }
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