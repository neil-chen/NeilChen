<?php

/**
 * @file
 * Theme function for enhence the views admin interface vor PDF options.
 */


/**
 * Theme function to style the table UI in the Table Style Settings pages in the
 * view editing form. 
 */
function theme_views_pdf_plugin_style_table($form) {
  $output = drupal_render($form['description_markup']);

  $header = array(
    t('Field'),
    t('Header Style'),
    t('Body Style'),
    t('Position')
  );
  
  $rows = array();
  foreach (element_children($form['info']) as $id) {
    $row = array();
    $row[] = array('data' => drupal_render($form['info'][$id]['name']), 'width' => '20%');
    $row[] = array('data' => drupal_render($form['info'][$id]['header_style']), 'width' => '30%');
    $row[] = array('data' => drupal_render($form['info'][$id]['body_style']), 'width' => '30%');
    $row[] = array('data' => drupal_render($form['info'][$id]['position']), 'width' => '20%');

    $rows[] = $row;
  }

  $output .= theme('table', $header, $rows);
  $output .= drupal_render($form);
  return $output;

}
