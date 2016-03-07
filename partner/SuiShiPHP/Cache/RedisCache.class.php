<?php
/**
 * redis cache
 * @author paizhang
 *
 */

class RedisCache
{
	/**
	 * host
	 * @var string
	 */
	protected $_host = '127.0.0.1';
	/**
	 * port
	 * @var string
	 */
	protected $_port = '6379';
	/**
	 * redis 对象
	 * @var Redis
	 */
	protected $_redis = null;
	/**
	 * 最后一个error
	 * @var string
	 */
	protected $_error = '';


	public function __construct($host = '127.0.0.1', $port = '6379') {
		$this->_host = $host;
		$this->_port = $port;
		$this->_redis = new Redis();
		try {
			$this->_redis->connect($this->_host, $this->_port);
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
		}

	}

	/**
	 * 获取缓存数据
	 * @param string $cache_id
	 * @return mixed
	 */
	public function get($cache_id) {
		try {
			$result = $this->_redis->get($cache_id);
			if (!$result) {
				return false;
			}
			return @unserialize($result);
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}

	/**
	 * 设置缓存
	 * @param string $cache_id
	 * @param mixed $data 缓存数据
	 * @param int $left 缓存时间 秒
	 * @return bool
	 */
	public function set($cache_id, $data, $left = 60) {
		try {
			$value = serialize($data);
			if ($left === 0) {
				$retRes = $this->_redis->set($cache_id, $value);
			} else {
				$retRes = $this->_redis->setex($cache_id, $left, $value);
			}
			return $retRes;
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}

	/**
	 * 删除缓存
	 * @param sting $cache_id
	 * @return bool
	 */
	public function clear ($cache_id) {
		try {
			return $this->_redis->delete($cache_id);
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}

	/**
	 * 清空数据
	 */
	public function clearAll() {
		try {
			return $this->_redis->flushAll();
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}

	/**
	 * key是否存在，存在返回ture
	 * @param string $cache_id KEY名称
	 */
	public function exists($cache_id) {
		try {
			return $this->_redis->exists($cache_id);
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}
	
	/**
	 * 开启事务
	 */
	public function multi() {
		try {
			return $this->_redis->multi(Redis::MULTI);
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}

	/**
	 * exec
	 */
	public function execs() {
		try {
			return $this->_redis->exec();
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}

	public function incrBy($key='', $count='') {
		try {
			return $this->_redis->incrBy($key, $count);
		} catch (Exception $e) {
			$this->_error = $e->getMessage();
			return false;
		}
	}

	public function setModel($model='') {
	}

	/**
	 * 验证cacheId
	 * @param  string|int $cache_id
	 * @return bool
	 */
	protected function checkCacheId($cache_id)
	{
		if (!$cache_id) {
			return false;
		}
		if (is_string($cache_id) || is_numeric($cache_id)) {
			return true;
		}
		return false;
	}

	public function __destruct() {
		try {
			if ($this->_redis) {
				$this->_redis->close();
			}
		} catch (Exception $e) {}
	}
}