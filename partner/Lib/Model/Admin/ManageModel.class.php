<?php
/**
* 用户管理
*
* @author     熊飞龙
* @date       2015-09-22
* @copyright  Copyright (c)  2015
* @version    $Id$
*/
class ManageModel extends Model {

    private $_db       = null;
    private $_table    = 'system_user';    // 表名
    private $_tableKey = 'user_id';        // 表的主键

    // 状态列表
    private $_status = array(
        1 => '有效',
        2 => '作废',
    );

    public function __construct () 
    {
        $this->_db = Factory::getDb();
    }

    /**
     * 初始化查询参数
     *
     * @access  private
     *
     * @param   array   $params     查询参数
     *
     * @return  array
     */
    private function _initParams (array $params = array())
    {
        $where = array(
            "user_id"    => empty($params['user_id'])    ? null : intval($params['user_id']),
            "user_name"  => empty($params['user_name'])  ? null : $params['user_name'],
            "status"     => empty($params['status'])     ? null : intval($params['status']),
        );

        return $where;
    }

    /**
     * 获得状态列表
     */
    public function getStatusList ()
    {
        return $this->_status;
    }

    /**
     * 列表
     * 
     * @param  array  $params
     * 
     * @return array
     */
    public function getList (array $params = array())
    {
        $orderBy = "{$this->_tableKey} DESC";

        $search = array(
            'like'    => array(
                'company_name' => empty($params['like_company_name']) ? null : $params['like_company_name'],
            ),
            'where'   => $this->_initParams($params),
            'orderBy' => empty($params['orderBy']) ? $orderBy : $params['orderBy'],
        );

        $search = array_merge($params, $search);

        $result = $this->_db->get($this->_table, $search);

        return $result;
    }

    /**
     * 获得详情
     * 
     * @param  array  $params
     * 
     * @return array
     */
    public function getDetail (array $params = array())
    {
        $search = array(
            'where'   => $this->_initParams($params),
        );
        $search = array_merge($params, $search);
        $info = $this->_db->get($this->_table, $search, true);

        return $info;
    }

    /**
     * 根据 ID 获得详情
     * 
     * @param  int     $id    
     * @param  varchar $fields
     * 
     * @return array|bool
     */
    public function getById ($id = null, $fields = null)
    {
        if (empty($id)) {
            $this->setError(null, '缺少必要参数 ID ');
            return false;
        }

        $params = array(
            'fields' => $fields,
            "{$this->_tableKey}" => intval($id),
        );

        $info = $this->getDetail($params);

        return $info;
    }

    /**
     * 更新 或 添加
     * 
     * @param  array  $params
     * 
     * @return bool
     */
    public function update (array $params = array())
    {
        if (empty($params['user_id']) && empty($params['user_name'])) {
            $this->setError(null, '请填写账号！');
            return false;
        }

        if (empty($params['user_id']) && empty($params['password'])) {
            $this->setError(null, '请填写密码！');
            return false;
        }

        if (empty($params['status'])) {
            $this->setError(null, '请选择状态！');
            return false;
        }

        // -------------------------------------- 防止重复添加 START -------------------------------------- 
        if (!isset($params["{$this->_tableKey}"]) || !intval($params["{$this->_tableKey}"])) {
            $searchParams = array(
                'user_name'  => $params['user_name'],
                'whereNotIn' => array(
                    'user_id' => !isset($params['user_id']) ? null : array($params['user_id']),
                ),
            );
            $detail = $this->getDetail($searchParams);
            if (!empty($detail)) {
                $this->setError(null, '该账号已经存在！');
                return false;
            }
        }
        // -------------------------------------- 防止重复添加 END -------------------------------------- 

        $update = array(
            'user_name'   => $params['user_name'],
            'password'    => $this->_password($params['password']),
            'nick_name'   => $params['nick_name'],
            'email'       => $params['email'],
            'status'      => intval($params['status']),
            'create_time' => date('Y-m-d H:i:s'),
        );

        if (isset($params["{$this->_tableKey}"]) && !empty($params["{$this->_tableKey}"])) {

            unset($update['user_id']);
            unset($update['user_name']);

            if (empty($params['password'])) {
                unset($update['password']);
            }

            return $this->_db->update($this->_table, " {$this->_tableKey}=" . intval($params["{$this->_tableKey}"]), $update);

        } else {

            return $this->_db->insert($this->_table, $update);
        }
    }

    /**
     * 用户登录认证
     * 
     * @param  array  $params [description]
     * 
     * @return bool|array
     */
    public function checkLogin (array $params)
    {
        if (empty($params['user_name'])) {
            $this->setError(null, '请输入用户名！');
            return false;
        }

        if (empty($params['password'])) {
            $this->setError(null, '请输入密码！');
            return false;
        }

        if (empty($params['verify_code'])) {
            $this->setError(null, '请输入验证码！');
            return false;
        }

        // 验证码是否输入正确
        if($_COOKIE['verify'] != md5($params['verify_code'])){
            $this->setError(null, '验证码错误!');
            return false;
        }

        // 获取用户信息
        $userParam = array(
            'user_name' => $params['user_name'],
        );
        $userInfo = $this->getDetail($userParam);
        if (empty($userInfo)) {
            $this->setError(null, '输入的用户名不存在！');
            return false;
        }

        if ($this->_password($params['password']) != $userInfo['password']) {
            $this->setError(null, '用户名或密码不正确！');
            return false;
        }

        $_SESSION['userInfo'] = $userInfo;

        return true;
    }

    /**
     * 给 SELECT 标签用的数据
     */
    public function getSelectList ()
    {
        $params = array(
            'fields'  => 'user_id, user_name',
            'isPages' => false,
        );

        $result = $this->getList($params);

        return $result['list'];
    }

    /**
     * 密码加密
     * 
     * @param  varchar  $password
     * 
     * @return varchar
     */
    private function _password ($passrod)
    {
        return md5(sha1(md5($passrod)));
    }
}