<?php

class ChannelModel extends Model {

    private $_db;

    /**
     * 构造方法,初始化
     */
    public function __construct() {
        parent::__construct();
        $this->_db = $this->getDb();
    }

    public function getlist($param = '', $limit = '') {
        if (!empty($param)) {
            $param = $this->_checkInput($param);
        }
        $where = '';
        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $where .= " AND c.name like '%{$keyword}%' ";
        }
        if (!empty($param['status'])) {
            $status = $param['status'];
            $where .= " AND c.status = {$status} ";
        }
        $sql = "SELECT c.id, c.name, c.status, c.created_at, COUNT(p.id) AS groupnumber FROM wx_channel c
            LEFT JOIN wx_partner_info p ON c.id = p.channel WHERE 1 {$where}
            GROUP BY c.id";
        try {
            $result = $this->_db->getAll($sql . $limit);
        } catch (Exception $e) {
            Logger::error($e->getMessage() . "<br/>" . $this->_db->getLastSql());
            return false;
        }
       
       $rows = array();
       foreach($result as $key => $v){
                $rows[$v['id']]['id'] = $v['id'];
                $rows[$v['id']]['name'] = $v['name'];
                $rows[$v['id']]['status'] = $v['status'];
                $rows[$v['id']]['created_at'] = $v['created_at'];
                $rows[$v['id']]['groupnumber'] = $v['groupnumber'];
       }
       
        return  $rows;
    }

    public function getlistcount($param = '') {
        $sql = "SELECT count(*) FROM wx_channel";
        if (!empty($param)) {
            $param = $this->_checkInput($param);
        }
        $where = '';
        if (!empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $where = " AND name like '%{$keyword}%' ";
        }
        if (!empty($param['status'])) {
            $status = $param['status'];
            $where = " AND status = {$status} ";
        }
        $where = ($where == '') ? '' : 'WHERE 1 ' . $where;

        try {
            $result = $this->_db->getOne($sql . $where);
        } catch (Exception $e) {
            Logger::error($e->getMessage() . "<br/>" . $this->_db->getLastSql());
            return false;
        }
        return $result;
    }

    public function add($param) {
        if (!empty($param)) {
            $param = $this->_checkInput($param);
        }
        try {
            $result = $this->_db->insert('wx_channel', $param);
        } catch (Exception $e) {
            Logger::error($e->getMessage() . "<br/>" . $this->_db->getLastSql());
            return false;
        }
        return $result;
    }
    
    //验证数据库渠道组名唯一
    public function verifyUnique($name =''){
       $sql = "SELECT name FROM wx_channel WHERE name = '{$name}'";
      // echo $sql;
        $result =$this->_db->getAll($sql);
       if($result){
           return $result;
       }
    }

    public function update($id, $param) {
        if (!empty($param)) {
            $param = $this->_checkInput($param);
        }
        $table = 'wx_channel';
        $where = " id = $id ";
        $set = $param;
        try {
            $result = $this->_db->update($table, $where, $set);
        } catch (Exception $e) {
            Logger::error($e->getMessage() . "<br/>" . $this->_db->getLastSql());
            return false;
        }
        return $result;
    }

    //查询一个
    public function getOne($id) {
        if (intval($id) == 0) {
            return;
        }
        $sql = "SELECT c.id, c.name, c.status, c.created_at, COUNT(p.id) AS groupnumber 
            FROM wx_channel c
            LEFT JOIN wx_partner_info p ON c.id = p.channel WHERE c.id = {$id} LIMIT 1";
        try {
            $result = $this->_db->getRow($sql);
        } catch (Exception $e) {
            echo $this->_db->getLastSql();
            Logger::error($e->getMessage() . "<br/>" . $this->_db->getLastSql());
            return false;
        }
        return $result;
    }

    //查询一个
    public function getOneCount($id) {
        if (intval($id) == 0) {
            return;
        }
        $sql = "SELECT COUNT(*) FROM wx_partner_info WHERE channel = {$id}";
        try {
            $result = $this->_db->getOne($sql);
        } catch (Exception $e) {
            Logger::error($e->getMessage() . "<br/>" . $this->_db->getLastSql());
            return false;
        }
        return $result;
    }

    /**
     * SQL防注入参数过滤
     * @param type $param
     * @return type
     */
    private function _checkInput($param) {
        if (is_array($param) && count($param)) {
            foreach ($param as $key => $val) {
                $param[$key] = addslashes($val);
            }
        }
        if (is_string($param)) {
            $param = addslashes($param);
        }
        return $param;
    }

    /**
     * csv头文件
     */
    private function _headerCsv() {
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . date('YmdHis') . ".csv");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
    }

    /**
     * 导出渠道组员
     * @param type $param
     */
    public function exportChanelUsers($param) {
        $this->_headerCsv();
        $str = iconv('utf-8', 'gbk', "渠道组名,合伙人编号,合伙人姓名,合伙人手机号\n");
        if ($param['ids']) {
            $sql = "SELECT c.id, c.name AS c_name, 
            p.id, p.name AS p_name, p.code AS p_code, p.phone AS p_phone
            FROM wx_channel c 
            LEFT JOIN wx_partner_info p ON c.id = p.channel
            WHERE c.id IN ({$param['ids']})";

            $rows = $this->_db->getAll($sql);

            if ($rows) {
                foreach ($rows as $item) {
                    $str .= iconv('utf-8', 'gbk', $item['c_name']) . ',';
                    $str .= iconv('utf-8', 'gbk', $item['p_code']) . ',';
                    $str .= iconv('utf-8', 'gbk', $item['p_name']) . ',';
                    $str .= iconv('utf-8', 'gbk', $item['p_phone']) . "\n";
                }
            }
        }
        echo $str;
    }

    /**
     * 导入渠道组员
     * @param type $id 渠道id
     * @param type $codes 组员编号
     * @param type $phones 组员电话
     */
    public function importChanelUsers($id, $codes = array(), $phones = array()) {
        if (!$id) {
            return false;
        }
        if (count($codes)) {
            $query_code = implode(',', $codes);
            $this->_db->query("UPDATE wx_partner_info SET channel = {$id} WHERE `code` IN ({$query_code})");
        }
        if (count($phones)) {
            $query_phone = implode(',', $phones);
            $this->_db->query("UPDATE wx_partner_info SET channel = {$id} WHERE phone IN ({$query_phone})");
        }
        return true;
    }

}
