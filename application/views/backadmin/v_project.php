<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <h1>projects <?php echo !empty($keyword)?'with keyword "'.$keyword.'"':'';?></h1>
            <div id="section_left">
				
                <table class="lists" width="100%">
                	
                    <thead>
                    	<th>#</th>
                        <th>User</th>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Deleted</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($projects as $i=>$r){ ?>
                    	<tr>
                        	<td><?php echo $i+1;?></td>
                        	<td><?php echo $r->user_name; ?></td>
                        	<td><a href="<?php echo base_url().'project/'.$r->project_id.'/'.pretty_url($r->title);?>" target="_blank"><img src="<?php echo content_thumb($r->thumb);?>" height="60" /></a></td>
                        	<td><a href="<?php echo base_url().'project/'.$r->project_id.'/'.pretty_url($r->title);?>" target="_blank"><?php echo $r->title;?></a></td>
                            <td><?php echo $r->post_deleted==1?'Deleted by <strong>'.($r->deleted_by=='-1'?'admin':$r->deleter).'</strong>'.(!empty($r->deleted_at)?' at<br>'.clean_date($r->deleted_at,'d-m-Y H:i:s'):''):'';?></td>
                        	<td>
                            <a href="<?php echo $admin_link.'project/update/'.$r->project_id;?>">edit</a> 
                            <a class="delete" href="<?php echo $admin_link.'project/delete/'.$r->project_id;?>">del</a>
                            </td>
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
                
               	<?php echo form_open($admin_link.'project/search',array('class'=>'search_form'));?>
                	<input type="text" name="keyword" placeholder="Search" value="<?php echo !empty($keyword)?$keyword:'';?>" />
                    <input type="submit" value="Go" />
                <?php echo form_close();?>
            </div><!-- #section_right -->  

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>