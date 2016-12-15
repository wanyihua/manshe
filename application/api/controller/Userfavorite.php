<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Userfavorite.php
 * Date: 2016/12/14
 * Time: 0:13
 */

namespace app\api\controller;
use think\Log;
use think\Request;
use app\library\Base as BaseController;
use app\library\Error;
use app\api\model\UserFavorite as UserFavoriteModel;
use think\Validate;
use think\Exception;

class UserFavorite extends BaseController
{
    private $param;
    private $userFavorite;

    public function __construct()
    {
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->userFavorite = new UserFavoriteModel();
    }

    /**
     * @return array
     */
    public function addFavorite()
    {
        $res =  self::check($this->param);
        if( true !== $res ){
            //return $this->getRes(Error::ERR_PARAM,Error::$arr_err_msg[Error::ERR_PARAM].': '.$res);
        }
        try{
            $res  = $this->userFavorite->addFavorite($this->param);
        } catch (Exception $e){
            Log::error("add user favorite error: ".json_encode($this->param));
            return $this->getRes(Error::ERR_SYS);
        }
        if(false === $res){
            return $this->getRes(Error::ERR_SYS);
        }else{
            return $this->getRes();
        }
    }

    /**
     * @return array
     */
    public function removeFavorite()
    {
        if (!isset($this->param['fav_id']) || !isset($this->param['user_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        $res = $this->userFavorite->removeFavorite($this->param);
        if($res){
            return $this->getRes();
        }else{
            return $this->getRes(Error::ERR_SYS,'');
        }
    }

    /**
     * @return array
     */
    public function getFavorite()
    {
        if (!isset($this->param['user_id']) || !isset($this->param['fav_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        $this->data =  $this->userFavorite->getFavorite($this->param['user_id'],$this->param['fav_id']);
        return $this->getRes();
    }

    /**
     * @param $param
     * @return array|bool
     */
    public function check($param)
    {
        $rule = array(
            'user_id' => 'require',
            'fav_type' => 'require|in:1,2',
            'fav_id' => 'require',
        );
        $msg = array(
            'fav_type.require' => '收藏类型必须',
            'fav_type.in' => '收藏类型必须正确',
            'fav_id.require' => '收藏帖子或者商品ID必须',
            'user_id.require' => '用户名必须',
        );
        $validate = new Validate($rule,$msg);
        $result = $validate->check($param);
        if (!$result) {
           return $validate->getError();
        }else{
            return $result;
        }
    }
}