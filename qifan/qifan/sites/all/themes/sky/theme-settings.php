<?php
// $Id$

/**
 * @file
 * Handles the custom theme settings
 */

/**
 * Return the theme settings' default values from the .info and save them into the database.
 * Credit: Zen http://drupal.org/project/zen
 *
 * @param $theme
 *   The name of theme.
 */
function sky_theme_get_default_settings($theme) {
 $themes = list_themes();

 // Get the default values from the .info file.
 $defaults = !empty($themes[$theme]->info['settings']) ? $themes[$theme]->info['settings'] : array();

 if (!empty($defaults)) {
   // Merge the defaults with the theme settings saved in the database.
   $settings = array_merge($defaults, variable_get('theme_'. $theme .'_settings', array()));
   // Save the settings back to the database.
   variable_set('theme_'. $theme .'_settings', $settings);
   // If the active theme has been loaded, force refresh of Drupal internals.
   if (!empty($GLOBALS['theme_key'])) {
     theme_get_setting('', TRUE);
   }
 }

 // Return the default settings.
 return $defaults;
}

/**
 * Implementation of _settings() theme function.
 *
 * @return array
 */
function sky_settings($saved_settings) {

  // Get the default settings.
  $defaults = sky_theme_get_default_settings('sky');
  // Merge the variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  // Breadcrumb Settings
  $form['sky_breadcrumbs'] = array(
    '#type' => 'checkbox',
    '#title' => t('Disable Breadcrumbs'),
    '#default_value' =>  $settings['sky_breadcrumbs'],
  );

  // Breadcrumb Separator
  $breadcrumbs_status = $settings['sky_breadcrumbs'] ? TRUE : FALSE;
  $breadcrumbs_desc = $breadcrumbs_status ? t('Select a breadcrumb separator.') : t('Breadcrumbs must be enabled to use this feature.');

  $form['sky_breadcrumbs_sep'] = array(
    '#type' => 'select',
    '#title' => t('Breadcrumb Separator'),
    '#default_value' =>  $settings['sky_breadcrumbs_sep'],
    '#options' => array(
      '&raquo;' => '»',
      '&rsaquo;' => '›',
      '&rarr;' => '→',
      '/' => t('/'),
    ),
    '#description' => $breadcrumbs_desc,
    '#disabled' => $breadcrumbs_status,
  );

  // Layout Options
  $form['layout'] = array(
    '#type' => 'fieldset',
    '#title' => 'Layout Options',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  // Layout Type
  $form['layout']['sky_layout'] = array(
    '#type' => 'select',
    '#title' => t('Layout Type'),
    '#default_value' => $settings['sky_layout'],
    '#options' => array(
      'fixed_960' => t('Fixed - 960px'),
      'fluid_98' => t('Fluid - 98%'),
      'fluid' => t('Fluid - 100%'),
    ),
    '#description' => t('This will determine the width of your site layout. Fixed layouts are center aligned.
      <ul class="tips">
        <li><strong>Fixed - 960px:</strong> A standard size for targeting: 1024 x 768 resolution.</li>
        <li><strong>Fluid - 98%:</strong> Will automatically size to fit the 98% the screen width, leaving room for the background image.</li>
        <li><strong>Fluid - 100%:</strong> Will automatically size to fit the 100% the screen width.</li>
    </ul>'),
  );

  $form['layout']['sky_custom_layout'] = array(
    '#type' => 'textfield',
    '#title' => t('Custom Layout Width'),
    '#default_value' => $settings['sky_custom_layout'],
    '#size' => 8,
    '#description' => t('Set your own layout width.  Be sure to specify units (px, em, %, etc). NOTE: If any value is set here, it will override the above layout options.'),
  );

  // Alignment of Navigation
  $form['layout']['sky_nav_alignment'] = array(
    '#type' => 'select',
    '#title' => t('Header Navigation Alignment'),
    '#default_value' =>  $settings['sky_nav_alignment'],
    '#options' => array(
      'left' => t('Left'),
      'right' => t('Right'),
      'center' => t('Center'),
    ),
    '#description' => t('The alignment of the header navigation bar.'),
  );

  // Width of Dropdown menus
  $form['layout']['sky_sub_navigation_width'] = array(
    '#type' => 'select',
    '#title' => t('Dropdown Menus Second Level Menu Width'),
    '#default_value' => $settings['sky_sub_navigation_width'],
    '#options' => sky_size_range(10, 30, 'em', 15),
    '#description' => t('The drop-down menus need a width. IF you find your menu items need to be adjusted smaller or larger, you can tweak the settings here.'),
  );

  // Adjust the height of the header, commonly requested in the issue queue.
  $form['layout']['sky_header_height'] = array(
    '#type' => 'textfield',
    '#title' => t('Height of Header (default is "100px")'),
    '#default_value' => $settings['sky_header_height'],
    '#description' => t('To tweak the height of the header, please enter the height in pixels or ems, ie. 100px, 5em'),
  );

  // Colors
  $form['colors'] = array(
    '#type' => 'fieldset',
    '#title' => 'Color Options',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  // Body Background Color
  $form['colors']['sky_background'] = array(
    '#type' => 'textfield',
    '#title' => t('Body Background'),
    '#default_value' => $settings['sky_background'],
    '#description' => t('Example: If you want a black background enter <code>#000000</code>.  If you want to include a background image, upload it to your server, and enter something like: <code>#fff url(\'/full/path/to/background/image.jpg\') repeat-x bottom left;</code>'),
  );

  // Heading Background Color
  $form['colors']['sky_background_header'] = array(
    '#type' => 'textfield',
    '#title' => t('Header Background'),
    '#default_value' => $settings['sky_background_header'],
    '#description' => t('Example: If you want a black background enter <code>#000000</code>.  If you want to include a background image, upload it to your server, and enter something like: <code>#fff url(\'/full/path/to/background/image.jpg\') repeat-x bottom left;</code>'),
  );

  // Fonts
  $form['fonts'] = array(
    '#type' => 'fieldset',
    '#title' => 'Font Options',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  // Base Font Size
  $form['fonts']['sky_font_size'] = array(
    '#type' => 'select',
    '#title' => t('Base Font Size'),
    '#default_value' => $settings['sky_font_size'],
    '#options' => sky_size_range(11, 16, 'px', 12),
    '#description' => t('Select the base font size for the theme.'),
  );

  // Base Font
  $form['fonts']['sky_font'] = array(
    '#type' => 'select',
    '#title' => t('Base Font'),
    '#default_value' =>  $settings['sky_font'],
    '#options' => sky_font_list(),
    '#description' => t('Select the base font for the theme.'),
  );

  // Headings Font
  $form['fonts']['sky_font_headings'] = array(
    '#type' => 'select',
    '#title' => t('Headings Font'),
    '#default_value' =>  $settings['sky_font_headings'],
    '#options' => sky_font_list(),
    '#description' => t('Select the base font for the heading (block, page titles and heading tags).'),
  );

  // Links
  $form['colors']['sky_links'] = array(
    '#type' => 'textfield',
    '#title' => t('Links: Normal'),
    '#default_value' => $settings['sky_links'],
    '#description' => t('Example: <code>#314C74</code> or <code>blue</code> NOTE: This will only change the links that are blue by default.'),
  );

  // Links: Active
  $form['colors']['sky_links_active'] = array(
    '#type' => 'textfield',
    '#title' => t('Links: Active'),
    '#default_value' => $settings['sky_links_active'],
    '#description' => t('Example: <code>#314C74</code> or <code>blue</code> NOTE: This will only change the links that are blue by default'),
  );

  // Links: Hover
  $form['colors']['sky_links_hover'] = array(
    '#type' => 'textfield',
    '#title' => t('Links: Hover'),
    '#default_value' => $settings['sky_links_hover'],
    '#description' => t('Example: <code>#314C74</code> or <code>blue</code> NOTE: This will only change the links that are blue by default'),
  );

  // Links: Visited
  $form['colors']['sky_links_visited'] = array(
    '#type' => 'textfield',
    '#title' => t('Links: Visited'),
    '#default_value' => $settings['sky_links_visited'],
    '#description' => t('Example: <code>#314C74</code> or <code>blue</code> NOTE: This will only change the links that are blue by default'),
  );

  // Generate custom.css and display a link to the file
  $form['sky_css'] = array(
    '#type' => 'fieldset',
    '#title' => 'Custom CSS Generation',
    '#description' =>  sky_write_css(), // This is the function that creates the custom.css file is created... Do not remove.
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  return $form;
}

function sky_build_css() {
  // Grab the current theme settings
  $theme_settings = variable_get('theme_sky_settings', '');
  if (!empty($theme_settings)) {
    // Build an array of only the theme related settings
    $setting = array();
    foreach ($theme_settings as $key => $value) {
      if (strpos($key, 'sky_') !== FALSE) {
        $setting[$key] = $value;
      }
    }
    // Handle custom settings for each case
    $custom_css = array();
    foreach ($setting as $key => $value) {
      switch ($key) {
        // Layout
        case 'sky_layout':
          // If a custom value is set for use "sky_custom_layout", ignore "sky_layout".
          if (!empty($setting['sky_custom_layout'])) {
            $custom_css[] = '#wrapper, #footer { width: '. $setting['sky_custom_layout'] .'; }';
          }
          else {
            switch ($value) {
              case 'fluid':
                $width = '100%';
                break;
              case 'fluid_98':
                $width = '98%';
                break;
              case 'fixed':default:
                $width = '960px';
                break;
            }
            $custom_css[] = '#wrapper, #footer { width: '. $width .'; }';
          }
        break;
        case 'sky_header_height':
          $custom_css[] = '#header { height: '. $value .'; }';
          break;
        case 'sky_sub_navigation_size':
          $custom_css[] = '#navigation ul ul, #navigation ul ul li  { width: '. $value .'; }';
          $custom_css[] = '#navigation li .expanded ul { margin: -2.65em 0 0 '. $value .'!important; }';
          break;

        // Colors
        case 'sky_background':
          $custom_css[] = (!empty($value)) ? 'html, body { background: '. $value .'; }' : '';
          break;
        case 'sky_background_header':
          $custom_css[] = (!empty($value)) ? '#header { background: '. $value .'; }' : '';
          break;
        case 'sky_links':
          $custom_css[] = (!empty($value)) ? 'a { color: '. $value .'; }' : '';
          break;
        case 'sky_links_hover':
          $custom_css[] = (!empty($value)) ? 'a:hover, a:visited:hover { color: '. $value .'; }' : '';
          break;
        case 'sky_links_active':
          $custom_css[] = (!empty($value)) ? 'a.active, li a.active { color: '. $value .'; }' : '';
          break;
        case 'sky_links_visited':
          $custom_css[] = (!empty($value)) ? 'a:visited { color: '. $value .'; }' : '';
          break;

        // Fonts
        case 'sky_font_size':
          $custom_css[] = (!empty($value)) ? '#wrapper { font-size: '. $value .'; }' : '';
          break;
        case 'sky_font':
        $custom_css[] = 'html, body, .form-radio, .form-checkbox, .form-file, .form-select, select, .form-text, input, .form-textarea, textarea  { font-family: '. sky_font_stack($value) .'; }';
          break;
        case 'sky_font_headings':
          $custom_css[] = 'h1, h2, h3, h4, h5, h6  { font-family: '. sky_font_stack($value) .'; }';
          break;
      }
    }
    return implode("\r\n", $custom_css);
    }
}

function sky_write_css() {
  // Set the location of the custom.css file
  $file_path = file_directory_path() .'/sky/custom.css';
  $directory = dirname($file_path);

  // If the directory doesn't exist, create it
  file_check_directory($directory, FILE_CREATE_DIRECTORY);

  // Generate the CSS
  $file_contents = sky_build_css();
  $output = '<div class="description">'. t('This CSS is generated by the settings chosen above and placed in the files directory: '. l($file_path, $file_path) .'. The file is generated each time this page (and only this page) is loaded. <strong class="marker">Make sure to refresh your page to see the changes</strong>') .'</div>';

  file_save_data($file_contents, $file_path, FILE_EXISTS_REPLACE);
  drupal_flush_all_caches();

  return $output;

}

/**
 * Helper function to provide a list of fonts for select list in theme settings.
 */
function sky_font_list() {
  $fonts = array(
    'Sans-serif' => array(
      'verdana' => t('Verdana'),
      'helvetica' => t('Helvetica, Arial'),
      'lucida' => t('Lucida Grande, Lucida Sans Unicode'),
      'geneva' => t('Geneva'),
      'tahoma' => t('Tahoma'),
      'century' => t('Century Gothic'),
    ),
    'Serif' => array(
      'georgia' => t('Georgia'),
      'palatino' => t('Palatino Linotype, Book Antiqua'),
      'times' => t('Times New Roman'),
    ),
  );
  return $fonts;
}

/**
 * Provides Font Stack values for theme settings which are written to custom.css
 * @see sky_font_list()
 */
function sky_font_stack($font) {
  if ($font) {
    $fonts = array(
      'verdana' => '"Bitstream Vera Sans", Verdana, Arial, sans-serif',
      'helvetica' => 'Helvetica, Arial, "Nimbus Sans L", "Liberation Sans", "FreeSans", sans-serif',
      'lucida' => '"Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", "DejaVu Sans", Arial, sans-serif',
      'geneva' => '"Geneva", "Bitstream Vera Serif", "Tahoma", sans-serif',
      'tahoma' => 'Tahoma, Geneva, "DejaVu Sans Condensed", sans-serif',
      'century' => '"Century Gothic", "URW Gothic L", Helvetica, Arial, sans-serif',
      'georgia' => 'Georgia, "Bitstream Vera Serif", serif',
      'palatino' => '"Palatino Linotype", "URW Palladio L", "Book Antiqua", "Palatino", serif',
      'times' => '"Free Serif", "Times New Roman", Times, serif',
    );

    foreach ($fonts as $key => $value) {
      if ($font == $key) {
        $output = $value;
      }
    }
  }
  return $output;
}

/**
 * Helper function to provide a list of sizes for use in theme settings.
 */
function sky_size_range($start = 11, $end = 16, $unit = 'px', $default = NULL) {
  $range = '';
  if (is_numeric($start) && is_numeric($end)) {
    $range = array();
    $size = $start;
    while ($size >= $start && $size <= $end) {
      if ($size == $default) {
        $range[$size . $unit] = $size . $unit .' (default)';
      }
      else {
        $range[$size . $unit] = $size . $unit;
      }
      $size++;
    }
  }
  return $range;
}