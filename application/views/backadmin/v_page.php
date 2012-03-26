<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <h1>pages</h1>
            <div id="section_left">
                <table class="lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <th>Title</th>
                        <th>Parent</th>
                        <th>Short Desc</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($pages as $i=>$r){ ?>
                    	<tr>
                        	<td><?php echo $i+1;?></td>
                        	<td><?php echo $r->title; ?></td>
                            <td><?php echo $r->parent_name; ?></td>
                            <td><p><?php echo substr(strip_tags($r->content),0,150);?>...</p></td>
                        	<td><a href="<?php echo base_url().'backadmin/page/update/'.$r->page_id;?>">edit</a> <a class="delete" href="<?php echo base_url().'backadmin/page/delete/'.$r->page_id;?>">del</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                
            </div><!-- #section_left -->        
			
            <div id="section_right">
            	<h2>Actions</h2>
                <a class="btn" href="<?php echo base_url().'backadmin/page/create';?>">create a page</a>
            </div><!-- #section_right -->  
            
		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>