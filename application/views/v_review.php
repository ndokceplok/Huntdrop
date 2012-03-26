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
                        <h1><span class="title fl"><?php echo $review_info->title;?></span></h1>
                    </div>
 					
                    <div class="content_container box-content">
                        <p class="stat_bar">
                            Review by <a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>"><?php echo $account->user_name;?></a>
                            Posted <?php echo pretty_date($post->entry_date);?> | 
                            <?php echo $post->view;?> view<?php echo plural($post->view);?> | 
                            <?php echo count($comments) ;?> Comment<?php echo plural(count($comments));?> | 
                            <strong><?php echo $likes ;?></strong> Like<?php echo plural($likes);?>
                        </p>
                    
                        <div class="fl">
                            <?php $this->load->view('includes/user_box');?>
                            
                        </div>
                        
                        <div class="content_box">
                        	
                            <div class="content_info">
                            	<p><strong><?php echo $review_info->object;?></strong></p>
                                <p>Tags : 
								<?php //echo (isset($tags))?$tags:'';
								foreach($tags as $i=>$t){
									if($i!=0){ echo ', '; }
									echo '<a href="'.base_url().'review/tag/'.$t.'">'.$t.'</a>';
								}
								?>
                                </p>
                            	<!--<p>Brand : <a href="">-</a> | Category : <a href="">-</a></p>-->
                                <div class="rateit content_list_rating" data-rateit-value="<?php echo $review_info->rating;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>

								<?php echo $like_bar; ?>
                                
                            </div>
                            
                            <div class="content_photos clearfix">
                            <?php foreach($photos as $r){?>
                                <a rel="same" class="fancy" title="<?php echo $review_info->object;?>" href="<?php echo base_url().'uploads/'.($r->src);?>"><img src="<?php echo content_thumb($r->thumb);?>" /></a>
                            <?php } ?>
                    		</div>
                            
                            <div class="content_text">
								<?php echo ($review_info->content);?>
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
                    
                    <?php $this->load->view('includes/comments.php',array('post_type'=>1)); ?>
                   
                </div>

                

            </div><!-- #section_left -->        

		

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
