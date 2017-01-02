$( document ).ready(function() {

  // Material Bootstrap initializer
  $.material.init()

  // Popover and tooltip initializer
  $("[data-toggle=popover]").popover();
  $('[data-toggle="tooltip"]').tooltip();

});
