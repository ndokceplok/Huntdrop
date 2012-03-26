<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
                <div class="box">
                    <div class="box-heading green">
                        <h1><span class="title fl">Hunters</span></h1>
                    </div>
    
                    <div class="content_container box-content">
                    <?php if(!$this->session->userdata('logged_in')){ ?>
                    <p class="fr"><a href="<?php echo assets_url().'account/register';?>"><img alt="join button" title="Join now!" src="<?php echo assets_url().'images/join.jpg';?>" /></a></p>
                    <?php } ?>
                    
                    <p class="stat_bar">
                    <a <?php if($sort=="latest"){?> class="selected" <?php } ?> href="<?php echo base_url();?>user">Most Recent</a> 
                    <a <?php if($sort=="active"){?> class="selected" <?php } ?> href="<?php echo base_url();?>user/by/active">Most Active</a>
                    <a <?php if($sort=="online"){?> class="selected" <?php } ?> href="<?php echo base_url();?>user/by/online">Online Now</a>
                    </p>

                    <p><strong>A <span class="tx_orange">red line</span> around photo indicates that the Hunter in currently online.</strong></p>
                    <ul id="hunters_thumbs" class="browse_user">
                        <?php foreach ($users as $i=>$r):?>
                            <li>
                            <?php 
                            $now = now().'<br>';
                            $last_active = human_to_unix($r->last_active);
                            //echo date("Y-m-d H:i:s"); //$class="hunter_online"?>
                            <a class="avatar-container <?php if($r->is_online==1 && $now-900<$last_active){?> hunter_online <?php } ?>" href="<?php echo base_url();?>user/<?php echo $r->user_name;?>" title="View the profile of <?php echo $r->user_name;?>" >
                            <span>
                                <img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar"/>
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
    			
                    <div class="pagination">
                    <?php echo $this->pager->create_links(); ?>
                    </div>
                    </div>
                </div>
            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
