<?php
class InterfaceAction {
	
	private static $_e;
	
	private static $_m;
	
	private static $_p;
	
	private $actionInfo;
	
	public function __construct($actionInfo) {
		$this->actionInfo = $actionInfo;
	}
	
	/**
	 * 注册绑定事件 （只能注册的事件一个是绑定和概率）
	 * @param string $name 事件名称
	 * @param obj $obj 验证绑定对象
	 * @param string method 方法名 
	 * @param int $type 1-模型层对象绑定  2-控制层对象绑定
	 */
	public function reqister($name,$obj,$method,$type=1,$param=array()) {
		if(in_array($name, array("bindding","chance"))) {
			if(!(@self::$_e[$name] instanceof $obj)) {
				self::$_e[$name] = ($type == 1) ? M($obj) : A($obj);
				self::$_m[$name] = $method;
				self::$_p[$name] = $param;
			}
		}
	}
	
	/**
	 * 活动配置查询（传递活动id查询活动数据）
	 */
	public function check() {
		return array('falg'=>1,'info'=>$this->actionInfo);
	}
	
	/**
	 * 用户参与活动接口
	 * @param string $uid 用户id
	 * @param string $data 用户参与活动时绑定的数据(可以不传)
	 * @param int $binding 是否需要判断绑定 (默认需要)
	 * @return string flag 1 wid-参与活动id actionInfo-活动信息  workInfo-原来参与信息
	 */
	public function join ($uid,$binding=1,$data="") {
		if($binding == 1) {
			if(is_object(self::$_e['bindding'])) {								//如果注册了绑定事件
				if(!call_user_func_array(array(self::$_e['bindding'], self::$_m['bindding']), array($uid))){
					return array('flag'=>-200,'desc'=>'玩家未绑定,不能参与活动');
				};
			} else {
				return array('flag'=>0,'desc'=>'未注册绑定事件,不能验证绑定信息');
			}
		}
		//通过用户id和活动id获取用户当前状态（如果是新用户操作生成操作id返回，如果不是返回操作信息）
		if($workInfo = WorkOper::getInstance()->getWorkInfoByUID($uid,$this->actionInfo['id'])) {
			if($workInfo['state'] == 1) {													//原来参与过还没有结束		
				$workID = $workInfo['wid'];
				if($this->actionInfo['issur']) {											//是否保存业务数据如果保存返回保存的数据
					$workInfoTemp = DataOper::getInstance()->getDataByID($workID);									//获取用户业务数据
					$surData = ($this->actionInfo['surData']) && json_decode($this->actionInfo['surData'],true);	
					if($surData && is_array($surData)) {
						foreach ($surData['data'] as $v) {
							$workInfoTemp[$v] && $workInfo[$v] = $workInfoTemp[$v];
						}
					}
				}
			}
		}
		if(@$this->actionInfo['cycle'] == 0) {																				//整个活动周期
			$count = WorkOper::getInstance()->getUserWorkCount($uid, $this->actionInfo['id']);								//用户参与该活动多少次
		} else {
			$endTime = strtotime(date('Y-m-d')) + 24*60*60;
			$startTime = $endTime - ($this->actionInfo['cycle']*24*60*60);
			$count = WorkOper::getInstance()->getUserWorkCount($uid, $this->actionInfo['id'],$startTime,$endTime);								//用户参与该活动多少次
		}
		if(!isset($workID)) {
			if($this->actionInfo['isRepeat'] == 0) {																		//活动参与不受限制								
				$workID = WorkOper::getInstance()->buildWorkID($uid, $this->actionInfo['id']);
			} else {			
				if($this->actionInfo['isRepeat'] > $count) {
					$workID = WorkOper::getInstance()->buildWorkID($uid, $this->actionInfo['id']);
				} else {
					return array('flag'=>0,'desc'=>'该活动不能重复参与','temp'=>$count);
				}
			}	
		}
		/**------------------------------------判断是否需要记录参与数据并且记录----------------------------**/
		if($this->actionInfo['isoper']) {																						//判断活动是否开启操作记录保存接口
			$operData = $this->actionInfo['operData'] ? json_decode($this->actionInfo['operData'],true) : array();
			if(in_array("join", $operData)) {
				OperOper::getInstance()->updateRecord($uid, $this->actionInfo['id'], "jion",$data);
			}
		}
		/**------------------------------------------END------------------------------------------------**/
		return array('flag'=>1,'wid'=>$workID,'workInfo'=>$workInfo,'desc'=>'成功','count'=>$count);
	}
	
