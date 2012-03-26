// JavaScript Document

$(function(){
  //set sidebar height as high as content height
  var sidebar_height = $('#sidebar').height();
  var content_height = $('#content').height();
  if(content_height> sidebar_height){
    $('#sidebar').height(content_height);
  }
});
