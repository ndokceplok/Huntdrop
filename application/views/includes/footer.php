	<div id="footer">
         <ul id="footer_nav">
        	<li><a href="<?php echo base_url();?>">Home</a> | </li>
        	<li><a <?php if(isset($active) && $active=='project'){?>class="active" <?php } ?> href="<?php echo base_url();?>project">Hunts</a> | </li>
            <li><a <?php if(isset($active) && $active=='video'){?>class="active" <?php } ?> href="<?php echo base_url();?>video">Video</a> | </li>
            <li><a <?php if(isset($active) && $active=='blog'){?>class="active" <?php } ?> href="<?php echo base_url();?>blog">Blog</a> | </li>
            <li><a <?php if(isset($active) && $active=='forum'){?>class="active" <?php } ?> href="<?php echo base_url();?>forum">Forum</a> | </li>
            <li><a <?php if(isset($active) && $active=='contest'){?>class="active" <?php } ?> href="<?php echo base_url();?>contest">Contest</a> | </li>
            <li><a href="">Articles</a> | </li>
            <li><a <?php if(isset($active) && $active=='review'){?>class="active" <?php } ?> href="<?php echo base_url();?>review">Product Reviews</a> | </li>
            <!--<li><a <?php if(isset($active) && $active=='help'){?>class="active" <?php } ?> href="<?php echo base_url();?>help">How To's</a> | </li>-->
            <li><a <?php if(isset($active) && $active=='user'){?>class="active" <?php } ?> href="<?php echo base_url();?>user">Hunters</a> | </li>
            <li><a href="<?php echo base_url();?>user/by/online">Who's Dropping</a> | </li>
            <li><a <?php if(isset($active) && $active=='about'){?>class="active" <?php } ?> href="<?php echo base_url();?>about">About Us</a> | </li>
            <li><a <?php if(isset($active) && $active=='help'){?>class="active" <?php } ?> href="<?php echo base_url();?>help">Help</a> | </li>
            <li class="last"><a <?php if(isset($active) && $active=='advertise'){?>class="active" <?php } ?>  href="<?php echo base_url();?>advertise">Advertise</a></li>
        </ul>
		<p>Copyright &copy; 2011 - All Rights Reserved</p>
	</div><!-- #footer -->