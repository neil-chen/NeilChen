<?php
// $Id$

/**
 * @file
 * Theme function overrides
 * @see sky_theme(), template.php
 */

/**
 * @see theme_breacrumb(), sky_theme()
 * http://api.drupal.org/api/function/theme_breadcrumb/6
 *
 * Added: Support for user to select a custom separator in theme settings
 * Added: id attribute: breadcrumbs, class attribute: clearfix
 * Removed: Class attribute: breadcrumb
 */
function sky_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb) && (theme_get_setting('sky_breadcrumbs') == 0)) {
    // Use separator defined by theme settings
    $sky_separator = theme_get_setting('sky_breadcrumbs_sep');

    $separator =  $sky_separator ? $sky_separator : '&raquo;';
    return '<div id="breadcrumbs" class="clearfix">'. implode(' '. $separator .' ', $breadcrumb) .'</div>';
  }
}

/**
 * @see theme_feed_icon(), sky_theme()
 * http://api.drupal.org/api/function/theme_feed_icon/6
 *
 * Added: A different default title when one is not provided.
 * Changed: The location of the feed icon image to one provided by the theme.
 */
function sky_feed_icon($url, $title) {
  if (!$title) {
    $title = t('Subscribe to this feed');
  }
  if ($image = theme('image', path_to_theme() .'/images/icn-feed.png', t('Syndicate content'), $title)) {
    $output = '<div class="feed-icon clearfix">';
    $output .= '<a href="'. check_url($url) .'">'. $image .'</a>';
    $output .= '</div>';
    return $output;
  }
}

/**
 * @see theme_fieldset(), sky_theme()
 * http://api.drupal.org/api/function/theme_fieldset/6
 *
 * Added: <div class="fieldset-wrapper"> Only collapsible fieldsets have it.
 * Applying padding and background colors to it as opposed to the fieldset
 * itself allows for better styling.
 */
function sky_fieldset($element) {
  if (!empty($element['#collapsible'])) {
    drupal_add_js('misc/collapse.js');

    if (!isset($element['#attributes']['class'])) {
      $element['#attributes']['class'] = '';
    }

    $element['#attributes']['class'] .= ' collapsible';
    if (!empty($element['#collapsed'])) {
      $element['#attributes']['class'] .= ' collapsed';
    }
  }

  return '<fieldset'. drupal_attributes($element['#attributes']) .'>'. ($element['#title'] ? '<legend>'. $element['#title'] .'</legend>' : '') .'<div class="fieldset-wrapper">'. (isset($element['#description']) && $element['#description'] ? '<div class="description">'. $element['#description'] .'</div>' : '') . (!empty($element['#children']) ? $element['#children'] : '') . (isset($element['#value']) ? $element['#value'] : '') ."</div></fieldset>\n";
}

 /**
 * @see theme_menu_local_tasks(), sky_theme()
 * http://api.drupal.org/api/function/theme_menu_local_tasks/6
 *
 * Added: A wrapper <div>'s with class attributes: clearfix class, a helper class
 * indicating what's inside, and id attributes.
 */
function sky_menu_local_tasks() {
  $output = '';
  $primary = menu_primary_local_tasks();
  $secondary = menu_secondary_local_tasks();

  // What's inside
  if ($primary && $secondary) {
    $helper_class = ' primary-and-secondary';
  }
  else {
    $helper_class = ' primary-only';
  }

  if ($primary || $secondary) {
    $output = '<div class="tab-wrapper clearfix'. $helper_class .'">';

    if ($primary) {
      $output .= "\n".'<div id="tabs-primary" class="tabs primary">'."\n".
      '  <ul>'."\n". $primary .'</ul>'."\n".
      '</div>';
    }
    if ($secondary) {
      $output .= "\n".'<div id="tabs-secondary" class="tabs secondary">'."\n" .
      '  <ul>'."\n". $secondary .'</ul>'."\n" .
      '</div>';
    }
    $output .= '</div>';
  }

  return $output;
}

