	<div id="header">
		<h1 id="logo"><a href="<?php echo base_url();?>">HuntDrop</a></h1>
    	
        <div id="header_menu">
        	<a class="about" href="<?php echo base_url();?>about">About</a>
            <a class="facebook" href="http://facebook.com" target="_blank">Facebook</a>
            <a class="twitter" href="http://twitte.com" target="_blank">Twitter</a>
            <a class="contact" href="<?php echo base_url();?>contact">Contact</a>
        </div>

        <div id="signin_menu">
			<?php if($this->session->userdata('logged_in')){?>
            <p>welcome , <?=$this->session->userdata('user_name')?></p>
            <?php }else{?>
        	<p><a href="<?php echo base_url();?>account/login">Sign In</a> or <a href="<?php echo base_url();?>account/register">Join Now</a></p>
            <?php }?>
        </div>

        <ul id="nav">
			<?php if($this->session->userdata('logged_in')){?>
                <li><?=anchor('', 'Home')?></li>
                <li><?=anchor('member', 'Your Dashboard', (isset($active) && $active=='dashboard')?'class="active"':'')?></li>
                <li><?=anchor('member/review', 'Reviews', (isset($active) && $active=='review')?'class="active"':'')?></li>
                <li><?=anchor('member/blog', 'Blogs', (isset($active) && $active=='blog')?'class="active"':'')?></li>
                <li><?=anchor('member/video', 'Video', (isset($active) && $active=='video')?'class="active"':'')?></li>
                <li><?=anchor('member/project', 'Projects', (isset($active) && $active=='project')?'class="active"':'')?></li>
                <li><?=anchor('member/message', 'Messages', (isset($active) && $active=='message')?'class="active"':'')?></li>
	            <li><a <?php if(isset($active) && $active=='contest'){?>class="active" <?php } ?> href="<?php echo base_url();?>contest">Contest</a></li>
               <li><?=anchor('member/profile/update', 'My profile', (isset($active) && $active=='profile')?'class="active"':'')?></li>
                <?php if($this->session->userdata('fb_profile')) { ?>
                <li><?=anchor('account/logout_facebook', 'Logout')?></li>
                <?php } else { ?>
                <li><?=anchor('account/logout', 'Logout')?></li>
                <?php } ?>
            <?php }else{?>
        	<li><a <?php if(isset($active) && $active=='project'){?>class="active" <?php } ?> href="<?php echo base_url();?>project">Hunts</a> | </li>
            <li><a <?php if(isset($active) && $active=='video'){?>class="active" <?php } ?> href="<?php echo base_url();?>video">Video</a> | </li>
            <li><a <?php if(isset($active) && $active=='blog'){?>class="active" <?php } ?> href="<?php echo base_url();?>blog">Blog</a> | </li>
            <li><a href="">Forum</a> | </li>
            <li><a <?php if(isset($active) && $active=='contest'){?>class="active" <?php } ?> href="<?php echo base_url();?>contest">Contest</a> | </li>
            <li><a href="">Articles</a> | </li>
            <li><a <?php if(isset($active) && $active=='review'){?>class="active" <?php } ?> href="<?php echo base_url();?>review">Product Reviews</a> | </li>
            <li><a <?php if(isset($active) && $active=='help'){?>class="active" <?php } ?> href="<?php echo base_url();?>help">How To's</a> | </li>
            <li class="last"><a <?php if(isset($active) && $active=='user'){?>class="active" <?php } ?> href="<?php echo base_url();?>user">Hunters</a></li>
			<?php } ?>
        </ul>
        
        <div id="subscribe_bar">
        	<p>
            Subscribe via : <a href="" class="email">E-mail</a> <a href="" class="rss">RSS</a>
            </p>
            
            <form class="fr search_form">
            	<input type="text" placeholder="Search HuntDrop" />
                <input type="submit" value="GO" />
            </form>
        </div>
    
        <div id="hunter_clipart"><a href="<?php echo base_url();?>"></a></div>
    </div>
    
    <div id="welcome_text">
        <h2 class="center">Welcome to HuntDrop.com</h2>
        <p>Upload (Drop) photos, video, and stories of your trophies. Ask questions. Make friends with othe hunters.</p>
    </div>
    
    <!--<br class="clear">-->

<!--	<div id="header">
		<h1>HuntDrop</h1>
		<?php if($this->session->userdata('logged_in')){?>
		welcome , <?=$this->session->userdata('user_name')?>
		<?php }?>
	</div><!-- #header 
	
	<div id="nav">
		<?php if($this->session->userdata('logged_in')){?>
		<ul>
			<li><?=anchor('', 'Home')?></li>
			<li><?=anchor('member', 'Your Dashboard')?></li>
			<li><?=anchor('member/review', 'Reviews')?></li>
			<li><?=anchor('member/blog', 'Blogs')?></li>
			<li><?=anchor('member/project', 'Projects')?></li>
			<li><?=anchor('member/profile/update', 'My profile')?></li>
			<?php if($this->session->userdata('fb_profile')) { ?>
			<li><?=anchor('account/logout_facebook', 'Logout')?></li>
			<?php } else { ?>
			<li><?=anchor('account/logout', 'Logout')?></li>
			<?php } ?>
		</ul>
		<?php }else{?>
		<ul>
			<li><?=anchor('', 'Home')?></li>
            <li><?=anchor('account/login', 'login')?></li>
            <li><?=anchor('account/register', 'sign up')?></li>
		</ul>
		<?php }?>
	</div><!-- #nav 
    -->