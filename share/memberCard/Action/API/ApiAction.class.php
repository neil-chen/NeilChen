<?php

/**
 * 接口文件
 */
class ApiAction extends Action {

    private $_model;
    private $_ModelCom;
    private $_admin_model;

    public function __construct() {
        parent::__construct();
        $this->_model = loadModel('Index');
        $this->_ModelCom = loadModel('Common');
        $this->_admin_model = loadModel('Admin.Admin');
    }

    /**
     * 验证api_key
     */
    private function checkKey() {
        $api_key = (string) trim($this->getParam('api_key'));

        if ($api_key != (string) "de593361841757578e935b1c99ccc2e1") {
            $json = array("error" => 1, "msg" => "api_key 错误");
            echo json_encode($json);
            exit;
        }
    }

    /**
     * 会员卡激活
     */
    public function activateCard() {

        //验证api_key
        $this->checkKey();

        $json = array("error" => 0, "msg" => "OK");
        //初始积分
        $init_bonus = trim($this->getParam('init_bonus'));

        if (empty($init_bonus) && $init_bonus != 0) {
            $json['msg'] = "init_bonus 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['init_bonus'] = $init_bonus;
        }
        //会员卡编号
        $membership_number = trim($this->getParam('membership_number'));
        $data['membership_number'] = $membership_number;
        if (empty($membership_number)) {
            $json['error'] = 1;
            $json['msg'] = "membership_number 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['membership_number'] = $membership_number;
        }
//         //卡卷id
//         $card_id = trim($this->getParam('card_id'));
//         if (empty($card_id)) {
//             $json['error'] = 1;
//             $json['msg'] = "Card_id 参数不能为空";
//             echo json_encode($json);
//             exit;
//         } else {
//             $data['card_id'] = $card_id;
//         }
        //初始等级
        $value1 = trim($this->getParam('value1'));
        if (empty($value1)) {
            $json['error'] = 1;
            $json['msg'] = "value1 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['init_custom_field_value1'] = $value1;
        }

        //openid
        $openid = trim($this->getParam('openid'));
        if (empty($openid)) {
            $json['error'] = 1;
            $json['msg'] = "Openid 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['openid'] = $openid;
        }

        //customer_id
        $customer_id = trim($this->getParam('code'));
        if (empty($customer_id)) {
            $json['error'] = 1;
            $json['msg'] = "code 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['customer_id'] = $customer_id;
        }

        $result = $this->_admin_model->activateCard($data);

        //结果验证
        if ($result['errcode'] == 0) {
            echo json_encode($json);
        } else {
            $json['error'] = 1;
            $json['msg'] = $result['errmsg'];
            echo json_encode($json);
        }
    }

    /**
     * 激活成功返回页面
     */
    public function activateSuccess() {
        $jsSign = new WxJsSign(Config::APP_ID, Config::API_SECRET);
        $signPackage = $jsSign->GetSignPackage();
        //JSAPI KEY
        $data = array(
            'appId' => $signPackage['appId'],
            'timestamp' => $signPackage['timestamp'],
            'nonceStr' => $signPackage['nonceStr'], //随机字符串
            'signature' => $signPackage['signature'],
        );
        $this->assign('data', $data);

        $this->display('Index.activateSuccess');
    }

    /**
     * 积分变更接口
     */
    public function scoreChangeApi() {

        //验证api_key
        $this->checkKey();

        $json = array("error" => 0, "msg" => "OK");

//         //卡卷id
//         $card_id = trim($this->getParam('card_id'));
//         if (empty($card_id)) {
//         	$json['error'] = 1;
//         	$json['msg'] = "Card_id 参数不能为空";
//         	echo json_encode($json);
//         	exit;
//         } else {
//         	$data['card_id'] = $card_id;
//         }
        //openid
        $openid = trim($this->getParam('openid'));
        if (empty($openid)) {
            $json['error'] = 1;
            $json['msg'] = "Openid 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['openid'] = $openid;
        }

        //source_score 原始分数
        $source_score = trim($this->getParam('source_score'));
        if (empty($source_score) && $source_score != 0) {
            $json['error'] = 1;
            $json['msg'] = "source_score 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['source_score'] = $source_score;
        }

        //source_score 现有分数
        $now_score = trim($this->getParam('now_score'));
        if (empty($now_score)) {
            $json['error'] = 1;
            $json['msg'] = "now_score 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['now_score'] = $now_score;
        }

        //add_bonus 变更积分
        $add_bonus = trim($this->getParam('add_bonus'));
        if (empty($add_bonus)) {
            $json['error'] = 1;
            $json['msg'] = "add_bonus 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['add_bonus'] = (int) $add_bonus;
        }

        //record_bonus  积分变更消息
        $record_bonus = trim($this->getParam('record_bonus'));
        if (empty($record_bonus)) {
            $json['error'] = 1;
            $json['msg'] = "record_bonus 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['record_bonus'] = $record_bonus;
        }


        //custom_field_value1  等级
        $value1 = trim($this->getParam('grade'));
        if (empty($value1)) {
            $json['error'] = 1;
            $json['msg'] = "custom_field_value1 参数不能为空";
            echo json_encode($json);
            exit;
        } else {
            $data['custom_field_value1'] = $value1;
        }

        $result = $this->_admin_model->scoreChange($data);

        //结果验证
        if ($result['errcode'] == 0) {
            $json['result_bonus'] = $result['result_bonus']; //变更成功后 将微信剩余积分返回
            echo json_encode($json);
        } else {

            $json['error'] = 1;
            $json['msg'] = $result['errmsg'];
            echo json_encode($json);
        }
    }

}
