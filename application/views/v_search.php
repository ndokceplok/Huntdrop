<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl">Search Result<?php echo !empty($qword)?' with keyword "'.$qword.'"':'' ;?></span></h1>
                    </div>

                    <div class="content_container box-content">
                        
                        <form class="search_page_form" method="post" action="<?php echo base_url();?>search">
                            Search <input type="text" name="q" value="<?php echo isset($qword)?$qword:'';?>" placeholder="Search HuntDrop" />
                            <input type="radio" value="" name="search_type" <?php if(empty($search_type)){?> checked="checked" <?php } ?> /> All
                            <input type="radio" value="project" name="search_type" <?php if($search_type=="project"){?> checked="checked" <?php } ?>/> Projects
                            <input type="radio" value="blog" name="search_type" <?php if($search_type=="blog"){?> checked="checked" <?php } ?>/> Blogs
                            <input type="radio" value="video" name="search_type" <?php if($search_type=="video"){?> checked="checked" <?php } ?>/> video
                            <input type="radio" value="review" name="search_type" <?php if($search_type=="review"){?> checked="checked" <?php } ?>/> Review
                            <input type="radio" value="thread" name="search_type" <?php if($search_type=="thread"){?> checked="checked" <?php } ?>/> Threads
                            <input type="radio" value="user" name="search_type" <?php if($search_type=="user"){?> checked="checked" <?php } ?>/> Users

                            <input type="submit" class="btn" value="GO" />
                        </form>

        		        <?php if(!empty($projects)){?>
                        <div class="search_result_box">
                        <h2>Projects<?php echo !empty($qword)?' with keyword "'.$qword.'"':'' ;?></h2>
                            <ul class="projects_list search_projects">
                            <?php foreach($projects as $i=>$r){ ?>
                                <li>
                                    <div class="projects_list_thumb">
                                    <a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><img src="<?php echo content_thumb($r->thumb);?>" /></a>
                                    </div>
                                    
                                    <p><a href="<?php echo base_url().'project/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></p>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></p>
                                    <p><?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                                </li>
                            <?php } ?> 
                            </ul>
                        </div>
                        <?php } ?>
 
                        <?php if(!empty($blogs)){?>
                        <div class="search_result_box">
                        <h2>Blogs<?php echo !empty($qword)?' with keyword "'.$qword.'"':'' ;?></h2>
                            <ul class="content_list">
                            <?php foreach($blogs as $i=>$r){ ?>
                                <li>
                                
                                <!--<a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" /></a>-->
                                <a class="blog_list_thumb" href="<?php echo base_url().'user/'.$r->user_name;?>">
                                    <span><img src="<?php echo user_image($r->photo);?>" /></span>
                                </a>
                                
                                <div class="blog_list_title">
                                    <h2><a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                                    <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>

                                    <p><a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>">Read this entry</a>&raquo;</p>

                                </div>

                                <br class="clear" />

                                
                                
                                </li>
                            <?php } ?> 
                            </ul>
                        </div>
                        <?php } ?>

                        <?php if(!empty($videos)){?>
                        <div class="search_result_box">
                        <h2>Videos<?php echo !empty($qword)?' with keyword "'.$qword.'"':'' ;?></h2>
                            <ul class="content_list">
                            <?php foreach($videos as $i=>$r){ ?>
                                <li>
                                
                                <!--<a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" /></a>-->
                                <a class="blog_list_thumb" href="<?php echo base_url().'user/'.$r->user_name;?>">
                                    <span><img src="<?php echo user_image($r->photo);?>" /></span>
                                </a>
                                
                                <div class="blog_list_title">
                                    <h2><a href="<?php echo base_url().'blog/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                                    <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>
    
                                    <p><a href="<?php echo base_url().'video/'.$r->ref_id.'/'.$r->alias;?>">Read this entry</a>&raquo;</p>

                                </div>

                                <br class="clear" />

                                
                                
                                </li>
                            <?php } ?> 
                            </ul>
                        </div>
                        <?php } ?>
                

                        <?php if(!empty($reviews)){?>
                        <div class="search_result_box">
                        <h2>Reviews<?php echo !empty($qword)?' with keyword "'.$qword.'"':'' ;?></h2>
                            <ul class="content_list">
                            <?php foreach($reviews as $i=>$r){ ?>
                                <li>
                                
                                <a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><img class="content_list_thumb" src="<?php echo content_thumb($r->thumb);?>" /></a>
                                
                                <div class="content_list_title review_list_title">
                                    <p class="highlight_bar">
                                        <a href="<?php echo base_url().'review/brand/'.$r->brand_id;?>"><?php echo $r->brand_name;?></a> <?php echo $r->object;?>
                                    </p>
                                     <div class="content_list_rating rateit" data-rateit-value="<?php echo $r->rating;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                   
                                    <h2><a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                    
                                    <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> | <?php echo $r->nb_comments;?> comment<?php plural($r->nb_comments);?> | <?php echo $r->view;?> view<?php plural($r->view);?> | <?php echo $r->nb_likes;?> like<?php plural($r->nb_likes);?></p>

                                </div>

                                <br class="clear" />

                                    <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>

                                <p><a href="<?php echo base_url().'review/'.$r->ref_id.'/'.$r->alias;?>">Read this review</a>&raquo;</p>
                                
                                
                                </li>
                            <?php } ?> 
                            </ul>
                        </div>
                        <?php } ?>
  
                        <?php if(!empty($threads)){?>
                        <div class="search_result_box">
                        <h2>Threads <?php echo !empty($qword)?' with keyword "'.$qword.'"':'' ;?></h2>
                        <table width="100%" class="lists forum_lists">
                            <thead>
                                <tr>
                                    <th>All Threads</th>
                                    <th class="center">Replies</th>
                                    <th class="center">Last Post</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($threads as $i=>$r){  ?>
                                    <tr>
                                        <td>
                                        <a href="<?php echo base_url().'user/'.$r->user_name;?>"><img class="blog_list_thumb" src="<?php echo user_image($r->photo);?>" /></a>
                                        <div class="blog_list_title">
                                            <h2><a href="<?php echo base_url().'forum/thread/'.$r->ref_id.'/'.$r->alias;?>"><?php echo $r->title;?></a></h2>
                                            
                                            <p><?php echo pretty_date($r->entry_date);?> by <a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a> in <a href="<?php echo base_url();?>forum/<?php echo $r->forum_id; ?>"><?php echo $r->forum_name;?></a></p>
            
                                            <p class="short_desc"><?php echo substr(strip_tags($r->content),0,150);?></p>
            
                                        </div>
                                        </td>
                                        <td class="center"><?php echo $r->nb_comments;?></td>
                                        <td class="center"><?php if(!empty($r->latest_reply)){ echo pretty_date($r->latest_reply); }else{ echo "-"; }?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                        <?php } ?>

                        <?php if(!empty($users)){?>
                        <div class="search_result_box">
                        <h2>Users <?php echo !empty($qword)?' with keyword "'.$qword.'"':'' ;?></h2>
                        <ul id="hunters_thumbs">
                            <?php foreach ($users as $i=>$r):?>
                                <li>
                                <?php 
                                $now = now().'<br>';
                                $last_active = human_to_unix($r->last_active);
                                //echo date("Y-m-d H:i:s"); //$class="hunter_online"?>
                                <a class="avatar-container <?php if($r->is_online==1 && $now-900<$last_active){?> hunter_online <?php } ?>" href="<?php echo base_url();?>user/<?php echo $r->user_name;?>">
                                <span>
                                    <img src="<?php echo user_image($r->photo);?>" />
                                </span>
                                </a>
                                <p><a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></p>
                                <?php 
                                    $interval = get_total_days($r->member_since,date("Y-m-d"));
                                ?>
                                <p class="small"><?php echo $r->total_posts;?> post<?php plural($r->total_posts);?> in <?php echo $interval;?> day<?php plural($interval);?></p>
                                <p class="small"><?php echo $r->location;?></p>
                                
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        </div>
                        <?php } ?>
                 
                    </div>
                    
        		</div>

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
