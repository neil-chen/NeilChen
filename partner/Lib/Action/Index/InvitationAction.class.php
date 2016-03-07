<?php
/**
 * 呼朋唤友
 */
class InvitationAction extends WebAction {

    public function __construct() 
    {
        parent::__construct ();
        $this->model = loadModel ( 'Index.Invitation' );
        $this->assign('title', '呼唤朋友');
    }

    /**
     * 呼朋唤友首页
     */
    public function index ()
    {
        $params = array();
        $params['isPage']   = true;
        $params['pageSize'] = 5;
        $params['fields']   = 'id, wx_name, wx_img, create_time';
        $params['invitation_open_id']  = $this->_openId;
        $result = $this->model->getList($params);

        // 获得合伙人二维码信息
        $invitationQrcModel = loadModel('Index.InvitationQrc');
        $qrInfo = $invitationQrcModel->getQrimg($this->_openId);

        // 设置分享参数
        $shareParams = array(
            'shareTitle' => '我只说一句来，你就可投怀送抱',
            'shareDesc'  => '集齐好友，即可召唤5100极地冰泉靓颜术！',
            'shareImg'   => HttpRequest::getUri() . '/Public/Index/images/lnvitation_share.jpg',
            'shareUrl'   => url('Invitation', 'share', array('open_id' => $this->_openId), 'index.php'),
        );
        $this->setShare($shareParams);

        $this->assign('data', $result);
        $this->assign('qrInfo', $qrInfo);

        $this->display('Index.Invitation.index');
    }

    /**
     * 呼唤朋友 - 分享扫描页
     */
    public function share ()
    {
        $params = $this->getParam();
        $params['open_id'] = empty($params['open_id']) ? 'no-data' : $params['open_id'];

        $partnerInfo = loadModel('Index.User')->getPartner($params['open_id']);
        $infoQr      = loadModel('Index.InvitationQrc')->getDetail($params);

        $this->assign('infoQr', $infoQr);
        $this->assign('partnerInfo', $partnerInfo);
        $this->display('Index.Invitation.share');
    }

    /**
     * 使用规则
     */
    public function rule ()
    {
        $this->display('Index.Invitation.rule');
    }

    /**
     * ajax 获得分页数据
     */
    public function ajaxGetList ()
    {
        $params             = $this->getParam();
        $params['pageSize'] = 5;
        $params['fields']   = 'id, wx_name, wx_img, score, money, create_time';
        $params['ltId']     = !isset($params['startId']) ? null : intval($params['startId']);
        $params['invitation_open_id']  = $this->_openId;
        $result = $this->model->getList($params);
        unset($result['debug']);

        printJson($result, 0, 'ok');
    }

    /**
     * 按月份搜索
     */
    public function search ()
    {
        $params           = $this->getParam();
        $params['openid'] = $this->_openId;
        $result = $this->model->rebateGetList($params);

        printJson($result, 0, 'ok');
    }
    
    /**
     * 我的返利按日期查询
     */
    public function searchInfo(){
        $params           = $this->getParam();
        $params['openid'] = $this->_openId;
        $result = $this->model->searchInfodata($params);
        printJson($result, 0, 'ok');
    }
}