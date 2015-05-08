$(document).ready(function() {
  /**
   * Customized Performs a cached and delayed search
   */
  Drupal.ACDB.prototype.search = function(searchString) {
    var db = this;
    this.searchString = searchString;

    // See if this key has been searched for before
    if (this.cache[searchString]) {
      return this.owner.found(this.cache[searchString]);
    }

    // Initiate delayed search
    if (this.timer) {
      clearTimeout(this.timer);
    }
    this.timer = setTimeout(function() {
      db.owner.setStatus('begin');

      // Ajax GET request for autocompletion
      $.ajax({
        type: "GET",
        url: db.uri + '/' + Drupal.encodeURIComponent(searchString),
        dataType: 'json',
        success: function(matches) {
          if (typeof matches['status'] == 'undefined' || matches['status'] != 0) {
            db.cache[searchString] = matches;
            // Verify if these are still the matches the user wants to see
            if (db.searchString == searchString) {
              db.owner.found(matches);
            }
            db.owner.setStatus('found');
          }
        },
        error: function(xmlhttp) {
          console.log(Drupal.ahahError(xmlhttp, db.uri));
        }
      });
    }, this.delay);
  };
  /**
   * Customized : Fills the suggestion popup with any matches received
   */
  Drupal.jsAC.prototype.found = function(matches) {
    // If no value in the textfield, do not show the popup.
    if (!this.input.value.length) {
      return false;
    }

    // Prepare matches
    var ul = document.createElement('ul');
    var ac = this;
    for (key in matches) {
      var li = document.createElement('li');
      $(li).attr('title', matches[key]);
      $(li)
              .html('<div>' + matches[key] + '</div>')
              .mousedown(function() {
                ac.select(this);
              })
              .mouseover(function() {
                ac.highlight(this);
              })
              .mouseout(function() {
                ac.unhighlight(this);
              });
      li.autocompleteValue = key;
      $(ul).append(li);
    }

    // Show popup with matches, if any
    if (this.popup) {
      if (ul.childNodes.length > 0) {
        $(this.popup).empty().append(ul).show();
      }
      else {
        $(this.popup).css({visibility: 'hidden'});
        this.hidePopup();
      }
    }
  };

});