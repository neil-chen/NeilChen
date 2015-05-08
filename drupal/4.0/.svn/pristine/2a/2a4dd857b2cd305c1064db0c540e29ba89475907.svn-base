<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');
class ListWidget extends AbstractWidget {
	
	
	
	public function make($columnHeads , $sql , $sortField , $sortType , $page , $pageSize , $totalPage ) {

		$url = $_SERVER['SERVER_PROTOCOL'].':'.$_SERVER['SERVER_PORT'].'//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

		$this->smarty->assign ( "sql", $sql );
		$this->smarty->assign ( "action", $url );
		
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
		
		$defaultUrl=str_replace('list','edit',str_replace('?q=','',$_SERVER['REQUEST_URI']));
		
		$queryArray=explode("?",$defaultUrl);
		if(count($queryArray)>1){
			$defaultUrl=$defaultUrl.'&';
		}else{
			$defaultUrl=$defaultUrl.'?';
		}
		
		$this->smarty->assign ( "defaultUrl", $defaultUrl );
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