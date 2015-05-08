<?php

/**
 * This template is used to echo a single field in a view. It is not
 * actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the
 * template is perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
global $user;
$file_arr = pathinfo($row->files_node_data_field_document_file_filename);
$case_default = ($file_arr['extension'] == 'pdf' || $file_arr['extension'] == 'PDF');
$user_account = ($user->covidien_user == 'Yes' || $row->node_data_field_document_version_field_doc_external_users_value == 1 || $user->uid == 1);
if ($user_account && $case_default && $row->content_type_document_field_document_md5sum_value) {
  echo l(t('View'), 'covidien/document/reader/' . $row->nid);
}
