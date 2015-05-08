<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');

class TableChooseNoHeaderWidget extends AbstractWidget {
	public function make($columnHeads, $sql) {
		$rowList = array ();
		$queryList = db_query ( $sql );
		while ( $row = db_fetch_array ( $queryList ) ) {
			$columns = array ();
			
			foreach ( $row as $key=>$value ) {								
				array_push ( $columns, $value );
			}
			array_push ( $rowList, $columns );
		}
						
		$this->smarty->assign ( "rowList", $rowList );
		$this->smarty->assign ( "columnHeadList", $columnHeads );
		$this->smarty->display ( 'tableChooseNoHeader.widget' );
	}
}

?>