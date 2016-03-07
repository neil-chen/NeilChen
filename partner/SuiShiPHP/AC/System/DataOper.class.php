<?php
/**
 * 业务数据操作类
 */
class DataOper {
	
	private static $instance;
	
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 通过业务ID+业务关键字获取业务数据
	 * @param int $wid  业务id
	 * @param string $key 关键字(默认为空返回全部用户该业务id的所有数据)
	 * @param array
	 */
	public function getDataByID($wid,$key="") {
		try {
			$ret = array();
			if($key == "") {
				$strsql = "SELECT * FROM ".DBConfig::$table['data']." WHERE `wid` = {$wid} ";
				$res = Factory::getDb("weixin_active")->getAll($strsql);
				if($res && is_array($res)) {
					foreach ($res as $k => $v) {	
						$ret[$v["key"]] = $v;
					}
				}
			} else {
				$strsql = "SELECT * FROM ".DBConfig::$table['data']." WHERE `wid` = {$wid} AND `key` = '{$key}' LIMIT 1";
				$res = Factory::getDb("weixin_active")->getRow($strsql);
				if($res) {
					$ret[$key] = $res;
				}
			}	
			return $ret;
		} catch (Exception $e) {
			Logger::error("通过业务ID+业务关键字获取业务数据失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 插入业务数据或者更新之
	 */
	public function updateData($uid,$aid,$wid,$key,$data) {
		try {
			$curTime = time();
			$data = mysql_real_escape_string($data);
			$strsql = "INSERT INTO `".DBConfig::$table['data']."`(`uid`,`aid`,`wid`,`key`,`data`,`time`) VALUES ('{$uid}',{$aid},{$wid},'{$key}','{$data}',{$curTime}) ON DUPLICATE KEY UPDATE `filed`=`data`,`data`='{$data}',`time`={$curTime}";
			Factory::getDb("weixin_active")->query($strsql);
			return Factory::getDb("weixin_active")->affectedRows();
		} catch (Exception $e) {
			Logger::error("插入业务数据或者更新之失败".$e->getmessage());
			return false;
		}
	}
	

}