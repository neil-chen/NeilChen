<?php

class PartnerAction extends AdminAction {

    private $_p;
    private $_a;
    private $_m;
    private $_IndexModel;
    private $_CardModel;
    private $pagesize = 20;

    /**
     * 构造方法，初始化
     */
    public function __construct() {
        parent::__construct();
        $this->_Model = loadModel('Admin.Partner');
        $this->_Channel = loadModel('Admin.Channel');
        $this->_IndexModel = loadModel('Index.Cardto');
        $this->_CardModel = loadModel('Admin.Card');

        $this->_a = $this->getParam('a');
        $this->_m = $this->getParam('m');
        $this->_p = $this->getParam('p') ? $this->getParam('p') : 1;

        $this->assign('a', $this->_a);
        $this->assign('m', $this->_m);
        $this->assign('p', $this->_p);

        $this->_keyword = $this->getParam('keyword');
        $this->_createtime = $this->getParam('createtime');
        $this->_status = $this->getParam('status');
        $this->_gendar = $this->getParam('gendar');
        $this->_level = $this->getParam('level');
        $this->_channel = $this->getParam('channel');
        $this->_id = $this->getParam('id');
        $this->_openid = $this->getParam('openid');
        $this->_end_date = $this->getParam('end_date');

        $this->_param = array(
            'keyword' => $this->_keyword,
            'createtime' => $this->_createtime,
            'end_date' => $this->_end_date,
            'status' => $this->_status,
            'gendar' => $this->_gendar,
            'level' => $this->_level,
            'channel' => $this->_channel
        );
        $this->assign('webdata', $this->_param);
    }

    /**
     * 合伙人列表
     */
    public function partnerList() {
        //前端页面默认打开
        if (!empty($this->_openid)) {
            $num = $this->_model->getopenidordernuminpartnerinfo($this->_openid);
            $currentPage = ceil($num / $this->pagesize); //反推 第几页
            $remain = $num % $this->pagesize; //反推某一页的第几条
        }

        $param = array();
        $param['name'] = $this->getParam('name');
        $param['sTime'] = $this->getParam('sTime');
        $param['eTime'] = $this->getParam('eTime');
        $param['state'] = $this->getParam('state');
        $param['sex'] = $this->getParam('sex');
        $param['grade'] = $this->getParam('grade');
        $param['channel'] = $this->getParam('channel');

        $param['order'] = " order by id DESC ";

        $param['special'] = " AND state in (1,3) "; //特殊wehere条件
        //获取总记录数
        $count = $this->_Model->getPartnerCount($param);

        $page = new Page2($count, $this->pagesize);
        $page->quicklySet(isset($currentPage) ? $currentPage : $this->_p, 7);
        $limit = $page->returnlimit();

        $param['limit'] = $limit;

        //获取列表
        $partnerList = $this->_Model->getPartnerList($param, 'p.*, ps.par_number');

        unset($param['order']);
        unset($param['limit']);
        unset($param['special']);

        //获取渠道列表
        $channel = $this->_Channel->getlist();
        $keyChannel = array();
        foreach ($channel as $val) {
            $keyChannel[$val['id']] = $val;
        }

        //获取等级列表
        $level = $this->_Model->getPartnerLevel();

        $this->assign('channel', $keyChannel);
        $this->assign('level', $level);
        $this->assign('page', $page->pageArray());
        $this->assign('param', $param);
        $this->assign('partnerList', $partnerList);
        $this->display("Admin.Partner.partnerList");
    }

    /**
     * 合伙人审核列表
     */
    public function checkPartnerList() {

        //前端页面默认打开
        if (!empty($this->_openid)) {
            $num = $this->_model->getopenidordernuminpartnerinfo($this->_openid);
            $currentPage = ceil($num / $this->pagesize); //反推 第几页
            $remain = $num % $this->pagesize; //反推某一页的第几条
        }

        $param = array();
        $param['name'] = $this->getParam('name');
        $param['sTime'] = $this->getParam('sTime');
        $param['eTime'] = $this->getParam('eTime');
        $param['state'] = $this->getParam('state');
        $param['sex'] = $this->getParam('sex');

        $param['order'] = " order by id DESC ";
        $param['special'] = " AND state in (0,2) "; //特殊wehere条件
        //获取总记录数
        $count = $this->_Model->getPartnerCount($param);

        $page = new Page2($count, $this->pagesize);
        $page->quicklySet(isset($currentPage) ? $currentPage : $this->_p, 7);
        $limit = $page->returnlimit();

        $param['limit'] = $limit;

        //获取列表
        $partnerList = $this->_Model->getPartnerList($param, 'p.*, ps.par_number');

        unset($param['order']);
        unset($param['limit']);
        unset($param['special']);

        $this->assign('page', $page->pageArray());
        $this->assign('param', $param);
        $this->assign('partnerList', $partnerList);
        $this->display("Admin.Partner.checkPartnerList");
    }