/**
 * @see theme_pager(), sky_theme()
 * http://api.drupal.org/api/function/theme_pager/6
 *
 * Added: 2 wrapper <div>'s
 * Changed: Wrapped $pager_current, and &hellip;'s in a <span> tag.
 * Removed: .pager-item, .pager-next, .pager-previous classes
 */
function sky_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', (isset($tags[0]) ? $tags[0] : t('« First')), $limit, $element, $parameters);
  $li_previous = theme('pager_previous', (isset($tags[1]) ? $tags[1] : t('‹ Previous')), $limit, $element, 1, $parameters);
  $li_next = theme('pager_next', (isset($tags[3]) ? $tags[3] : t('Next ›')), $limit, $element, 1, $parameters);
  $li_last = theme('pager_last', (isset($tags[4]) ? $tags[4] : t('Last »')), $limit, $element, $parameters);

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => 'pager-first',
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => 'pager-previous',
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '<span>&hellip;</span>',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'data' => theme('pager_previous', $i, $limit, $element, ($pager_current - $i), $parameters),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => 'pager-current',
            'data' => '<span>'. $i .'</span>',
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'data' => theme('pager_next', $i, $limit, $element, ($i - $pager_current), $parameters),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => 'pager-ellipsis',
          'data' => '<span>&hellip;</span>',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'data' => $li_last,
      );
    }

    // Prepare the pager output
    $output = '<div class="pager clearfix">'."\n";
    $output .= '  <div class="pager-inner">'."\n";
    $output .=     theme('item_list', $items, NULL, 'ul', array('class' => 'pager')) ."\n";
    $output .= '  </div>'."\n";
    $output .= '</div>'."\n";

    return $output;
  }
}

/**
 * @see theme_table(), sky_theme()
 * http://api.drupal.org/api/function/theme_table/6
 *
 * Added: A wrapper <div> with to class attributes: table-wrapper, clearfix to
 * deal with overflow and word-wrap and word-break issues.
 */
