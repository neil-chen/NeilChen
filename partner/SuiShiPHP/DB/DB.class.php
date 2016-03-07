<?php
/**
 * mysql 数据库操作类
 *
 */

class DB {

	private $debug            = false;  // same as $trace
	private $num_queries      = 0;//操作次数
	private $queries          = array();
	private $last_query       = null;//最后一个sql
	private $last_error       = null;//最后一个错误信息
	private $insertId;
    // 事务指令数
    private $transTimes      = 0;

	private $link ;
	protected $host;
	private $user;
	private $password;
	protected $dbname;
	Private $charset = 'utf8';
	protected $lastQueryTime;

	public function __construct($host, $user, $password, $dbname , $connect = false,$charset = 'utf8') {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->charset = $charset;

		if ($connect) {
			$this->connect();
		}
	}

	//链接数据库
	public function connect () {
		if (!function_exists('mysql_connect')) {
			$this->error("undefined function mysql_connect(), 请加载php_mysql模块");
			return false;
		}
	    if ($this->link && mysql_ping($this->link)) {
	        return true;
	    }
            if ($this->link) {
	    	@mysql_close($this->link);
	    }
	    $startT = microtime(true);
		if (!$this->link = @mysql_connect($this->host, $this->user, $this->password, true)) {
			$this->lastQueryTime = sprintf("%.4f",(microtime(true) - $startT) * 1000);
			$this->error("connect error！ " . mysql_error(), array($this->host,$this->user,$this->password));
			return false;
		}
		mysql_query("set names " . $this->charset , $this->link);
		$this->lastQueryTime = (microtime(true) - $startT) * 1000;
		$this->logger('connect db');
		if ($this->dbname) {
			$this->selectDb();
		}
		return true;
	}

	//选择库
	public function selectDb ($dbname = null) {
		if ($dbname) {
			$this->dbname = $dbname;
		}
		if (!$this->link) return;

		if (!@mysql_select_db($this->dbname, $this->link)) {
			$this->error("select db error : " . mysql_error());
			return;
		}
		mysql_query("set names " . $this->charset , $this->link);
	}

