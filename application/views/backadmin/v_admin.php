<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
                <h1>admins</h1>
				
                <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>
                <table class="lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <th>Username</th>
                        <th>Group</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($admins as $i=>$r){  ?>
                        <?php 
                        if(userdata('admin_group')!='superadmin'){
                            // if not superadmin, the admin who's logged in can only edit his acount
                            if($r->ID == userdata('admin_id')){
                            ?>
                        	<tr>
                            	<td><?php echo $i+1;?></td>
                            	<td><?php echo $r->user_name; ?></td>
                                <td><?php echo $r->user_group; ?></td>
                            	<td>
                                    <a href="<?php echo base_url().'backadmin/admin/update/'.$r->ID;?>">edit</a>
                                </td>
                            </tr>
                            <?php
                            }
                        }else{
                        ?>
                            <tr>
                                <td><?php echo $i+1;?></td>
                                <td><?php echo $r->user_name; ?></td>
                                <td><?php echo $r->user_group; ?></td>
                                <td>
                                    <a href="<?php echo base_url().'backadmin/admin/update/'.$r->ID;?>">edit</a>
                                    <?php if($r->ID!=1){?><a class="delete_admin" href="<?php echo base_url().'backadmin/admin/delete/'.$r->ID;?>">del</a><?php } ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    <?php } ?>
                    </tbody>
                </table>
                
            </div><!-- #section_left -->        

            <div id="section_right">
                <h2>Actions</h2>
                <?php if(userdata('admin_group')=='superadmin'){ ?>
                <a class="btn" href="<?php echo base_url().'backadmin/admin/create';?>">add an admin</a>
                <?php } ?>
            </div><!-- #section_right -->  

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>