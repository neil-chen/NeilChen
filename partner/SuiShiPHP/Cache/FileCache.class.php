<?php
/**
 * 文件缓存类
 *
 * class_description
 *
 * @author mxg
 */
class FileCache
{
	private $cachePath = "/projects/cache/web/";
	private $shellCachePath = '/projects/cache/shell/';
	private $cacheModel = '';
	private $runShell = false;

	public function __construct($runShell = false)
	{
		$this->runShell = $runShell;
	}
	//设置缓存路径
	public function setPath ($path) {
		if (is_string($path)) {
			if ('/' != $path) {
				$path = rtrim($path, '/');
				$this->cachePath = $path . '/web/';
				$this->shellCachePath = $path . '/shell/';
			}
		}
	}
    /**
     * 获取文件缓存
     *
     * function_description
     *
     * @author grh
     * @param  string|int $cache_id  必选参数
     * @param  int  $time  可选参数
     */
    public function get($cache_id)
    {
    	if (!$this->checkCacheId($cache_id)) {
    		return false;
    	}
    	$fileName = $this->genCacheFile($cache_id);
        if (! file_exists($fileName)) {
        	return false;
        }
        return $this->_read($fileName);
    }

    /**
     * 设置缓存文件
     *
     * function_description
     *
     * @author grh
     * @param  string|int $cache_id     必选参数
     * @param  string|array|json $data  必选参数
     * @param  int $left  有效时间 单位：秒
     * @return bool
     */
    public function set($cache_id, $data, $left = 60)
    {
    	if (!isset($data) || !$this->checkCacheId($cache_id)) {
    		trigger_error("参数错误!");
    		return false;
    	}
    	$realPath = $this->getRealPath();
        if (is_dir($realPath)) {
        	if (! is_writable($realPath)) {
        		trigger_error("用户缓存目录不可写： " . $realPath);
        		return false;
        	}
        } else {
            if (!@mkdir($realPath, 0777, true)) {
            	trigger_error("创建用户缓存目录失败： " . $realPath);
            	return false;
            }
        }
        return $this->_write($this->genCacheFile($cache_id),$data, $left);
    }

    /**
     * 设置缓存路径
     *
     * function_description
     *
     * @author author
     * @param  string $model 路径
     *
     */
    public function setModel($model='')
    {
    	$model = trim($model, '/');
        $this->cacheModel = $model;
    }

	/**
     * 写文件
     *
     * function_description
     *
     * @since     2012-10-17
     * @author grh
     * @param  $filename 文件名称
     * @param  $content  文件内容
     * @param  int $left 有效时间(s)
     * @return bool
     */
    private function _write($filename,$content,$left)
    {
    	$handle = @fopen($filename, 'w+');
        if(!$handle) {
        	trigger_error("打开文件失败： " . $filename);
            return false;
        }
        $content = "$left\n".serialize($content);
        fwrite($handle, $content);
        fclose($handle);
        return true;
    }

	/**
     * 读文件
     *
     * function_description
     *
     * @since    2012-10-17
     * @author grh
     * @param $filename 文件名称
     * @return string
     */
    private function _read($filename)
    {
        $handle = @fopen($filename, "r");
    	if(! $handle) {
        	trigger_error("打开文件失败： " . $filename);
            return '';
        }
        $content = fread($handle, filesize($filename));
        fclose($handle);
        $cArr = explode("\n", $content);
        $time = (int)$cArr[0];
        $rt = @unserialize(trim($cArr[count($cArr) - 1]));
        if ($time == 0) {
        	return $rt;
        }
        if(time()-filemtime($filename) > $time){
        	return false;
        }
        return $rt;
    }

	/**
     * 生成缓存文件
     *
     * function_description
     *
     * @since  2012-10-17
     * @author grh
     * @param string|int $cache_id
     * @return String
     */
    protected function genCacheFile($cache_id)
    {
        return $this->getRealPath() . md5($cache_id).'_c.cache' ;
    }

    /**
     * 获取文件路径
     *
     * function_description
     *
     * @since  2012-10-17
     * @author grh
     * @return String
     */
    protected function getRealPath ()
    {
    	if (true === $this->runShell) {
    		return $this->shellCachePath.($this->cacheModel ? ($this->cacheModel.'/') : '');
    	}
    	return $this->cachePath.($this->cacheModel ? ($this->cacheModel.'/') : '');
    }

    /**
     * 验证cacheId
     *
     * function_description
     *
     * @since  2012-10-17
     * @author grh
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

    /**
     * 清除缓存
     *
     * function_description
     *
     * @author mxg
     * @param  string $cache_id
     *
     */
    public function clear($cache_id = null, $dir = null)
    {
        $fileResult = true;
        if ($cache_id) {
            $fileName = $this->genCacheFile($cache_id);
            if (! file_exists($fileName)) {
            	return $fileResult;
            }
            $fileResult = unlink($fileName);
            if (! $dir) {
                return $fileResult;
            }
        }
        $cachePath = $dir ? $dir : $this->getRealPath();
        //$cachePath = $this->getRealPath();
        if (! is_dir($cachePath)) {
            return true;
        }
        $dh = opendir($cachePath);
        while ( $file = readdir($dh) ) {
            if($file!="." && $file!="..") {
                $fullpath = $cachePath."/".$file;
                if(! is_dir($fullpath) ) {
                    unlink($fullpath);
                } else {
                    $this->clear(null, $fullpath);
                }
            }
        }
        closedir($dh);
        return (rmdir($cachePath) && $fileResult);
    }
}