function sky_table($header, $rows, $attributes = array(), $caption = NULL) {

  // Add sticky headers, if applicable.
  if (count($header)) {
    drupal_add_js('misc/tableheader.js');
    // Add 'sticky-enabled' class to the table to identify it for JS.
    // This is needed to target tables constructed by this function.
    $attributes['class'] = empty($attributes['class']) ? 'sticky-enabled' : ($attributes['class'] .' sticky-enabled');
  }

  $output = '<div class="table-wrapper clearfix">';
  $output .= '<table'. drupal_attributes($attributes) .">\n";

  if (isset($caption)) {
    $output .= '<caption>'. $caption ."</caption>\n";
  }

  // Format the table header:
  if (count($header)) {
    $ts = tablesort_init($header);
    // HTML requires that the thead tag has tr tags in it follwed by tbody
    // tags. Using ternary operator to check and see if we have any rows.
    $output .= (count($rows) ? ' <thead><tr>' : ' <tr>');
    foreach ($header as $cell) {
      $cell = tablesort_header($cell, $header, $ts);
      $output .= _theme_table_cell($cell, TRUE);
    }
    // Using ternary operator to close the tags based on whether or not there are rows
    $output .= (count($rows) ? " </tr></thead>\n" : "</tr>\n");
  }
  else {
    $ts = array();
  }

  // Format the table rows:
  if (count($rows)) {
    $output .= "<tbody>\n";
    $flip = array('even' => 'odd', 'odd' => 'even');
    $class = 'even';
    foreach ($rows as $number => $row) {
      $attributes = array();

      // Check if we're dealing with a simple or complex row
      if (isset($row['data'])) {
        foreach ($row as $key => $value) {
          if ($key == 'data') {
            $cells = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $cells = $row;
      }
      if (count($cells)) {
        // Add odd/even class
        $class = $flip[$class];
        if (isset($attributes['class'])) {
          $attributes['class'] .= ' '. $class;
        }
        else {
          $attributes['class'] = $class;
        }

        // Build row
        $output .= ' <tr'. drupal_attributes($attributes) .'>';
        $i = 0;
        foreach ($cells as $cell) {
          $cell = tablesort_cell($cell, $header, $ts, $i++);
          $output .= _theme_table_cell($cell);
        }
        $output .= " </tr>\n";
      }
    }
    $output .= "</tbody>\n";
  }

  $output .= "</table>\n";
  $output .= '</div>';
  return $output;
}

/**
 * @see theme_status_messages(), sky_theme()
 * http://api.drupal.org/api/function/theme_status_messages/6
 *
 * Added: A wrapper <div> with to class attributes: table-wrapper, clearfix to
 * deal with overflow and word-wrap and word-break issues.
 */
function sky_status_messages($display = NULL) {
  $output = '';
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"messages $type\">\n";
    $output .= '<span class="icon">&nbsp;</span>';
    $output .= '<div class="inner">';

    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>'. $message ."</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
    $output .= "</div>\n";
  }
  return $output;
}

function sky_status_report($requirements) {
  $i = 0;
  $output = '<table class="system-status-report">';
  foreach ($requirements as $requirement) {
    if (empty($requirement['#type'])) {
      $class = ++$i % 2 == 0 ? 'even' : 'odd';

      $classes = array(
        REQUIREMENT_INFO => 'info',
        REQUIREMENT_OK => 'ok',
        REQUIREMENT_WARNING => 'warning',
        REQUIREMENT_ERROR => 'error',
      );
      $class = $classes[isset($requirement['severity']) ? (int)$requirement['severity'] : 0] .' '. $class;

      // Output table row(s)
      if (!empty($requirement['description'])) {
        $output .= '<tr class="'. $class .' merge-down"><th><span class="icon">&nbsp;</span>'. $requirement['title'] .'</th><td>'. $requirement['value'] .'</td></tr>';
        $output .= '<tr class="'. $class .' merge-up"><td colspan="2">'. $requirement['description'] .'</td></tr>';
      }
      else {
        $output .= '<tr class="'. $class .'"><th><span class="icon">&nbsp;</span>'. $requirement['title'] .'</th><td>'. $requirement['value'] .'</td></tr>';
      }
    }
  }

  $output .= '</table>';
  return $output;
}

/**
 * @see theme_form_element()
 * http://api.drupal.org/api/function/theme_form_element/6
 * Added: A css class indicating the type of element it contains, i.e. .form-item-textfield
 * Added: A css class indicating of the element is required, i.e. .form-item-required
 */
function sky_form_element($element, $value) {
  // This is also used in the installer, pre-database setup.
  $t = get_t();
  
  // Form wrapper attributes.
  $attributes = array();
  $attributes['class'] = 'form-item';

  // Create a class that indicates what type of form item is inside the wrapper.
  if (!empty($element['#type'])) {
    $attributes['class'] .= ' form-item-'. str_replace('_', '-', $element['#type']);
  }

  // Create a class that indicates if the element is required
  if ($element['#required'] == TRUE) {
    $attributes['class'] .= ' form-item-required';
  }

  // Add an id attribute where one exists.
  if (!empty($element['#id'])) {
    $attributes['id'] = $element['#id'] .'-wrapper';
  }

  $output = '<div'. drupal_attributes($attributes).'>' ."\n";

  $required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';

  if (!empty($element['#title'])) {
    $title = $element['#title'];
    if (!empty($element['#id'])) {
      $output .= ' <label for="'. $element['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
    else {
      $output .= ' <label>'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
  }

  $output .= " $value\n";

  if (!empty($element['#description'])) {
    $output .= ' <div class="description">'. $element['#description'] ."</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

/**
 * @see theme_more_link()
 * http://api.drupal.org/api/function/theme_more_link/6
 * Added: <span> tag for icon
 */
function sky_more_link($url, $title) {
  return '<div class="more-link"> <span class="icon">&nbsp;</span> '. t('<a href="@link" title="@title">more</a>', array('@link' => check_url($url), '@title' => $title)) .'</div>';
}

/**
 * @see theme_menu_item_link()
 * http://api.drupal.org/api/function/theme_menu_item_link/6
 * Added: <span> tag for icon
 */
function sky_menu_item_link($link) {
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }
  $link['localized_options']['html'] = TRUE;

  return l('<span></span>' . $link['title'], $link['href'], $link['localized_options']);
}
