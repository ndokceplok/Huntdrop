<?php $this->load->view('includes/backadmin/_top.php');?>
<script>
$(document).ready(function(){

});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
                <h1><?php echo $request_info->requester_name;?></h1>

                <p>Date : <?php echo clean_date($request_info->request_date);?></p>

                <p>Name : <?php echo $request_info->requester_name;?></p>
                <p>Email : <?php echo $request_info->requester_email;?></p>
                <p>Inquiry : </p>
                <p class="hilite"><?php echo nl2br($request_info->inquiry);?></p>

                <p>Sent from IP <?php echo $request_info->requester_ip;?></p>

                <a class="btn" href="<?php echo $admin_link; ?>advertising">Back</a>
                

            </div><!-- #section_left -->        

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>