<?php
/**
* 默认控制器
*
* @author     熊飞龙
* @date       2015-11-06
* @copyright  Copyright (c)  2015
* @version    $Id$
*/
class IndexAction extends Action {

    private $_Model = null;

    /*
    * 构造函数
    */
    public function __construct() {
        parent::__construct();
    }

    public function index ()
    {
        $url = url('User', 'index', null, 'index.php');
        header("Location:{$url}");
        exit;
    }
    
    /**
     * 活动规则页
     */
    public function QA() {
        $this->display('Index.QA');
    }
}