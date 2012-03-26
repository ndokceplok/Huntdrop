</div><!--#wrapper-->
<!--additional js here -->
	<script type="text/javascript" src="<?=assets_url()?>js/main.js"></script>
    <?php 
		if(isset($add_js)){ 
		foreach($add_js as $r){
	?>
	<script type="text/javascript" src="<?=assets_url()?>js/<?php echo $r;?>.js"></script>
    <?php
		}
		} 
	?>

	<?php if(!empty($this->analytics)){?>
	<!-- DISABLE GA for localhost
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '<?php echo $this->analytics;?>']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>-->
	<?php }?>
    </body>
</html>