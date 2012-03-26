<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <div id="section_left">
                <h1>users</h1>
				
                <table class="lists" width="100%">
                	
                   <thead>
                    	<th>#</th>
                        <?php if(isset($order) && $order=="asc"){ $order_link = "desc";} else{ $order_link = "asc";} ?>
                        <th><a href="<?php echo $admin_link?>user/by/user_name/<?php echo $order_link;?>">Username</a></th>
                        <th>Name</th>
                        <!-- <th class="center">Photo</th> -->
                        <th>Email</th>
                        <th><a href="<?php echo $admin_link?>user/by/total_posts/<?php echo $order_link;?>">Total Posts</a></th>
                        <th><a href="<?php echo $admin_link?>user/by/join_date/<?php echo $order_link;?>">Join Date</a></th>
                        <th>Status</th>
                        <th>Deleted</th>
                        <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($users as $i=>$r){ ?>
                    	<tr>
                        	<td><?php echo $i+1;?></td>
                        	<td><?php echo $r->user_name; ?></td>
                            <td><?php echo $r->first_name.' '.$r->last_name; ?></td>
                        	<!-- <td class="center"><img src="<?php echo user_image($r->photo);?>" height="60" /></td> -->
                        	<td><?php echo $r->email;?></td>
                        	<td><?php echo $r->total_posts;?></td>
                            <td><?php echo clean_date($r->member_since,'m-d-Y H:i:s');?></td>
                            <td><?php echo (($r->status==0)?'inactive':'');?></td>
                            <td>
                            <?php echo $r->deleted==1?/*'Deleted at<br>'.*/clean_date($r->deleted_at,'d-m-Y H:i:s'):'';?>
                            </td>
                        	<td>
                            <a href="<?php echo $admin_link.'user/update/'.$r->account_id;?>">edit</a> 
                            <?php if($r->deleted==NULL){?>
                            <a class="delete" href="<?php echo $admin_link.'user/delete/'.$r->account_id;?>">del</a>
                            <?php }else{ ?>
                            <a class="undelete" href="<?php echo $admin_link.'user/undelete/'.$r->account_id;?>">undel</a>
                            <?php } ?>
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
                
                <?php echo form_open($admin_link.'user/search',array('class'=>'search_form'));?>
                    <input type="text" name="keyword" placeholder="Search" value="<?php echo !empty($keyword)?$keyword:'';?>" />
                    <input type="submit" value="Go" />
                <?php echo form_close();?>
            </div><!-- #section_right -->  

		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>