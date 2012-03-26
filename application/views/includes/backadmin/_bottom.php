</div><!--#wrapper-->
<!--additional js here -->
	<script type="text/javascript" src="<?=assets_url()?>js/backadmin/main.js"></script>
    <?php 
		if(isset($add_js)){ 
		foreach($add_js as $r){
	?>
	<script type="text/javascript" src="<?=assets_url()?>js/<?php echo $r;?>.js"></script>
    <?php
		}
		} 
	?>
    </body>
</html>