	/**
     * 搜索
     * 
     * @param  string $table    表名
     * @param  array  $params   条件参数
     * @param  bool   $isRow    是否只显示一条记录（主要给 getRow 函数用）
     * 
     * @return array
     */
    public function get($table, array $params = array(), $isRow = false)
    {
        $total = 0;
        $debug = array();

        // 过滤掉 值为 null 的 key
        invalidDataFilterRecursive($params, array(null));

        $fields     = !isset($params['fields'])        ? '*'  : $params['fields'];              // 需要获得的字段
        $keyName    = !isset($params['keyName'])       ? null : $params['keyName'];             // 使用某个字段做为数组中的 KEY（注意要保持唯一，否则会丢数据）
        $isPage     = !isset($params['isPage'])        ? null : $params['isPage'];              // 是否需要分页，默认不分页
        $pageNo     = !isset($_GET['page'])            ? 0    : intval($_GET['page']);          // 当前页码（默认第1页）
        $pageSize   = !isset($params['pageSize'])      ? null : intval($params['pageSize']);    // 每页显示数据条数（有分页的情况下，默认 10 条）
        $orderBy    = !isset($params['orderBy'])       ? null : $params['orderBy'];             // 排序
        $groupBy    = !isset($params['groupBy'])       ? null : $params['groupBy'];             // 分组
        $join       = !isset($params['join'])          ? null : (!is_array($params['join'])       ? null : $params['join'] );        // inner join 查询
        $like       = !isset($params['like'])          ? null : (!is_array($params['like'])       ? null : $params['like'] );        // 模糊查询
        $where      = !isset($params['where'])         ? null : (!is_array($params['where'])      ? null : $params['where'] );       // where 条件
        $whereOr    = !isset($params['whereOr'])       ? null : (!is_array($params['whereOr'])    ? null : $params['whereOr'] );     // OR 条件
        $whereIn    = !isset($params['whereIn'])       ? null : (!is_array($params['whereIn'])    ? null : $params['whereIn'] );     // In 条件
        $whereNotIn = !isset($params['whereNotIn'])    ? null : (!is_array($params['whereNotIn']) ? null : $params['whereNotIn'] );  // Not In 条件

        $likeSql = "";

        // join
        $joinSql = "";
        if ($join && is_array($join)) {
            foreach ($join as $key => $val) {
                if ($val['on']) {
                    $as      = empty($val['as']) ? ' AS ' . $key : 'AS ' . $val['as'];  // 别名
                    $type    = empty($val['type']) ? 'INNER' : $val['type'];    // join 类型 （left、 inner、 right）
                    $joinSql .= ' ' . $type . " JOIN `" . $key . "` " . $as . " ON ". $val['on'];
                }
            }
        }
        
        if ($like && is_array($like)) {
            foreach ($like as $key => $val) {
                $likeSql .= " AND `" . $key . "` like '%{$val}%'";
            }
        }

        $whereSql = "";
        if ($where && is_array($where)) {

            foreach ($where as $key => $val) {

                // 联表查询时可能会写 “表名.字段”
                $tempArr      = explode('.', $key);
                $tempTableAs  = empty($tempArr[1]) ? '' : '`' . $tempArr[0] . '`.';
                $tempTableKey = empty($tempArr[1]) ? trim($key) : trim($tempArr[1]);

                // preg_match_all('/(\W+))/', $tempTableKey, $data, PREG_SET_ORDER);    // 这种写法不支持在字段上使用函数
                preg_match_all('/[!=|<=|>=|<|>|<>]+/', $tempTableKey, $data, PREG_SET_ORDER);

                if (!empty($data)) {
                    $tempWhere   = $data[0][0]; // 过滤后的字段名
                    $tempKey    = trim(str_replace($tempWhere, '', $tempTableKey));

                    $whereSql .= " AND " . $tempTableAs . '`' . trim($tempKey) . '` ' . $tempWhere . " '{$val}'";

                // 正常的 “=” 模式
                } else {

                    // 检查字段中是否使用了函数，即使用 “(.*)” 做为标准
                    preg_match_all('/(\(.*\))+/', $tempTableKey, $keyData, PREG_SET_ORDER);

                    // 带函数的写法
                    if (!empty($keyData)) {
                        $whereSql .= " AND " . $tempTableAs . trim($tempTableKey) . " = '{$val}'";
                    } else {
                        $whereSql .= " AND " . $tempTableAs . '`' . trim($tempTableKey) . "` = '{$val}'";
                    }
                }
            }
        }

        $whereOrSql = "";
        if ($whereOr && is_array($whereOr)) {
            $whereOrSql .= " AND (";
            foreach ($whereOr as $key => $val) {
                $whereOrSql .= " `" . $key . "`='{$val}' OR";
            }

            $whereOrSql = substr($whereOrSql, 0, -3);
            $whereOrSql .= " ) ";
        }

        $whereInSql = "";
        if ($whereIn && is_array($whereIn)) {
            foreach ($whereIn as $key => $val) {
                $whereInSql .= " AND `" . $key . "` IN('" . implode("', '", $val) . "')";
            }
        }

        $whereNotInSql = "";
        if ($whereNotIn && is_array($whereNotIn)) {
            foreach ($whereNotIn as $key => $val) {
                $whereNotInSql .= " AND `" . $key . "` NOT IN('" . implode("', '", $val) . "')";
            }
        }

        $orderBySql = "";
        if ($orderBy && !empty($orderBy)) {
            $orderBySql = " ORDER BY " . $orderBy;
        }

        $groupBySql = "";
        if ($groupBy && !empty($groupBy)) {
            $groupBySql = " Group BY " . $groupBy;
        }

        $dataCount = 0;
        if ($isPage && !$isRow) {
            $sql = "SELECT count(*) FROM `{$table}` {$joinSql} WHERE 1 {$likeSql}{$whereSql}{$whereOrSql}{$whereInSql}{$whereNotInSql}{$groupBySql}";

            $dataCount = $this->getOne($sql);
            $dataCount = intval($dataCount);
            $debug[] = $sql;
        }

        $limit = "";
        if ($isPage && !$isRow) {

            $pageSize = !intval($pageSize)  ? 10 : $pageSize;

            if ($pageNo == 0 || $dataCount == 0) {
                $pageNo = "0, ";
            } else {

                $no     = intval(($pageNo - 1) * $pageSize);
                $maxNo  = (ceil($dataCount / $pageSize) - 1 ) * $pageSize;
                $no     = $no > $maxNo ? $maxNo : $no;
                $pageNo = $no . ", ";
            }

            $limit = " LIMIT {$pageNo}{$pageSize}";
        }

        // 不分页的情况，但指定了获取数据的条数
        if ($pageSize && !$isPage) {
            $limit = " LIMIT {$pageSize}";
        }

        // 如果只需要显示一条数据到此结束运行
        if ($isRow) {
            $sql = "SELECT {$fields} FROM `{$table}` {$joinSql} WHERE 1 {$likeSql}{$whereSql}{$whereOrSql}{$whereInSql}{$whereNotInSql}{$groupBySql}{$orderBySql} LIMIT 1";
            $info = $this->getRow($sql);

            return empty($info) ? array() : $info;
        }

        $sql = "SELECT {$fields} FROM `{$table}` {$joinSql} WHERE 1 {$likeSql}{$whereSql}{$whereOrSql}{$whereInSql}{$whereNotInSql}{$groupBySql}{$orderBySql}{$limit}";

        $list = $this->getAll($sql);

        // 使用字段值做为 KEY
        if ($keyName) {

            $tempResult = array();
            foreach ($list as $key => $val) {
                $tempKey = isset($val[$keyName]) ? $val[$keyName] : $key ;
                $tempResult[$tempKey] = $val;
            }

            $list = $tempResult;
        }

        $debug[] = $sql;

        unset($fields, $keyName, $isPage, $pageNo, $pageSize, $like, $where, $whereOr, $whereIn, $whereNotIn, $orderBy, $groupBy, $sql);

        return array(
            'list'  => empty($list) ? array() : $list,
            'total' => intval($dataCount),
            'debug' => $debug,
        );
    }

