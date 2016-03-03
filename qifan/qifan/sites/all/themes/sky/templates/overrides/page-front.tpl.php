<?php // $Id$

/**
 * @file
 * Main template file
 *
 * @see template_preprocess_page(), preprocess/preprocess-page.inc
 * http://api.drupal.org/api/function/template_preprocess_page/6
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">
    <head>
      <?php print $head; ?>
      <title><?php print $head_title; ?></title>
      <?php print $styles; ?>
      <?php print $ie_styles; ?>
      <?php print $scripts; ?>
	<!-- add by neil -->
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-17338102-4']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
	<!-- add by neil end -->
    </head>
  <body<?php print $body_attributes; ?>>
  <?php if (!empty($admin)) print $admin; // support for: http://drupal.org/project/admin ?>
  <div id="wrapper">
  <!-- logo start -->
  <div id="header">
	<div id="top"><img src="sites/default/files/images/index_02.jpg"/></div>
	<div id="logo"><img src="sites/default/files/images/index_04.jpg"></div>
	<div id="top-rirgt">
		<a href="javascript:this.style.behavior='url(#default#homepage)';this.sethomepage('http://www.shanghaiqifan.com');">设为首页</a> | 
		<a href="user.php">会员登录</a> | 
		<a href="javascript:window.external.addfavorite(document.location.href,document.title)">加入收藏</a> | 
		<a href="http://mail.163.com/" target="_blank">邮箱登录</a>
	</div>
  </div>
  <div class="clear"></div>
  <!-- logo end -->
  <!-- menu start -->
  <div id="menu">
  	<ul>
  		<li id="menu1"><img src="sites/default/files/images/index_09.jpg"/></li>
  		<li id="menu2"><img src="sites/default/files/images/index_10.jpg"/></li>
  		<li id="menu3"><img src="sites/default/files/images/index_11.jpg"/></li>
  		<li id="menu4"><img src="sites/default/files/images/index_12.jpg"/></li>
  		<li id="menu5"><img src="sites/default/files/images/index_13.jpg"/></li>
  		<li id="menu6"><img src="sites/default/files/images/index_14.jpg"/></li>
  		<li id="menu7"><img src="sites/default/files/images/index_15.jpg"/></li>
  		<li id="menu8"><img src="sites/default/files/images/index_16.jpg"/></li>
  	</ul>
  </div>
  <div class="clear"></div>
  <!-- menu end -->
  <!-- banner start -->
  <div id="banner">
	<object height="263" width="1000" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0">
              <param value="sites/default/files/images/banner.swf" name="movie">
              <param value="high" name="quality">
              <param value="transparent" name="wmode">
              <embed height="263" width="1000" wmode="transparent" type="application/x-shockwave-flash" quality="high" src="sites/default/files/images/banner.swf">
	</object>
  </div>
  <!-- banner end -->
<!-- content start -->
<table cellspacing="0" cellpadding="0" width="1002" align="center">
	<tbody>
        <tr>
          <td width="389">
            <table cellspacing="0" cellpadding="0">

              <tbody>
                <tr>
                  <td>
                    <a href="news.php"><img src="sites/default/files/images/index_18.jpg" height="41" width="389"/></a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table cellspacing="0" cellpadding="0">

                      <tbody>
                        <tr>
                          <td valign="top">
                            <img height="233" src="sites/default/files/images/index_21.jpg" width="6" />
                          </td>
                          <td valign="top" width="382" height="233">
                            <table cellspacing="0" cellpadding="0" width="100%">
                              <tbody>
                                <tr>

                                  <td align="middle" height="5"></td>
                                </tr>
                                <tr>
                                  <td align="middle">
                                    <table cellspacing="0" cellpadding="0" width="90%">
                                      <tbody>
                                        <tr>
                                          <td align="left" width="106">
                                            <table cellspacing="1" cellpadding="3" bgcolor="#cccccc">

                                              <tbody>
                                                <tr>
                                                  <td></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td width="238">有人说，资金是企业的血液。这话不错，一个企业的正常运作的确离不开资金的支撑。那么产品的质量呢？依我...
                                          </td>

                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="middle" height="20"></td>
                                </tr>
                                <tr>

                                  <td align="middle">
                                    <table cellspacing="0" cellpadding="0" width="90%">
                                      <tbody>
                                        <tr>
                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">
                                            起帆代表出席《名牌战略与企业持续发展》研讨会
                                          </td>

                                        </tr>
                                        <tr>
                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">
                                            起帆电缆开展”迎世博,环境保护”集体活动
                                          </td>
                                        </tr>

                                        <tr>
                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">
                                            起帆产品实行电子监管
                                          </td>
                                        </tr>
                                        <tr>

                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">
                                            起帆网站成功改版
                                          </td>
                                        </tr>
                                        <tr>
                                          <td valign="center" width="15" height="20">

                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">
                                            起帆新厂区建设情况
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>

                                </tr>
                              </tbody>
                            </table>
                          </td>
                          <td valign="top">
                            <img height="233" src="sites/default/files/images/p_1.jpg" width="1"/>
                          </td>
                        </tr>
                      </tbody>

                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <img height="29" src="sites/default/files/images/index_29.jpg" width="389" />
                  </td>
                </tr>
              </tbody>

            </table>
          </td>
          <td valign="top" width="394">
            <table cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td>
                    <a href="news-1.php"><img height="41" src="sites/default/files/images/index_19.jpg" width="394"/></a>
                  </td>

                </tr>
                <tr>
                  <td>
                    <table cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td>
                            <img height="233" src="sites/default/files/images/p_2.jpg" width="6" />
                          </td>

                          <td valign="top" width="382" height="233">
                            <table cellspacing="0" cellpadding="0" width="100%">
                              <tbody>
                                <tr>
                                  <td align="middle" height="5"></td>
                                </tr>
                                <tr>
                                  <td align="middle">
                                    <table cellspacing="0" cellpadding="0" width="90%">

                                      <tbody>
                                        <tr>
                                          <td align="left" width="106">
                                            <table cellspacing="1" cellpadding="3" bgcolor=
                                            "#cccccc">
                                              <tbody>
                                                <tr>
                                                  <td></td>
                                                </tr>
                                              </tbody>

                                            </table>
                                          </td>
                                          <td width="238">海洋石油开发将迎来一个高速发展期，计划在2010年前使海洋石油的开采规模达到2003年两倍。...
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>

                                <tr>
                                  <td align="middle" height="20"></td>
                                </tr>
                                <tr>
                                  <td align="middle">
                                    <table cellspacing="0" cellpadding="0" width="90%">
                                      <tbody>
                                        <tr>
                                          <td valign="center" width="15" height="20">

                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">
                                            产品质量法
                                          </td>
                                        </tr>
                                        <tr>
                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>

                                          </td>
                                          <td height="28">
                                            工程建设项目货物招标投标办法
                                          </td>
                                        </tr>
                                        <tr>
                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>

                                          <td height="28">
                                            建筑节能与太阳能开发应用前景
                                          </td>
                                        </tr>
                                        <tr>
                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">

                                            美国超导公司携手上海电缆研究所进军中国超导电缆市场
                                          </td>
                                        </tr>
                                        <tr>
                                          <td valign="center" width="15" height="20">
                                            <img height="7" width="7" src="sites/default/files/images/arrow2.jpg"/>
                                          </td>
                                          <td height="28">
                                            目前全球塑料产业现状分析
                                          </td>

                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                          <td>

                            <img height="233" src="sites/default/files/images/index_25.jpg" width="6" />
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>

                    <img height="29" src="sites/default/files/images/index_30.jpg" width="394" />
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td width="219">
		<table cellspacing="0" cellpadding="0">
  <tbody>

	<tr>
	  <td>
		<img width="219" height="62" src="sites/default/files/images/index_20.jpg" alt="">
	  </td>
	</tr>
	<tr>
	  <td>
		<img width="219" height="135" usemap="#map3" src="sites/default/files/images/index_26.jpg">
	  </td>

	</tr>
	<tr>
	  <td align="center" width="219" valign="top" height="71" background="sites/default/files/images/jpeg.jpg">
		<table width="80%" cellspacing="0" cellpadding="0">
		  <tbody>
			<tr>
			  <td align="center">
				<a target="_blank" href="http://www.china-wire.net">中国电线电缆网</a>

			  </td>
			</tr>
			<tr>
			  <td align="center">
				<a target="_blank" href="http://www.smm.cn">上海有色金属网</a>
			  </td>
			</tr>
			<tr>

			  <td align="center">
				<a target="_blank" href="http://www.ometal.com">长江有色金属现货</a>
			  </td>
			</tr>
		  </tbody>
		</table>
	  </td>
	</tr>

	<tr>
	  <td>
		<img width="219" height="35" src="sites/default/files/images/index_28.jpg" alt="">
	  </td>
	</tr>
  </tbody>
</table>          </td>
        </tr>
      </tbody>

    </table>
    <table cellspacing="0" cellpadding="0" width="1002" align="center">
      <tbody>
        <tr>
          <td>
            <a href="product.php"><img height="37" src="sites/default/files/images/index_31.jpg" width="1002"/></a>
          </td>
        </tr>
        <tr>

          <td>
            <table cellspacing="0" cellpadding="0" width="1002">
              <tbody>
                <tr>
                  <td width="21">
                    <img height="127" src="sites/default/files/images/index_32.jpg" width="21" />
                  </td>
                  <td valign="center" align="middle" width="959" bgcolor="#F3F9F9" height="127">
                    <div id="demo" class="c1">

                      <table cellpadding="0" align="left" cellpadding="0">
                        <tbody>
                          <tr>
                            <td id="demo1" valign="top">
                              <table cellspacing="0" cellpadding="5" width="80%">
                                <tbody>
                                  <tr>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%">

                                        <tbody>
                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>

                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle">
                                              预制分支电缆
                                            </td>
                                          </tr>
                                        </tbody>

                                      </table>
                                    </td>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%" border="0">
                                        <tbody>
                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>

                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle">

                                              核用电缆
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%">
                                        <tbody>

                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>

                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle">
                                              矿用电缆
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>

                                    </td>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%">
                                        <tbody>
                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>
                                                  <tr>

                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle">
                                              架空电缆
                                            </td>

                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%">
                                        <tbody>
                                          <tr>
                                            <td align="middle">

                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>

                                          <tr>
                                            <td align="middle">
                                              控制电缆
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                    <td>

                                      <table cellspacing="0" cellpadding="0" width="80%">
                                        <tbody>
                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                  </tr>

                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle">
                                              布电线
                                            </td>
                                          </tr>

                                        </tbody>
                                      </table>
                                    </td>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%">
                                        <tbody>
                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">

                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>

                                            <td align="middle">
                                              铝绞线及钢芯铝绞线
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%">

                                        <tbody>
                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>

                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle">
                                              射频同轴电缆
                                            </td>
                                          </tr>
                                        </tbody>

                                      </table>
                                    </td>
                                    <td>
                                      <table cellspacing="0" cellpadding="0" width="80%">
                                        <tbody>
                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>

                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle">

                                              交联聚乙烯绝缘电缆
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                    <td>
                                      聚氯乙烯绝缘电缆
                                      <table cellspacing="0" cellpadding="0" width="80%">
                                        <tbody>

                                          <tr>
                                            <td align="middle">
                                              <table cellspacing="1" cellpadding="3" bgcolor="#d0dee1">
                                                <tbody>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>

                                            </td>
                                          </tr>
                                          <tr>
                                            <td></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>

                                </tbody>
                              </table>
                            </td>
                            <td id="demo2" valign="top"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </td>

                  <td width="22">
                    <img height="127" src="sites/default/files/images/index_34.jpg" width="22" />
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>

          <td>
            <img height="13" src="sites/default/files/images/index_35.jpg" width="1002" />
          </td>
        </tr>
      </tbody>
    </table>
<!-- content end -->
    <table cellspacing="0" cellpadding="0" width="1002" align="center" border="0">
      <tbody>
        <tr>
          <td align="left" background="sites/default/files/images/b_18.jpg">
            <table cellspacing="0" cellpadding="0" width="1002" border="0">
              <tbody>
                <tr>
                  <td width="5">
                    <img height="74" src="sites/default/files/images/p8.jpg" width="5" alt="Image" />
                  </td>
                  <td align="middle" width="987">

                    版权所有：上海起帆电线电缆有限公司<br />
                    地址：上海市青浦区重固镇北青公路5999号 电话：021-62901196 手机：13301700256
                  </td>
                  <td align="right" width="10">
                    <img height="74" src="sites/default/files/images/about_18.jpg" width="10" alt="Image" />
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <img height="16" src="sites/default/files/images/about_20.jpg" width="1002" alt="Image" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </body>
</html>