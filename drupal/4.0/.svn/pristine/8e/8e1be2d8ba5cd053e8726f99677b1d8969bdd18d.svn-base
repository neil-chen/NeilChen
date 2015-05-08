<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');

class AdminRegisterAlertWidget extends AbstractWidget {
    /**
     * fucntion to initial widget.
     * 
     * @param unknown_type $title
     * table title.
     * @param unknown_type $columnHeads
     * talbel column.
     * @param unknown_type $sql
     * the sql to query reocrds.
     */
	public function make($title,$columnHeads, $sql) {
		$rowList = array ();
		$queryList = db_query ( $sql );
		while ( $row = db_fetch_array ( $queryList ) ) {
			$columns = array ();
			
			foreach ( $row as $key=>$value ) {								
				array_push ( $columns, $value );
			}
			array_push ( $rowList, $columns );
		}
				
		$this->smarty->assign ( "title", $title );
		$this->smarty->assign ( "rowList", $rowList );
		$this->smarty->assign ( "columnHeadList", $columnHeads );
		$this->smarty->display ( 'adminRegisterAlert.widget' );
	}
}

?>