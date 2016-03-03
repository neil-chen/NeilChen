<?php 

/* author: neil
 * menu
 */
$url = $_SERVER['REQUEST_URI'];
$menu = array();
$menu['index'] = 'index_09.jpg';
$menu['about'] = 'index_10.jpg';
$menu['news'] = 'index_11.jpg';
$menu['product'] = 'index_12.jpg';
$menu['sale'] = 'index_13.jpg';
$menu['dhlc'] = 'index_14.jpg';
$menu['rcll'] = 'index_15.jpg';
$menu['contact'] = 'index_16.jpg';

if (strpos($url, 'index')) {
	$menu['index'] = 'menu_01.jpg';
}
if (strpos($url, 'about')) {
	$menu['about'] = 'menu_02.jpg';
}
if (strpos($url, 'news')) {
	$menu['news'] = 'menu_03.jpg';
}
if (strpos($url, 'product')) {
	$menu['product'] = 'menu_04.jpg';
}
if (strpos($url, 'sale')) {
	$menu['sale'] = 'menu_05.jpg';
}
if (strpos($url, 'dhlc')) {
	$menu['dhlc'] = 'menu_06.jpg';
}
if (strpos($url, 'rcll')) {
	$menu['rcll'] = 'menu_07.jpg';
}
if (strpos($url, 'contact')) {
	$menu['contact'] = 'menu_08.jpg';
}
?>
<table cellspacing="0" cellpadding="0" width="1002" align="center" border="0">
  <tbody>
	<tr>
	  <td>
		<img height="5" src="images/index_02.jpg" width="1002" />
	  </td>
	</tr>
	<tr>
	  <td>
		<table cellspacing="0" cellpadding="0" width="1002" border="0">
		  <tbody>
			<tr>
			  <td>
				<a href="/"><img height="89" src="images/index_04.jpg" width="656" /></a>
			  </td>
			  <td valign="top">
				<table cellspacing="0" cellpadding="0" border="0">
				  <tbody>
					<tr>
					  <td>
						<img height="32" src="images/index_05.jpg" width="346" />
					  </td>
					</tr>
					<tr>
					  <td>
						<table cellspacing="0" cellpadding="0" border="0">
						  <tbody>
							<tr>
							  <td valign="bottom" align="middle" width="334" background="images/index_06.jpg" height="25">
								<a class="hui" href="#" onClick="this.style.behavior='url(#default#homepage)'; this.setHomePage('http://www.shanghaiqifan.com');">设为首页</a> | 
								<a href="user.php">会员登录</a> | 
								<a class="hui" href="#" onClick="window.external.AddFavorite(parent.location.href, document.title);">加入收藏</a> | 
								<a href="http://mail.163.com/" target="_blank">邮箱登录</a>
							  </td>
							  <td>
								<img height="25" width="12" src="images/index_07.jpg" />
							  </td>
							</tr>
						  </tbody>
						</table>
					  </td>
					</tr>
					<tr>
					  <td width="346" height="32"></td>
					</tr>
				  </tbody>
				</table>
			  </td>
			</tr>
		  </tbody>
		</table>
	  </td>
	</tr>
	<tr>
	  <td>
		<table cellspacing="0" cellpadding="0" width="1002" border="0">
		  <tbody>
			<tr>
			  <td>
				<a href="index.php"><img src="images/<?php echo $menu['index'];?>"/></a>
			  </td>
			  <td>
				<a href="about.php"><img src="images/<?php echo $menu['about'];?>"/></a>
			  </td>
			  <td>
				<a href="news.php"><img src="images/<?php echo $menu['news'];?>"/></a>
			  </td>
			  <td>
				<a href="product.php"><img src="images/<?php echo $menu['product'];?>"/></a>
			  </td>
			  <td>
				<a href="sale.php"><img src="images/<?php echo $menu['sale'];?>"/></a>
			  </td>
			  <td>
				<a href="dhlc.php"><img src="images/<?php echo $menu['dhlc'];?>"/></a>
			  </td>
			  <td>
				<a href="rcll.php"><img src="images/<?php echo $menu['rcll'];?>"/></a>
			  </td>
			  <td>
				<a href="contact.php"><img src="images/<?php echo $menu['contact'];?>"/></a>
			  </td>
			</tr>
		  </tbody>
		</table>
	  </td>
	</tr>
  </tbody>
</table>
