// JavaScript Document

var gid = function(x) { return document.getElementById(x); };

function focus_txt(msg, id){
	if(gid(id).value == msg){
		gid(id).value="";
	}
}

function blur_txt(msg, id){
	if(gid(id).value.length < 1){
		gid(id).value=msg;
	}
}

$(document).ready(function(){
	$("#contact_form, #advertise_form").validationEngine({promptPosition: "topRight"});
});
