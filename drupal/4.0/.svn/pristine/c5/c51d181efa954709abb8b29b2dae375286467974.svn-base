<?php

print t('Covidien');
print "\r\n";
print t('Title :');
print $separator;
print t('Device Current Configuration Report');
print "\r\n";
print t('Date :');
print $separator;
print date("m/d/Y");
print "\r\n";
print "\r\n";
if (count($report_filter) > 0) {
  $filter = $report_filter;
  $report_filter_count = count($report_filter);
  for ($i = 0; $i < $report_filter_count; $i++) {
    unset($filter[$i]['colspan']);
    if (count($filter[$i]) > 0)
      print implode($separator, $filter[$i]);
    print $separator;
    print $separator;
    ++$i;
    unset($filter[$i]['colspan']);
    if (count($filter[$i]) > 0)
      print implode($separator, $filter[$i]) . "\r\n";
  }
  print "\r\n";
  print "\r\n";
}
?>
<?php

// Print out header row, if option was selected.
if ($options['header']) {
  print implode($separator, $header) . "\r\n";
}
