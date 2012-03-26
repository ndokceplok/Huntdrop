<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

            	<div class="box">
                	<?php 
					$add ='';
					if(!empty($tag)){ $add = '/tag/'.$tag; }
					if(!empty($category)){ $add = '/category/'.$category; $suffix = $categories[$category-1]->category_name; }
					if(!empty($brand)){ $add = '/brand/'.$brand; $suffix = $brands[$brand-1]->brand_name;}
					?>
                	<div class="box-heading red">
                        <h1><span class="title fl">Reviews <?php if(!empty($tag)){ echo ' with tag "'.$tag.'"';}?> <?php if(!empty($suffix)){ echo ' of Products with keyword "'.$suffix.'"';}?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        <p class="stat_bar">
                            <a <?php if($sort=="latest"){?> class="selected" <?php } ?> href="<?php echo base_url();?>review<?php echo $add;?>" >Most Recent</a> 
                            <a <?php if($sort=="view"){?> class="selected" <?php } ?> href="<?php echo base_url();?>review<?php echo $add;?>/by/view">Most Viewed</a> 
                            <a <?php if($sort=="active"){?> class="selected" <?php } ?> href="<?php echo base_url();?>review<?php echo $add;?>/by/active" >Most Discussed</a> 
                            <a <?php if($sort=="popular"){?> class="selected" <?php } ?> href="<?php echo base_url();?>review<?php echo $add;?>/by/popular"  >Most Favorited</a> 
                        </p>

                        <div class="content_sidebar fl">
                            <h2>Browse Reviews</h2>
            
                            <ul class="tabs">
                                <li><a <?php if(!empty($category)){ ?> class="category-active" <?php } ?> href="#tab1">Category</a></li>
                                <li><a <?php if(!empty($brand)){ ?> class="brand-active" <?php } ?> href="#tab2">Brand</a></li>
                            </ul>
                            <div class="tab_container">
                                <div id="tab1" class="tab_content">
                                    <ul>
                                    <?php foreach($categories as $r){ ?>
                                    
                                        <li>
                                        <?php if(isset($category) && $category == $r->category_id){ ?>
                                        <strong><?php echo $r->category_name;?></strong>
                                        <?php }else{ ?>
                                        <a href="<?php echo base_url();?>review/category/<?php echo $r->category_id;?>"><?php echo $r->category_name;?></a>
                                        <?php } ?>
                                        </li>
                                    
                                    <?php } ?>        
                                    </ul>
            
                                </div>
                                <div id="tab2" class="tab_content">
                                    <ul>
                                    <?php foreach($brands as $r){ ?>
                                    
                                        <li>
                                        <?php if(isset($brand) && $brand == $r->brand_id){ ?>
                                        <strong><?php echo $r->brand_name;?></strong>
                                        <?php }else{ ?>
                                        <a href="<?php echo base_url();?>review/brand/<?php echo $r->brand_id;?>"><?php echo $r->brand_name;?></a>
                                        <?php } ?>
                                        </li>
                                    
                                    <?php } ?>        
                                    </ul>
                                </div>
                            </div>
            
                        </div><!-- .user_box-->

                        <div class="content_box">
							
                            <?php if(count($reviews)==0){
                            if($this->session->userdata('user_id')){
                            $review_link = "member/review/create";
                            }else{
                            $review_link = "account/login";
                            }
                            ?>
                            <p class="no-item">There are no reviews yet. <a href="<?php echo base_url().$review_link;?>">Create one</a></p>
                            <?php }else{ ?>
                            <ul class="content_list">
                            <?php
                                foreach($reviews as $i=>$r){ ?>
                            	<li>
                                
                                <p class="fl member_content_with_thumbnail">
                                    <a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" /></a>
                                </p>

                                <div class="content_list_title review_list_title">
                                    <p class="highlight_bar">
                                        <!--<a href="<?php echo base_url().'review/brand/'.$r->brand_id;?>">-->
                                        <?php if(!empty($r->brand_id)){?><strong><?php echo $r->brand_name;?> </strong> - <?php } ?>
                                        <!--</a>-->
                                        <?php echo $r->object;?>
                                    </p>
                                    <div class="content_list_rating rateit" data-rateit-value="<?php echo $r->rating;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                   
                                    <h2><a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                                </div>

                                <br class="clear" />

                                <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>

                                <p><a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>">Read this review</a>&raquo;</p>
                                
                                
                            	</li>
                            <?php } 
                            }
                            ?> 
                            </ul>

                            <div class="pagination">
                            <?php echo $this->pager->create_links(); ?>
                            </div>
                                                       
                    	</div>
                    </div>
                    
            	</div><!-- .box -->
          	</div><!--#section_left-->
          
			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>

