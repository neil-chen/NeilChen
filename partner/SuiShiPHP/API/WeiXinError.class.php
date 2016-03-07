<?php
/**
 * 定义error code 文件
 *
 * class_description
 *
 * @author mxg
 */
final class WX_Error
{
    //自定义错误
    /**
     * 返回正确数据
     * @var int
     */
	const NO_ERROR = 0;
    /**
     * API 返回数据格式错误
     * @var int
     */
	const RESPONSE_FOMAT_ERROR = 1000;
	/**
     * 参数错误
     * @var int
     */
	const PARAM_ERROR = 1001;
	/**
     * 无效的user_id
     * @var int
     */
	const INVALID_USER_ERROR = 1100;
	/**
     * 无效的文件类型
     * @var int
     */
	const INVALID_FILE_TYPE_ERROR = 4005;
	/**
     * 媒体文件大小超出
     * @var int
     */
	const INVALID_MEIDA_SIZE_ERROR = 4006;
	/**
	 * 缩略图文件大小无效
	 * @var int
	 */
	const INVALID_THUMB_SIZE_ERROR = 4012;
	/**
	 * media参数为空
	 * @var int
	 */
	const MEDIA_DATA_MISSING_ERROR = 4105;
	/**
	 * 创建media_id失败
	 * @var int
	 */
	const CREATE_MEDIA_ID_ERROR = 4110;
	/**
	 * 创建thumb_media_id失败
	 * @var int
	 */
	const CREATE_THUMB_MEDIA_ID_ERROR = 4111;
	/**
	 * 与微信通信失败
	 */
	const CONNECTION_ERROR = 5100;
	/**
	 * 微信系统错误
	 * @var int
	 */
	const SYSTEM_ERROR = 5200;
	/**
	 * 数据格式错误
	 * @var int
	 */
	const DATA_FORMAT_ERROR = 4701;
	/**
	 * 图文消息数据为空
	 * @var int
	 */
	const EMPTY_NEWS_DATA_ERROR = 4403;
	/**
	 * 图文消息条数超出限制最多10条
	 * @var int
	 */
	const ARTICLE_SIZE_OUT_ERROR = 4508;
	/**
	 * 语音文件播放时间超出，最长时间60s
	 * @var int
	 */
	const PLAYTIME_OUT_ERROR = 4507;
	/**
	 * api频率受限
	 * @var int
	 */
	const API_FREQ_OUT_ERROR = 4509;
	//微信平台返回错误代码
	/**
     * 没有新的数据产生
     * @var int
     */
	const HTTP_NOT_MODIFIED_ERROR = 304;
	/**
     * 无效的请求
     * @var int
     */
	const HTTP_BAD_REQUEST_ERROR = 400;
	/**
     * 验证信息缺失或身份验证失败
     * @var int
     */
	const HTTP_UNAUTHORIZED_ERROR = 401;
	/**
     * 频率受限
     * @var int
     */
	const HTTP_FORBIDDEN_ERROR = 403;
	/**
     * API无效或者所查询的信息不存在
     * @var int
     */
	const HTTP_NOT_FOUND_ERROR = 404;
	/**
     * 系统内部错误
     * @var int
     */
	const HTTP_INTERNAL_SERVER_ERROR = 500;
	/**
     * 服务器挂了或在升级中
     * @var int
     */
	const HTTP_BAD_GATEWAY_ERROR = 502;
	/**
     * 服务器无法提供服务
     * @var int
     */
	const HTTP_SERVICE_UNAVAILABLE_ERROR = 503;
	/**
     * 无效的app_id
     * @var int
     */
	const INVALID_APP_ID_ERROR = 40008;
	/**
	 * 无效的secret
	 * @var int
	 */
	const INVALID_SECRET_ERROR = 40001;
	/**
     * 验证失败
     * @var int
     */
    const VERIFY_FAIL_ERROR = 40000;
	/**
     * app_secret为空
     * @var int
     */
    const APP_SECRET_MISSING_ERROR = 40320;
	/**
     * app_id为空
     * @var int
     */
    const APP_ID_MISSING_ERROR = 40317;
	/**
     * 无效的grant_type
     * @var int
     */
    const INVALID_GRANT_TYPE_ERROR = 40009;
	/**
     * token为空
     * @var int
     */
    const KOTEN_MISSING_ERROR = 40007;
	/**
     * 无效的凭证
     * @var int
     */
    const INVALID_CREDENTIAL_ERROR = 40003;
	/**
     * 用户不存在
     * @var int
     */
    const INVALID_USERNAME_ERROR = 40301;
	/**
     * token过期
     * @var int
     */
    const TOKEN_EXPIRED_ERROR = 40005;
	/**
     * 内容不存在
     * @var int
     */
    const CONTENT_MISSING_ERROR = 40308;
    /**
     * 无效的消息类型
     * @var int
     */
    const INVALID_MESSAGE_TYPE_ERROR = 40304;
    /**
     * media_id为空
     * @var int
     */
    const MEDIA_ID_MISSING_ERROR = 40305;
    /**
     * 微信用户ID为空
     * @var int
     */
    const WEIXIN_ID_MISSING_ERROR = 40346;
    /**
     * thumb_media_id为空
     * @var int
     */
    const THUMB_MEDIA_ID_MISSING_ERROR = 40307;
    /**
     * 标题为空
     * @var int
     */
    const TITLE_MISSING_ERROR = 40343;
    /**
     * 描述为空
     * @var int
     */
    const DESCRIPTION_MISSING_ERROR = 40344;
    /**
     * url为空
     * @var int
     */
    const URL_MISSING_ERROR = 40345;
    /**
     * method需要post方式
     * @var int
     */
    const REQUIRE_POST_METHOD_ERROR = 40323;
    /**
     * 无效的媒体类型
     * @var int
     */
    const INVALID_MEDIA_TYPE_ERROR = 40313;
    /**
     * 微信服务器出错
     * @var int
     */
    const SERVICE_UNAVAILABLE_ERROR = 50000;
	/**
     * 需要https请求协议
     * @var int
     */
    const REQUIRE_PROTOCOL_ERROR = 43003;
    /**
     * 无效的菜单数据
     * @var int
     */
    const INVALID_BUTTON_SIZE = 40016;
    /**
     * 无效的菜单类型
     * @var int
     */
    const INVALID_BUTTON_TYPE = 40017;
    /**
     * 无效的菜单名称
     * @var int
     */
    const INVALID_BUTTON_NAME = 40018;
    /**
     * 无效的菜单key
     * @var int
     */
    const INVALID_BUTTON_KEY = 40019;
    /**
     * 无效的字符集
     * @var int
     */
    const INVALID_CHARSET = 40033;
    /**
     * 无效的二级菜单数据
     * @var int
     */
    const INVALID_SUB_BUTTON_SIZE = 40023;
    /**
     * 无效的二级菜单类型
     * @var int
     */
    const INVALID_SUB_BUTTON_TYPE = 40024;
    /**
     * 无效的二级菜单名称
     * @var int
     */
    const INVALID_SUB_BUTTON_NAME = 40025;
    /**
     * 无效的二级菜单key
     * @var int
     */
    const INVALID_SUB_BUTTON_KEY = 40026;
    /**
     * 没有菜单数据
     * @var int
     */
    const MENU_NO_EXIST = 46003;
    /**
     * 未关注用户
     * @var int
     */
    const REQUIRE_SUBSCRIBE = 43004;
    /**
     * 响应时间限制
     * @var int
     */
	const RESPONSE_OUT_TIME = 45015;
	/**
	 * api未授权
	 * @var int
	 */
	const API_UNAUTHORIZED = 48001;

