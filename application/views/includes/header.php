	<div id="header">
		<h1 id="logo"><a href="<?php echo base_url();?>">HuntDrop</a></h1>
    	
        <div id="header_menu">
        	<a class="about" href="<?php echo base_url();?>about">About</a>
            <a class="facebook" href="http://facebook.com" target="_blank">Facebook</a>
            <a class="twitter" href="http://twitter.com" target="_blank">Twitter</a>
            <a class="contact" href="<?php echo base_url();?>contact">Contact</a>
        </div>

        <div id="signin_menu">
			<?php if($this->session->userdata('logged_in')){?>
                <p><a class="my_huntdrop" href="#">My HuntDrop</a></p>
                <ul class="hidden member_nav">
                    <li><?=anchor('', 'Home')?></li>
                    <li><?=anchor('member', 'Your Dashboard', (isset($active) && $active=='dashboard')?'class="active"':'')?></li>
                    <li><?=anchor('member/review', 'Your Reviews', (isset($active) && $active=='review')?'class="active"':'')?></li>
                    <li><?=anchor('member/blog', 'Your Blogs', (isset($active) && $active=='blog')?'class="active"':'')?></li>
                    <li><?=anchor('member/forum', 'Your Forum Threads', (isset($active) && $active=='forum')?'class="active"':'')?></li>
                    <li><?=anchor('member/video', 'Your Videos', (isset($active) && $active=='video')?'class="active"':'')?></li>
                    <li><?=anchor('member/project', 'Your Projects', (isset($active) && $active=='project')?'class="active"':'')?></li>
                    <li><?=anchor('member/message', 'Your Messages', (isset($active) && $active=='message')?'class="active"':'')?></li>
                    <li><?=anchor('member/friend', 'Your Friends', (isset($active) && $active=='friend')?'class="active"':'')?></li>
                    <!-- <li><a <?php if(isset($active) && $active=='contest'){?>class="active" <?php } ?> href="<?php echo base_url();?>contest">Contest</a></li> -->
                    <li><?=anchor('member/profile/update', 'My profile', (isset($active) && $active=='profile')?'class="active"':'')?></li>
                    <?php if($this->session->userdata('fb_profile')) { ?>
                    <li><?=anchor('account/logout_facebook', 'Logout')?></li>
                    <?php } else { ?>
                    <li><?=anchor('account/logout', 'Logout')?></li>
                </ul>
                <?php } ?>
            <?php }else{?>
        	<p><a href="<?php echo base_url();?>account/login" >Sign In</a> or <a href="<?php echo base_url();?>account/register">Join Now</a></p>
            <?php }?>
        </div>

        <ul id="nav">
        	<li><a <?php if(isset($active) && $active=='project'){?>class="active" <?php } ?> href="<?php echo base_url();?>project">Hunts</a> | </li>
            <li><a <?php if(isset($active) && $active=='video'){?>class="active" <?php } ?> href="<?php echo base_url();?>video">Video</a> | </li>
            <li><a <?php if(isset($active) && $active=='blog'){?>class="active" <?php } ?> href="<?php echo base_url();?>blog">Blog</a> | </li>
            <li><a <?php if(isset($active) && $active=='forum'){?>class="active" <?php } ?> href="<?php echo base_url();?>forum">Forum</a> | </li>
            <li><a <?php if(isset($active) && $active=='contest'){?>class="active" <?php } ?> href="<?php echo base_url();?>contest">Contest</a> | </li>
            <li><a <?php if(isset($active) && $active=='article'){?>class="active" <?php } ?> href="<?php echo base_url();?>article">Articles</a> | </li>
            <li><a <?php if(isset($active) && $active=='review'){?>class="active" <?php } ?> href="<?php echo base_url();?>review">Product Reviews</a> | </li>
            <li><a <?php if(isset($active) && $active=='help'){?>class="active" <?php } ?> href="<?php echo base_url();?>help">How To's</a> | </li>
            <li class="last"><a <?php if(isset($active) && $active=='user'){?>class="active" <?php } ?> href="<?php echo base_url();?>user">Hunters</a></li>
        </ul>

       
        <div id="subscribe_bar">
        	<div class="fl email-form">
                Subscribe via : <a href="#" class="trigger email">E-mail</a> <a href="http://feeds.feedburner.com/Huntdrop" class="rss">RSS</a>
                <div class="hidden popup">
                    <form class="subscription-form" method="post" action="<?php echo base_url().'main/save_subscription';?>">
                        <p>Email : <input type="text" name="subscribe-email" class="subscribe-email"> <input class="btn subscribe-btn" type="submit" value="Subscribe"></p>
                        <!-- <p><input class="btn" type="submit" value="Go"></p> -->
                    </form>
                    <a class="close" href="#">Close</a>
                </div>
            </div>

      
                  
            <form class="fr search_form" method="post" action="<?php echo base_url();?>search">
            	<input type="text" name="q" value="<?php echo isset($qword)?$qword:'';?>" placeholder="Search HuntDrop" />
                <input type="submit" value="GO" />
            </form>
        </div>
    
        <div id="hunter_clipart"><a href="<?php echo base_url();?>"></a></div>
    </div>
    
    <div id="welcome_text">
        <h2 class="center">Welcome to HuntDrop.com</h2>
        <p>Upload (Drop) photos, video, and stories of your trophies. Ask questions. Make friends with other hunters.</p>
    </div>
    
    <div id="content">

        <div id="main_section">
        
            <div id="section_left" class="column <?php if(isset($active) && $active=="home"){ echo 'grid_10' ;}else{ echo 'grid_13';}?>" >
