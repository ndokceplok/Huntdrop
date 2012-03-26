                            <div class="user_box">
                                <div class="user_image">
                                    <img alt="<?php echo $account->user_name;?>'s avatar" title="<?php echo $account->user_name;?>'s avatar" src="<?php echo user_image($profile->photo);?>" />
                                </div>
                                
                                <div class="user_info">
                                    <h2><?php echo $account->user_name;?></h2>
                                    <p><?php echo $nb_posts;?> posts <br />in <?php echo $nb_days;?> days</p>
                                </div>
                                <br class="clear" />
    
                                <p class="user_links"><a href="<?php echo base_url();?>user/<?php echo $account->user_name;?>">home</a> | <a href="<?php echo base_url();?>project/<?php echo $account->user_name;?>">projects</a> | <a href="<?php echo base_url();?>review/<?php echo $account->user_name;?>">reviews</a></p>
    
                                
                            </div><!-- .user_box-->
