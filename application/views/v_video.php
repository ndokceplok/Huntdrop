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
                        <h1><span class="title fl"><?php echo $video_info->title;?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            Video by <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>"><?php echo $account->user_name;?></a>
                            Posted <?php echo pretty_date($post->entry_date);?> | 
                            <?php echo $post->view;?> view | 
                            <?php echo count($comments) ;?> Comment<?php if(count($comments)>1){echo 's';} ?> | 
                            <strong><?php echo $likes ;?></strong> Like<?php if($likes>1){echo 's';} ?>

                        </p>
                    
                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>
                            
                        </div>
                        
                        <div class="content_box">
                        	
                            <div class="content_info">
                                <p><?php echo $post->view;?> view</p>
                                <p>Tags : 
								<?php //echo (isset($tags))?$tags:'';
								foreach($tags as $i=>$t){
									if($i!=0){ echo ', '; }
									echo '<a href="'.base_url().'video/tag/'.$t.'">'.$t.'</a>';
								}
								?>
                                </p>
								
								<?php echo $like_bar; //$this->load->view('includes/like_bar.php',array('post_type'=>2)); ?>

                            </div>
                            
                            <div class="content_text">
								<?php echo ($video_info->content);?>
                            </div>
                                <iframe class="youtube-player" type="text/html" width="570" height="428" src="http://www.youtube.com/embed/<?php echo $video_info->youtube_id;?>" frameborder="0"></iframe>

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
                    
                    <?php $this->load->view('includes/comments.php',array('post_type'=>4)); ?>
            
                </div>

                

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