	/**
	 * 用户操作记录保存接口(比如点击事件)
	 * @param string 用户id
	 * @param string $operKey 操作关键字
	 * @param int $binding 判断是否需要绑定
	 * @param string $filed 操作备注信息 
	 */
	public function oper($uid,$operKey,$binding=1,$filed="") {
		if($binding == 1) {
			if(is_object(self::$_e['bindding'])) {								//如果注册了绑定事件
				if(!call_user_func_array(array(self::$_e['bindding'], self::$_m['bindding']), array($uid))){
					return array('flag'=>-200,'desc'=>'玩家未绑定,不能参与活动');
				};
			} else {
				return array('flag'=>0,'desc'=>'未注册绑定事件,不能验证绑定信息');
			}
		}
		if($this->actionInfo['isoper']) {																						//判断活动是否开启操作记录保存接口
			$operData = $this->actionInfo['operData'] ? json_decode($this->actionInfo['operData'],true) : array();
			if(in_array($operKey, $operData)) {
				$flag = OperOper::getInstance()->updateRecord($uid, $this->actionInfo['id'], $operKey, $filed);
				 return array('flag'=>$flag,'desc'=>'成功');
			} else {
				return array('flag'=>0,'desc'=>'该操作不合法');
			}
		} else {
			die(json_encode(array('flag'=>0,'desc'=>'系统不提供操作记录支持')));
		}
	}
	
	/**
	 * 用户业务数据操作保存接口(比如选择哪个选项格式由前端来控制)
	 * @param string $uid 用户id
	 * @param int $wid 业务id (即参加业务的时候返回的id)
	 * @param string $key 业务关键字(数据库配置)
	 * @param string $data 业务保存的数据
	 * @param int $binding 是否需要绑定
	 */
	public function data($uid,$wid,$key,$data,$binding=1) {
		if($binding == 1) {
			if(is_object(self::$_e['bindding'])) {								//如果注册了绑定事件
				if(!call_user_func_array(array(self::$_e['bindding'], self::$_m['bindding']), array($uid))){
					return array('flag'=>-200,'desc'=>'玩家未绑定,不能参与活动');
				};
			} else {
				return array('flag'=>0,'desc'=>'未注册绑定事件,不能验证绑定信息');
			}
		}
		
		/**-----------------------------------------判断业务ID是否合法------------------------------**/
		$workInfo = WorkOper::getInstance()->getWorkInfoByWID($wid);
		if(is_array($workInfo) && $workInfo) {
			if(($workInfo['uid'] != $uid) || ($workInfo['aid'] != $this->actionInfo['id']) || ($workInfo['state'] != 1)) {
				return array('flag'=>0,'desc'=>'此条业务数据不是你的,请确定业务id正确性');
			}
		} else {
			return array('flag'=>0,'desc'=>'业务没有这条id,请先参加活动后再来保存业务数据');													//无效业务ID
		}
		/**-----------------------------------------END-------------------------------------------**/
		
		
		/**---------------------------------判断业务数据是否可以保存并保存之--------------------------------------**/
		if($this->actionInfo['issur']) {																						//判断活动配置中业务数据是否保存
			if($this->actionInfo['surData']) {
				$surData = json_decode($this->actionInfo['surData'],true);
				if(in_array($key, $surData['data'])) {																//这个关键字能够保存业务数据
					if($surData['sys']['order'] == 1) {																	//需要按照顺序保存业务数据
						foreach ($surData['data'] as $k => $v) {
							if($v == $key) {
								$tempKey = isset($surData['data'][$k-1]) ? $surData['data'][$k-1] : false;		//是否前面有业务数据关键字有保存，没有赋值false
							}
						}
						if($tempKey) {
							if($historyData = DataOper::getInstance()->getDataByID($wid,$key)) {
								$flag = DataOper::getInstance()->updateData($uid,$this->actionInfo['id'], $wid, $key, $data);
							} else {
								return array('flag'=>0,'请先完成前面的步骤');
							}
						} else {																						//是业务的第一个步骤数据保存(不需要验证前面是否是按照步骤来)
							$flag = DataOper::getInstance()->updateData($uid,$this->actionInfo['id'], $wid, $key, $data);
						}
					} else {
						$flag = DataOper::getInstance()->updateData($uid,$this->actionInfo['id'], $wid, $key, $data);
					}
					return array('flag'=>$flag,'desc'=>'成功');
				} else {
					return array('flag'=>0,'desc'=>'系统不支持该业务key保存,请联系管理后台');
				}
			} else {
				return array('flag'=>0,'desc'=>'系统没有业务key保存功能');
			}
		} else {
			return array('flag'=>0,'desc'=>'系统不支持保存业务key功能');
		}
		/**-----------------------------------------END------------------------------------------**/
		return array('flag'=>0,'desc'=>'系统错误');
	}
	
