// JavaScript Document
$(document).ready(function(){

	$("#message_form").validationEngine({promptPosition: "topRight"});
	//$(".chzn-select").chosen();
	
	$(".show").click(function(){
		$(this).siblings('.hidden').slideToggle();
		return false;
	});
});
