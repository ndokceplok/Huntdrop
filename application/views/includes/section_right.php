<div id="section_right" class="column <?php if(isset($active) && $active=="home"){ echo 'grid_6' ;}else{ echo 'grid_3';}?>">
	<?php if(isset($active) && $active=="home"){?>
        <?php if( !$this->session->userdata('logged_in')) { ?>
    		<a class="join-now" href="<?php echo base_url().'account/register';?>"><img src="<?php echo assets_url();?>images/join-now.jpg" alt="Join Now Banner" /></a>
        <?php } ?>

    	<div class="box">
        	<div class="box-heading brown">
                <span class="title fl">Hunters</span>

                <!--<span class="links">
                latest 25 | <a href="<?php echo base_url();?>user">view all</a>
                </span>-->
                
                <span class="links2 fr">
                View <a href="<?php echo base_url();?>user">all</a> | <a href="<?php echo base_url();?>user/by/active">most active</a>
                </span>

            </div>
            
            <ul id="hunters_thumbs">
				<?php foreach ($latest_user as $r): ?>
                    <li>
                    <a title="view <?php echo $r->user_name;?>'s profile" class="avatar-container" href="<?php echo base_url();?>user/<?php echo $r->user_name;?>">
                    <span><img src="<?php echo user_image($r->photo);?>" alt="<?php echo $r->user_name;?>'s avatar"/></span>
                    <p class="avatar-name" ><?php echo $r->user_name;?></p>
                    <!--<p>Member since : <?php echo pretty_date($r->member_since);?></p>-->
                    </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            
        </div>
	   
       <?php if(!empty($home_side_banners)){
           foreach($home_side_banners as $r){ ?>
            
            <a href="<?php echo $r->banner_link;?>" target="_blank"><img src="<?php echo banner_image($r->banner_image);?>" alt="<?php echo $r->banner_title;?>" /></a>

       <?php }} ?>

    <p><a class="green" href="<?php echo base_url();?>advertise">Advertise with us</a> <a class="green" href="<?php echo base_url();?>advertise">All Advertisers</a></p>
	<?php }else{ ?>

	<!-- <img src="<?php echo assets_url();?>images/ads1.jpg" alt="ads1" />
 	<img src="<?php echo assets_url();?>images/ads2.jpg" alt="ads2" /> -->
    <p><a class="green" href="<?php echo base_url();?>advertise">Advertise with us</a></p>
    <p><a class="green" href="<?php echo base_url();?>advertise">All Advertisers</a></p>
    <?php } ?>

</div>
