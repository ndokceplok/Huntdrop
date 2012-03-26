$(function(){
	$('.unlike').click(function(){
		$(this).remove();

		$.ajax({
		 type: "POST",
		 url: base_url+'like/remove',
		 data: {id: $(this).attr('id'), type: $(this).attr('data-type')},		 
		 success: function(msg){
			 if(msg=='no good'){
			 	alert( 'You have never liked this' );
			 }else{
				 $('.like_bar').html('Thank you!');
			 }
		 }
		});

		return false;
	});

	$('.like').click(function(){
		$(this).remove();

		$.ajax({
		 type: "POST",
		 url: base_url+'like/add',
		 data: {id: $(this).attr('id'), type: $(this).attr('data-type')},		 
		 success: function(msg){
			 if(msg=='no good'){
			 	alert( 'You already liked this' );
			 }else{
				 $('.like_bar').html('Thank you!');
			 }
		 }
		});

//		$.post(base_url+'like/add',{'data' : $(this).attr('id')},function(data){
//			alert(data);
//			if(data == 'OOPS')
//				alert('You already liked this!');
//			else {
//			//$('.like_bar').html('Thank you!');
//			//var nb = eval($('.like_count').html())+1;
//			//$('.like_count').html(nb);
//			}
//		});	
		return false;
	});
});