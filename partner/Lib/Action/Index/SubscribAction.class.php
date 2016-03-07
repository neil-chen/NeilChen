<?php
/**
 * 呼朋唤友 - 关注后的处理事件
 */
class SubscribAction extends Action {

    public function __construct() 
    {
        parent::__construct ();
        $this->model = loadModel ( 'Index.Invitation' );
        $this->assign('title', '呼唤朋友');
    }

    /**
     * 关注 后的事件
     */
    public function index ()
    {
        $this->model->subscrib($this->getParam());
    }
}