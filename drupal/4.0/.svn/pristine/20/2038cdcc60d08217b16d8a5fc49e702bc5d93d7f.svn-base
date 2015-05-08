<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');

class CommonTableChooseWidget extends AbstractWidget {
  /**
   * fucntion to initial widget.
   * 
   * @param unknown_type $htmlId
   * @param unknown_type $columnHeads
   * @param unknown_type $sql
   * @param unknown_type $fieldType
   * @param unknown_type $sortField
   * @param unknown_type $sortType
   * @param unknown_type $page
   * @param unknown_type $pageSize
   * @param unknown_type $totalPage
   */
  public function make($htmlId ,$columnHeads, $sql, $fieldType, $sortField , $sortType , $page , $pageSize , $totalPage) {
    $rowList = array ();

	if(!(empty($sortField)||empty($sortType))){
      $sql=$sql.' order by '.$sortField.' '.$sortType;
    }

    if(!(empty($page)||empty($pageSize))){
      $sql=$sql.' limit '.($page-1)*$pageSize.','.$pageSize;
    }
    
    $queryList = db_query ( $sql );
    while ( $row = db_fetch_array ( $queryList ) ) {
      $columns = array ();
      	
      foreach ( $row as $key=>$value ) {
        array_push ( $columns, $value );
      }
      array_push ( $rowList, $columns );
    }
    
    $this->smarty->assign ( "sql", $sql );
    $this->smarty->assign ( "htmlId", $htmlId );
    $this->smarty->assign ( "rowList", $rowList );
    $this->smarty->assign ( "columnHeadList", $columnHeads );
    $this->smarty->assign ( "fieldType", $fieldType );
    $this->smarty->assign ( "sortField", $sortField );
    $this->smarty->assign ( "sortType", $sortType );
    $this->smarty->assign ( "pageSize", $pageSize );
    $this->smarty->assign ( "page", $page );
    print "<div id='$htmlId'>";
    $this->smarty->display ( 'commonTableChoose.widget' );

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
    print "</div>";
  }
}

?>