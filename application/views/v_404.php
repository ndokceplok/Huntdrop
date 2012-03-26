<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

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
                  
            <form class="fr search_form" method="post" action="<?php echo base_url();?>search">
                <input type="text" name="q" value="<?php echo isset($qword)?$qword:'';?>" placeholder="Search HuntDrop" />
                <input type="submit" value="GO" />
            </form>
        </div>
    
        <div id="hunter_clipart"><a href="<?php echo base_url();?>"></a></div>
    </div>

    <div id="content">

		<div id="main_section" class="center">
	        <h1 >404 ~ OOPS</h1>		
	        <h2 >Sorry, we can't find what you're looking for!</h2>

            <p>You typed <strong><?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?></strong> but we cannot find it in our website.</p>
            <p>Use our navigation or search bar above to find what you're looking for. </p>
		</div><!-- #main_section -->
	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
