<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <h1>subscribers</h1>
            <div id="section_left">
				
                <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>
                <table class="lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <th>Email</th>
                        <th>Delete</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($subscriptions as $i=>$r){  ?>
                        <tr>
                            <td><?php echo $i+1;?></td>
                            <td><a href="mailto:<?php echo $r->email;?>"><?php echo $r->email; ?></a></td>
                            <td><a href="<?php echo $admin_link;?>subscription/delete/<?php echo $r->ID;?>" class="delete">del</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                
            </div><!-- #section_left -->        

            <div id="section_right">
                <h2>Actions</h2>
                <!-- <a href="" class="btn">Delete all invalid email</a> -->
            </div><!-- #section_right -->  

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>