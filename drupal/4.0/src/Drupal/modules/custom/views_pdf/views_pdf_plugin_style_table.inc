<?php

/**
 * @file
 * Table PDF style plugin
 */


/**
 * Style plugin to render each item as a row in a table.
 *
 * @ingroup views_style_plugins
 */
class views_pdf_plugin_style_table extends views_plugin_style {
  
  /**
   * Render the style
   */ 
  function render() {
    $output = '';
    
    $this->view->numberOfRecords = count($this->view->result);  
    $this->view->pdf->drawTable($this->view, $this->options);
    
    return $output;
  }


  /**
   * Option definitions
   */
  function option_definition() {
    $options = parent::option_definition();

    $options['info'] = array('default' => array());
    $options['position'] = array('default' => array());    

    return $options;
  }
  
  /**
   * Options form
   */
  function options_form(&$form, &$form_state) {
    
    $handlers = $this->display->handler->get_handlers('field');
    if (empty($handlers)) {
      $form['error_markup'] = array(
        '#value' => t('You need at least one field before you can configure your table settings'),
        '#prefix' => '<div class="error form-item description">',
        '#suffix' => '</div>',
      );
      return;
    }

    // Note: views UI registers this theme handler on our behalf. Your module
    // will have to register your theme handlers if you do stuff like this.
    $form['#theme'] = 'views_pdf_plugin_style_table';

    $columns = $this->display->handler->get_field_labels();
    
    $fields = $this->display->handler->get_option('fields');
  
    $fonts = array_merge(array('default' => t(' -- Default -- ')), views_pdf_get_font_list());
    $font_styles = array(
      'b' => t('Bold'),
      'i' => t('Italic'),
      'u' => t('Underline'),
      'd' => t('Line through'),
      'o' => t('Overline')
    );    
    $align = array(
      'L' => t('Left'),
      'C' => t('Center'),
      'R' => t('Right'),
      'J' => t('Justify'),
    );      
    
    $hyphenate = array(
      'none' => t('None'),
      'auto' => t('Detect automatically'),
    );
    $hyphenate = array_merge($hyphenate, views_pdf_get_hyphenations());

    foreach ($columns as $field => $column) {
      
      if ($fields[$field]['exclude'] == 1) {
        continue;
      }
    
      $safe = str_replace(array('][', '_', ' '), '-', $field);
      // the $id of the column for dependency checking.
      $id = 'edit-style-options-columns-' . $safe;

      // markup for the field name
      $form['info'][$field]['name'] = array(
        '#value' => $column,
      );
      
      $form['info'][$field]['header_style']['text'] = array(
        '#type' => 'fieldset',
        '#title' => t('Text Settings'),
        '#collapsed' => TRUE,
        '#collapsable' => TRUE,
      );
      
      $form['info'][$field]['header_style']['text']['font_size'] = array(
        '#type' => 'textfield',
        '#size' => 10,
        '#title' => t('Font Size'),
        '#default_value' => isset($this->options['info'][$field]['header_style']['text']['font_size']) ? $this->options['info'][$field]['header_style']['text']['font_size'] : '',
      );
      
      
      $form['info'][$field]['header_style']['text']['font_family'] = array(
        '#type' => 'select',
        '#title' => t('Font Family'),
        '#required' => TRUE,
        '#options' => $fonts,
        '#size' => 5,
        '#default_value' => !empty($this->options['info'][$field]['header_style']['text']['font_family']) ? $this->options['info'][$field]['header_style']['text']['font_family'] : 'default',
      );
      
      $form['info'][$field]['header_style']['text']['font_style'] = array(
        '#type' => 'checkboxes',
        '#title' => t('Font Style'),
        '#options' => $font_styles,
        '#size' => 10,
        '#default_value' => $this->options['info'][$field]['header_style']['text']['font_style'] == NULL ? $this->display->handler->get_option('default_font_style') : $this->options['info'][$field]['header_style']['text']['font_style'],
      );
      $form['info'][$field]['header_style']['text']['align'] = array(
        '#type' => 'radios',
        '#title' => t('Alignment'),
        '#options' => $align,
        '#default_value' => $this->options['info'][$field]['header_style']['text']['align'] == NULL ? $this->display->handler->get_option('default_text_align') : $this->options['info'][$field]['header_style']['text']['align'],
      );

      $form['info'][$field]['header_style']['text']['hyphenate'] = array(
        '#type' => 'select',
        '#title' => t('Text Hyphenation'),
        '#options' => $hyphenate,
        '#description' => t('If you want to use hyphenation, then you need to download from <a href="@url">ctan.org</a> your needed pattern set. Then upload it to the dir "hyphenate_patterns" in the TCPDF lib directory. Perhaps you need to create the dir first. If you select the automated detection, then we try to get the language of the current node and select an appropriate hyphenation pattern.', array('@url' => 'http://www.ctan.org/tex-archive/language/hyph-utf8/tex/generic/hyph-utf8/patterns/tex')),
        '#default_value' => $this->options['info'][$field]['header_style']['text']['hyphenate'] == NULL ? $this->display->handler->get_option('default_text_hyphenate') : $this->options['info'][$field]['header_style']['text']['hyphenate'],
      );


      $form['info'][$field]['header_style']['text']['color'] = array(
        '#type' => 'textfield',
        '#title' => t('Text Color'),
        '#description' => t('If a value is entered without a comma, it will be interpreted as a hexadecimal RGB color. Normal RGB can be used by separating the components by a comma. e.g 255,255,255 for white. A CMYK color can be entered in the same way as RGB. e.g. 0,100,0,0 for magenta.'),
        '#size' => 10,
        '#default_value' => $this->options['info'][$field]['header_style']['text']['color'] == NULL ? $this->display->handler->get_option('default_text_color') : $this->options['info'][$field]['header_style']['text']['font_style'],
      );
      
      
      
      $form['info'][$field]['header_style']['render'] = array(
        '#type' => 'fieldset',
        '#title' => t('Render Settings'),
        '#collapsed' => TRUE,
        '#collapsable' => TRUE,
      );

      $form['info'][$field]['header_style']['render']['is_html'] = array(
        '#type' => 'checkbox',
        '#title' => t('Render As HTML'),
        '#default_value' => isset($this->options['info'][$field]['header_style']['render']['is_html']) ? $this->options['info'][$field]['header_style']['render']['is_html'] : 1,
      );
      
      /*$form['info'][$field]['header_style']['render']['swap_on_new_page'] = array(
        '#type' => 'checkbox',
        '#title' => t('Swap on new page'),
        '#description' => t('If there is a high chance, that the content has not enough space to print on the current page, a new page is added.'),
        '#default_value' => isset($this->options['formats'][$field]['render']['swap_on_new_page']) ? $this->options['formats'][$field]['render']['swap_on_new_page'] : 1,
      );*/
     
      $form['info'][$field]['header_style']['render']['eval_before'] = array(
        '#type' => 'textarea',
        '#title' => t('PHP Code Before Output'),
        '#default_value' => isset($this->options['info'][$field]['header_style']['render']['eval_before']) ? $this->options['info'][$field]['header_style']['render']['eval_before'] : '',
      );
      
      $form['info'][$field]['header_style']['render']['eval_after'] = array(
        '#type' => 'textarea',
        '#title' => t('PHP Code After Output'),
        '#default_value' => isset($this->options['info'][$field]['header_style']['render']['eval_after']) ? $this->options['info'][$field]['header_style']['render']['eval_after'] : '',
      );
      
      
      
      $form['info'][$field]['body_style']['text'] = array(
        '#type' => 'fieldset',
        '#title' => t('Text Settings'),
        '#collapsed' => TRUE,
        '#collapsable' => TRUE,
      );
      $form['info'][$field]['body_style']['text']['font_size'] = array(
        '#type' => 'textfield',
        '#size' => 10,
        '#title' => t('Font Size'),
        '#default_value' => isset($this->options['info'][$field]['body_style']['text']['font_size']) ? $this->options['info'][$field]['body_style']['text']['font_size'] : '',
      );
      
      $form['info'][$field]['body_style']['text']['font_family'] = array(
        '#type' => 'select',
        '#title' => t('Font Family'),
        '#required' => TRUE,
        '#options' => $fonts,
        '#size' => 5,
        '#default_value' => !empty($this->options['info'][$field]['body_style']['text']['font_family']) ? $this->options['info'][$field]['body_style']['text']['font_family'] : 'default',
      );
      
      $form['info'][$field]['body_style']['text']['font_style'] = array(
        '#type' => 'checkboxes',
        '#title' => t('Font Style'),
        '#options' => $font_styles,
        '#size' => 10,
        '#default_value' => $this->options['info'][$field]['body_style']['text']['font_style'] == NULL ? $this->display->handler->get_option('default_font_style') : $this->options['info'][$field]['body_style']['text']['font_style'],
      );
      $form['info'][$field]['body_style']['text']['align'] = array(
        '#type' => 'radios',
        '#title' => t('Alignment'),
        '#options' => $align,
        '#default_value' => $this->options['info'][$field]['body_style']['text']['align'] == NULL ? $this->display->handler->get_option('default_text_align') : $this->options['info'][$field]['body_style']['text']['align'],
      );
      $form['info'][$field]['body_style']['text']['hyphenate'] = array(
        '#type' => 'select',
        '#title' => t('Text Hyphenation'),
        '#options' => $hyphenate,
        '#description' => t('If you want to use hyphenation, then you need to download from <a href="@url">ctan.org</a> your needed pattern set. Then upload it to the dir "hyphenate_patterns" in the TCPDF lib directory. Perhaps you need to create the dir first. If you select the automated detection, then we try to get the language of the current node and select an appropriate hyphenation pattern.', array('@url' => 'http://www.ctan.org/tex-archive/language/hyph-utf8/tex/generic/hyph-utf8/patterns/tex')),
        '#default_value' => $this->options['info'][$field]['body_style']['text']['hyphenate'] == NULL ? $this->display->handler->get_option('default_text_hyphenate') : $this->options['info'][$field]['body_style']['text']['hyphenate'],
      );

      $form['info'][$field]['body_style']['text']['color'] = array(
        '#type' => 'textfield',
        '#title' => t('Text Color'),
        '#description' => t('If a value is entered without a comma, it will be interpreted as a hexadecimal RGB color. Normal RGB can be used by separating the components by a comma. e.g 255,255,255 for white. A CMYK color can be entered in the same way as RGB. e.g. 0,100,0,0 for magenta.'),
        '#size' => 20,
        '#default_value' => $this->options['info'][$field]['body_style']['text']['color'] == NULL ? $this->display->handler->get_option('default_text_color') : $this->options['info'][$field]['body_style']['text']['font_style'],
      );
      
      
      $form['info'][$field]['body_style']['render'] = array(
        '#type' => 'fieldset',
        '#title' => t('Render Settings'),
        '#collapsed' => TRUE,
        '#collapsable' => TRUE,
      );

      $form['info'][$field]['body_style']['render']['is_html'] = array(
        '#type' => 'checkbox',
        '#title' => t('Render As HTML'),
        '#default_value' => isset($this->options['info'][$field]['body_style']['render']['is_html']) ? $this->options['info'][$field]['body_style']['render']['is_html'] : 1,
      );
      
      /*$form['info'][$field]['body_style']['render']['swap_on_new_page'] = array(
        '#type' => 'checkbox',
        '#title' => t('Swap on new page'),
        '#description' => t('If there is a high chance, that the content has not enough space to print on the current page, a new page is added.'),
        '#default_value' => isset($this->options['formats'][$field]['render']['swap_on_new_page']) ? $this->options['formats'][$field]['render']['swap_on_new_page'] : 1,
      );*/
      
      $form['info'][$field]['body_style']['render']['eval_before'] = array(
        '#type' => 'textarea',
        '#title' => t('PHP Code Before Output'),
        '#default_value' => isset($this->options['info'][$field]['body_style']['render']['eval_before']) ? $this->options['info'][$field]['body_style']['render']['eval_before'] : '',
      );
      
      $form['info'][$field]['body_style']['render']['eval_after'] = array(
        '#type' => 'textarea',
        '#title' => t('PHP Code After Output'),
        '#default_value' => isset($this->options['info'][$field]['body_style']['render']['eval_after']) ? $this->options['info'][$field]['body_style']['render']['eval_after'] : '',
      );
      
      $form['info'][$field]['position']['width'] = array(
        '#type' => 'textfield',
        '#size' => 10,
        '#title' => t('Width'),
        '#default_value' => isset($this->options['info'][$field]['position']['width']) ? $this->options['info'][$field]['position']['width'] : '',
      );
      

    }
    
    // Some general options
    $form['position'] = array(
      '#type' => 'fieldset',
      '#title' => t('Table Position'),
      '#collapsed' => TRUE,
      '#collapsable' => TRUE,
    );
    $form['position']['last_writing_position'] = array(
      '#type' => 'checkbox',
      '#title' => t('Relative to last writing position'),
      '#default_value' => isset($this->options['position']['last_writing_position']) ? $this->options['position']['last_writing_position'] : 1,
    );
    $form['position']['x'] = array(
      '#type' => 'textfield',
      '#size' => 10,
      '#title' => t('X'),
      '#description' => t('X Coordinate (relative to page with margins)'),
      '#default_value' => isset($this->options['position']['x']) ? $this->options['position']['x'] : '',
    );  
    $form['position']['y'] = array(
      '#type' => 'textfield',
      '#size' => 10,
      '#title' => t('Y'),
      '#description' => t('Y Coordinate (relative to page with margins)'),
      '#default_value' => isset($this->options['position']['y']) ? $this->options['position']['y'] : '',
    );
    $form['position']['width'] = array(
      '#type' => 'textfield',
      '#size' => 10,
      '#title' => t('Table Width'),
      '#default_value' => isset($this->options['position']['width']) ? $this->options['position']['width'] : '',
    );
    
    $form['position']['row_height'] = array(
      '#type' => 'textfield',
      '#size' => 10,
      '#title' => t('Row Height'),
      '#default_value' => isset($this->options['position']['row_height']) ? $this->options['position']['row_height'] : '',
    );
    
    

    parent::options_form($form, $form_state);

  }

