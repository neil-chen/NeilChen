<?php

global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');

class DeviceTypeWidget extends AbstractWidget {
	
	public function make($deviceTypeId=-1) {
		$rows = array ();
// 		$deviceList = db_query ( 'SELECT a.nid , b.title FROM content_type_devicetype a,node b WHERE a.nid=b.nid and b.type="devicetype" ORDER BY b.title' );
		$deviceList = db_query ( 'SELECT nid , title FROM node where type="devicetype" AND nid in(select nid from content_field_device_product_line where field_device_product_line_nid='.$_SESSION['default_cot'].')ORDER BY title' );
		
		while ( $row = db_fetch_array ( $deviceList ) ) {
			array_push ( $rows, array($row ['nid'] => $row ['title']) );
		}
		
		global $base_url ;

		$this->smarty->assign("defaultDeviceTypeId",$deviceTypeId);
		$this->smarty->assign ( "action", $base_url.'/deviceType/namedConfig/list' );
		$this->smarty->assign ( "deviceTypeList", $rows );
		$this->smarty->display ( 'deviceType.widget' );
	}
	
	
	
	public function make2($action_url,$deviceTypeId=-1 ) {
		$rows = array ();
// 		$deviceList = db_query ( 'SELECT a.nid , b.title FROM content_type_devicetype a,node b WHERE a.nid=b.nid and b.type="devicetype" ORDER BY b.title' );
// 		$deviceList = db_query ( 'SELECT nid , title FROM node where type="devicetype" ORDER BY title' );
		$deviceList = db_query ( 'SELECT nid , title FROM node where type="devicetype" AND nid in(select nid from content_field_device_product_line where field_device_product_line_nid='.$_SESSION['default_cot'].')ORDER BY title' );
		
	
		while ( $row = db_fetch_array ( $deviceList ) ) {
			array_push ( $rows, array($row ['nid'] => $row ['title']) );
		}
	
		$this->smarty->assign("defaultDeviceTypeId",$deviceTypeId);
		$this->smarty->assign ( "action", $action_url );
		$this->smarty->assign ( "deviceTypeList", $rows );
		$this->smarty->display ( 'deviceType.widget' );
	}
	
	
	
}

?>