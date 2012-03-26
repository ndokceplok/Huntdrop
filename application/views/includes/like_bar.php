								<?php 
								//$this->load->model('m_likes');
								//$has_like =	$this->m_likes->check_like($this->session->userdata('user_id'),$post_type,$post->ID);
								?>
								
                                <div class="like_bar">
								<?php if($this->session->userdata('logged_in')){ ?>
									<?php if($can_like){ ?>
										<?php if($has_like){ ?>
                                        <p><span class="small_log">You Like This</span></p>
                                        <?php }else{ ?>
                                        <a data-type="<?php echo $post_type;?>" id="<?php echo $id;?>" class="like btn" href="#">Like</a>
                                        <?php } ?>
									<?php }else{ ?>
                                    <p>You cannot like your own post</p>
                                    <?php } ?>
                                <?php }else{ ?>
                                <a class="btn" href="<?php echo base_url();?>account/login">Like</a>  		                              	
								<?php } ?>
                                </div>
