<?php $this->load->view('includes/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/_meta.php');?>

<?php $this->load->view('includes/header.php');?>
	
                <div class="box">
                    <div class="box-heading red">
                        <h1><span class="title fl">About Us</span></h1>
                    </div>

                    <div class="content_container box-content">

                        <ul class="tabs">
                            <?php 
                            foreach($pages as $i=>$r){
                                echo "<li><a href='#tab".($i+1)."'>".$r->title."</a></li>";
                            }
                            ?>
                        </ul>
                        
                        <div class="tab_container">
                            <?php 
                            foreach($pages as $i=>$r){
                            ?>
                                <div id="tab<?php echo ($i+1);?>" class="tab_content">
                                    <h2><?=$r->title;?></h2>
                                    <?=$r->content?>
                                    <!--Content-->
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>


            </div><!-- #section_left -->        

			<?php include('includes/section_right.php');?>
		</div><!-- #main_section -->        

	</div><!-- #content -->

<?php $this->load->view('includes/footer.php');?>

<?php $this->load->view('includes/_bottom.php');?>
