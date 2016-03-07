<?php
/**
 * 微信api Request
 *
 * php curl http 传输文件和数据
 * 需要安装curl扩展
 *
 * @author mxg
 */
class WeiXinApiRequest
{
    const GET  = 'GET';
    const POST = 'POST';

    /**
     * Contains the last HTTP status code returned.
     *
     * @ignore
     */
    public static $http_code;

    /**
     * Contains the last HTTP headers returned.
     *
     * @ignore
     */
    public static $http_info;

    /**
     * Contains the last HTTP response.
     *
     * @ignore
     */
    public static $response;

    /**
     * Contains the last API call.
     *
     * @ignore
     */
    public static $url;

    /**
     * Contains the last HTTP params.
     *
     * @ignore
     */
    public static $params;

    /**
     * Set timeout default.
     *
     * @ignore
     */
    public static $timeout = 30;

    /**
     * Set connect timeout.
     *
     * @ignore
     */
    public static $connecttimeout = 30;

    /**
     * Verify SSL Cert.
     *
     * @ignore
     */
    public static $ssl_verifypeer = false;

    /**
     * Respons format.
     *
     * @ignore
     */
    public static $format = 'json';

    /**
     * Decode returned json data.
     *
     * @ignore
     */
    public static $decode_json = TRUE;

    /**
     * Set the useragnet.
     *
     * @ignore
     */
    public static $useragent = 'WeiXinApi SDK v0.1';

    /**
     * print the debug info
     *
     * @ignore
     */
    public static $debug = false;

    /**
     * boundary of multipart
     * @ignore
     */
    public static $boundary = '';

