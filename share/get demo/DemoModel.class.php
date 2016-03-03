<?php
/**
* 示例
*
* @author     熊飞龙
* @date       2015-10-09
* @copyright  Copyright (c)  2015
* @version    $Id$
*/
class DemoModel extends Model {

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
            "{$this->_table}.user_id"    => empty($params['user_id'])    ? null : intval($params['user_id']),
            "{$this->_table}.company_id" => empty($params['company_id']) ? null : intval($params['company_id']),
            "{$this->_table}.dept_id"    => empty($params['dept_id'])    ? null : intval($params['dept_id']),
            "{$this->_table}.role_id"    => empty($params['role_id'])    ? null : intval($params['role_id']),
            "{$this->_table}.status"     => empty($params['status'])     ? null : intval($params['status']),
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
        $fields  = "{$this->_table}.*, company.company_name, dept.dept_name, role.role_name";

        $search = array(
            'fields'  => $fields,
            'like'    => array(
                'user_name' => empty($params['user_name']) ? null : $params['user_name'],
                'nick_name' => empty($params['nick_name']) ? null : $params['nick_name'],
            ),
            'where'   => $this->_initParams($params),
            'orderBy' => empty($params['orderBy']) ? $orderBy : $params['orderBy'],
            'join'    => array(
                'system_company' => array(
                    'as' => 'company',
                    'on' => "company.company_id = {$this->_table}.company_id",
                ),
                'system_dept' => array(
                    'as' => 'dept',
                    'on' => "dept.dept_id = {$this->_table}.dept_id",
                ),
                'system_role' => array(
                    'as' => 'role',
                    'on' => "role.role_id = {$this->_table}.role_id",
                ),
            ),
        );

        $search = array_merge($params, $search);

        $result = $this->_db->get($this->_table, $search);
        foreach ($result['list'] as &$val) {
            if (!empty($val['status'])) {
                $val['status_title'] = $this->_status[$val['status']];
            }
        }
        unset($val);

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
        if (empty($params['company_id'])) {
            $this->setError('请选择公司！');
            return false;
        }

        if (empty($params['dept_id'])) {
            $this->setError('请选择部门！');
            return false;
        }

        if (empty($params['user_id']) && empty($params['user_name'])) {
            $this->setError('请填写账号！');
            return false;
        }

        if (empty($params['user_id']) && empty($params['password'])) {
            $this->setError('请填写密码！');
            return false;
        }

        if (empty($params['role_id'])) {
            $this->setError('请选择角色！');
            return false;
        }

        if (empty($params['status'])) {
            $this->setError('请选择状态！');
            return false;
        }

        // -------------------------------------- 防止重复添加 START -------------------------------------- 
        $searchParams = array(
            'user_name' => $params['user_name'],
            'whereNotIn'   => array(
                'user_id' => !isset($params['user_id']) ? null : array($params['user_id']),
            ),
        );
        $detail = $this->getDetail($searchParams);
        if (!empty($detail)) {
            $this->setError(null, '该账号已经存在！');
            return false;
        }
        // -------------------------------------- 防止重复添加 END -------------------------------------- 

        $update = array(
            'user_name'  => $params['user_name'],
            'password'   => $this->_password($params['password']),
            'nick_name'  => $params['nick_name'],
            'email'      => $params['email'],
            'company_id' => intval($params['company_id']),
            'dept_id'    => intval($params['dept_id']),
            'role_id'    => intval($params['role_id']),
            'status'     => intval($params['status']),
        );

        if (isset($params["{$this->_tableKey}"]) && !empty($params["{$this->_tableKey}"])) {

            appendUpdateInfo($update);

            unset($update['user_id']);
            unset($update['user_name']);

            return $this->_db->update($this->_table, " {$this->_tableKey}=" . intval($params["{$this->_tableKey}"]), $update);

        } else {

            appendCreateUpdate($update);

            return $this->_db->insert($this->_table, $update);
        }
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
 
    /**
     * 使用示例
     */
    public function demo()
    {
        /**
         * DB get 方法使用示例
         */
        $demoParams = array(
            'fields'   => '',    // 需要获取的字段，默认为 *
            'keyName'  => '',    // 使用某个字段的值作为 KEY （通常为关联使用 例： 用 id 作为 key 能方便获得多维数组数据） 注意该字段数据必须为唯一的，否则key 会重复的
            'isPage'   => true,  // 是否需要分页处理，默认为 false （获取多条数据时，为 true 时会自动获得数据条数）
            'pageSize' => 10,    // 获取的数据条数，默认为10条 ( isPage 为 true 时使用)

            // 模糊查询
            'like'     => array(
                'name' => 'hei',   // 生成的结果 like '%hei%'
            ),

            // where 条件
            'where'   => array(
                'id'    => 1,
                'age >' => 20,  // 支持在字段中使用条件如 “ <、 <=、 >、 >=、 != ” 等
            ),

            // where Or （不支持在字段中使用条件如 “ <、 <=、 >、 >=、 != ” 等）
            'whereOr' => array(
                'id'    => 1,
                'age'   => 20,
                'age >' => 20,  // 不支持这种写法，这种写法拼成sql 语句会报错的。
            ),

            // where in (注意此处 value 类型必须为一维数组)
            'whereIn' => array(
                'id' => array(1,2,3),
                'id' => 1       // 不支持这种写法，这种写法拼成sql 语句会报错的。
            ),

            // where not in (注意此处 value 类型必须为一维数组)
            'whereNotIn' => array(
                'id' => array(1,2,3),
                'id' => 1       // 不支持这种写法，这种写法拼成sql 语句会报错的。
            ),

            // 联表查询
            'join'    => array(
                // key 为表名, 支持多个join
                'tableName' => array(
                    'as'   => 'tb', // 表的别名
                    'on'   => "tb.id = {$this->_table}.id", // ON 后面的条件
                    'type' => '',   // join 类型 （left、 inner、 right） 默认为 inner
                ),

                // 实用示例
                'system_dept' => array(
                    'as' => 'dept',
                    'on' => "dept.dept_id = {$this->_table}.dept_id",
                ),
            ),

            // 排序 (value 处不要加 order by )
            'orderBy' => 'id ASC, age DESC',    

            // 分组 (value 处不要加 group by )
            'groupBy' => 'age',
        );

        // * $demoParams 变量中如果 value 为 null 则会自动过滤
        $this->_db->get($this->_table, $demoParams);    // 获取列表

        // $this->_db->get($this->_table, $demoParams, true);    // 获取单条数据
    }
}