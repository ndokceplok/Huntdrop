<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


    <div id="content">
        
        <div id="main_section">
        
            <h1>contests result/entries</h1>
            <div id="section_left">

                <p><a href="<?php echo $admin_link.'contest';?>" class="btn">Back</a></p>

                <table id="winners_list" class="lists" width="100%">
                <thead>
                    <th width="10%">Pos</th>
                    <th colspan="2">Project</th>
                    <th width="10%" class="center">Votes</th>
                </thead>
                <tbody>
                <?php foreach($submissions as $i=>$r){?>
                    <tr>
                        <td><?php echo $i+1;?>.</td>
                        <td class="entry_thumb"><a target="_blank" href="<?php echo base_url().'project/'.$r->project_id.'/'.pretty_url($r->title);?>"><img src="<?php echo content_thumb($r->thumb);?>" height="60" /></a></td>
                        <td>
                        <p><a target="_blank" href="<?php echo base_url().'project/'.$r->project_id.'/'.pretty_url($r->title);?>"><?php echo $r->title;?></a></p>
                        <p>by <a target="_blank" href="<?php echo base_url().'user/'.$r->user_name;?>"><?php echo $r->user_name;?></a></p>
                        </td>
                        <td class="vote"><?php echo $r->total_votes;?></td>
                    </tr>

                <?php } ?>
                </tr>
                </table>
                
            </div><!-- #section_left -->        
            
            <div id="section_right">
                <h2>Actions</h2>
                <a class="btn" href="<?php echo base_url().'backadmin/contest/create';?>">create a contest</a>
            </div><!-- #section_right -->  
            
        </div><!-- #main_section -->        

    </div><!-- #content -->
    

<?php $this->load->view('includes/backadmin/_bottom.php');?>