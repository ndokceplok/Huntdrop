<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
                <h1>banner management</h1>
				
                <?php if($this->session->flashdata('log')){echo '<p class="log">'.$this->session->flashdata('log').'</p>';}?>
                <table class="lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <th>Title</th>
                        <th>Thumbnail</th>
                        <th>Page</th>
                        <th>Position</th>
                        <th>Active Date</th>
                        <th>Status</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($banners as $i=>$r){  ?>
                        <tr>
                            <td><?php echo $i+1;?></td>
                            <td><?php echo $r->banner_title; ?></td>
                            <td><img width="200" src="<?php echo banner_image($r->banner_image); ?>"></td>
                            <td><?php echo $r->banner_page; ?></td>
                            <td><?php echo $r->banner_position; ?></td>
                            <td><?php echo $r->banner_start_date .' - '.$r->banner_end_date; ?></td>
                            <td>
                                <?php echo $r->banner_status==1?'active':'inactive'; ?>
                                <?php if(date('Y-m-d H:i:s')>$r->banner_end_date){?>
                                <p><strong class="tx_red">expired</strong></p>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url().'backadmin/banner/update/'.$r->banner_id;?>">edit</a>
                                <a class="delete_admin" href="<?php echo base_url().'backadmin/banner/delete/'.$r->banner_id;?>">del</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                
            </div><!-- #section_left -->        

            <div id="section_right">
                <h2>Actions</h2>
                <?php if(userdata('admin_group')=='superadmin'){ ?>
                <a class="btn" href="<?php echo base_url().'backadmin/banner/create';?>">add a banner</a>
                <?php } ?>
            </div><!-- #section_right -->  

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>