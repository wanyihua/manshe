<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserCoupon.php
 * Date: 2016/12/25
 * Time: 21:36
 */
namespace  app\api\model;
use think\Db;
use think\Model;
use app\library\Flag;
class UserCoupon extends model{
    //set talbename
    protected $table = 'user_coupon';

    public function addCoupon($user_id,$coupon_id,$content){

        $param['user_id'] = $user_id;
        $param['coupon_id'] = $coupon_id;
        $param['content'] = $content;
        $param['create_time'] = time();
        $param['update_time'] = time();
        $param['status'] = Flag::USER_COUPON_VALID;
        $this->data($param);
        return $this->save();
    }

    public function getCoupon($user_id){
        $conds = array(
            'user_id' => $user_id,
        );
        $field = array(
            'coupon_id',
            'content',
            'status',
        );
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
    public function invalidCoupon($user_id,$coupon_id){
        $conds = array(
            'user_id' => $user_id,
            'coupon_id' => '$coupon_id',
        );
        $filed = array(
            'status' => Flag::USER_CONPON_INVALID,
        );
        return $this->isUpdate(true)->save($field,$conds);
    }
}