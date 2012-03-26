// JavaScript Document
$(document).ready(function(){

	$('.random_thumbs a').live('click',function(){
		var el = $(this).children('img');
		if(!el.hasClass('active')){
			$('.random_thumbs a').each(function(){
				//alert($(this).html());
				$(this).children('img').css({'opacity' :0.6}).removeClass('active');
			});
	
			el.css({'opacity' :1}).addClass('active');
			this_image = el.attr('src');
			this_big_image = el.attr('data-big-image');
			this_link = el.parent().attr('href');
			this_alt = el.attr('alt');
			this_title = el.attr('title');
			el.parents('.random_text').siblings('.random_big_image').fadeOut(function(){
				$(this).children('a').attr('href',this_link);
				$(this).children('a').children('img').attr('src',this_big_image);
				$(this).children('a').children('img').attr('alt',this_alt);
				$(this).children('a').children('img').attr('title',this_title);
				$(this).children('a').children('.random_big_image_caption').text(this_title);
				$(this).fadeIn();  
			});
		}
		//$(this).parents('.random_text').siblings('.random_big_image').attr('src',this_image);
		//alert($(this).attr('src'));
		
		return false;
	});

	$('.random_thumbs a img:not(.active)').live('mouseover mouseout',function(event){
		if ( event.type == "mouseover" ) {
			// do something on mouseover
			$(this).stop().animate({'opacity' :1},500);
		} else {
			// do something on mouseout
			$(this).stop().animate({'opacity' :0.6},500);		
		}
		
	});
	
	$('.random_btn').click(function(){
		$(this).hide().next('.hidden').show();
		//alert(base_url+"main/get_random");
		$.ajax({
		   type: "POST",
		   dataType : "json",
		   url: base_url+"main/get_random_user",
           data: "not="+$('.random_id').attr('id'),
		   success: function(data){
			 $('.user_link').attr('title','View the profile of '+data.random_user.first_name+' '+data.random_user.last_name);
			 $('.user_link').attr('href',base_url+'user/'+data.random_user.user_name);
			 $('.user_link span').html(data.random_user.user_name);
			 $('.random_id').attr('id',data.random_user.account_id);
			 $('.random_project_count').attr('href',base_url+'project/'+data.random_user.user_name);
			 $('.random_project_count span').text(data.count_random_user_projects);
			 $('.random_photo img').attr('src',data.random_photo);
			 $('.random_big_image').html(data.random_big_image);
			 $('.random_thumbs').html(data.random_thumbs);
			 $('.loading').hide().prev('.random_btn').show();
		   }
		 });
		
		return false;
	});
	
	$('.carou').jcarousel({
		visible : 3,
		animation: "slow"
	});

});
