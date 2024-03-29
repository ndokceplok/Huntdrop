(function($) {
  $(function() {
    if(!('placeholder' in document.createElement("input"))) { //don't do any work if we don't have to!
      var inputs = $("input[type='text']"),
        origColour = inputs.eq(0).css("color");

      inputs
        .each(function(i) {
          var $t = $(this);
          $t.val($t.attr("placeholder")).css("color", "#585858");
        })
        .focus(function() {
          var $t = $(this);
          if($t.val() === $t.attr("placeholder")) $t.val('').css("color", origColour);
        })
        .blur(function() {
          var $t = $(this);
          if($t.val() === '') {
            $t.val($t.attr("placeholder")).css("color", "#585858");
          } 
        })
    }
  })

})(jQuery);