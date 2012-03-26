<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	

                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl">Contest</span></h1>
                    </div>

                    <div class="content_container box-content">
                        <?php
                            if(count($contests)==0){
                        ?>
                            <p class="no-item">There are no contests yet.</p>
                        <?php  
                            }else{
                        ?>
                        <ul id="contest_list">
                            <?php foreach ($contests as $i=>$r): ?>
                            	<?php $contest_link = base_url().'contest/'.$r->contest_id.'/'.pretty_url($r->title);?>
                                <li>
                                <p><a href="<?php echo $contest_link;?>"><img src="<?php echo base_url().'uploads/contest/'.$r->image;?>" /></a></p>
                                <p><a href="<?php echo $contest_link;?>"><?php echo $r->title;?></a></p>
                                <p>entry dates : <?php echo clean_date($r->submission_start_date).' - '.clean_date($r->submission_end_date);?></p>
                                <p>vote dates : <?php echo clean_date($r->voting_start_date).' - '.clean_date($r->voting_end_date);?></p>
                                <p><a href="<?php echo $contest_link;?>">view details</a></p>
                                <?php if(date('Y-m-d')>$r->submission_start_date && date('Y-m-d')<$r->submission_end_date){ ?>
                                <p class="tx_red">in progress</p>
                                <?php } ?>
                                <?php if(date('Y-m-d')>$r->submission_end_date){ ?>
                                <p class="tx_red">contest ends!</p>
                               <?php } ?>

                                <?php if(date('Y-m-d')>$r->voting_start_date && date('Y-m-d')<$r->voting_end_date){ ?>
                                <p class="tx_red">voting starts!</p>
                                <?php } ?>
                                <?php if(date('Y-m-d')>$r->voting_end_date){ ?>
                                <p class="tx_red">voting ends!</p>
                               <?php } ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
        			    <?php
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
