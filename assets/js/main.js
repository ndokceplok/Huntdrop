// JavaScript Document

$(document).ready(function(){
	$(".my_huntdrop").click(function(){
		$(this).parent().siblings('.hidden').fadeIn('fast',function(){
			$('body').click(function(){
				$(".my_huntdrop").parent().siblings('.hidden').fadeOut('fast');
			});
		});
		return false;
	});
	
	$('.trigger').click(function(){
		var el = $(this).siblings('.popup');
		el.fadeIn(500);			


		return false;
	});

	$('.popup .close').live('click',function(){
		$(this).parent('.popup').fadeOut(580);
	});

	$('.subscription-form').submit(function(){
		//alert('success');
		var $this = $(this);
		if($this.find('.subscribe-email').val()==''){
			alert('Please input your email');
			return false;
		}
		$.ajax({
		   type: "POST",
		   url: base_url+"main/save_subscription",
		   data: "email="+$('.subscribe-email').val(),
		   success: function(html){
		   		if(html=='exist'){
		   			alert('You have already subscribed to us');
		   		}else if(html=='invalid'){
		   			alert('Please supply the valid email');
		   			return;
		   		}
					$this.fadeOut(500,function(){
						$this.parent().prepend('<p>Thanks for the subscription</p>');
						$this.remove();
					});		   			   			
		   }
		 });

		return false;
	})

});
