<?php 
print "\r\n";
print "\r\n";
if(count($covidien_reports_subrow)>0){ ?>
<?php
foreach($covidien_reports_subrow as $subval){?>
<?php print $subval['label'];?>
<?php print $separator; ?>
<?php print $subval['value_text'];?>
<?php 
print "\r\n";
}
?>
<?php
}
?>
<?php

/**
 * CSV files don't really have a footer.
 */
print "\r\n";
print t('Covidien Report'); 