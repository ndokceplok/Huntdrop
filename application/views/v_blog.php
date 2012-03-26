<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<script>
$(function(){
	$('.fancy').fancybox();
});
</script>
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

            	<div class="box">
                	<div class="box-heading red">
                        <h1><span class="title fl"><?php echo $blog_info->title;?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            Blog by <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>"><?php echo $account->user_name;?></a>
                            Posted <strong><?php echo pretty_date($post->entry_date);?></strong> | 
                            <strong><?php echo $post->view;?></strong> view | 
                            <strong><?php echo count($comments) ;?></strong> Comment<?php if(count($comments)>1){echo 's';} ?> | 
                            <strong><?php echo $likes ;?></strong> Like<?php if($likes>1){echo 's';} ?>
                        </p>
                    	
                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>
  
                            <div class="content_sidebar">
                                <h2><?php echo $account->user_name;?>'s Blogs</h2>
                                <ul>
                                <?php foreach($other_blogs as $r){ ?>
                                
                                    <li>
                                        <a href="<?php echo base_url();?>blog/<?php echo $r->ref_id;?>/<?php echo $r->alias;?>">
                                            <p><?php echo $r->title;?></p>
                                        </a>
                                        <p class="small"><?php echo pretty_date($r->entry_date);?></p>
                                    </li>
                                
                                <?php } ?>        
                                </ul>
                            </div><!-- .content_sidebar-->

                        </div>
                        
                        <div class="content_box">

                            <div class="content_info">
                                <?php if(!empty($blog_info->series_id)){?><p>Series : <a href="<?php echo base_url().'blog/series/'.$blog_info->series_id;?>"><?php echo $blog_info->series_name;?></a></p><?php } ?>
                                <p><?php echo $post->view;?> view</p>
                                <p>Tags : 
								<?php //echo (isset($tags))?$tags:'';
								foreach($tags as $i=>$t){
									if($i!=0){ echo ', '; }
									echo '<a href="'.base_url().'blog/tag/'.$t.'">'.$t.'</a>';
								}
								?>
                                </p>
								
								<?php echo $like_bar; //$this->load->view('includes/like_bar.php',array('post_type'=>2)); ?>

                            </div>
                            
                            <div class="content_photos">
                            <?php foreach($photos as $r){?>
                                <a class="fancy" rel="same" title="<?php echo $blog_info->title;?>" href="<?php echo base_url().'uploads/'.($r->src);?>"><img src="<?php echo content_thumb($r->thumb);?>" /></a>
                            <?php } ?>
                    		</div>
                            
                            <div class="content_text">
								<?php echo ($blog_info->content);?>
                            </div>

                            <?php if(!empty($profile->signature)){?><p class="signature">-- <?php echo $profile->signature;?></p><?php } ?>

                            <!-- AddThis Button BEGIN -->
                            <div class="addthis_toolbox addthis_default_style ">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4eca518f1b67b3ee"></script>
                            <!-- AddThis Button END -->
                            
                        </div><!-- .content_box-->
                    </div>
                    
                    <?php $this->load->view('includes/comments.php',array('post_type'=>2)); ?>
            
                </div>

                

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
