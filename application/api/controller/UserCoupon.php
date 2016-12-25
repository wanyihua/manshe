<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserConpon.php
 * Date: 2016/12/25
 * Time: 21:45
 */
namespace app\api\controller;
use app\library\Base as BaseController;
use app\api\model\UserCoupon as UserCouponModel;
use app\library\Error;

use app\library\Flag;
use think\Log;
use think\Request;

class UserCoupon extends BaseController {

    private $param;
    private $userCouponModel;
    public function __construct(){
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->userCouponModel = new UserCouponModel();
    }

    public function getCouponList(){
        if(!isset($this->param['user_id'])){
            Log::alert(__METHOD__.' param: '.json_encode($this->param));
            return $this->getRes(Error::ERR_PARAM);
        }
        $ret = $this->userCouponModel->getCoupon($this->param['user_id']);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        }else{
            $this->data = $ret;
            return $this->getRes();
        }
    }

    public function addCoupon(){
        if(!isset($this->param['user_id']) || !isset($this->param['coupon_id'])){
            Log::alert(__METHOD__.' param: '.json_encode($this->param));
            return $this->getRes(Error::ERR_PARAM);
        }
        //TODO: 根据coupon_id查询rule填充到content�?
        $content = '优惠券描述信息';
        $ret = $this->userCouponModel->addCoupon($this->param['user_id'],$this->param['coupon_id'],$content);
        if(false === $ret){
            Log::alert(__METHOD__.' ret: '.json_encode($res));
            return $this->getRes(Error::ERR_SYS);
        }else{
            Log::info(__METHOD__.' return '.json_encode($ret));
            return $this->getRes();
        }
    }

    public function invalidCoupon($userid,$coupon_id){

    }
}
