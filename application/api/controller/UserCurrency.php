<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserCurrency.php
 * Date: 2016/12/26
 * Time: 23:32
 */
namespace app\api\controller;

use think\Validate;
use app\library\Error;
use app\library\Flag;
use think\Request;
use think\Log;
use app\library\Base as BaseController;
use app\api\model\UserCurrency as UserCurrencyModel;

class UserCurrency extends BaseController
{

    private $param;
    private $userCurrencyModel;

    public function __construct()
    {
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->userCurrencyModel = new UserCurrencyModel();
    }

    public function getCoin(){
        $res = $this->check($this->param);
        if (true !== $res) {
            Log::alert(__METHOD__ . ' param: ' . json_encode($this->param));
            return $this->getRes(Error::ERR_PARAM, $res);
        }
        $ret = $this->getCurrency($this->param['user_id'],Flag::CURRENCY_TYPE_COIN);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        }else{
            $this->data = $ret;
            return $this->getRes();
        }
    }

    public function getIntegral(){
        $res = $this->check($this->param);
        if (true !== $res) {
            Log::alert(__METHOD__ . ' param: ' . json_encode($this->param));
            return $this->getRes(Error::ERR_PARAM, $res);
        }
        $ret = $this->getCurrency($this->param['user_id'],Flag::CURRENCY_TYPE_COIN);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        }else{
            $this->data = $ret;
            return $this->getRes();
        }
    }
    public function getCurrency($user_id,$currency_type)
    {
        return $this->userCurrencyModel->getCurrency($user_id,$currency_type);
    }

    public function getRechargeRule(){
        $rule = array(
            array(
                'coin' => 600,//充值送的漫币
                'integral' => 300,//充值送的漫豆
                'price' => 600,//充值金额，单位分
                'tittle' => '首次充值送',
            ),
            array(
                'coin' => 1010,//充值送的漫币
                'integral' => 400,//充值送的漫豆
                'price' => 1000,//充值金额，单位分
                'tittle' => '',
            ),
        );
        $this->data = $rule;
        return $this->getRes();
    }
    public function check($param)
    {
        $rule = [
            'user_id' => 'require',
        ];
        $msg = [
            'user_id.require' => 'user_id必须',
        ];
        $validate = new Validate($rule, $msg);
        $result = $validate->check($param);
        if (!$result) {
            return $validate->getError();
        }
        return $result;
    }
}