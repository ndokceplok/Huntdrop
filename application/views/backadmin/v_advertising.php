<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <h1>advertise requests</h1>
            <div id="section_left">
				
                <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>
                <table class="lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($requests as $i=>$r){  ?>
                        <tr>
                            <td><?php echo $i+1;?></td>
                            <td><?php echo clean_date($r->request_date); ?></td>
                            <td><?php echo $r->requester_name; ?></td>
                            <td><a href="mailto:<?php echo $r->requester_email;?>"><?php echo $r->requester_email; ?></a></td>
                            <td><strong><?php echo ($r->request_read==0?'Unread':'Read'); ?></strong></td>
                            <td>
                                <a href="<?php echo base_url().'backadmin/advertising/read/'.$r->request_id;?>">read</a>
                                <a class="delete_admin" href="<?php echo base_url().'backadmin/advertising/delete/'.$r->request_id;?>">del</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                
            </div><!-- #section_left -->        

            <div id="section_right">
                <h2>Actions</h2>
            </div><!-- #section_right -->  

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>