	/**
	 * 业务结束接口
	 * @param string $uid 用户id 
	 * @param int $wid 业务流水id (如果不传递,则获取最近的业务id)
	 */
	public function finish($uid,$wid="",$binding = 1) {
		if($binding == 1) {
			if(is_object(self::$_e['bindding'])) {								//如果注册了绑定事件
				if(!call_user_func_array(array(self::$_e['bindding'], self::$_m['bindding']), array($uid))){
					return array('flag'=>-200,'desc'=>'玩家未绑定,不能参与活动');
				};
			} else {
				return array('flag'=>0,'desc'=>'未注册绑定事件,不能验证绑定信息');
			}
		}
		
		$workInfo = $wid ? WorkOper::getInstance()->getWorkInfoByWID($wid) : $workInfo = WorkOper::getInstance()->getWorkInfoByUID($uid, $this->actionInfo['id']);
		if($workInfo && ($workInfo['uid'] == $uid)) {
			if($workInfo['state'] == 1) { 
				$flag = WorkOper::getInstance()->updateState($workInfo['wid'], array('state'=>2));
				return array('flag'=>$flag,'desc'=>'成功');	
			}
		} else {
			return array('flag'=>0,'desc'=>'用户没有参与该活动,不能请求结束接口');							//用户没有参与活动
		}
		return array('flag'=>0,'desc'=>'业务流水已经结束');
	}
	
	/**
	 * 活动来源接口
	 * @param string $uid 用户id
	 * @param string $source 来源资源值
	 * @param $string $memo 来源值备注
	 */
	public function source($uid,$source,$memo= "") {									//附加信息可以为空
		if($flag = SourceOper::getInstance()->insertUsource($this->actionInfo['id'], $uid,$source,$memo)) {
			return array('flag'=>1,'desc'=>'成功');
		} else {
			return array('flag'=>0,'desc'=>'系统错误');
		}
	}
	
