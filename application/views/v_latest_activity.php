                                <h2>Latest Activity</h2>
                                <ul>
                                <?php foreach($posts as $r){ print_r($r); ?>
                                
                                    <li>
                                    <?php echo $type_list[$r->type_id];?> - 
                                    <?php
                                    if($r->type_id==1){
                                        $content = $this->m_reviews->read($r->ref_id);
                                        $link = base_url().'review/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==2){
                                        $content = $this->m_blogs->read($r->ref_id);
                                        $link = base_url().'blog/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==3){
                                        $content = $this->m_projects->read($r->ref_id);
                                        $link = base_url().'project/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==4){
                                        $content = $this->m_videos->read($r->ref_id);
                                        $link = base_url().'video/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==5){
                                        $content = $this->m_threads->read($r->ref_id);
                                        $link = base_url().'forum/thread/'.$r->ref_id.'/'.$content->alias;
                                    }elseif($r->type_id==8 || $r->type_id==9){
                                        if($r->type_id==8){
                                        $info = $this->m_likes->read($r->ref_id);
                                        }else{
                                        $info = $this->m_comments->read($r->ref_id);
                                        $user_id = $info->user_id;
                                        }
                                        $post_id = $info->post_id;				
                                        $post_type = $info->post_type;
                                        if(!empty($user_id)){
                                            $user_info = $this->m_accounts->read($user_id);
                                            $link = base_url().'user/'.$user_info->user_name;
                                        }
                                        if($post_type==1){
                                            $content = $this->m_reviews->read($info->post_id);
                                            $link = base_url().'review/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==2){
                                            $content = $this->m_blogs->read($info->post_id);
                                            $link = base_url().'blog/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==3){
                                            $content = $this->m_projects->read($info->post_id);
                                            $link = base_url().'project/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==4){
                                            $content = $this->m_videos->read($info->post_id);
                                            $link = base_url().'video/'.$info->post_id.'/'.$content->alias;
                                        }elseif($post_type==5){
                                            $content = $this->m_threads->read($info->post_id);
                                            $link = base_url().'forum/thread/'.$info->post_id.'/'.$content->alias;
                                        }
                                    }
                                    ?>
                                    
                                    <?php if(!empty($user_id)){ ?>
                                    <a href="<?php echo $link;?>"><?php echo $user_info->user_name;?></a> profile
                                    <?php }else{ ?>
                                    <a href="<?php echo $link;?>"><?php echo $content->title;?></a>
                                    <?php } ?>
                                     - 
                                    <?php echo pretty_date($r->entry_date);?>
                                    </li>
                                    
                                <?php } ?>
                                </ul>
