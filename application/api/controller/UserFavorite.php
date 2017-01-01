<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserFavorite.php
 * Date: 2016/12/14
 * Time: 0:13
 */

namespace app\api\controller;
use think\Log;
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
        $this->userFavorite = new UserFavoriteModel();
    }

    /**
     * @return array
     */
    public function addFavorite()
    {
        $res =  $this->check();
        if( true !== $res ){
            return $this->getRes(Error::ERR_PARAM,$res);
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
        //TODO: 根据fav_id从商品表或者贴子表中获取更多的详细信息，拼接起来返回
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
            'fav_type.require' => '参数必须包含收藏类型',
            'fav_type.in' => '参数收藏类型必须正确',
            'fav_id.require' => '参数必须包含收藏帖子ID或者商品ID',
            'user_id.require' => '参数必须包含用户名',
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