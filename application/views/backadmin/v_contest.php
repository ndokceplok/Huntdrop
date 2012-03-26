<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <h1>contests</h1>
            <div id="section_left">
                <table class="lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <th width=20%>Title</th>
                        <th>Image</th>
                        <th>Short Desc</th>
                        <th>Total Submissions</th>
                        <th>Deleted</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($contests as $i=>$r){ ?>
                    	<tr>
                        	<td><?php echo $i+1;?></td>
                        	<td><a href="<?php echo base_url().'contest/'.$r->contest_id.'/'.pretty_url($r->title);?>" target="_blank"><?php echo $r->title; ?></a></td>
                            <td><img width="150" src="<?php echo contest_image($r->image);?>" alt="<?=$r->title?>" title="<?=$r->title?>" /></td>
                        	<td><p><?php echo substr(strip_tags($r->content),0,150);?>...</p></td>
                            <td><a href="<?php echo base_url().'backadmin/contest/entries/'.$r->contest_id;?>"><?php echo $r->total_submissions ;?></a></td>
                            <td><?php echo $r->deleted==1?'Deleted'.(!empty($r->deleted_at)?' at<br>'.clean_date($r->deleted_at,'d-m-Y H:i:s'):''):'';?></td>
                        	<td><a href="<?php echo base_url().'backadmin/contest/update/'.$r->contest_id;?>">edit</a> <a class="delete" href="<?php echo base_url().'backadmin/contest/delete/'.$r->contest_id;?>">del</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                
            </div><!-- #section_left -->        
			
            <div id="section_right">
            	<h2>Actions</h2>
                <a class="btn" href="<?php echo base_url().'backadmin/contest/create';?>">create a contest</a>
            </div><!-- #section_right -->  
            
		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>