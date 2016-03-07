<?php
/**
* 合伙人邀请好友 - 二维码表
*
* @author     熊飞龙
* @date       2015-10-30
* @copyright  Copyright (c)  2015
* @version    $Id$
*/
class InvitationQrcModel extends Model {

    private $_db       = null;
    private $_table    = 'wx_partner_invitation_qrc';    // 表名
    private $_tableKey = 'id';        // 表的主键
 
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
            "{$this->_tableKey}" => empty($params[$this->_tableKey]) ? null : intval($params[$this->_tableKey]),
            "qimg_id"            => empty($params['qimg_id'])        ? null : $params['qimg_id'],
            "open_id"            => empty($params['open_id'])        ? null : $params['open_id'],
        );

        return $where;
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

        $search = array(
            'where'   => $this->_initParams($params),
            'orderBy' => empty($params['orderBy']) ? $orderBy : $params['orderBy'],
        );

        $search = array_merge($params, $search);

        $result = $this->_db->get($this->_table, $search);

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
     * 获得邀请朋友二维码
     */
    public function getQrimg ($openId)
    {
        $searchParams = array(
            'open_id' => $openId,
        );
        $detail = $this->getDetail($searchParams);

        // 如果没有二维码则生成
        if (empty($detail)) {

            $qrConfig=array(
                'qrc_app_id'  => 4,
                'media_id'    => "",
                'type'        => 'third',
                'is_tip'      => 1,
                'group_id'    => 10,
                'scanMsg'     => array(),
                'subscribMsg' => array(
                    'type'        => 'third',
                    'third_path'  => '1',
                    'content'     => 'http://sh.app.socialjia.com/5100Partner/www/index.php?a=Subscrib', // 不要带 &m=index
                    'material_id' => '0'
                )
            );

            $response = loadModel('Common')->getUerQrcToApi($openId, $qrConfig);
            $response = json_decode($response, true);

            // 生成二维码并入库
            if ($response['error'] == 0) {

                $insert = array(
                    'open_id'     => $openId,
                    'qimg_id'     => $response['data']['qimg_id'],
                    'qrc_url'     => $response['data']['qrc_url'],
                    'create_time' => date('Y-m-d H:i:s'),
                );
                $this->_db->insert('wx_partner_invitation_qrc', $insert);

                $detail = $response['data'];
            }
        }

        return $detail;
    }
}