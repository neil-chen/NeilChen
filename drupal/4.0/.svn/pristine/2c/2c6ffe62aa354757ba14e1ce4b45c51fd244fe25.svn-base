<?php

/**
 * @file
 * @brief
 *   Settings form
 *
 * @author      Rafal Wieczorek
 * @date        April 2010
 */

/**
 * Menu callback for the settings form.
 */
function account_profile_get_admin_form() {
  $form['account_profile'] = array(
    '#type' => 'fieldset',
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );

  $form['account_profile']['account_profile_main_profile'] = array(
    '#type' => 'radios',
    '#title' => t('Main Profile'),
    '#description' => t('Choose the main profile which should contain user fields.'),
    '#default_value' => variable_get('account_profile_main_profile', key(content_profile_get_types('names'))),
    '#options' => content_profile_get_types('names'),
  );

  $form['account_profile']['account_profile_redirect'] = array(
    '#type' => 'checkbox',
    '#title' => t('Redirect on User Edit page'),
    '#default_value' => variable_get('account_profile_redirect', TRUE),
  );

  $form['account_profile']['account_profile_edit_tab'] = array(
    '#type' => 'checkbox',
    '#title' => t('Disable the normal User Edit tab'),
    '#default_value' => variable_get('account_profile_edit_tab', TRUE),
  );
  $form['#submit'][] = 'account_profile_admin_form_submit';

  return system_settings_form($form);
}

/**
 * Implementation of submit callback
 */
function account_profile_admin_form_submit($form, &$form_state) {
  if (variable_get('account_profile_edit_tab', TRUE) != $form_state['values']['account_profile_edit_tab']) {
    menu_rebuild();
  }
}

