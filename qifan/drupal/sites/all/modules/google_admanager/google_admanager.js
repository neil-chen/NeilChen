(function ($) {
Drupal.GoogleAdManagerFix = function() {
  $("div.gam-holder").each(function() {
    var banner = $("#" + $(this).attr("id").replace(/^gam-holder/, "gam-content"));
    // If the block does not exist (for unknown reason), or has no content
    // (probably because of adblockers), we simply leave everything untouched.
    if (banner.length == 0 || banner.width() == 0 || banner.height() == 0) {
      return;
    }
    $(this).css({"width": banner.width(), "height": banner.height()});
    banner.css($(this).offset());
  });
};

$(window).resize(function() {Drupal.GoogleAdManagerFix();});

// We must update the position periodically.
// There is a watch plugin, but it does not help
// when the top and left are set to "auto"
// http://www.west-wind.com/weblog/posts/478985.aspx
setInterval("Drupal.GoogleAdManagerFix();", 500);
})(jQuery);
