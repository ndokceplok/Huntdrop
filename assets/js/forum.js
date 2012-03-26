// JavaScript Document
$(document).ready(function(){

  $('.show-forums').live('click',function(){
    $this = $(this);
    if($this.siblings('.forums').hasClass('hidden')){
      $this.siblings('.forums').fadeIn(500,function(){
        $(this).removeClass('hidden');
        $this.text('Hide Forums');
      });      
    }else{
      $this.siblings('.forums').fadeOut(500,function(){
        $(this).addClass('hidden');
        $this.text('Show Forums');
      });      
    }
  });
});