    /**
     * GET wrappwer for apiRequest.
     *
     * @return mixed
     */
    public static function get($url, $params = array())
    {
        $response = self::_request($url, self::GET, $params);
        if (self::$format === 'json' && self::$decode_json) {
        	$result = json_decode($response, true);
            if (! $result) {
            	$response = preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $response);
            	$result = json_decode($response, true);
            }
            return $result;
        }
        return $response;
    }

    /**
     * POST wreapper for apiRequest.
     *
     * @return mixed
     */
    public static function post($url, $params = array(), $multi = false, $json = true)
    {
    	$timeout = 0;
    	if ('video' == @$params['msgtype']) {
    		$timeout = 300;
    	}
		if (true == $json) {
			$params=self::_unescaped($params);
		}
        $response = self::_request($url, self::POST, $params, $multi, $timeout);
        if (self::$format === 'json' && self::$decode_json) {
            $result = json_decode($response, true);
            if (! $result) {
            	$response = preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $response);
            	$result = json_decode($response, true);
            }
            return $result;
        }
        return $response;
    }

    /**
     * Format and sign an API request
     *
     * @return string
     * @ignore
     */
    private static function _request($url, $method, $params, $multi = false, $timeout = 0)
    {
        self::$url = $url;
        self::$params = $params;
        if (self::GET == $method) {
            $url = $url . (strpos($url, '?') ? '&' : '?') . (is_array($params) ? http_build_query($params) : $params);
            $response = self::_http($url, self::GET);
        } else {
            $headers = array();
            if (! $multi /*  && (is_array($params) || is_object($params)) */ ) {
                //$body = http_build_query($params);
                $body = $params;
            } else {
            	//TODO:目前没有使用
                $body = self::_buildHttpQueryMulti($params);
                $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
            }
            $response = self::_http($url, self::POST, $body, $headers, $timeout);
        }

        return self::_parseResponse($response);
    }

    /**
     * 解析结果集
     *
     * 把message_id原数字用正则转换为字符串
     *
     * @author mxg
     * @param
     */
    private static function _parseResponse($response)
    {
        return preg_replace('/\"message_id\":( )*([\d]{13,})/', "\"message_id\": \"$2\"", $response);
    }

    /**
     * Make an HTTP request
     *
     * @return string API results
     * @ignore
     */
    private static function _http($url, $method, $postfields = NULL, $headers = array(), $timeout = 0)
    {
        if (! self::test()) {
            echo '您的服务器不支持 PHP 的 Curl 模块，请安装或与服务器管理员联系。';
            exit;
        }
		$timeout = $timeout ? $timeout : self::$timeout;
        self::$http_info = array();
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, self::$useragent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, self::$connecttimeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_ENCODING, "");

        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, self::$ssl_verifypeer);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, (self::$ssl_verifypeer == true) ? 2 : false);

        curl_setopt($ci, CURLOPT_HEADERFUNCTION, 'WeiXinApiRequest::_getHeader');
        curl_setopt($ci, CURLOPT_HEADER, FALSE);

        if (self::POST == $method) {
            curl_setopt($ci, CURLOPT_POST, TRUE);
            if (!empty($postfields)) {
                curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                //self::$postdata = $postfields;
            }
        }

        curl_setopt($ci, CURLOPT_URL, $url );
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );

        self::$response = $response = curl_exec($ci);
        self::$http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        self::$http_info = array_merge(self::$http_info, curl_getinfo($ci));

        if (self::$debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);

            echo '=====info====='."\r\n";
            print_r( curl_getinfo($ci) );

            echo '=====$response====='."\r\n";
            print_r( $response );

            echo '=====error====='."\r\n";
            print_r( curl_error($ci) );
        }
        curl_close($ci);
        return $response;
    }

    /**
     * Get the header info to store.
     *
     * @return int
     * @ignore
     */
    private static function _getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            //self::$http_header[$key] = $value;
        }
        return strlen($header);
    }

    /**
     * @ignore
     */
    private static function _buildHttpQueryMulti($params)
    {
        if (!$params) return '';

        uksort($params, 'strcmp');

        $pairs = array();

        self::$boundary = $boundary = uniqid('----------');

        $MPboundary = '--'.$boundary;
        $endMPboundary = $MPboundary. '--';
        $multipartbody = '';

        foreach ($params as $param => $value) {

            if( 'media' == $param && $value{0} == '@' ) {
                $url = ltrim( $value, '@' );
                $content = file_get_contents( $url );
                $array = explode( '?', basename( $url ) );
                $filename = $array[0];

                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'Content-Disposition: form-data; name="' . $param . '"; filename="' . $filename . '"'. "\r\n";
                $multipartbody .= "Content-Type: application/octet-stream\r\n\r\n";
                $multipartbody .= $content. "\r\n";
            } else {
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'Content-Disposition: form-data; name="' . $param . "\"\r\n\r\n";
                $multipartbody .= $value."\r\n";
            }

        }

        $multipartbody .= $endMPboundary;
        return $multipartbody;
    }
    /**
     * 转码字符或者数组,保持编码一致(防止微信乱码)
     * @param string||array $data
     */
    private static function _unescaped($data){
    	if(version_compare(PHP_VERSION,'5.4.0','<')){
			$data=array_map('self::_urlencode', $data);
    		return urldecode(json_encode($data));
    	}
    	return urldecode(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
    /**
     * url编码数组和字符串
     * @param array|string $data
     * @return array|string
     * 因php5.4版本不支持，并且传入的内容有双引号，加上addslashes
     */
	private static function _urlencode($data){
		if(is_array($data)){
			foreach ($data as $k=>$v){
				$v=is_array($v) ? array_map('self::_urlencode', $v) : urlencode(addslashes($v));
				$data[urlencode($k)]=$v;
			}
			return $data;
		}else{
			return urlencode(addslashes($data));
		}
	}
    /**
     * Whether this class can be used for retrieving an URL.
     *
     * @static
     * @return boolean False means this class can not be used, true means it can.
     */
    public static function test()
    {
        if ( ! function_exists( 'curl_init' ) || ! function_exists( 'curl_exec' ) ) {
            return false;
        }
        $is_ssl = self::$ssl_verifypeer;

        if ( $is_ssl ) {
            $curl_version = curl_version();
            if ( ! (CURL_VERSION_SSL & $curl_version['features']) ) {// Does this cURL version support SSL requests?
                return false;
            }
        }
        return true;
    }

}