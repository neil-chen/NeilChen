<?php 

class Page2
{
    private $currentPage; //当前页
    private $totalRecord; //总记录条数
    private $pageSize;    //每页显示记录条数
    private $totalPage;   //总记录页数
    private $MaxPage;     //最大页码（其实始终和总记录页数相等）
    
    private $showPageMaxNum = 4; //页码显示数量
    private $showLeftPageNum;  //页码条最小页至当前页的 页码数
    private $showRightPageNum; //页码条最大页至当前页的 页码数
    private $showMinPage;      //页码条 显示最小页
    private $showMaxPage;      //页码条 显示最大页
    
    private $error;
    
    public function __construct($totalRecord, $pageSize){
        $this->totalRecord = $totalRecord;
        $this->pageSize = $pageSize;
        $this->totalPage = ceil($totalRecord/$pageSize);
        $this->MaxPage =$this->totalPage ;  
    }
    
    /**
     * 快速设置 
     * @param number $currentpage
     * @param number $showPageMaxNum
     * @return Ambigous <number, mixed>
     */
    public function quicklySet($currentpage = 1, $showPageMaxNum = 5){
        $this->setCurrentPage($currentpage);
        $this->setShowPageMaxNum($showPageMaxNum);
        $this->adjustPageArg();
        return $this->pageArray();
    }
    
    public function setCurrentPage($pageNum){
        $this->currentPage = $pageNum;
    }
    
    public function setShowPageMaxNum($num){
        $this->showPageMaxNum = $num;
    }
    
    public function adjustPageArg(){
        
        $_p = $this->currentPage;
        
//         if(!is_int($_p)){
//             $this->error =  $_p;
//             return;
//         }
        $this->currentPage = $_p <= 1 ? 1 : min($this->MaxPage, $_p);
        $this->showLeftPageNum = floor( ($this->showPageMaxNum - 1)/ 2) ;
        $this->showRightPageNum = floor($this->showPageMaxNum / 2);
        
        $leftflag = 1 + $this->showLeftPageNum;
        $rightflag = $this->MaxPage - $this->showRightPageNum;
        
        
        if( $_p  < $leftflag ){
            $this->showMinPage = 1; 
            $this->showMaxPage = min( $this->MaxPage ,  $this->showPageMaxNum );
        }else if( $_p >= $leftflag && $_p <= $rightflag ){
            $this->showMaxPage = $_p + $this->showRightPageNum;
            $this->showMinPage = $_p - $this->showLeftPageNum;
        }else if($_p >= $rightflag){
            $this->showMaxPage = $this->MaxPage;
            $this->showMinPage = max($this->MaxPage - $this->showPageMaxNum + 1, 1);
        }
        
    }
    
    public function returnlimit($needsWordLimit = true){
        $offset =($this->currentPage - 1) * $this->pageSize;
        $limit = $needsWordLimit ? " LIMIT $offset,$this->pageSize " : " $offset,$this->pageSize ";
        return $limit;
    }
    
    public function pageArray(){
        $page['minPage'] = $this->showMinPage;
        $page['maxPage'] = $this->showMaxPage;
        $page['currentPage'] = $this->currentPage;
        return $page;
    }
    
    public function checkArgument($num){
        $reg ="/^\d?$/";
        if(!preg_match($reg, $num)){
            $this->error = 'validate currentPage error: $this->currentPage=' + $num;
            return false;
        }
    }
}

?>