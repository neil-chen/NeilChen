<?php

/**
 * @file
 * Allow a view context to display its attachment(s).
 */

$plugin = array(
  'title' => t('View exposed widgets'),
  'category' => t('View context'),
  'icon' => 'icon_views_page.png',
  'description' => t('Display the view exposed widgets if there are no results.'),
  'required context' => new ctools_context_required(t('View'), 'view'),
  'defaults' => array(
    'which' => array(),
  ),
);

/**
 * Render the node_terms content type.
 */
function views_content_views_exposed_content_type_render($subtype, $conf, $panel_args, $context) {
  if (empty($context) || empty($context->data)) {
    return;
  }

  // Build the content type block.
  $block = new stdClass();
  $block->module  = 'views_exposed';
  $block->delta   = $context->argument;
  $block->title   = '';
  $block->content = '';

  $output = views_content_context_get_output($context);
  $block->content = $output['exposed'];

  return $block;
}

function views_content_views_exposed_content_type_edit_form(&$form, &$form_state) {
}

function views_content_views_exposed_content_type_edit_form_submit(&$form, &$form_state) {
  // Kept so we guarantee we have a submit handler.
}

/**
 * Returns the administrative title for a type.
 */
function views_content_views_exposed_content_type_admin_title($subtype, $conf, $context) {
  return t('"@context" exposed widgets', array('@context' => $context->identifier));
}
