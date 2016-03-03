<?php
/**
* demo
*
* @author     熊飞龙
* @date       2015-10-09
* @copyright  Copyright (c)  2015
* @version    $Id$
*/
class DemoAction extends Action {

    private $_Model = null;

    public function __construct ()
    {
        $this->_Model = loadModel('Admin.Demo');
    }

    /**
     * 列表
     */
    public function index () 
    {
        $params = $this->getParam();
        $params['isPage'] = true;

        $data = $this->_Model->getList($params);

        $pagination = new Pagination();
        $pageShow = $pagination->show($data['total']);

        $this->assign('page', $pageShow);
        $this->assign('list', $data['list']);
        $this->assign('statusList', $this->_Model->getStatusList());

        $this->display('Admin.Base.head');
        $this->display('Admin.Manage.index');
        $this->display('Admin.Base.foot');
    }

    /**
     * 新增 或 编辑 页面
     */
    public function edit ()
    {
        $params = $this->getParam();

        if (intval($params['user_id'])) {
            $detail = $this->_Model->getById($params['user_id']);
            if ($detail === false) {
                showMsg($this->getError());
            }

            if (empty($detail)) {
                showMsg('ID 对应的数据不存在！');
            }

            unset($detail['password']);

            $this->assign('formInit', $detail);
        }

        $companyModel = loadModel('Admin.Company');
        $companyList  = $companyModel->getSelectList();

        $roleModel = loadModel('Admin.Role');
        $roleList  = $roleModel->getSelectList();

        $this->assign('roleList', $roleList);
        $this->assign('companyList', $companyList);
        $this->assign('statusList', $this->_Model->getStatusList());

        $this->display('Admin.Base.head');
        $this->display('Admin.Manage.edit');
        $this->display('Admin.Base.foot');
    }
}