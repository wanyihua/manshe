<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Circle.php
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use think\Validate;

use app\library\Base as BaseController;
use app\api\model\CircleApprove as CircleApproveModel;
use app\library\Error;

class CircleApprove extends BaseController {
    
    private $circleApproveModel;

    public function __construct() {
        parent::__construct();
        $this->circleApproveModel = new CircleApproveModel();
    }

    /**
     * 新建圈子审核
     *
     * @return array
     */
    public function addCircleApprove()
    {
        if (!$this->check($this->param)) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $ret = $this->circleApproveModel->addCircleApprove($this->param);
        if (false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        }
        return $this->getRes();
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
