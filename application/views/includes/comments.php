                    <div class="comment_container box-content" id="comments">
                        <!-- <h2 class="center"><?php echo count($comments) ;?> Comment<?php if(count($comments)>1){echo 's';} ?> So Far</h2> -->
                        
                        <?php foreach($comments as $i=>$r){  ?>
                        <div class="comment_item">
                        	<div class="fl">
                                <div class="user_box">
                                    <div class="user_image">
                                        <img alt="<?php echo $r->user_name;?>'s avatar" title="<?php echo $r->user_name;?>'s avatar" src="<?php echo user_image($r->photo);?>" />
                                    </div>
                                    <div class="user_info">
                                        <h2><a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>"><?php echo $r->user_name;?></a></h2>
                                        <p><?php echo $commenter_posts[$i];?> posts <br />in <?php echo $commenter_days[$i];?> days</p>
                                    </div>
                                    <br class="clear" />
        
                                    <p class="user_links"><a href="<?php echo base_url();?>user/<?php echo $r->user_name;?>">home</a> | <a href="<?php echo base_url();?>project/<?php echo $r->user_name;?>">projects</a> | <a href="<?php echo base_url();?>review/<?php echo $r->user_name;?>">reviews</a></p>
                                    
                                </div><!-- .user_box-->
                                <p class="time"><?php echo pretty_date($r->entry_date);?></p>
                            </div>
                            
                            <div class="comment_text">
                            	<p><?php echo $r->hidden==0?nl2br($r->content):'<em>This comment is removed</em>';?></p>
                                
                                <p class="signature">--<?php echo $r->signature;?></p>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <h2 class="center">Leave Your Comments Here</h2>
                        <?php if($this->session->userdata('logged_in')){ ?>
                        <div class="comment_item">
                        	<div class="fl">
                                <div class="user_box">
                                    <div class="user_image">
                                        <img alt="<?php echo $loggedin_account->user_name;?>'s avatar" title="<?php echo $loggedin_account->user_name;?>'s avatar" src="<?php echo user_image($loggedin_profile->photo);?>" />
                                    </div>
                                    
                                    <div class="user_info">
                                        <h2><?php echo $loggedin_account->user_name;?></h2>
                                        <p><?php echo $loggedin_posts;?> posts <br />in <?php echo $loggedin_days;?> days</p>
                                    </div>
                                    <br class="clear" />
        
                                    <p class="user_links"><a href="<?php echo base_url();?>user/<?php echo $loggedin_account->user_name;?>">home</a> | <a href="<?php echo base_url();?>project/<?php echo $loggedin_account->user_name;?>">projects</a> | <a href="<?php echo base_url();?>review/<?php echo $loggedin_account->user_name;?>">reviews</a></p>
                                    
                                </div><!-- .user_box-->
                            </div>
                            
                            <div class="comment_text">
								<?php echo form_open('comment/create');?>
                                    
                                    <?php if(isset($post_type)){ ?>
                                    <input id="post_type" name="post_type" value="<?php echo $post_type;?>" type="hidden">
                                    <input id="post_id" name="post_id" value="<?php echo $post->ref_id;?>" type="hidden">
                                    <input id="target" name="target" value="1" type="hidden">
                                    <?php }?>
                                    
                                    <?php if(isset($user_comment)){ ?>
                                    <input id="user_id" name="user_id" value="<?php echo $account->ID;?>" type="hidden">
                                     <input id="target" name="target" value="2" type="hidden">
                                   
                                    <?php } ?>
                                    <textarea name="comment"></textarea>
                                    
                                    <p><input type="submit" class="btn" value="Submit" /></p>
                        
                                <?php echo form_close();?>
                            </div>
                        </div>
                        <?php }else{ ?>
                        <p>You have to log in to comment</p>
                        <?php } ?>
                   	</div>
