<?php

/**
 * This template is used to print a single field in a view. It is not
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
// Variable from covidien_ui_init
// wordwrap function implemented for gateway-325
global $wordwraplength, $wordwrapchar;
?>
<?php

preg_match('/<.*>(.*?)<\/.*>/s', $output, $matches);

if (count($matches) > 0) {
  $output = str_replace('>' . $matches[1] . '<', '>' . wordwrap($matches[1], $wordwraplength, $wordwrapchar, TRUE) . '<', $output);
  echo $output;
} else {
  $output = html_entity_decode($output, ENT_QUOTES);
  print wordwrap($output, $wordwraplength, $wordwrapchar, true);
}
?>
