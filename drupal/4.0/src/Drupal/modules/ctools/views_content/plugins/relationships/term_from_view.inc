<?php

/**
 * @file
 * Plugin to provide an relationship handler for term from view.
 */

/**
 * Plugins are described by creating a $plugin array which will be used
 * by the system that includes this file.
 */
$plugin = array(
  'title' => t('Term from view'),
  'keyword' => 'term',
  'description' => t('Extract a term context from a view context of the base type term.'),
  'required context' => new ctools_context_required(t('View'), 'view', array('base' => 'term_data')),
  'context' => 'views_content_term_from_view_context',
  'settings form' => 'views_content_term_from_view_settings_form',
  'settings form validate' => 'views_content_term_from_view_settings_form_validate',
  'defaults' => array('row' => 1),
);

/**
 * Return a new context based on an existing context.
 */
function views_content_term_from_view_context($context, $conf, $placeholder = FALSE) {
  // If unset it wants a generic, unfilled context, which is just NULL.
  if (empty($context->data) || $placeholder) {
    return ctools_context_create_empty('term', NULL);
  }
  $view = views_content_context_get_view($context);
  // Ensure the view executes, but we don't need its output.
  views_content_context_get_output($context);

  $row = intval($conf['row']) - 1;
  if (isset($view->result[$row])) {
    $tid = $view->result[$row]->{$view->base_field};
    if ($tid) {
      $term = taxonomy_get_term($tid);
      return ctools_context_create('term', $term);
    }
  }
  return ctools_context_create_empty('term', NULL);
}

/**
 * Settings form for the relationship.
 */
function views_content_term_from_view_settings_form($conf) {
  $form['row'] = array(
    '#title' => t('Row number'),
    '#type' => 'textfield',
    '#default_value' => $conf['row'],
  );

  return $form;
}

function views_content_term_from_view_settings_form_validate($form, &$form_values, &$form_state) {
  if (intval($form_values['row']) <= 0) {
    form_error($form['row'], t('Row number must be a positive integer value.'));
  }
}
