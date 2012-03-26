<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <h1>forums</h1>
            <div id="section_left">
                <table class="lists forum_lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <th width=25%>Forum Name</th>
                        <th>Short Desc</th>
                        <th width=15%>Total Threads</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($forums as $i=>$r){ ?>
                    	<tr>
                        	<td><?php echo $i+1;?></td>
                        	<td><?php echo $r->forum_name; ?></td>
                            <td><p><?php echo substr(strip_tags($r->description),0,150);?>...</p></td>
                            <td><?php echo $r->total_threads; ?></td>
                        	<td><a href="<?php echo base_url().'backadmin/forum/update/'.$r->forum_id;?>">edit</a> <a class="delete" href="<?php echo base_url().'backadmin/forum/delete/'.$r->forum_id;?>">del</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            <h1>threads</h1>
                <table class="lists" width="100%">
                    
                   <thead>
                        <th>#</th>
                        <th width=25%>Thread Title</th>
                        <th width=25%>Forum</th>
                        <th>Thread Starter</th>
                        <th>Replies</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($threads as $i=>$r){  ?>
                        <tr>
                            <td><?php echo $i+1;?></td>
                            <td><a href="<?php echo base_url().'forum/thread/'.$r->ref_id;?>" target="_blank"><?php echo $r->title; ?></a></td>
                            <td><?php echo $r->forum_name; ?></td>
                            <td><?php echo $r->user_name; ?></td>
                            <td><?php echo $r->nb_comments; ?></td>
                            <td><a href="<?php echo base_url().'backadmin/forum/thread_update/'.$r->ref_id;?>">edit</a> <a class="delete" href="<?php echo base_url().'backadmin/forum/thread_delete/'.$r->ref_id;?>">del</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
 
                <?php if(isset($this->pager) && ($this->pager->create_links())){ ?>
                <div class="pagination">
                <?php echo $this->pager->create_links(); ?>
                </div>
                <?php } ?>
               
            </div><!-- #section_left -->        
			
            <div id="section_right">
            	<h2>Actions</h2>
                <a class="btn" href="<?php echo base_url().'backadmin/forum/create';?>">create a forum</a>
            </div><!-- #section_right -->  
            
		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>