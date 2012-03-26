<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function() {
    $('.edit').editable('<?php echo $admin_link;?>config/update', { 
         cancel    : 'Cancel',
         submit    : 'OK',
         type:'textarea',
         rows : 1,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         cssclass  : 'inline',
    });
});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


	<div id="content">
		
        <div id="main_section">
        
            <h1>site configs</h1>
            <div id="section_left">
                <p>Click the value of each to edit</p>
                <table class="lists" width="100%">
                	
                   <thead>
                        <th width="12%">Parameter</th>
                        <th>Value</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($configs as $i=>$r){ ?>
                    	<tr>
                        	<td><?php echo $r->key; ?></td>
                            <td><p id="<?php echo $r->key;?>" class="edit"><?php echo $r->value; ?></p></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                
            </div><!-- #section_left -->        
			
            <div id="section_right">
            </div><!-- #section_right -->  
            
		</div><!-- #main_section -->        

	</div><!-- #content -->
	

<?php $this->load->view('includes/backadmin/_bottom.php');?>