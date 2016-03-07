<?php
/**
 * 微信api数据结构类
 * @author mxg
 */

/**
 * 微信OAuth 授权token
 * @author paizhang
 *
 */
class WX_OAuthToken
{
	public $accessToken;
	public $refreshToken;
	public $openId;
	public $expiresIn;
	public function __construct($accessToken, $openId, $refreshToken=null,
			$expiresIn=null){
		$this->accessToken = $accessToken;
		$this->openId = $openId;
		$this->refreshToken = $refreshToken;
		$this->expiresIn = $expiresIn;
	}
}

/**
 * token数据结构
 *
 *
 * @author mxg
 */
class WX_Token
{
    /**
     * 应用token
     * @var string
     */
    public $token;
    /**
     * token有时间时间期
     * @var int
     */
    public $expires_in;

    public function __construct($token, $expires_in)
    {
        $this->token = $token;
        $this->expires_in = $expires_in;
    }
}

/**
 * 应用配置数据结构
 *
 */
class WX_Configuration
{
    /**
     * 应用appid
     * @var string
     */
    public $app_id;
    /**
     * 允许应用发送的图片大小
     * @var int
     */
    public $image_size_limit;
    /**
     * 允许应用发送的语音大小
     * @var int
     */
    public $voice_size_limit;
    /**
     * 允许应用发送的视频大小
     * @var int
     */
    public $video_size_limit;
    /**
     * 允许应用发送的thumb大小
     * @var int
     */
    public $thumb_size_limit;
}

/**
 * 微信用户数据结构
 *
 */
class WX_User
{
    /**
     * 微信用户ID
     * @var string
     */
    public $user;
    /**
     * 是否是订阅用户
     * @var int  0|1
     */
    public $subscribe;
    /**
     * 微信用户昵称
     * @var string
     */
    public $nickname;
    /**
     * 性别
     * @var int
     */
    public $sex;
    /**
     * 头像地址
     * @var string url
     */
    public $picture;
    /**
     * 用户国家
     * @var string
     */
    public $country;
    /**
     * 省份
     * @var string
     */
    public $province;
    /**
     * 城市
     * @var string
     */
    public $city;
    /**
     * 时区
     * @var int
     */
    public $timezone;
    /**
     * 语言
     * @var string
     */
    public $language;
    /**
     * 头像
     * @var url 用户头像，
     * 最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），
     * 用户没有头像时该项为空
     */
    public $headimgurl;
    /**
     * 用户关注时间
     * @var int 用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
     */
    public $subscribe_time;
    /**
     * 用户特权信息，数组，如微信沃卡用户为（chinaunicom）oauth2.0
     * @var array
     */
    public $privilege;

    /**
     * 微信用户ID
     * @var string
     */
    public $type = 'user';
    public function __construct($user, $subscribe)
    {
        $this->user = $user;
        $this->subscribe = $subscribe;
    }

}

/**
 * 微信消息信息
 *
 */
class WX_Message
{
    /**
     * 消息ID
     * @var string
     */
    public $message_id;
    /**
     * 微信用户ID
     * @var string
     */
    public $from_user;
    /**
     * 消息类型
     * 类型分：text-文本|image-图片|voice-语音|video-视频|subscribe-订阅|report-报告|location-位置|link-链接|card-名片
     * @var string
     */
    public $type;
    /**
     * 信息时间
     * 时间戳
     * @var int
     */
    public $created_at;
    /**
     * 消息内容
     * 类型为text时 content为字符串 类型为subscribe|report 为数组
     * @var string|array
     */
    public $content;
    /**
     * 媒体ID
     * @var string
     */
    public $media_id;
    /**
     * 缩略图ID
     * 类型为video/link
     * @var string
     */
    public $thumb_media_id;
    /**
     * 媒体播放时间
     * @var int
     */
    public $play_time;
    /**
     * 媒体url地址
     * @var string
     */
    public $media_url;
    /**
     * 地理位置
     * @var object WX_Location
     */
    public $location;
    /**
     * 企业微信号
     * @var string
     */
    public $ent_weixin;
    /**
     * 事件类型
     * @var WX_Event
     */
    public $event;
    /**
     * 消息标题(类型link)
     * @var string
     */
    public $title;
    /**
     * 消息描述(类型link)
     * @var string
     */
    public $description;
    /**
     * 消息链接(类型link)
     * @var string
     */
    public $url;
	/**
	 * 语音格式，如amr，speex等
	 * @var string
	 */
    public $format;
    /**
     * 语音识别结果，UTF8编码
     * @var string
     */
    public $recognition;

    public function __construct($message_id, $type, $from_user, $created_at)
    {
        $this->message_id = $message_id;
        $this->type = $type;
        $this->from_user = $from_user;
        $this->created_at = $created_at;
    }

}

/**
 * 微信事件类型数据
 */