	public static function getMessage($code) {
		switch ($code) {
		    case self :: HTTP_NOT_MODIFIED_ERROR:

		        return ' 没有新的数据产生';

	        case self :: RESPONSE_FOMAT_ERROR:

	            return ' API 返回数据格式错误';

	        case self :: PARAM_ERROR :

	            return ' 错误:参数错误/缺少必要的参数,请参考文档';

	        case self :: INVALID_USER_ERROR:

	            return ' 无效的user_id';

	        case self :: INVALID_FILE_TYPE_ERROR:

	            return ' 无效的文件类型';

	        case self :: CONNECTION_ERROR:

	            return ' 与微信通信失败';

	        case self :: MEDIA_DATA_MISSING_ERROR:

	            return ' 附件为空';

	        case self :: INVALID_MEIDA_SIZE_ERROR:

	            return ' 媒体文件大小超出';

	        case self :: SYSTEM_ERROR:

	            return ' 微信系统错误';

	        case self :: DATA_FORMAT_ERROR:

	            return ' 数据格式错误';

	        case self :: INVALID_THUMB_SIZE_ERROR:

	            return ' 缩略图文件大小无效';

	        case self :: EMPTY_NEWS_DATA_ERROR:

	            return ' 图文消息数据为空';

	        case self :: ARTICLE_SIZE_OUT_ERROR:

	            return ' 图文消息条数超出限制最多10条';

	        case self :: PLAYTIME_OUT_ERROR:

	            return ' 语言文件播放时间超出';

	        case self :: API_FREQ_OUT_ERROR:

	            return ' api频率受限';

		    case self :: HTTP_BAD_REQUEST_ERROR :

		        return ' 无效的请求';

		    case self :: HTTP_UNAUTHORIZED_ERROR :

		        return ' 验证信息缺失或身份验证失败';

		    case self :: HTTP_FORBIDDEN_ERROR :

		        return ' 频率受限';

		    case self :: HTTP_NOT_FOUND_ERROR :

		        return ' API无效或者所查询的信息不存在';

		    case self :: HTTP_INTERNAL_SERVER_ERROR :

		        return ' 系统内部错误';

		    case self :: HTTP_BAD_GATEWAY_ERROR :

		        return ' 服务器挂了或在升级中';

		    case self :: HTTP_SERVICE_UNAVAILABLE_ERROR :

		        return ' 服务器无法提供服务';

		    case self :: INVALID_APP_ID_ERROR :

		        return ' 无效的app_id';

		    case self :: INVALID_SECRET_ERROR :

		        return ' 无效的secret';

            /* case self :: VERIFY_FAIL_ERROR:

                return ' 验证失败'; */

            case self :: APP_SECRET_MISSING_ERROR:

                return ' app_secret参数为空';

            case self :: APP_ID_MISSING_ERROR:

                return ' app_id参数为空';

            case self :: INVALID_GRANT_TYPE_ERROR:

                return ' 无效的grant_type';

            case self :: KOTEN_MISSING_ERROR;

                return ' token为空';

            case self :: INVALID_CREDENTIAL_ERROR:

                return ' 无效的凭证';

            case self :: INVALID_USERNAME_ERROR;

                return ' 用户不存在';

            case self :: TOKEN_EXPIRED_ERROR:

                return ' token过期';

            case self :: CONTENT_MISSING_ERROR:

                return ' 内容不存在';

            case self :: INVALID_MESSAGE_TYPE_ERROR:

                return ' 消息类型错误';

            case self :: MEDIA_ID_MISSING_ERROR:

                return ' media_id参数为空';

            case self :: WEIXIN_ID_MISSING_ERROR;

                return ' weixin_id参数为空';

            case self :: THUMB_MEDIA_ID_MISSING_ERROR:

                return ' thumb_media_id参数为空';

            case self :: DESCRIPTION_MISSING_ERROR:

                return ' 描述为空';

            case self :: URL_MISSING_ERROR:

                return ' 链接Url为空';

            case self :: INVALID_MEDIA_TYPE_ERROR:

                return ' 无效的媒体类型';

            case self :: SERVICE_UNAVAILABLE_ERROR:

               	return ' 微信服务器出错';

            case self :: REQUIRE_POST_METHOD_ERROR:

				return ' 请求method需要post类型';

			case self :: REQUIRE_PROTOCOL_ERROR:

				return ' 请求协议错误，需要https';

			case self :: INVALID_BUTTON_SIZE:

				return ' 无效的菜单数据';

			case self :: INVALID_BUTTON_TYPE:

				return ' 无效的菜单类型';

			case self :: INVALID_BUTTON_NAME:

				return ' 无效的菜单名称';

			case self :: INVALID_BUTTON_KEY:

				return ' 无效的菜单key';

			case self :: INVALID_CHARSET:

				return ' 无效的字符集';

			case self :: INVALID_SUB_BUTTON_SIZE:

				return ' 无效的二级菜单数据';

			case self :: INVALID_SUB_BUTTON_TYPE:

				return ' 无效的二级菜单类型';

			case self :: INVALID_SUB_BUTTON_NAME:

				return ' 无效的二级菜单名称';

			case self :: INVALID_SUB_BUTTON_KEY:

				return ' 无效的二级菜单key';

			case self :: MENU_NO_EXIST:

				return ' 菜单不存在';

			case self :: REQUIRE_SUBSCRIBE:

				return ' 未关注用户';

			case self :: CREATE_MEDIA_ID_ERROR:

				return ' 创建media_id失败';

			case self :: RESPONSE_OUT_TIME:

				return ' 响应时间限制';

			case self :: API_UNAUTHORIZED:

				return ' api未授权';
		}
		return '未知错误';
	}

}