    /**
     * 合伙人编辑
     */
    public function partnerEdit() {

        $id = $this->getParam('id');

        //根据id查询合伙人
        $partner = $this->_Model->getPartner($id);

        //对省市区字段进行处理
        $area = explode("-", $partner['area']);

        //获取渠道列表
        $channel = $this->_Channel->getlist(array('status' => 1));
        //获取等级信息
        $level = $this->_Model->getPartnerLevelByScore($partner['integral']);

        $this->assign('level', $level);
        $this->assign('channel', $channel);
        $this->assign('partner', $partner);
        $this->assign('prov', $area[0]);
        $this->assign('city', $area[1]);
        $this->assign('dist', $area[2]);
        $this->display("Admin.Partner.partnerEdit");
    }

    /**
     * 合伙人修改
     */
    public function edit() {

        $param['name'] = $this->getParam('name');
        $param['sex'] = $this->getParam('sex');
        $param['area'] = $this->getParam('prov') . "-" . $this->getParam('city') . "-" . $this->getParam('dist');
        $param['birthday'] = $this->getParam('birthday');
        $param['profession'] = $this->getParam('profession');
        $param['identity_card'] = $this->getParam('identity_card');
        $param['phone'] = $this->getParam('phone');
        $param['msg'] = $this->getParam('msg');
        $param['integral'] = $this->getParam('integral');
        $param['address'] = $this->getParam('address');
        $param['channel'] = $this->getParam('channel');

        $type = $this->getParam('type') ? $this->getParam('type') : 'partnerList';

        $id = $this->getParam('id');
        if ($id) {

            $result = $this->_Model->updatePartner($id, $param);

            if ($result) {
                $url = url('Partner', 'partnerEdit', array('id' => $id, "type" => $type), 'admin.php');

                echo "<script> alert('修改成功!');location.href = '{$url}'; </script>";
            } else {
                echo "<script> alert('修改错误,请重新操作!'); </script>";
            }
        } else {
            echo "<script> alert('修改错误,请重新操作!'); </script>";
        }
    }