class WX_Event
{
	/**
	 * 事件类型:
	 * subscribe(订阅)、unsubscribe(取消订阅)、CLICK(自定义菜单点击事件)、LOCATION(地理位置)
	 * @var string
	 */
	public $event_type;
	/**
	 * 事件KEY值，与自定义菜单接口中KEY值对应
	 * @var string
	 */
	public $event_key;
	/**
	 * 地理位置经度
	 * @var string
	 */
	public $latitude;
	/**
	 * 地理位置纬度
	 * @var string
	 */
	public $longitude;
	/**
	 * 地理位置精度
	 * @var string
	 */
	public $precision;
	/**
	 * 消息ID
	 * @var string
	 */
	public $message_id;
	/**
	 * 模板消息发送回执状态
	 * @var string
	 */
	public $status;
	/**
	 * 群发粉丝总数
	 * group_id下粉丝数；或者openid_list中的粉丝数
	 * @var int
	 */
	public $total_count;
	/**
	 * 过滤后群发粉丝总数
	 * 过滤（过滤是指特定地区、性别的过滤、用户设置拒收的过滤，用户接收已超4条的过滤）后，
	 * 准备发送的粉丝数，原则上，FilterCount = SentCount + ErrorCount
	 * @var int
	 */
	public $filter_count;
	/**
	 * 群发发送成功的粉丝数
	 * @var int
	 */
	public $sent_count;
	/**
	 * 群发失败的粉丝数
	 * @var int
	 */
	public $error_count;

	public function __construct($event_type, $event_key = null)
	{
		$this->event_type = $event_type;
		$this->event_key = $event_key;
	}
}

/**
 * 微信发送消息对象
 */
class WX_Message_Body
{
    /**
     * 收消息的用户ID
     * @var string
     */
    public $to_users;
    /**
     * 消息类型
     * 六种类型：text-文本|image-图片|voice-语音|video-视频|link-链接|news-图文消息
     * @var string
     */
    public $type;
    /**
     * 发送消息内容
     * @var string
     */
    public $content;
    /**
     * 当类型为image/voice/video时，为附件媒体ID
     * @var string
     */
    public $media_id;
    /**
     * 当类型为link/music时，为标题
     * @var string
     */
    public $title;
    /**
     * 当类型为link/music时，为描述
     * @var string
     */
    public $description;
    /**
     * 当类型为link时，为链接地址
     * @var string
     */
    public $url;
    /**
     * 当类型为card时，为微信用户ID
     * @var string
     */
    public $weixin_id;
    /**
     * 当类型为image/voice/video时，为附件地址：绝对路径，路径中不能存在中文字符
     * 图片（image）: 1MB，支持JPG格式
	 * 语音（voice）：1MB，播放长度不超过60s，支持AMR格式
	 * 视频（video）：10MB，支持MP4格式
	 * 缩略图（thumb）：64KB，支持JPG格式
     * @var string
     */
    public $attachment;
    /**
     * 当类型为news图文消息，为消息内容
     * 内容为二维数组 最多为10条消息
     * array(
     *     array(
     * 	       'title'=> string 消息标题, 'description' => string 消息简介, 'url' => string 点击链接跳转地址,
     * 		   'picurl' => string 图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80
     * 	   )
     * )
     * @var array
     */
    public $articles;
    /**
     * 当类型为video/link/music时，为缩略图地址：绝对路径，路径中不能存在中文字符
     * @var string
     */
    public $thumb_path;
    /**
     * 缩略图ID(媒体文件id)
     * @var string
     */
    public $thumb_media_id;
	/**
	 * 当类型为music时,音乐链接
	 * @var string
	 */
    public $music_url;
    /**
     * 当类型为music时,高品质音乐链接，wifi环境优先使用该链接播放音乐
     * @var string
     */
    public $hq_music_url;
    /**
     * 发送报告
     * @var int
     */
    public $notify = 1;
    /**
     * 自定义提醒内容
     * 不超过20个中午字符，默认有微信自动生成
     * @var string
     */
    public $notify_str = '';
    /**
     * 当类型为template时，为模板ID
     * @var string
     */
    public $template_id;
    /**
     * 当类型为templatec时，为模板数据
     * @var array
     */
    public $data;
    /**
     * 当类型为templatec时，为模板背景顶部颜色
     * @var string  事例：#FF0000
     */
    public $topcolor;

    public function __construct()
    {

    }
}

/**
 * 消息地理位置数据结果
 *
 * function_description
 *
 * @author mxg
 *
 */
class WX_Location
{
    /**
     * 消息ID
     * @var string
     */
    public $message_id;
    /**
     * 经度
     * @var float
     */
    public $location_x;
    /**
     * 纬度
     * @var float
     */
    public $location_y;
    /**
     * 缩略大小
     * @var int
     */
    public $scale;
    /**
     * 地址
     * @var string
     */
    public $label;

    public function __construct($message_id, $location_x, $location_y, $scale, $label)
    {
        $this->message_id = $message_id;
        $this->location_x = $location_x;
        $this->location_y = $location_y;
        $this->scale = $scale;
        $this->label = $label;
    }
}

/**
 * 微信自定义菜单接口对象
 */
class WX_Menu
{
	/**
	 * 菜单内容
	 * 内容为多维数组 最多为3条 为一级菜单
	 * 数组中sub_button值数组最多5条 为二级菜单（可选）
	 * array(
	 *     array(
	 * 	       'type' => 'click', 'name' => string 菜单名称, 'key' => string 菜单Key,
	 * 	   ),
	 * 	   array(
	 * 	       'type' => 'view', 'name' => string 菜单名称, 'url' => string 链接URL,
	 * 	   ),
	 * 	   array(
	 * 	      'name' => string 菜单名称,
	 *        'sub_button' => array(
	 *                    array('type' => 'click', 'name' => string 菜单名称, 'key' => string 菜单Key)
	 * 		  ),
	 *     ),
	 * )
	 * @var array
	 */
	public $button;

	public function __construct($button)
	{
		$this->button = $button;
	}
}
