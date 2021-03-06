<?php

function covidien_contenttype_update($arg) {
  module_load_include('inc', 'content', 'includes/content.crud');

  $module_name = $arg['module_name'];
  $import_new = $arg['import_new'];
  $import_updatearr = $arg['import_updatearr'];
  $import_deletearr = $arg['import_deletearr'];
  $import_ctdeletearr = $arg['import_ctdeletearr'];

  $import_update = array_keys($import_updatearr);

  $files = file_scan_directory(drupal_get_path('module', $module_name) . '/content_type', '.cck_import.inc');
  if (is_array($import_ctdeletearr) && count($import_ctdeletearr) > 0) {
    foreach ($import_ctdeletearr as $key => $fields) {
      if (count($fields) > 0) {
        foreach ($fields as $field_name) {
          $field = array();
          $field['field_name'] = $field_name;
          $field['type_name'] = $key;
          content_field_instance_delete($field['field_name'], $field['type_name'], FALSE);
          drupal_set_message('Deleted ' . $field['field_name'] . ' in ' . $field['type_name']);
        }
      }
    }
    // Clear caches and rebuild menu.
    content_clear_type_cache(TRUE);
    menu_rebuild();
  }
  foreach ($files as $absolute => $file) {
    // Creating new content type.
    if (in_array($file->name, $import_new)) {
      $form_state = array();
      $form_state['values']['type_name'] = '<create>';
      $fh = fopen($file->filename, 'r');
      $theData = fread($fh, filesize($file->filename));
      fclose($fh);
      $form_state['values']['macro'] = "$theData";
      drupal_execute('content_copy_import_form', $form_state);
    }

    // Updating existing content type.	
    if (in_array($file->name, $import_update)) {
      // Add the new fileds to the content type
      $form_state = array();
      $form_state['values']['type_name'] = $import_updatearr[$file->name];
      $fh = fopen($file->filename, 'r');
      $theData = fread($fh, filesize($file->filename));
      eval($theData);
      fclose($fh);
      $form_state['values']['macro'] = "$theData";
      drupal_execute('content_copy_import_form', $form_state);
      // Update Title filed label
      $title_label = $content['type']['title_label'];
      $type = $content['type']['type'];
      db_query("UPDATE {node_type} SET title_label = '%s' WHERE type = '%s'", $title_label, $type);
      // Update several fields at a time.	  
      if (count($content['fields']) > 0) {
        foreach ($content['fields'] as $key => $field) {
          if (is_array($field)) {
            $field['type_name'] = $content['type']['type'];
            if ($field['type_name'] != '' && $field['field_name'] != '') {
              content_field_instance_update($field, FALSE);
              drupal_set_message('updated ' . $field['field_name'] . ' in ' . $field['type_name']);
            }
          }
        }
      }

      /**
       * Code to remove the cck filed from content type.
       */
      if (is_array($import_deletearr)) {
        $fields = $import_deletearr[$file->name];
      }
      if (count($fields) > 0) {
        foreach ($fields as $field_name) {
          $field = array();
          $field['field_name'] = $field_name;
          $field['type_name'] = $import_updatearr[$file->name];
          content_field_instance_delete($field['field_name'], $field['type_name'], FALSE);
          drupal_set_message('Deleted ' . $field['field_name'] . ' in ' . $field['type_name']);
        }
      }

      // Clear caches and rebuild menu.
      content_clear_type_cache(TRUE);
      menu_rebuild();
    }
  }
}
