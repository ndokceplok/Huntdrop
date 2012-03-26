<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl"><?php echo $title;?></span></h1>
                    </div>

                    <div class="content_container box-content">

                        <div class="fl">
                        	<?php $this->load->view('includes/contest_sidebar.php');?>
                        </div><!-- .user_box-->

                        <div class="content_box">

                            <h2>Contest Entries</h2>

                        	<ul id="entries_list">
							<?php foreach($submissions as $r){?>
                            	<li>
                                	<p class="entry_thumb"><a target="_blank" href="<?php echo base_url().'project/'.$r->project_id.'/'.pretty_url($r->title);?>"><img src="<?php echo content_thumb($r->thumb);?>" /></a></p>
                                    <p><a target="_blank" href="<?php echo base_url().'project/'.$r->project_id.'/'.pretty_url($r->title);?>"><?php echo $r->title;?></a></p>
                                    <p>by <a target="_blank" href="<?php echo base_url().'user/'.$r->user_name;?>"><?php echo $r->user_name;?></a></p>
                                </li>

                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                    
        		</div>

            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
