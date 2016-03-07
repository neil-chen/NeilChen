<?php

/**
 * @name 渠道管理
 * @author wangpa
 *
 */
class ChannelAction extends AdminAction {

    private $_a = null;
    private $_m = null;
    private $_status = null;
    private $_keyword = null;
    private $_name = null;
    private $_id = null;
    private $_Model;
    private $_param = null;

    public function __construct() {
        parent::__construct();
        $this->_a = $this->getParam('a');
        $this->_m = $this->getParam('m');
        $this->_param = $this->getParam();
        $this->assign('a', $this->_a);
        $this->assign('m', $this->_m);

        $this->_p = $this->getParam('p') ? intval($this->getParam('p')) : 0;
        $this->_status = $this->getParam('status');
        $this->_keyword = $this->getParam('keyword');
        $this->_name = $this->getParam('name');
        $this->_id = $this->getParam('id');

        $this->_Model = loadModel('Admin.Channel');

        $webdata = array(
            'keyword'=>$this->_keyword,
            'status' => $this->_status,
        );
        $this->assign('webdata', $webdata);
    }

    public function index() {

        $param = array(
            'status' => $this->_status,
            'keyword' => $this->_keyword
        );

        $result = $this->_Model->getlist($param);
        $count = $this->_Model->getlistcount($param);
        $pagesize = 10;

        $pageObj = new Page($count, $pagesize);
        $pageObj->parameter = "&" . http_build_query($param);
        $page = $pageObj->show();
        
        $page = new Page2($count, $pagesize);
        $page->quicklySet($this->_p,7);
        $limit = $page->returnlimit();
        $param['limit'] = $limit;

        foreach ($result as &$v) {
            foreach ($v as $key => &$value) {
                if ($key == 'created_at') {
                    $v['created_ats'] = empty($value) ? '' : date('Y-m-d H:i:s', $value);
                }
                if ($key == 'status') {
                    $v['status_name'] = $value == 1 ? '有效' : '无效';
                }
            }
        }

        $this->assign('page', $page->pageArray());
        $this->assign('param', $param);
        $this->assign('result', $result);
        $this->display('Admin.Channel.Channel');
    }

    //添加渠道组页面
    public function add() {
        $this->display('Admin.Channel.Add');
    }

    //添加渠道组处理接口
    public function addjson() {
        $param = array(
            'status' => $this->_status,
            'name' => $this->_name
        );
        $param['created_at'] = time();
        if ($param['status'] != 1 && $param['status'] != 2) {
            printJson(3, 'FAILED', '状态参数获取错误');
            exit;
        }
        $name=trim($param['name']);
        if(empty($name)){
             printJson(1, 'FAILED', '渠道组不能为空');
        }
        $res=$this->_Model->verifyUnique($name);
        if($res){
            printJson(1, 'FAILED', '该渠道组已经存在');
        }
        if ($this->_Model->add($param)) {
            printJson(1, 'OK', '添加成功');
        } else {
            printJson(2, 'FAILED', '添加失败');
        }
    }
    
 

    //编辑页面
    public function update() {
        $id = $this->_id;
        if (intval($id) == 0) {
            $url = url('Channel', 'index', '', 'admin.php');
            $this->redirect($url);
            exit;
        }
        $data = $this->_Model->getOne($id);
        foreach ($data as $k => &$v) {
            if ($k == 'created_at') {
                $data['created_ats'] = empty($v) ? '' : date('Y-m-d H:i:s', $v);
            }
        }

        $this->assign('data', $data);
        $this->display('Admin.Channel.Update');
    }

    //编辑渠道处理接口
    public function updatejson() {
        $param = array(
            'status' => $this->_status,
            'name' => $this->_name,
        );
        $id = $this->_id;
        if ($param['status'] != 1 && $param['status'] != 2) {
            printJson(3, 'FAILED', '状态参数获取错误');
            exit;
        }
        if (intval($id) == 0) {
            printJson(4, 'FAILED', 'id参数获取错误');
            exit;
        }
        if ($this->_Model->update($id, $param)) {
            printJson(1, 'OK', '编辑成功');
        } else {
            printJson(2, 'FAILED', '编辑失败');
        }
    }

    //渠道页面 批量设置无效
    public function setchannelstatus() {
        $param = array(
            'status' => $this->_status,
            'ids' => $this->_id
        );
        if ($param['status'] != 1 && $param['status'] != 2) {
            printJson(3, 'FAILED', '状态参数获取错误');
            exit;
        }
        if (strlen($param['ids']) == 0) {
            printJson(4, 'FAILED', '未获取到id');
            exit;
        }
        $idarray = explode(',', $param['ids']);
        $flag = true;
        unset($param['ids']);
        for ($i = 0; $i <= count($idarray) - 1; $i++) {
            $id = $idarray[$i];
            if (!$this->_Model->update($id, $param)) {
                $flag = false;
            }
        }
        if ($flag) {
            printJson(1, 'OK', '添加成功');
        } else {
            printJson(2, 'FAILED', '有数据添加失败');
        }
    }

    /**
     * 导入渠道组员列表
     */
    public function importChanelUsers() {
        //上传文件导入列表
        if ($_FILES) {
            $handle = fopen($_FILES["file"]["tmp_name"], 'r');
            $codes = $phones = array();
            while ($date = fgetcsv($handle)) {
                $codes[] = "'{$date[0]}'";
                $phones[] = "'{$date[1]}'";
            }
            $result = $this->_Model->importChanelUsers($this->_param['id'], $codes, $phones);
            $url = url('Channel', 'importChanelUsers', array('id' => $this->_param['id']), 'admin.php');
            if ($result) {
                echo "<script> alert('导入成功!');location.href = '{$url}'; </script>";
                //printJson(0, 'SUCCESS', '导入组员成功');
            } else {
                echo "<script> alert('导入失败!');location.href = '{$url}'; </script>";
                //printJson(1, 'FAILED', '导入组员失败');
            }
        }
        //不上传正常显示
        $channel = $this->_Model->getOne($this->_param['id']);
        $count = $this->_Model->getOneCount($this->_param['id']);
        $this->assign('channel', $channel);
        $this->assign('count', $count);
        $this->display('Admin.Channel.Import');
    }

    /**
     * 导出渠道组员列表
     */
    public function exportChanelUsers() {
        $this->_Model->exportChanelUsers($this->_param);
    }

}
