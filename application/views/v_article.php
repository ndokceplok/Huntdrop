<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl"><?php if(empty($article_id)){?>Articles<?php }else{ echo $articles->title; } ?></span></h1>
                    </div>

                    <div class="content_container box-content">
        		
                        <?php 
                        if(empty($article_id)){ 
                        ?>
                        <ul class="article_list">
                            <?php
                                foreach($articles as $r){ 
                            ?>
                            <li>
                            	<p><a href="<?php echo base_url().'article/'.$r->article_id.'/'.pretty_url($r->title);?>"><?php echo $r->title;?></a></p>
                                <small><?php echo $r->short_desc;?></small>
                            </li>
                            <?php 
                            }
                            ?>
                        </ul>                        
                        <?php
                        }else{
                        
                            echo html_entity_decode($articles->content);
                            
                            echo "<a href='".base_url()."article' class='btn margin-top'>Back to Articles list</a>";
                        }
                        ?>
                
                    </div>
                    
        		</div>

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
