<html>
  <head>


    <script type="text/javascript" src="/covidien/misc/jquery.js"></script>
  </head>
  <body>
    <?php
    global $base_url;
    $theme = drupal_get_path('theme', 'covidien_theme');
    ?>
    <div id="header-region" class="clear-block"><div class="user_manage">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  </div></div>
    <div id="wrapper" style="width:1000px">
      <div id="container" class="clear-block" >

        <!--  <div id="header">
            
          </div>  /header -->

        <div class="head_and_menu" style='text-align:center;'>
          <div id="logo-floater">

            <h1><a href="<?php print $base_url . '/' ?>" ><img src="<?php echo $base_url . '/' . $theme; ?>/logo.png" id="logo" />        </div>
                <div style='margin-top:3px;height:40px'>
                  <h1><a href="<?php print $base_url . '/' ?>" ><?php echo t('Client Download'); ?></a></h1>		</div> 
                </div>
                </div>
                <div align="right" style="margin-top:20px;"></div>
                <!--<?php // if ($left):   ?>
                 <div id="sidebar-left" class="sidebar">
                    <div class="block block-theme"></div>                  </div>
                -->


                <div id="center">
                  <div class="right-corner"><div class="left-corner">
                      <div class="tabs_wrapper">
                      </div>
                      <div id="content-part" class="clear-block">
                        <div style="text-align: center">
                          <div style="text-align: center">
                            <form action="<?php echo $base_url . '/download/list' ?>" method="post">
                              <table align="center" width="100%" class="noborder">
                                <tr><td width="50%" align="right" class="noborder">			
                                    <b><?php echo t('Device Type:'); ?></b> <select name="sel_device_type">
                                      <option value='All' <?php print $isSelected ?>><?php echo t('All'); ?></option>
                                      <?php
                                      foreach ($dirs as $dir) {
                                        $isSelected = '';
                                        if ($deviceType == $dir) {
                                          $isSelected = 'selected';
                                        }
                                        ?>

                                        <option value='<?php print $dir ?>' <?php print $isSelected ?>><?php echo $dir ?></option>
                                        <?php
                                      }
                                      ?>

                                    </select>
                                  </td>
                                  <td width="50%" align="left" class="noborder"><input id="btn_search" type="button" value="search" class="form-submit" onclick='search()' />
                                  </td></tr>
                              </table>
                            </form>
                          </div>
                          <?php
                          if (!isset($allVersions)) {
                            ?>
                            <div style="text-align: center; margin-top: 20px">
                              <table class="content_tbl">
                                <tr>
                                  <th><?php echo t('Name'); ?></th>
                                  <th><?php echo t('Size(MB)'); ?></th>
                                  <th><?php echo t('File Upload Date'); ?></th>
                                  <th><?php echo t('Description'); ?></th>
                                </tr>
                                <?php
                                if (isset($versions)) {
                                  foreach ($versions as $version) {
                                    $fileUrl = 'download/download?filePath=' . $version ['name'] . '&deviceType=' . $deviceType;
                                    ?>

                                    <tr id="tr_content">
                                      <td><a href='<?php print $fileUrl ?>'><?php print $version['name']; ?></a></td>
                                      <td><a href='<?php print $fileUrl; ?>'><?php print $version['fileSize']; ?></a></td>
                                      <td><a href='<?php print $fileUrl; ?>'><?php print $version ['lastModified']; ?></a></td>
                                      <td><a href='<?php print $fileUrl; ?>'><?php print $version ['description']; ?></a></td>

                                    </tr>
                                    <?php
                                  }
                                }
                                ?>




                              </table>
                            </div>
                            <?php
                          } else {
                            foreach ($allVersions as $versions) {
                              ?>
                              <div style="text-align: center; margin-top: 20px">
                                <div style="text-align:center;width:100%;background-color:#8DB6CD;color:#003878;height:28px;padding-top:8px;font-size:14px;font-weight:bold;cursor:pointer" onclick="toggleTable(this)">
                                  <?php print current(array_keys($versions)) . ' ' . '(Total:' . count($versions[current(array_keys($versions))]) . ')' ?></div>
                                <div style="display:block">
                                  <table style="width:100%" class="content_tbl">			
                                    <tr>
                                      <th style="width:30%"><?php echo t('Name'); ?></th>
                                      <th style="width:20%"><?php echo t('Size(MB)'); ?></th>
                                      <th><?php echo t('File Upload Date'); ?></th>
                                      <th><?php echo t('Description'); ?></th>
                                    </tr>
                                    <?php
                                    foreach ($versions as $deviceType => $versionArray) {
                                      foreach ($versionArray as $version) {
                                        $fileUrl = 'download/download?filePath=' . $version ['name'] . '&deviceType=' . $deviceType;
                                        ?>

                                        <tr id="tr_content">
                                          <td><a href='<?php print $fileUrl ?>'><?php print $version['name']; ?></a></td>
                                          <td><a href='<?php print $fileUrl; ?>'><?php print $version['fileSize']; ?></a></td>
                                          <td><a href='<?php print $fileUrl; ?>'><?php print $version ['lastModified']; ?></a></td>
                                          <td><a href='<?php print $fileUrl; ?>'><?php print $version ['description']; ?></a></td>

                                        </tr>
                                      <?php }
                                    }
                                    ?>
                                  </table>
                                </div>
                              </div>

                            <?php }
                          }
                          ?>

                        </div>

                        <div align="right"><br /><a id="secondary_submit" href="<?php print base_path(); ?>"><?php echo t('Cancel'); ?></a></div>

                      </div>
                      <div id="footer"> </div>
                    </div></div></div></div>
                </body>
                <script>
                  function search() {
                    $("form").submit();
                  }

                  function toggleTable(comp) {
                    var next = $(comp).next();
                    if (next.css("display") == "none") {
                      next.slideDown("slow");
                    } else {
                      next.slideUp("slow");
                    }
                    next.css("width", "100%");
                  }
                </script>