    /**
     * 合伙人状态操作
     */
    public function stateOperation() {
        $ids = $this->getParam('ids');
        $openids = $this->getParam('openids');

        //type 1申请通过 2申请未通过 3冻结
        $type = $this->getParam('type');

        $result = $this->_Model->stateOperation($ids, $type);
        if ($result) {
            if ($type == 1) {
                $arr = explode(",", $openids);
                $this->_Model->addPartnerStatistics($openids);
                foreach ($arr as $u) {
                    //审核成功后生成合伙人编号
                    $this->_Model->addPartnerUserCode($u);
                    $level = $this->_Model->getPartnerLevelByScore(0);
                    //卡券操作
                    $res = $this->_Model->listCardInfoInId($level['award_cards']);
                    foreach ($res as $v) {
                        $arrto = array(
                            'card_info_id' => $v['id'],
                            'openid' => $u,
                            'cardid' => $v['card_id'],
                            'cardname' => $v['card_name'],
                            'card_ceiling' => $level['card_total'],
                            'card_number' => $level['card_total'],
                        );
                        $resto = $this->_Model->addPartnerCardStatistics($arrto);
                        $this->_CardModel->addPartnerCodeData($u, $v['card_id'], $level['card_total']);  //这里更改为100 
                    }
                    // 发送消息 wangpq
                    loadModel('Common')->insertOneMessage($u, '合伙人审核通过');
                }
            }
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    /**
     * ajax添加卡券
     */
    public function ajaxAddCardCode() {
        $openids = $this->getParam('openids');
        $arr = explode(",", $openids);
        $this->_Model->addPartnerStatistics($openids);
        foreach ($arr as $u) {
            $res = $this->_Model->listCardInfo();
            foreach ($res as $v) {
                $arrto = array(
                    'openid' => $u,
                    'cardid' => $v['card_id'],
                    'cardname' => $v['card_name'],
                    'card_ceiling' => 100,
                    'card_number' => 100,
                );
                $resto = $this->_Model->addPartnerCardStatistics($arrto);
                $this->_CardModel->addPartnerCodeData($u, $v['card_id'], 100);
            }
        }
    }

    /**
     * 合伙人参数
     */
    public function partnerArgs() {
        $level = $this->_Model->getPartnerLevel();
        $award = $this->_Model->getPartnerAward();
        $cards = $this->_Model->getCardList();
        $end_level = array();
        if (count($level) > 1) {
            $end_level = end($level);
        }
        $this->assign('level', $level);
        $this->assign('end_level', $end_level);
        $this->assign('cards', $cards);
        $this->assign('award', $award);
        $this->display("Admin.Partner.partnerArgs");
    }

    /**
     * 合伙人参数保存
     */
    public function partnerArgsSave() {
        $param = $this->getParam();
        //合伙人等级
        $levels = array();
        $now = time();
        foreach ($param['level_id'] as $level_id) {
            $levels[$level_id]['id'] = $level_id;
            $levels[$level_id]['name'] = $param['level_name'][$level_id];
            $levels[$level_id]['from_score'] = $param['from_score'][$level_id];
            $levels[$level_id]['score'] = $param['level_score'][$level_id];
            $levels[$level_id]['card_total'] = $param['card_total'][$level_id];
            $levels[$level_id]['rebate'] = $param['rebate'][$level_id];
            //去空，去重
            $award_cards_arr = array_unique(array_filter(explode(',', $param['cards'][$level_id])));
            $award_cards = implode(',', $award_cards_arr);
            $levels[$level_id]['award_cards'] = $award_cards;
            $levels[$level_id]['changed'] = $now;
            //保存合伙人等级信息
            $level_result = $this->_Model->savePartnerLevel($levels[$level_id]);
        }
        //合伙人返利参数
        $args = array();
        //id 1 为呼朋唤友奖励
        $args[1]['id'] = 1;
        $args[1]['score'] = $param['recommend_score'];
        $args[1]['money'] = $param['recommend_money'];
        $args[1]['changed'] = $now;
        //id 2 为 卡券核销奖励
        $args[2]['id'] = 2;
        $args[2]['score'] = $param['card_score'];
        $args[2]['money'] = $param['card_money'];
        $args[2]['changed'] = $now;
        //保存合伙人返利参数
        $args1_result = $this->_Model->savePartnerAward($args[1]);
        $args2_result = $this->_Model->savePartnerAward($args[2]);

        $url = url('Partner', 'partnerArgs', array(), 'admin.php');
        if ($level_result && $args1_result && $args2_result) {
            echo "<script> alert('修改成功!');location.href = '{$url}'; </script>";
            exit;
        }
        echo "<script> alert('修改错误,请重新操作!'); </script>";
        exit;
    }

    /**
     * 删除合伙人等级
     */
    public function partnerDelete() {
        $param = $this->getParam();
        $id = $param['id'];
        $result = $this->_Model->deletePartnerLevel($id);
        $url = url('Partner', 'partnerArgs', array(), 'admin.php');
        if ($result) {
            echo "<script> alert('删除成功!');location.href = '{$url}'; </script>";
            exit;
        }
        echo "<script> alert('修改失败,请重新操作!'); </script>";
        exit;
    }

    /**
     * 导出合伙人列表
     */
    public function exportPartner() {
        $this->downloadpageset();

        $param = array();
        $param['name'] = $this->getParam('name');
        $param['sTime'] = $this->getParam('sTime');
        $param['eTime'] = $this->getParam('eTime');
        $param['state'] = $this->getParam('state');
        $param['sex'] = $this->getParam('sex');
        $param['grade'] = $this->getParam('grade');
        $param['channel'] = $this->getParam('channel');
        $param['ids'] = $this->getParam('ids');
        $param['order'] = " order by id DESC ";
        $param['special'] = " AND state in (1,3) "; //特殊wehere条件
        //获取列表
        $partnerList = $this->_Model->getPartnerList($param, 'p.*, ps.par_number');

        $fieldlist = array();
        $fieldlist['id'] = 'ID';
        $fieldlist['openid'] = 'openid';
        $fieldlist['code'] = '合伙人编号';
        $fieldlist['name'] = '合伙人姓名';
        $fieldlist['gender'] = '性别';
        $fieldlist['create_time'] = '注册日期';
        $fieldlist['state_name'] = '状态';
        $fieldlist['phone'] = '电话';
        $fieldlist['area'] = '区域';
        $fieldlist['address'] = '地址';
        $fieldlist['identity_card'] = '身份证';
        $fieldlist['profession'] = '职业';
        $fieldlist['integral'] = '积分';
        $fieldlist['level_name'] = '等级';
        $fieldlist['channel_name'] = '渠道组';
        //$fieldlist['par_number'] = '持有卡券数';
        echo $this->getexportstring($partnerList, $fieldlist);
    }

    /**
     * 导出合伙人审核列表
     */
    public function exportCheckPartner() {
        $this->downloadpageset();
        $param = array();
        $param['name'] = $this->getParam('name');
        $param['sTime'] = $this->getParam('sTime');
        $param['eTime'] = $this->getParam('eTime');
        $param['state'] = $this->getParam('state');
        $param['sex'] = $this->getParam('sex');
        $param['ids'] = $this->getParam('ids');
        $param['order'] = " order by id DESC ";
        $param['special'] = " AND state IN (0,2) "; //特殊wehere条件
        //获取列表
        $partnerList = $this->_Model->getPartnerList($param, 'p.*, ps.par_number');

        $fieldlist = array();
        $fieldlist['id'] = 'ID';
        $fieldlist['openid'] = 'openid';
        $fieldlist['name'] = '合伙人姓名';
        $fieldlist['gender'] = '性别';
        $fieldlist['create_time'] = '注册日期';
        $fieldlist['state_name'] = '状态';
        $fieldlist['phone'] = '电话';
        $fieldlist['area'] = '区域';
        $fieldlist['address'] = '地址';
        $fieldlist['identity_card'] = '身份证';
        $fieldlist['profession'] = '职业';
        echo $this->getexportstring($partnerList, $fieldlist);
    }

    /**
     * 下载 接口的一段通用代码
     * @author wangpq 
     */
    private function downloadpageset() {
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . date('YmdHis') . ".csv");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
    }

    /**
     * 输出用于csv格式的字符串。
     * @author wangpq
     * @param array $result 数据库结果集数组
     * @param array $transferfield 显示excel列名以及列名的先后顺序<br/>
     * example:<br/>
     * 如果数组为 array('name','desc','age') 那么输出列顺序为 name,desc,age<br/>
     * 如果数组为 array('name'=>'名字','desc'=>'描述','age'=>'年龄') 那么输出列为 名字，描述，年龄
     * @param boolean $testmode 为true时，编码默认'utf8',输出的换行符为'<br/>'，便于网页测试。<br/>
     * 默认为false，输出'\n'用于csv，并且转换为gbk格式。
     * @return string
     */
    private function getexportstring($result, $transferfield = array(), $testmode = false) {
        $string = '';
        if (empty($result) && empty($transferfield)) {
            return $string;
        }
        if (empty($result) && !empty($transferfield)) {
            //没有数据 只有字段名 那么只输出字段名
            foreach ($transferfield as $v) {
                $string .= $this->transString($v, $testmode);
            }
            $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
            return $string;
        }
        if (!empty($result) && empty($transferfield)) {
            //有数据 无字段名，那么按照数据库原样输出excel 字段名就为键名
            $firstloop = true;
            foreach ($result as $v) {
                if ($firstloop) {
                    foreach ($v as $key => $value) {
                        $string .= $this->transString($key, $testmode);
                    }
                    $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
                    $firstloop = false;
                }
                foreach ($v as $key => $value) {
                    $string .= $this->transString($value, $testmode);
                }
                $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
            }
            return $string;
        }
        if (!empty($result) && !empty($transferfield)) {
            //输出 excel 列名（首行）(字段名)
            foreach ($transferfield as $k => $v) {
                $string .= $this->transString($v, $testmode);
            }
            $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);

            //对于 不改变字段名的数组 如：array（'name','age','id'）
            //统一成 array('数据库字段名1'=>'任意值','数据库字段名2'=>'任意值')的形式。
            if (array_key_exists(0, $transferfield)) {
                $transferfield = array_flip($transferfield);
            }

            foreach ($result as $v) {
                foreach ($v as $key => $value) {
                    if (in_array($key, array_keys($transferfield))) {
                        //将值写入新的数组里，目的按照transferfield更改顺序
                        $transferfield[$key] = $value;
                    }
                }
                //更改完 顺序，输出一行。
                foreach ($transferfield as $v) {
                    $string .= $this->transString($v, $testmode);
                }
                $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
            }
            return $string;
        }
    }

    /**
     * 更换字符串类型 用于导出csv
     * @param type $array
     * @param type $testmode
     * @return $string 
     */
    private function transString($string, $testmode = false) {
        $string = $testmode ? $string : iconv('UTF-8', 'GBK//IGNORE', $string);
        $string = "\"\t" . $string . '"';
        return $string . ',';
    }

}
