<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');
class CommonWidget extends AbstractWidget {
	
	/**
	 * select widget
	 *
	 * @param unknown $select_name        	
	 * @param unknown $sql        	
	 * @param unknown $default_value        	
	 */
	public function makeSelect($select_name, $select_key_value_sql, $default_value) {
		$options = array ();
		// $results = db_query ( 'SELECT key , value FROM table' );
		$results = db_query ( $select_key_value_sql );
		
		while ( $row = db_fetch_array ( $results ) ) {
			$option = array (
					current ( $row ) => next ( $row ) 
			);
			
			array_push ( $options, $option );
		}
		
	/* 	if (isset ( $options ) && count ( $options ) > 0) {
			foreach ( $options as $option ) {
				if (isset($default_value) && key($option) == $default_value ) {
					print_r($option);
				}
			}
		} */
		
		$this->smarty->assign ( "options", $options );
		$this->smarty->assign ( "select_name", $select_name );
		$this->smarty->assign ( "default_value", $default_value );
		
		$this->smarty->display ( 'select.widget' );
	}
	

	public function makeRadioTable($columnHeads, $radio_name , $sql , $radio_checked_value) {
		// $results = db_query ( 'SELECT radio_value , values FROM table' );
		$rows = array ();
	
		$queryList = db_query ( $sql );
		while ( $row = db_fetch_array ( $queryList ) ) {  
			$columns = array ();
			while ( list ( $key, $val ) = each ( $row ) ) {
				array_push($columns , $val);
			}
			array_push ( $rows, $columns );
		}
		
		$this->smarty->assign ( "columnHeadList", $columnHeads );
		$this->smarty->assign ( "radio_name", $radio_name );
		$this->smarty->assign ( "radio_checked_value", $radio_checked_value );
		$this->smarty->assign ( "rowList", $rows );
		
		$this->smarty->display ( 'radioTable.widget' );
	}
	

	public function makecheckboxTable($columnHeads, $checkbox_name , $sql , $default_checked_value) {
		// $results = db_query ( 'SELECT radio_value , values FROM table' );
		$rows = array ();
	
		$queryList = db_query ( $sql );
		while ( $row = db_fetch_array ( $queryList ) ) {
			$columns = array ();
			while ( list ( $key, $val ) = each ( $row ) ) {
				array_push($columns , $val);
			}
			array_push ( $rows, $columns );
		}
	
		$this->smarty->assign ( "columnHeadList", $columnHeads );
		$this->smarty->assign ( "checkbox_name", $checkbox_name.'[]' );
		$this->smarty->assign ( "default_checked_value", $default_checked_value);
		$this->smarty->assign ( "rowList", $rows );
	
		$this->smarty->display ( 'checkboxTable.widget' );
	}
	


	public function makeList($columnHeads , $sql , $sortField , $sortType , $page , $pageSize , $totalPage) {
		$this->smarty->assign ( "sql", $sql );
		$rows = array ();
	
		if(!(empty($sortField)||empty($sortType))){
			$sql=$sql.' order by '.$sortField.' '.$sortType;
		}
	
		if(!(empty($page)||empty($pageSize))){
			$sql=$sql.' limit '.($page-1)*$pageSize.','.$pageSize;
		}
	
		$queryList = db_query ( $sql );
		while ( $row = db_fetch_array ( $queryList ) ) {
			$columns = array ();
			while ( list ( $key, $val ) = each ( $row ) ) {
				array_push($columns , $val);
			}
			array_push ( $rows, $columns );
		}
	
		$this->smarty->assign ( "rowList", $rows );
		$this->smarty->assign ( "columnList", $columnHeads );
		$this->smarty->assign ( "sortField", $sortField );
		$this->smarty->assign ( "sortType", $sortType );
		$this->smarty->assign ( "pageSize", $pageSize );
		$this->smarty->assign ( "page", $page );
	
	
		$this->smarty->display ( 'list.widget' );
	
	
		if  ($totalPage > 1) {
			$isFirst = false;
			if ($page == 1) {
				$isFirst = true;
			}
			$isLast = false;
	
			if ($page == $totalPage) {
				$isLast = true;
			}
	
			$firstPage = $page - 4 > 0 ? $page - 4 : 1;
			$lastPage = $page + 4 <= $totalPage ? $page + 4 : $totalPage;
			$previousPage = $page - 1 > 0 ? $page - 1 : 1;
			$nextPage = $page + 1 < $totalPage ? $page + 1 : $totalPage;
	
	
			print "<div class=\"item-list\"><ul class=\"pager\">";
			if (! $isFirst) {
				print "<li class=\"pager-first first\"><a href=\"javascript: gotopage(1)\" title=\"Go to first page\">« first</a></li>";
				print "<li class=\"pager-previous\"><a href=\"javascript: gotopage(".$previousPage.")\"  title=\"Go to previous page\">‹ previous</a></li>";
			}
			for($i = $firstPage; $i <= $lastPage; $i++) {
				$activeStyle = "";
				if ($i == $page) {
					$activeStyle = "class='active'";
				}
				print "<li class=\"pager-item\"><a href=\"javascript: gotopage(".$i.")\" title=\"Go to page ".$i."\" ".$activeStyle .">".$i."</a></li>";
	
			}
			if (! $isLast) {
				print "<li class=\"pager-next\"><a href=\"javascript: gotopage(".$nextPage.")\" title=\"Go to next page\" class=\"active\">next ›</a></li>";
				print "<li class=\"pager-last last\"><a href=\"javascript: gotopage(".$totalPage.")\" title=\"Go to last page\" class=\"active\">last »</a></li>";
			}
			print "</ul></div>";
	
	
		}
	}
	
	
	
}

?>