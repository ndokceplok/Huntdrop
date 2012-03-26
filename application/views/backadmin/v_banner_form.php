<?php $this->load->view('includes/backadmin/_top.php');?>
<!--additional css and js here -->
<script>
$(document).ready(function(){
  $('.date').datepicker({dateFormat:'yy-mm-dd'});

  $("#form").validationEngine();
  $("#form").submit(function(){
    if($('#banner_start_date').val() > $('#banner_end_date').val()){
      alert('Start date must not be earlier than end date');
      return false;
    }
  });

  $('.delete_image').click(function(e){
      $this = $(this);
      e.preventDefault();
      var a = confirm("Are you sure you want to delete this banner image ?");
      if(a){
          $.ajax({
           type: "POST",
           url: base_url+'backadmin/banner/remove_banner_image',
           data: {banner_id: $(this).attr('id')},
           success: function(msg){
               //alert($('#youtube_id').siblings('.status').html('That is'));
               if(msg=='failed'){
                  alert('Sorry, cannot delete this image at this moment. Please try again.')
               }else{

                  $this.siblings('img').fadeOut(500,function(){
                      $(this).remove();
                  });
                  $this.fadeOut(500,function(){
                      the_id = $this.parent().prev('label').attr('for');
                      $('<input type="file" name="'+the_id+'" id="'+the_id+'">').appendTo($this.parent());
                      
                      $(this).remove();
                  });

              }
               
           }
          });
      }
  });

  $('input[type=text],select').focus(function(){
    $(this).siblings('span').fadeIn();
  });

  $('input[type=text],select').blur(function(){
    $(this).siblings('span').fadeOut();
  });
  
});
</script>
<?php $this->load->view('includes/backadmin/_meta.php');?>

<?php $this->load->view('includes/backadmin/header.php');?>


  <div id="content">
    
        <div id="main_section">
        
            <?php if($action=="add"){?>
                <h1>add a banner</h1>
                <?php }else{ ?>
                <h1>Edit banner : <?php echo $banner_info->banner_title;?></h1>
                <?php } ?>
        
            <?php if($this->session->flashdata('log')){echo '<div class="log">'.$this->session->flashdata('log').'</div>';}?>
            <?php 
                if($action=="add"){
                 echo form_open_multipart('backadmin/banner/create_exec',array('id'=>'form'));
                }else{ 
                 echo form_open_multipart('backadmin/banner/update_exec',array('id'=>'form'));
                } 
                ?>

                <label for="banner_position">Position</label>
                <p>
                <select name="banner_position" id="banner_position" class="validate[required]">
                  <option value="">None</option>
                  <?php 
                    foreach($banner_positions as $r):
                  ?>
                    <option <?php if($action=="edit" && $r==$banner_info->banner_position){?> selected="selected" <?php } ?> value="<?php echo $r;?>"><?php echo $r;?></option>
                  <?php endforeach; ?>
                </select>
                </p>

                <label for="banner_page">Page</label>
                <p>
                <select name="banner_page" id="banner_page" class="validate[required]">
                  <option value="">None</option>
                  <?php 
                    foreach($banner_pages as $r):
                  ?>
                    <option <?php if($action=="edit" && $r==$banner_info->banner_page){?> selected="selected" <?php } ?> value="<?php echo $r;?>"><?php echo $r;?></option>
                  <?php endforeach; ?>
                </select>
                <span class="hidden tips">home or anywhere else</span>
                </p>

<!--                 <label for="banner_type">Type</label>
                <p>
                <select name="banner_type" id="banner_type" class="validate[required]">
                  <option value="">None</option>
                  <?php 
                    foreach($banner_types as $r):
                  ?>
                    <option <?php if($action=="edit" && $r==$banner_info->banner_type){?> selected="selected" <?php } ?> value="<?php echo $r;?>"><?php echo $r;?></option>
                  <?php endforeach; ?>
                </select>
                </p>

 -->
                <label for="banner_title">Title</label>
                <p><input type="text" id="banner_title" name="banner_title" value="<?php echo $action=="add"? set_value('banner_title'): $banner_info->banner_title ?>" ></p>

                <label for="banner_start_date">Banner Start Date</label>
                <p><input type="text" class="date validate[required]" id="banner_start_date" name="banner_start_date" value="<?php echo $action=="add"? set_value('banner_start_date'): $banner_info->banner_start_date ?>" ></p>

                <label for="banner_end_date">Banner End Date</label>
                <p><input type="text" class="date validate[required]" id="banner_end_date" name="banner_end_date" value="<?php echo $action=="add"? set_value('banner_end_date'): $banner_info->banner_end_date ?>" ></p>

                <label for="photo">Image</label>
                
                <p>
                <?php if(!empty($banner_info->banner_image)){ ?>
                
                <img height="150" src="<?php echo banner_image($banner_info->banner_image);?>" alt="<?=$banner_info->banner_title?>" title="<?=$banner_info->banner_title?>" />
                <a id="<?php echo $banner_info->banner_id;?>" href="#" class="delete_image alert" >Remove Image</a>
                <?php }else{ ?>
                <input type="file" id="photo" name="photo" />
                <span class="tips">banner dimension -> top banner: 1000x150px &bull; sidebar: 170x250px &bull; home sidebar:360x300px </span>
                <?php } ?>
                </p>

                <label for="banner_link">Banner Link</label>
                <p>
                <input type="text" class="validate[required]" id="banner_link" name="banner_link" value="<?php echo $action=="add"? set_value('banner_link'): $banner_info->banner_link ?>" >  
                <span class="hidden tips">don't forget the http://</span>
                </p>

                <?php if($action=="edit"){ ?>
                <label for="banner_status">Banner Status</label>
                <p>
                <label><input type="checkbox" id="banner_status" name="banner_status" value="1" <?php if($banner_info->banner_status==1){?> checked="checked" <?php } ?> >  Active</label>
                <span class="tips">Unchecking this will disable the banner even if the banner is still active</span>
                </p>
                <?php } ?>
               
                <?php 
                if($action=="edit"){ 
                echo form_hidden('banner_id', $banner_info->banner_id);
                }
                ?>
                
                <input class="btn" type="submit" name="submit" value="<?php echo $action=="add"? 'add': 'update'?>" /> 
                <a href="<?php echo $admin_link.'banner';?>" class="btn">Cancel</a>
                
                <?=form_close()?>


    </div><!-- #main_section -->        

  </div><!-- #content -->
  

<?php $this->load->view('includes/backadmin/_bottom.php');?>