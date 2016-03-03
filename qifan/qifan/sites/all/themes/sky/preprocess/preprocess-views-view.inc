<?php
// $Id$

/**
 * @file
 * Passes variables to the views templates.
 * @see theme_preprocess_views_view(), templates/overrides/views-view.tpl.php
 *
 * @return $vars
 */

// Prepare the variables that will store the attributes while being processed.
$vars['views_attributes'] = array();

// These are the styles views uses by default.
$vars['views_attributes']['class'][] = 'view';
$vars['views_attributes']['class'][] = 'view-'. $vars['css_name'];
$vars['views_attributes']['class'][] = 'view-id-'. $vars['name'];
$vars['views_attributes']['class'][] = 'view-display-id-'. $vars['display_id'];
$vars['views_attributes']['class'][] = 'view-dom-id-'. $vars['dom_id'];

// Add a class for the display plugin being used.
if (!empty($vars['view']->display['$display_id']['display_plugin'])) {
  $vars['views_attributes']['class'][] =  $vars['view']->display['$display_id']['display_plugin'];
}
// Add support for the Skinr module
if (!empty($vars['skinr'])) {
  $vars['views_attributes']['class'][] = $vars['skinr'];
}

// Crunch all attributes into a single string to be added to the block container.
$vars['views_attributes'] = theme('render_attributes', $vars['views_attributes']);
