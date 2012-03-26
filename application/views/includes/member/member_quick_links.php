<p class="stat_bar">
    View my : 
    <a <?php if($ql_active=="dashboard"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/">Dashboard</a>
    <a <?php if($ql_active=="blog"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/blog">Blogs</a>
    <a <?php if($ql_active=="project"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/project">Projects</a>
    <a <?php if($ql_active=="review"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/review">Reviews</a>
    <a <?php if($ql_active=="video"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/video">Videos</a>
    <a <?php if($ql_active=="forum"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/forum">Forum Threads</a>
    <a <?php if($ql_active=="message"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/message">Messages</a>
    <a <?php if($ql_active=="friend"){ echo "class='selected'"; } ?> href="<?php echo base_url();?>member/friend">Friends</a>
</p>
