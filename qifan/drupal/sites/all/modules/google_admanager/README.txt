Module: Google Admanager
Author:
- Thomas Bonte <www.thomasbonte.net>
- Hai-Nam Nguyen aka jcisio <www.jcisio.com>

Description
===========
Adds the DoubleClick for Publishers code to your website.
Note: it was Google Admanager before.

Requirements
============
DoubleClick for Publishers account https://www.google.com/dfp/
Get your DFP Property Code at https://www.google.com/dfp/admin

Installation
============
1. Copy the 'google_admanager' module directory in to your Drupal 
   sites/all/modules directory as usual
2. Go to admin/config/system/google_admanager and fill in the form
3. For each submitted Ad Slot name, you will get find a block 
   at admin/build/block which you can add to a region
Note: in this module the term "ad slot" is used for "ad  unit"

Upgrade
=============
Previous versions of the google_admanager module required you to place some
code into the theme's template.php file, but this version DOES NOT.
Please remove such code from the template file before you upgrade. 

First BACKUP you theme's template.php file, then remove the following code if it exists. 

function _phptemplate_variables($hook, $vars) {
  if ($hook == 'page') {
    if (module_exists('google_admanager')) {
      $vars['scripts'] .= google_admanager_add_js();
    }

    return $vars;
  }
  return array();
}


function phptemplate_preprocess_page(&$vars) {

  // Insert Google Ad Manager scripts into header
  if (module_exists('google_admanager')) {
    $vars['scripts'] .= google_admanager_add_js();
  }

}

== Lazy loading
Lazy loading is an experimental feature, allow you to insert DFP javascript
just before closing </body>. This makes browser render content faster.

Two drawbacks at the moment:
- Not supported if you are using inline ad filter
- When using with Panels, must select the pane style as "System block"

== In-Content ad
1. Enable the Google Admanager filter in your input format
2. Add [google_ad:ADSLOTNAME] where you want ad to be displayed

Note: you must place at least one ad block in a page, so that
Google Admanager script can be initialized.

== Superslot
A superslot is a block that contain many ad slot, each has its own visibility
settings.

== Custom tag
If you want to pass custom tag into ad slot as described at
http://www.google.com/support/dfp_sb/bin/answer.py?answer=91225
you can use this function:
  google_admanager_add_attribute($key, $value)

Support
=======
Offcial Drupal project page
http://drupal.org/project/google_admanager

File a bug or support request at 
http://drupal.org/project/issues/google_admanager
