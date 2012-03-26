	<div id="header">
		<h1 id="logo" class="<?php if((userdata('admin_logged_in'))){ ?> fl <?php } ?>"><a href="<?php echo $admin_link;?>">HuntDrop</a></h1>
    	
        <?php if(userdata('admin_logged_in')){?>
        <div class="fr ta-right">
            <p>You are logged in as : <strong><?php echo userdata('admin_user_name');?></strong></p>
            <p>
            <a class="btn" href="<?php echo base_url();?>">Back to Homepage</a>
            <a class="btn" href="<?php echo $admin_link;?>login/logout">Logout</a>
            </p>
        </div>
            <?php } ?>

        <?php if($this->session->userdata('admin_logged_in')){ ?>
        <ul id="nav" class="clear">
        	<?php $admin_link = base_url().'backadmin/';?>
        	<li><a <?php if(isset($active) && $active=='project'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>project">Hunts</a> | </li>
            <li><a <?php if(isset($active) && $active=='video'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>video">Video</a> | </li>
            <li><a <?php if(isset($active) && $active=='blog'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>blog">Blog</a> | </li>
            <li><a <?php if(isset($active) && $active=='review'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>review">Reviews</a> | </li>
            <li><a <?php if(isset($active) && $active=='forum'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>forum">Forum</a> | </li>
            <li><a <?php if(isset($active) && $active=='comment'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>comment">Comments</a> | </li>
            <li><a <?php if(isset($active) && $active=='contest'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>contest">Contest</a> | </li>
            <li><a <?php if(isset($active) && $active=='article'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>article">Articles</a> | </li>
            <li><a <?php if(isset($active) && $active=='page'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>page">Pages</a> | </li>
            <li><a <?php if(isset($active) && $active=='user'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>user">Hunters</a> | </li>
            <li><a <?php if(isset($active) && $active=='subscription'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>subscription">Subscriptions</a> | </li>
            <li><a <?php if(isset($active) && $active=='config'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>config">Config</a> | </li>
            <li><a <?php if(isset($active) && $active=='advertising'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>advertising">Advertising</a> | </li>
            <li><a <?php if(isset($active) && $active=='banner'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>banner">Banners</a> | </li>
            <li class="last"><a <?php if(isset($active) && $active=='admin'){?>class="active" <?php } ?> href="<?php echo $admin_link;?>admin">Admins</a></li>
            <!-- <li class="last"><a href="<?php echo $admin_link;?>login/logout">Logout</a></li> -->
            <?php } ?>
        </ul>
        
    </div>