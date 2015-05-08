<?php
global $base_path;
global $drupal_downloadrepo, $agent_desc, $agent_file;
$theme = drupal_get_path('theme', 'covidien_theme');
?>
<html>
  <head>
    <link href="<?php echo $base_path . $theme; ?>/css/style.css" media="all" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo $base_path ?>misc/jquery.js"></script>
  </head>
  <body style='text-align: center;'>
    <div id="wrapper" >
      <div id="container">
        <!--  <div id="header"></div>  /header -->
        <div class="head_and_menu" style='text-align: center;'>
          <div id="logo-floater">
            <h1><img	src="<?php echo $base_path . $theme; ?>/logo.png" id="logo" /></h1>
          </div>
          <div style='margin-top: 3px; height: 40px'>
            <h1><?php echo t('Client Download'); ?></h1>
          </div>
        </div>
      </div>
      <div align="right" style="margin-top: 20px;"></div>
      <!-- content -->
      <div id="center" style="width:950px\9;">
        <div id="content-part" class="clear-block" style="padding-left: 25px; margin:0px;">
          <div style="text-align: center;">
            <?php
            if (!isset($files) || count($files) == 0) {
              ?>
              No client download application available.
              <?php
            } else {
              ?>
              <table style="width: 100%;border-right: 0 none;" class="content_tbl" cellspacing="0">
                <?php
                $fileNumbers = count($files); //content 
                $index = 1;
                $rows = ceil($fileNumbers / 3); //row
                for ($i = 0; $i < $rows; $i ++) {
                  ?>
                  <tr>
                    <?php
                    for ($j = 0; $j < 3; $j ++) {
                      if ($index <= $fileNumbers) {
                        ?>
                        <td style="width: 33%;text-align: center;" onmouseover='highlight(this)' onmouseout='nohighlight(this)'>
                          <div>
                            <h2 style="margin: 0; padding: 5px;">
                              <?php echo $files[$index]['title']; ?>
                            </h2>
                            <a href='<?php echo $base_path . $files[$index]['filepath']; ?>'>
                              <img style="width: 200px;" src="<?php echo $base_path . $files[$index]['image']; ?>" />
                            </a>
                          </div>
                          <div>
                            <a href="<?php echo $base_path . $files[$index]['filepath']; ?>">
                              <?php echo $files[$index]['text']; ?>
                            </a>
                          </div>
                        </td>
                        <?php
                      } else {
                        ?>
                        <td style="width:33%">&nbsp;</td>
                        <?php
                      }
                      $index++;
                    }
                    ?>										
                  </tr>
                  <?php
                }
              }
              ?>
            </table>
          </div>
          <!-- footer -->
          <div id="footer" style="margin-top: 20px; padding: 0; height: auto; text-align: left;">
            <div class="footer_image">
              <a href="<?php echo $agent_file; ?>">
                <img src="<?php echo $base_path . $theme ?>/images/download_logo_image.png" width="300px"/>
              </a>
            </div>
            <div class="footer_text" style="background: #013E7F;width: 290px;width: 300px\9;padding:5px; margin-top:15px;text-align: center;font-weight: bold;">
              <a href="<?php echo $agent_file; ?>" style="color: #FFFFFF;"><?php echo $agent_desc; ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<script>
  function highlight(comp) {
    $(comp).css("border", "2px solid #E066FF");
  }

  function nohighlight(comp) {
    $(comp).css("border", "");
    $(comp).css("border-right", "1px solid #D1D3D4");
  }
</script>
