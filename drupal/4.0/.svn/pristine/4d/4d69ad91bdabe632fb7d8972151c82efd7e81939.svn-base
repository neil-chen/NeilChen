<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');
class DeviceTypeSingleWidget extends AbstractWidget {
	public function make($deviceTypeId=-1) {
		$rows = array ();
// 		$deviceList = db_query ( 'select b.nid as nid, title from content_type_devicetype a,node b where a.nid=b.nid and b.type="devicetype" order by b.title' );
		$deviceList = db_query ( 'SELECT vid , title FROM node where type="devicetype" ORDER BY title' );
		
		while ( $row = db_fetch_array ( $deviceList ) ) {
			$devcieType = array (
					"id" => $row ['vid'],
					"name" => $row ['title'] 
			);
			array_push ( $rows, $devcieType );
		}
				
		$this->smarty->assign("defaultDeviceTypeId",$deviceTypeId);
		$this->smarty->assign ( "deviceTypeList", $rows );
		$this->smarty->display ( 'deviceTypeSingle.widget' );
	}

	public function makeWithAll($deviceTypeId=-1) {
		$rows = array ();
		// 		$deviceList = db_query ( 'select b.nid as nid, title from content_type_devicetype a,node b where a.nid=b.nid and b.type="devicetype" order by b.title' );
		$deviceList = db_query ( 'SELECT vid , title FROM node where type="devicetype" ORDER BY title' );
	
		while ( $row = db_fetch_array ( $deviceList ) ) {
			$devcieType = array (
					"id" => $row ['vid'],
					"name" => $row ['title']
			);
			array_push ( $rows, $devcieType );
		}
	
		$this->smarty->assign("defaultDeviceTypeId",$deviceTypeId);
		$this->smarty->assign ( "deviceTypeList", $rows );
		$this->smarty->assign ( "includesAll", "true" );
		$this->smarty->display ( 'deviceTypeSingle.widget' );
	}
}
?>