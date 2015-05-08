<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');
class ConfigTypeWidget extends AbstractWidget {
	public function make($typeId=-1) {
		$rows = array ();
		$deviceList = db_query ( 'SELECT id,name FROM named_configuration_type ' );
		while ( $row = db_fetch_array ( $deviceList ) ) {
			$record = array (
					'id' => $row ['id'],
					'name' => $row ['name'] 
			);
			array_push ( $rows, $record );
		}
		$this->smarty->assign ( "defaultTypeId", $typeId );
		$this->smarty->assign ( "configTypeList", $rows );
		$this->smarty->display ( 'configType.widget' );
	}
}

?>