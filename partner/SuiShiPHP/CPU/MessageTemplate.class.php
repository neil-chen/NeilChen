<?php
/**
 * 这里是生成5秒回复接口消息消息模板类文件
 */
class MessageTemplate
{

	/**
	 * 获取下行消息XML
	 * @param unknown_type $entWxId
	 * @param WX_Message_Body $messageBody
	 * @return string
	 */
	public static function get($entWxId, $messageBody)
	{
		$rntStrXml = '';
		if ($messageBody && $entWxId && isset($messageBody->type)) {
			$date = strtotime(date('Y-m-d H:i:s'));
			switch ($messageBody->type) {
				case 'text' :
					$rntStrXml = "<xml>
						<ToUserName><![CDATA[{$messageBody->to_users}]]></ToUserName>
						<FromUserName><![CDATA[{$entWxId}]]></FromUserName>
						<CreateTime>{$date}</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[{$messageBody->content}]]></Content>
						</xml>";
					break;
				case 'music' :
					$rntStrXml = "<xml>
						<ToUserName><![CDATA[{$messageBody->to_users}]]></ToUserName>
						<FromUserName><![CDATA[{$entWxId}]]></FromUserName>
						<CreateTime>{$date}</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						<Music>
						<Title><![CDATA[{$messageBody->title}]]></Title>
						<Description><![CDATA[{$messageBody->description}]]></Description>
						<MusicUrl><![CDATA[{$messageBody->music_url}]]></MusicUrl>
						<HQMusicUrl><![CDATA[{$messageBody->hq_music_url}]]></HQMusicUrl>
						</Music>
						</xml>";
					break;
				case 'news' :
					$count = count($messageBody->articles);
					$rntStrXml = "<xml>
						<ToUserName><![CDATA[{$messageBody->to_users}]]></ToUserName>
						<FromUserName><![CDATA[{$entWxId}]]></FromUserName>
						<CreateTime>{$date}</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>{$count}</ArticleCount>
						<Articles>";
					if ($messageBody->articles) {
						foreach ($messageBody->articles as $article) {
							$rntStrXml .= "<item>
							<Title><![CDATA[{$article['title']}]]></Title>
							<Description><![CDATA[{$article['description']}]]></Description>
							<PicUrl><![CDATA[{$article['picurl']}]]></PicUrl>
							<Url><![CDATA[{$article['url']}]]></Url>
							</item>";
						}
					}
					$rntStrXml .= "</Articles>
						</xml> ";
					break;

				default :
					$rntStrXml = "<xml>
						<ToUserName><![CDATA[{$messageBody->to_users}]]></ToUserName>
						<FromUserName><![CDATA[{$entWxId}]]></FromUserName>
						<CreateTime>{$date}</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[this is a default value!please check]]></Content>
						</xml>";
					break;
			}
		}
		return $rntStrXml;
	}
}