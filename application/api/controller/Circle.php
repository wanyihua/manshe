<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Circle.php
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\api\model\Circle as CircleModel;
use app\library\Error;
use think\Validate;

class Circle extends BaseController {
    
    private $circleModel;

    public function __construct() {
        parent::__construct();
        $this->circleModel = new CircleModel();
    }

    /**
     * 新建圈子审核
     *
     * @return array
     */
    public function addCircle()
    {
        if (!$this->check($this->param)) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $ret = $this->circleModel->addCircle($this->param);
        if (false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        }
        return $this->getRes();
    }

    /**
     * 审核圈子
     * status：1：通过，2：驳回
     * 
     * @return array
     */
    public function approveCircle()
    {
        if (empty($this->param['circle_id']) || empty($this->param['status'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $ret = $this->circleModel->approveCircle($this->param);
        if (false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        }
        return $this->getRes();
    }

    /**
     * 
     * 获取所有圈子
     * 
     * @return array
     */
    public function getCircle() {
        $ret = $this->circleModel->getCircle();
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        }else{
            $this->data = $ret;
            return $this->getRes();
        }
    }

    /**
     * @param $param
     * @return array|bool
     * @DESC 验证接口字段
     */
    public function check($param)
    {
        $rule = [
            'category_id' => 'require',
            'name'        => 'require|min:4|max:8',
            'briefing'    => 'require|min:50',
            'reason'      => 'require',
        ];
        $msg = [
            'category_id.require' => '圈子必须归属分类',
            'name.require'        => '圈子名称必须填写',
            'name.min'            => '圈子名称不得少于4个字符',
            'name.max'            => '圈子名称不能多于8个字符',
            'briefing.require'    => '圈子介绍必须填写',
            'briefing.min'        => '圈子介绍不得少于50字符',
            'reason.require'      => '圈子申请理由必须填写',
        ];

        $validate = new Validate($rule, $msg);
        $result = $validate->check($param);
        if (!$result) {
            return $validate->getError();
        }
        return $result;
    }
    
}