  /**
   * Options form storage
   */
  function options_submit(&$form, &$form_state) {
    $default_font_style = $this->display->handler->get_option('default_font_style');
    foreach ($form_state['values']['style_options']['info'] as $id => $field) {
      
      // Reset to default, if the elements are equal to the default settings
      if (
        count(array_diff($default_font_style, $field['header_style']['text']['font_style'])) == 0 && 
        count(array_diff($field['header_style']['text']['font_style'], $default_font_style)) == 0) {
        $form_state['values']['style_options']['info'][$id]['header_style']['text']['font_style'] = NULL;
      }
      
      if ($field['header_style']['text']['align'] == $this->display->handler->get_option('default_text_align')) {
        $form_state['values']['style_options']['info'][$id]['header_style']['text']['align'] = NULL;
      }
      
      if ($field['header_style']['text']['hyphenate'] == $this->display->handler->get_option('default_text_hyphenate')) {
        $form_state['values']['style_options']['info'][$id]['header_style']['text']['hyphenate'] = NULL;
      }  
      
      // Reset to default, if the elements are equal to the default settings
      if (
        count(array_diff($default_font_style, $field['body_style']['text']['font_style'])) == 0 && 
        count(array_diff($field['body_style']['text']['font_style'], $default_font_style)) == 0) {
        $form_state['values']['style_options']['info'][$id]['body_style']['text']['font_style'] = NULL;
      }
      
      if ($field['body_style']['text']['align'] == $this->display->handler->get_option('default_text_align')) {
        $form_state['values']['style_options']['info'][$id]['body_style']['text']['align'] = NULL;
      }  
      
      if ($field['body_style']['text']['hyphenate'] == $this->display->handler->get_option('default_text_hyphenate')) {
        $form_state['values']['style_options']['info'][$id]['body_style']['text']['hyphenate'] = NULL;
      }  
    }

  }

  /**
   * Attach this view to another display as a feed.
   *
   * Provide basic functionality for all export style views like attaching a
   * feed image link.
   */
  function attach_to($display_id, $path, $title) {
    $display = $this->view->display[$display_id]->handler;
    $url_options = array();
    $input = $this->view->get_exposed_input();
    if ($input) {
      $url_options['query'] = $input;
    }

    $url = url($this->view->get_url(NULL, $path), $url_options);

    if (empty($this->view->feed_icon)) {
      $this->view->feed_icon = '';
    }
    $this->view->feed_icon .= theme('views_pdf_icon', $url, $title);
  }


}
