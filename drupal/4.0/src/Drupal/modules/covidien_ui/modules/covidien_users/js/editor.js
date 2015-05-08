$(document).ready(function() {
  $(".iframe").colorbox({iframe: true, width: "500px", height: "500px", scrolling: false, overlayClose: false, onLoad: function() {
      $('#cboxClose').remove();
    }
  });



});

