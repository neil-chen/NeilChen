<?php
global $drupal_abs_path;

require ($drupal_abs_path . '/sites/all/libraries/smarty/Smarty.class.php');

abstract class AbstractWidget {
	protected $smarty;
	public function __construct() {		
		global $drupal_abs_path;
		$widget_path = $drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/';
		$this->smarty = new Smarty ();
		$this->smarty->template_dir = $widget_path.'template/';		
		$this->smarty->compile_dir = $widget_path.'templates_c/';
		$this->smarty->config_dir = $widget_path.'configs/';
		$this->smarty->cache_dir = $widget_path.'cache/';
		
		$this->smarty->caching = false;
		$this->smarty->left_delimiter = "{#";
		$this->smarty->right_delimiter = "#}";
	}
	
}

?>