// JavaScript Document
$(document).ready(function(){
	
	$('.delete').click(function(e){
		e.preventDefault()
		var a = confirm("Do you want to delete this item ? \nOnce deleted you won't be able to recover it anymore");
		if(a){
			var is_submit = $(this).is('input[type="submit"]');
			if(is_submit){
				$(this).parent('form').submit();
			}else{
				location.href = $(this).attr('href');			
			}
		}
	});

	$('.undelete').click(function(e){
		e.preventDefault()
		var a = confirm("Do you want to undelete this item ?");
		if(a){
			location.href = $(this).attr('href');
		}
	});

	$('.delete_series').click(function(e){
		e.preventDefault()
		var a = confirm("Do you want to delete this series ? \nAll blogs inside the series will be marked as No Series");
		if(a){
			$.ajax({
				type: "POST",
				url: base_url+'member/blog/delete_series',
				data: {series_id: $(this).attr('id')},		 
				success: function(msg){
					console.log(msg);
					if(msg=='nope'){
						alert('For some reasons we can\'t process your request. Please try again later');
					}else{
						location.href = base_url+'member/blog';			
					}
				}
			});
			//location.href = $(this).attr('href');
		}
	});

	$('.delete_admin').click(function(e){
		e.preventDefault()
		var a = confirm("Do you want to delete this admin ?");
		if(a){
			location.href = $(this).attr('href');
		}
	});
	
});

