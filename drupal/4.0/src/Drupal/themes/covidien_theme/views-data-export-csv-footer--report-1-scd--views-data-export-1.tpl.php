<?php

/**
 * CSV files don't really have a footer.
 */
print "\r\n";
print "\r\n";
 print $covidien_reports_subline.$separator.$separator.$separator.$separator.$covidien_reports_sub2line. "\r\n";
 print implode($separator, $covidien_reports_subkey).$separator.$separator.implode($separator, $covidien_reports_sub2key) . "\r\n";
 
 $sub1length = count($covidien_reports_subval);
 $sub2length = count($covidien_reports_sub2val);
 
 for($i=1;;$i++){
     if($i>$sub1length && $i>$sub2length){
         break;
     }
     if($i<=$sub1length){
         foreach(array_shift($covidien_reports_subval) as $val){
             print $val.$separator;
         }
         print $separator;
     }else{
         print $separator.$separator.$separator.$separator;
     }
     if($i<=$sub2length){
         foreach(array_shift($covidien_reports_sub2val) as $val){
             print $val.$separator;
         }
     }
     print "\r\n";
 }
 print "\r\n";
print t("Covidien Report");