	/**
	 * 用户抽奖接口
	 * @param string $uid 用户uid
	 * @param int $wid 业务流水id
	 * @param int $binding 是否需要判断绑定
	 */
	public function getReward($uid,$wid,$binding = 1) {
		if($binding == 1) {
			if(is_object(self::$_e['bindding'])) {								//如果注册了绑定事件
				$res = call_user_func_array(array(self::$_e['bindding'], self::$_m['bindding']), array($uid));
				if(!$res) {
					return array('flag'=>-200,'desc'=>'玩家未绑定,不能参与活动');
				}
			} else {
				return array('flag'=>0,'desc'=>'未注册绑定事件,不能验证绑定信息');
			}
		}
		$rewardID = 0;
		$workInfo = WorkOper::getInstance()->getWorkInfoByWID($wid);
		if($workInfo['state'] == 2) {																					//代表用户已经完成该业务
			$rewardConfig = RewardOper::getInstance()->getRewardInfoByAid($this->actionInfo['id']);
			
			if($rewardConfig && is_array($rewardConfig)) {
				if(is_object(self::$_e['chance'])) {								//前端注册了概率则按照前端处理概率来处理
					$conProbability = call_user_func_array(array(self::$_e['chance'], self::$_m['chance']), self::$_p['chance']);		//前端控制产生的概率格式 array('9'=>0.5,'10'=>0.2))
					if($conProbability && is_array($conProbability)) {
						foreach ($rewardConfig as $k => $v) {
							if(in_array($v['rid'], array_keys($conProbability))) {
								$v['chance'] = $conProbability[$v['rid']];
							}
							$rewardConfig[$k] = $v;
						}
					}
				}
				/**-------------------------------奖项逻辑----------------------------------------**/
				//获取活动今天奖励数据分配
				$spreadDData = RewardOper::getInstance()->getSpreadByAid($this->actionInfo['id']);
				//判断整个活动获取的奖励数据分配
				$spreadAData = RewardOper::getInstance()->getSpreadByAid($this->actionInfo['id'],2);
				//获取用户今天奖励数据分配
				$spreadUDData = RewardOper::getInstance()->getSpreadByUid($this->actionInfo['id'],$uid);
				//获取用户整个活动获取的奖励数据分配
				$spreadUAData = RewardOper::getInstance()->getSpreadByUid($this->actionInfo['id'],$uid,2);
				$seed = rand(1, 100000);
				$temp = 0;																		//随机种子累加										
				$tempChance = 0;																//判断全服概率
				$isGetReward = array('i'=>0,'r'=>0);											//是否可以获得奖励 i=>0,1可以获得奖励 r=>奖励的id
				foreach ($rewardConfig as $k => $v) {
					$tempChance += $v['chance'];
					if(@($v['num'] <= $spreadAData[$k]) && ($v['num'] != -1)) continue;			//超过了系统的发放
					if(@($v['slimit'] <= $spreadDData[$k]) && ($v['slimit'] != -1)) continue;	//超过了系统每日的发放
					if(@($v['ulimit'] <= $spreadUDData[$k]) && ($v['ulimit'] != -1)) continue;	//超过了用户每日发放的限制
					$isGetReward["i"] = 1;
					$temp += $v['chance']*100000;
					$isGetReward["r"] = $k;
					if($seed <= $temp) {
						$rewardID = $k;
						break;
					}			
				}
				if(($rewardID == 0) && ($tempChance == 1) && ($isGetReward["i"] == 1)) {		//用户未中奖(判断是否概率为100%)查看系统剩余的奖励随机分配一个
					$rewardID = $isGetReward['r'];
				}
				if($rewardID > 0) {																//代表玩家获得改奖项
					if($rid = RewardOper::getInstance()->insertRewardInfo($this->actionInfo['id'],$uid,$rewardID)) {
						if(WorkOper::getInstance()->updateState($wid,array("state"=>3,"rid"=>$rid))) {						//更新记录状态
							return array('flag'=>1,'rewardID'=>$rewardID,'rewardData'=>$rewardConfig[$rewardID],'temp'=>$isGetReward);
						}
					} else {
						return array('flag'=>0,'desc'=>'未更新数据');
					}
				} else {
					
					
					return array('flag'=>0,'desc'=>'没有获得奖励','temp'=>$isGetReward);
				}
				/**-------------------------------END--------------------------------------------**/
			} else {
				return array('flag'=>0,'desc'=>'该活动没有奖励');
			}
		} else {
			if($workInfo['state'] == 1) {
				return array('flag'=>0,'desc'=>'没有完成,不能领取奖励');
			} else if($workInfo['state'] == 3) {
				return array('flag'=>0,'desc'=>'已经领取完奖励');
			} 
			return array('flag'=>0,'desc'=>'当前流水不可用');
		}
	}
	
	/**
	 * 获取用户上一条记录数据
	 * @param string $uid 用户id
	 */
	public function getLastWorkInfo($uid) {
		return WorkOper::getInstance()->getWorkInfoByUID($uid,$this->actionInfo['id']);
	}
	
	/**
	 * 通过业务id和业务关键字获取业务信息
	 */
	public function getDataInfo($wid,$key="") {
		return DataOper::getInstance()->getDataByID($wid,$key);
	}
	
	/**
	 * 更新用户领奖数据状态
	 * @param int $id 领奖记录id
	 */
	public function updateRewardInfo($id,$state) {
		return RewardOper::getInstance()->updateLastRewardInfo($id,$state);
	}
	
	/**
	 * 更新用户记录状态
	 */
	public function updateRecordInfo($wid,$rid,$state = 1) {
		return WorkOper::getInstance()->updateState($wid,array("state"=>$state,"rid"=>$rid));				//更新最后记录已经获得奖励状态
	}
	
	/**
	 * 通过业务id获取业务信息 
	 */
	public function getWorkInfoByWID($wid) {
		return WorkOper::getInstance()->getWorkInfoByWID($wid);
	}
	
	/**
	 * 通过奖励id获取奖励信息
	 */
	public function getRewardById($id) {
		return RewardOper::getInstance()->getRewardInfoByID($id);
	}
	
	/**
	 * 插入邮件地址信息
	 */
	public function insertMail($data) {
		$data['aid'] = $this->actionInfo['id'];
		return MailOper::getInstance()->insertInfo($data);
	}
}