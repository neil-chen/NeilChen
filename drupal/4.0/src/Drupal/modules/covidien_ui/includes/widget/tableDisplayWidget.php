<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');

class TableDisplayWidget extends AbstractWidget {
	
	public function make($title,$columnHeads) {		
				
		$this->smarty->assign ( "title", $title );		
		$this->smarty->assign ( "columnHeadList", $columnHeads );
		$this->smarty->display ( 'tableDisplay.widget' );
	}
}

?>