	//按sql获取所有
	public function getAll($sql) {
		$res = $this->query($sql);
		if ($res !== false) {
			$arr = array();
			while ($row = mysql_fetch_assoc($res)) {
				$arr[] = $row;
			}
			return $arr;
		} else {
			return null;
		}
	}

	//按sql获取一条数据
	public function getRow($sql, $limited = false) {
		if ($limited == true) {
			$sql = trim($sql . ' LIMIT 1');
		}

		$res = $this->query($sql);
		if ($res !== false) {
			return mysql_fetch_assoc($res);
		} else {
			return null;
		}
	}

	//按sql获取第一个字段数据列表
	public function getCol($sql) {
		$res = $this->query($sql);
		if ($res !== false) {
			$arr = array();
			while ($row = mysql_fetch_row($res)) {
				$arr[] = $row[0];
			}
			return $arr;
		} else {
			return null;
		}
	}

	//按sql获取第一条数据的第一列到值
	public function getOne ($sql) {
		$res = $this->query($sql);
		if ($res !== false) {
			$row = mysql_fetch_row($res);
			return $row[0];
		} else {
			return null;
		}
	}

	/**
     * 启动事务
     * @return void
     */
    public function startTrans() {
    	if (!$this->link || $this->transTimes <= 0) {
    		$conn = $this->connect();
    	} else {
    		$conn = mysql_ping($this->link);
    	}

        if ( !$conn ) {
        	$this->error('开启事务时数据库链接异常');
        }
        //数据rollback 支持
        if ($this->transTimes == 0) {
            $tran = mysql_query('START TRANSACTION', $this->link);
            if (!$tran) {
            	$this->error('开启事务异常: '.mysql_error($this->link));
            }
        }
        $this->transTimes++;
        return ;
    }

    /**
     * 用于非自动提交状态下面的查询提交
     * @return boolen
     */
    public function commit()
    {
        if ($this->transTimes > 0) {
            $result = mysql_query('COMMIT', $this->link);
            $this->transTimes = 0;
            if(!$result){
                $this->error("数据库事务提交失败！ " . mysql_error());
                return false;
            }
        }
        return true;
    }

    /**
     * 事务回滚
     * @return boolen
     */
    public function rollback()
    {
        if ($this->transTimes > 0) {
            $result = mysql_query('ROLLBACK', $this->link);
            $this->transTimes = 0;
            if(!$result){
                $this->error("数据库事务回滚失败！ " . mysql_error());
                return false;
            }
        }
        return true;
    }

