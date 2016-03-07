<?php

/**
 * 角色管理
 *
 * @author     熊飞龙
 * @date       2015-09-22
 * @copyright  Copyright (c)  2015
 * @version    $Id$
 */
class InvitationModel extends Model {

    private $_db = null;
    private $_table = 'wx_partner_invitation';    // 表名
    private $_table1 = 'wx_bonus_draw';
    private $_tableKey = 'id';        // 表的主键

    public function __construct() {
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
    private function _initParams(array $params = array()) {
        $where = array(
            "{$this->_tableKey}" => empty($params[$this->_tableKey]) ? null : intval($params[$this->_tableKey]),
            "id <" => empty($params['ltId']) ? null : intval($params['ltId']),
            "invitation_open_id" => empty($params['invitation_open_id']) ? null : $params['invitation_open_id'],
            "open_id" => empty($params['open_id']) ? null : $params['open_id'],
            "create_time" => empty($params['create_time']) ? null : $params['create_time'],
            "create_time >=" => empty($params['lgt_create_time']) ? null : $params['lgt_create_time'],
            "create_time <" => empty($params['lgt_create_time']) ? null : date('Y-m', strtotime('+1 month', strtotime($params['lgt_create_time']))),
        );

        return $where;
    }

    /**
     * 查询 wx_bonus_draw表
     * @param array $params
     * @return type
     */
    private function _initSecondParams(array $params = array()) {
        $where = array(
            "{$this->_tableKey}" => empty($params[$this->_tableKey]) ? null : intval($params[$this->_tableKey]),
            "id <" => empty($params['id']) ? null : intval($params['id']),
            "openid" => empty($params['openid']) ? null : $params['openid'],
            "money" => empty($params['money']) ? null : $params['money'],
            "rebate_money" => empty($params['rebate_money']) ? null : $params['rebate_money'],
            "state" => !isset($params['state']) ? null : intval($params['state']),
            "create_time >=" => empty($params['create_time']) ? null : $params['create_time'],
            "create_time <" => empty($params['create_time']) ? null : date('Y-m', strtotime('+1 month', strtotime($params['create_time']))),
            "tradeNo" => empty($params['tradeNo']) ? null : intval($params['tradeNo']),
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
    public function getList(array $params = array()) {
        $orderBy = "{$this->_tableKey} DESC";

        $search = array(
            'where' => $this->_initParams($params),
            'orderBy' => empty($params['orderBy']) ? $orderBy : $params['orderBy'],
        );

        $search = array_merge($params, $search);

        $result = $this->_db->get($this->_table, $search);

        foreach ($result['list'] as &$val) {
            $val['md_create_time'] = date('m-d', strtotime($val['create_time']));
        }
        unset($val);

        return $result;
    }

    public function getSecondList(array $params = array()) {
        $orderBy = " id DESC";
        $search = array(
            'where' => $this->_initSecondParams($params),
            'orderBy' => $orderBy,
        );
        $search = array_merge($params, $search);
        $result = $this->_db->get($this->_table1, $search);

        $state = array(
            '0' => '未审核',
            '1' => '已批准',
            '2' => '已拒绝',
        );
        foreach ($result['list'] as &$val) {
            $val['state_title'] = $state[$val['state']];
        }

        unset($val);

        return $result;
    }

    /**
     * 获得详情
     *
     * @param  array  $params
     *
     * @return array
     */
    public function getDetail(array $params = array()) {
        $search = array(
            'where' => $this->_initParams($params),
        );
        $search = array_merge($params, $search);
        $info = $this->_db->get($this->_table, $search, true);

        return $info;
    }

    /**
     * 处理关注事件
     *
     * @param  array  $params [description]
     *
     * @return void
     */
    public function subscrib(array $params) {
        if (!isset($params['openid']) || !isset($params['event_key'])) {
            return false;
        }

        // 只记录新关注的用户
        // {"a":"Invitation","apiKey":"9d351e5444ca8328721988dc84234e3d","timestamp":"1446186825","sig":"72b2481e8696a09119406955daa489cd","openid":"onwtvsw1aSkZDwyeQtac7DElG9O8","event_key":"456"}
        // event_key 参数的数值带 “qrscene_xxx” 标识表示成功关注了的，只是数字的话表示 已关注过 重新扫描进来的。
        $event_key = explode('_', $params['event_key']);

        // 入库并发放奖励
        if ($event_key[0] == 'qrscene' && !empty($event_key[1])) {

            // 根据 qimg_id 获得 scene_id
            $ywcDb = Factory::getDb('YWC_DB');
            $codeSceneParams = array(
                'where' => array(
                    'scene_id' => $event_key[1],
                ),
            );
            $sceneInfo = $ywcDb->get('wx_qr_code_scene', $codeSceneParams, true);
            if (empty($sceneInfo)) {
                // 获取用户信息失败
                Logger::error('合伙人信息不存在！ OpenId' . $params['openid']);
                return false;
            }

            // 根据 qimg_id 获得合伙人的 openId
            $invitationQrcParams = array(
                'qimg_id' => intval($sceneInfo['qimg_id']),
            );
            $qrInfo = loadModel('Index.InvitationQrc')->getDetail($invitationQrcParams);

            if (!empty($qrInfo)) {
                //关注后发送卡券领取消息
                $source_openid = $qrInfo['open_id'] ? $qrInfo['open_id'] : '';
                $url = 'http://sh.app.socialjia.com/5100App/www/partners.php?a=Draw&m=index&openid=' . $params['openid'] . '&source_openid=' . $source_openid . '&wechat_card_js=1';
                $msg_text = "5100Skincare，<a href=\"{$url}\">领取优惠券</a>";
                //关注后被动回复发送卡券领取消息
                //echo (loadModel('Common')->msgText($params['openid'], '领取优惠券'));
                //发送消息
                Logger::debug('关注后发送领取卡券信息', $params);
                loadModel('Common')->insertOneMessage($params['openid'], $msg_text);

                // 获得关注用户的基础信息
                $userInfo = loadModel('Common')->getUserToApi($params['openid']);
                $userInfo = json_decode($userInfo, true);
                if ($userInfo['error'] != 0) {
                    // 获取用户信息失败
                    Logger::error('获取用户信息失败 OpenId' . $params['openid']);
                }

                // 检查用户是否重复关注
                $invitationParams = array(
                    'open_id' => $params['openid'],
                );
                $userWxInfo = $this->getDetail($invitationParams);
                if (!empty($userWxInfo)) {
                    // 用户重复关注
                    Logger::error('用户重复关注 OpenId' . $params['openid']);
                    return true;
                }

                // 获得发放奖励的参数
                $awardParams = array(
                    'where' => array(
                        'id' => 1,
                    ),
                );
                $award = $this->_db->get('wx_partner_award', $awardParams, true);
                if (empty($award)) {
                    // 没有配置奖励参数
                    Logger::error('没有配置奖励参数 OpenId' . $params['openid']);
                }

                $score = intval($award['score']);
                $money = floatval($award['money']);
                $limitMoney = 500;  // 每月上限金额
                // 检查当月奖励金额是否到达每月上限
                $sql = "SELECT SUM(money) money FROM wx_partner_invitation WHERE `invitation_open_id`='{$qrInfo['open_id']}' AND DATE_FORMAT(create_time, '%Y-%m') = '" . date('Y-m') . "' ";
                $totalMoney = $this->_db->getOne($sql);
                $totalMoney = floatval($totalMoney);

                if (($totalMoney + $money) > $limitMoney) {

                    if ($totalMoney < $limitMoney) {
                        $money = number_format($limitMoney - $totalMoney, 2);
                    } else {
                        $money = 0;
                    }
                }

                $insert = array(
                    'open_id' => $params['openid'],
                    'wx_name' => $userInfo['data']['nickname'],
                    'wx_img' => $userInfo['data']['headimgurl'],
                    'score' => $score,
                    'money' => $money,
                    'create_time' => date('Y-m-d H:i:s'),
                    'invitation_open_id' => $qrInfo['open_id'],
                );

                if ($this->_db->insert($this->_table, $insert)) {

                    // 更新用户的可用金额及积分
                    $sql = "UPDATE `wx_partner_info` SET `integral`=integral+{$insert['score']} WHERE `openid`='{$insert['invitation_open_id']}'";
                    $this->_db->query($sql);

                    // 更新用户的可提现返利
                    $sql = "UPDATE `wx_partner_statistics` SET `notaccount_money`=notaccount_money+{$insert['money']},`summon_money`=summon_money+{$insert['money']} WHERE `openid`='{$insert['invitation_open_id']}'";
                    $this->_db->query($sql);
                }
            }
        }

        return true;
    }

    /**
     * 我的返利 - 呼唤朋友
     *
     * @param  array  $parmas
     *
     * @return array
     */
    public function rebateGetList(array $params) {

        $openId = $params['openid'];
        $params['isPage'] = true;
        $params['pageSize'] = 5;
        $params['fields'] = 'id, wx_name, wx_img, score, money, create_time';
        $params['invitation_open_id'] = $openId;

        $data = $this->getList($params);


        $where = '';
        if (isset($params['lgt_create_time']) && !empty($params['lgt_create_time'])) {
            $where = " AND DATE_FORMAT(create_time, '%Y-%m')='" . $params['lgt_create_time'] . "' ";
        }

        // 获得总积分
        $total_score = $this->_db->getOne("SELECT SUM(`score`) FROM `wx_partner_invitation` WHERE `invitation_open_id` = '{$openId}' {$where} GROUP BY score ");

        // 获得总返利
        $total_money = $this->_db->getOne("SELECT SUM(`money`) FROM `wx_partner_invitation` WHERE `invitation_open_id` = '{$openId}' {$where} GROUP BY money ");

        return array(
            'list' => $data['list'],
            'total' => $data['total'],
            'total_score' => intval($total_score),
            'total_money' => floatval($total_money),
        );
    }

    /**
     * 我的返利，基本信息查询
     * @param array $params
     * @return array
     */
    public function searchInfodata(array $params) {
        $poenid = $params['openid'];
        $params['isPage'] = true;
        $params['pageSize'] = 5;
        $params['fields'] = 'id, openid, money, rebate_money, state,create_time,cancel_time';
        $params['state'] = 1;
        $data = $this->getSecondList($params);

        $where = '';

        if (isset($params['create_time']) && !empty($params['create_time'])) {
            $where = " AND DATE_FORMAT(create_time, '%Y-%m')='" . $params['create_time'] . "' ";
        }

        // 获得总次数
        $total_num = $this->_db->getOne("SELECT COUNT(id) FROM `wx_bonus_draw` WHERE `openid` = '{$poenid}' AND `state`=1 {$where} ");

        // 获得总返利
        $total_money = $this->_db->getOne("SELECT SUM(`money`) FROM `wx_bonus_draw` WHERE `openid` = '{$poenid}' AND `state`=1 {$where} ");

        return array(
            'list' => $data['list'],
            'total' => $data['total'],
            'total_num' => intval($total_num),
            'total_money' => floatval($total_money),
        );
    }

}
