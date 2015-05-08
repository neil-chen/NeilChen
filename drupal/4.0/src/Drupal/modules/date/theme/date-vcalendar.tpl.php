<?php
/**
 * @file
 * Template for a VCALENDAR file.
 */

/**
 * $calname
 *   The name of the calendar.
 * $events
 *   @see date-vevent.tpl.php.
 *   @see date-valarm.tpl.php.
 *
 * If you are editing this file, remember that all output lines generated by it
 * must end with DOS-style \r\n line endings, and not Unix-style \n, in order to
 * comply with the iCal spec: http://tools.ietf.org/html/rfc5545#section-3.1.
 */
if (empty($method)):
  $method = 'PUBLISH';
endif;
  print "BEGIN:VCALENDAR\r\n";
  print "VERSION:2.0\r\n";
  print "METHOD:$method\r\n";
if (!empty($calname)):
  print "X-WR-CALNAME;VALUE=TEXT:$calname\r\n";
endif;
print "PRODID:-//Drupal iCal API//EN\r\n";
foreach ($events as $event):
  print theme('date_vevent', $event);
endforeach;
print "END:VCALENDAR\r\n";