	/**
	 * SELECT
	 */
	public function select($tables, $fields = array(),$where = '', $limit = '',$order = '') {
		$fields = empty($fields) ? '*' : implode(',', $fields);
		$sql = "SELECT $fields FROM {$tables} ";
		if (!empty($where)) {
			$sql .= ' WHERE ' . $where ;
		}
		if (!empty($order)) {
			$sql .= ' ORDER BY ' . $order;
		}
		if (!empty($limit)) {
			$sql .= ' LIMIT ' . $limit;
		}
		return $this->getAll($sql);
	}

	/**
	 * 插入数据
	 * @param string $table
	 * @param array $set
	 * @param boolean $replace 是否replace
	 */
	public function insert ($table, $set = array(),$replace=false) {
		$fields = array();
		$values = array();
		foreach ($set as $key=>$value) {
			$fields[] = "`{$key}`";
			$values[] = $this->parseValue($value);
		}
		$sql = ($replace ? 'REPLACE' : 'INSERT')." INTO `{$table}` ".' ('.implode(',', $fields).') VALUES ('.implode(',', $values).')';
		if ($this->query($sql)) {
			$this->insertId = mysql_insert_id($this->link);
			return $this->insertId;
		}
		return false;
	}

	//更新数据
	public function update ($table, $where, $set = array()) {
		foreach ($set as $key=>$value) {
			$sets[] = "`{$key}` = " . $this->parseValue($value);
		}
		$sql   =  "UPDATE `{$table}` SET " . implode(',', $sets) . '  WHERE  ' . $where;
		if (!$this->query($sql)) {
			return false;
		}
		return true;
	}

	//delete
	public function delete ($table, $where) {
		$sql = "DELETE FROM `{$table}` WHERE {$where}";
		return $this->query($sql);
	}

	/**
	 * 执行sql
	 * @param string $sql
	 */
	public function query ($sql) {
		$this->last_query = $sql;
		if (!$this->link || !mysql_ping($this->link)) {
			$this->connect();
		}
		$startT = microtime(true);
		$this->num_queries++;
		$result = @mysql_query($sql, $this->link);
		$this->lastQueryTime = sprintf("%.4f",(microtime(true) - $startT) * 1000);

		$this->logger($sql);
		if (!$result) {
			$this->error('query error : ' . mysql_error($this->link));
		}

		return $result;
	}

	//insert id
	public function insertId() {
		$this->insertId = mysql_insert_id($this->link);
		return $this->insertId;
	}

	//影响结果集数
	public function affectedRows() {
		return mysql_affected_rows($this->link);
	}

	/**
	 *
	 * @param mixed $value
	 */
	public function parseValue($value) {
		if(is_string($value)) {
			$value = '\''.$this->escape($value).'\'';
		}elseif(isset($value[0]) && is_string($value[0]) && strtolower($value[0]) == 'exp'){
			$value   =  $this->escape($value[1]);
		}elseif(is_array($value)) {
			$value   =  array_map(array($this, 'parseValue'),$value);
		}elseif(is_null($value)){
			$value   =  'null';
		}
		return $value;
	}

	/**
	 * 转义字符
	 * @param string $str
	 * @return string
	 */
	public function escape ($str) {
		return @mysql_escape_string(stripslashes($str));
	}

	/**
	 * 根据数组获取sql中in条件sql
	 * @param array $arr
	 * @param boolean $isString
	 * @return string
	 */
	public function genSqlInStr ($arr, $isString = true) {
		$str = "";
		if (empty($arr) || !is_array($arr)) return '';
		$k = 0;
		foreach ($arr as $value) {
			if ($k != 0) $str .= " , ";
			if ($isString) {
				$str .= "'" . $this->escape($value) . "'";
			} else {
				$str .= intval($value);
			}
			$k++;
		}
		return $str;
	}

	/**
	 +----------------------------------------------------------
	 * 获取最近一次查询的sql语句
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	public function getLastSql() {
		return $this->last_query;
	}

	/**
	 * 系统时间
	 */
	public function sysdate() {
		return 'NOW()';
	}

	/**
	 * 添加error信息
	 * @param string $error
	 */
	public function error ($error) {
		$this->last_error = $error;
		$this->logger($error . "\n  " . 'sql : ' . $this->last_query, 'error');
		throw new MysqlException($error);
	}

	//close
	public function close () {
		mysql_close($this->link);
	}

	//日志
	public function logger ($str, $type = 'sql') {
		//TODO (user) 重写此函数
	}

	public function __destruct() {
		@mysql_close($this->link);
	}
}

class MysqlException extends Exception {

}
