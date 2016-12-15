<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserFeedback.php
 * Date: 2016/12/16
 * Time: 0:16
 */

namespace app\api\controller;

use app\library\Error;
use think\Exception;
use think\Request;
use think\Validate;
use app\library\Base as BaseController;
use app\api\model\UserFeedback as UserFeedbackModel;

class UserFeedback extends BaseController
{
    private $param;
    private $userFeedback;

    public function __construct()
    {
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->userFeedback = new UserFeedbackModel();
    }

    public function addFeedback()
    {
        $validate = $this->check();
        if (true !== $validate) {
            return $this->getRes(Error::ERR_PARAM,$validate);
        }

        $res = $this->userFeedback->addFeedback($this->param);
        if(false === $res )
        {
            return $this->getRes(Error::ERR_USER_FEEDBACK_ADD);
        }else{
            return $this->getRes();
        }
    }

    public function getFeedback()
    {
        if(!isset($this->param['user_id']))
        {
            return $this->getRes(Error::ERR_PARAM);
        }
        $res = $this->userFeedback->getFeedback($this->param['user_id']);
        if(false === $res){
            return $this->getRes(Error::ERR_SYS);
        }
        $this->data = $res;
        return $this->getRes();
    }

    public function check()
    {
        $rule = array(
            'user_id' => 'require',
            'content' => 'require|length:5,255',
        );
        $msg = array(
            'user_id.require' => '参数必须包含user_id',
            'content.require' => '参数必须包含content',
            'content.length' => '文本内容在5到255个字符内',
        );
        $validate = new Validate($rule, $msg);
        $res = $validate->check($this->param);
        if (!$res) {
            return $validate->getError();
        } else {
            return $res;
        }
    }
}
