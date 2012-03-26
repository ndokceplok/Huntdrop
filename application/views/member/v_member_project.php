<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>


            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl">Your Hunts</span></h1>
                    </div>
		
                    <div class="content_container box-content">
                        <?php $this->load->view('includes/member/member_quick_links.php');?>

                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>

                            <div class="content_sidebar ">
                                <?php if(count($tags)>0){ ?>
                                <h2><?php echo $account->user_name;?>'s Project Tags</h2>
                                <ul>
                                <?php foreach($tags as $r){ ?>
                                
                                    <li>
                                    <a href="<?php echo base_url();?>member/project/tag/<?php echo $r->name;?>"><?php echo $r->name;?> (<?php echo $r->tag_qty;?>)</a> 
                                    </li>
                                
                                <?php } ?>
                                </ul>
                                <?php } ?>
                            </div><!-- .content_sidebar-->

                        </div><!-- .fl-->

                        <div class="content_box">

					        <?php 
							if(isset($project_list)){
							?>
                            <p>
                                <?php if(!empty($browse_tag)){?>
                                <strong>Displaying Projects with Tag : <?php echo $tag;?></strong> <a class="btn" href="<?php echo base_url();?>member/project">View All Projects</a>
                                <?php } ?>
					           <a class="btn" href="<?php echo base_url();?>member/project/create">Create New Project</a>
                            </p>
                            <ul class="content_list">
					        <?php
								foreach($project_list as $a=>$r):
							?>
                            	<li>
                                
                                <p class="fl member_content_with_thumbnail">
                                    <img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" alt="<?php echo $r->title;?>" />
                                </p>
                                <div>
                                    <h2><a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>

                                    <p>Tags : 
                                    	<strong><?php foreach($post_tags[$a] as $i=>$t){ if($i!=0){ echo ', '; } echo $t->name.' '; }?></strong>
                                    </p>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>
    
                                    <?php
                                    /*<p>
							            <a href="<?php echo base_url();?>member/project/update/<?php echo $r->ref_id;?>">Edit</a>
							             - 
							            <a class="tx_red delete" href="<?php echo base_url();?>member/project/delete/<?php echo $r->ref_id;?>">Delete</a>
									</p>                                
                                    */?>

                                    <?php 
                                    echo form_open(base_url('member/project/delete')) ;
                                    echo form_hidden('project_id', $r->ref_id);
                                    ?>
                                    <a class="btn bg_green" href="<?php echo base_url();?>member/project/update/<?php echo $r->ref_id;?>">Edit</a>
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
					        
					        
								<p>You have not created any projects. Start creating one now? Click <a href="<?php echo base_url();?>member/project/create">Here</a></p>
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