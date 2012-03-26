<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function() {
    $('.edit').editable('<?php echo $admin_link;?>comment/update', { 
         cancel    : 'Cancel',
         submit    : 'OK',
         type:'textarea',
         rows : 1,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         cssclass  : 'inline',
    });


  $('.confirm').live('click',function(){
    var conf = confirm('Are you sure you want to hide/show this comment?');
    if(conf){
      
      var el = $(this);
      var current_status;
      if(el.hasClass('show')){
        current_status = 'hidden';
      }else{
        current_status = 'shown';
      }
      var the_url = el.attr('href');

      $.ajax({
        type: "POST",
        url: the_url,
        success: function(html){
          if(html=='success'){
            //if current_status = hidden , change to shown
            if(current_status=='hidden'){
              el.text('hide');
              el.removeClass('show').addClass('hide');  
              el.attr('href',the_url.replace('show','hide'));
            }else{
              el.text('show');
              el.removeClass('hide').addClass('show');
              el.attr('href',the_url.replace('hide','show'));
            }
          }else{
            alert('Something\'s wrong. Please try again.');
          }
        }
      });

    }
    return false;

  });

});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


  <div id="content">
    
        <div id="main_section">
        
            <h1>comments</h1>
            <div id="section_left">
        
                <p>Click the value of comment to edit it</p>

                <p class="stat_bar">
                Show only : 
                <a <?php if(empty($only)){ ?> class="selected" <?php } ?> href="<?php echo $this->admin_link.'comment';?>">all</a>
                <a <?php if($only=='project'){ ?> class="selected" <?php } ?> href="<?php echo $this->admin_link.'comment/only/project';?>">projects</a>
                <a <?php if($only=='blog'){ ?> class="selected" <?php } ?> href="<?php echo $this->admin_link.'comment/only/blog';?>">blogs</a>
                <a <?php if($only=='review'){ ?> class="selected" <?php } ?> href="<?php echo $this->admin_link.'comment/only/review';?>">reviews</a>
                <a <?php if($only=='video'){ ?> class="selected" <?php } ?> href="<?php echo $this->admin_link.'comment/only/video';?>">videos</a>
                <a <?php if($only=='profile'){ ?> class="selected" <?php } ?> href="<?php echo $this->admin_link.'comment/only/profile';?>">profile</a>
                <a <?php if($only=='thread'){ ?> class="selected" <?php } ?> href="<?php echo $this->admin_link.'comment/only/thread';?>">thread</a>
                </p>
                <table class="lists" width="100%">
                  
                    <thead>
                      <th>#</th>
                      <th>User</th>
                      <th width=40%>Comment</th>
                      <th>Post Type</th>
                      <th>Post Title</th>
                      <th>Options</th>
                    </thead>
                    
                    <tbody>
                    <?php foreach($comments as $i=>$r){  ?>
                      <tr>
                          <td><?php echo $i+1;?></td>
                          <td><?php echo $r->user_name; ?></td>
                          <td><p id="<?php echo $r->ID;?>" class="edit"><?php echo nl2br($r->content); ?></p></td>
                          <td><?php if(!empty($r->post_type)){ echo $type_label[$r->post_type]; }else{ echo 'profile'; } ?></td>
                          <td><a target="_blank" href="<?php echo base_url(); if(!empty($r->post_type)){ echo $type_label[$r->post_type].'/'.$r->post_id.'/'; }else{ echo 'user/'.$r->whose_profile; } ?>"><?php if(!empty($r->post_type)){ echo $type_label[$r->post_type]; }else{ echo $r->whose_profile.'\'s profile'; } ?></a></td>
                          <td>
                            <?php if($r->hidden==1){ $c_toggle = 'show';}else{ $c_toggle = 'hide';} ?>
                            <a class="btn confirm <?php echo $c_toggle;?>" href="<?php echo $admin_link.'comment/'.$c_toggle.'/'.$r->ID;?>"><?php echo $c_toggle;?></a>
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
                
                <!--<?php echo form_open($admin_link.'comment/search',array('class'=>'search_form'));?>
                  <input type="text" name="keyword" placeholder="Search" value="<?php echo !empty($keyword)?$keyword:'';?>" />
                    <input type="submit" value="Go" />
                <?php echo form_close();?>-->
            </div><!-- #section_right -->  

    </div><!-- #main_section -->        

  </div><!-- #content -->
  

<?php $this->load->view('includes/backadmin/_bottom.php');?>