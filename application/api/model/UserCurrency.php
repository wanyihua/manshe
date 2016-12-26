<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserCurrency.php
 * Date: 2016/12/26
 * Time: 23:32
 */
namespace app\api\model;
class UserCurrency extends \think\console\command\make\Model{
    private $table = 'user_currency';
    public function addCurrency(){

    }

    public function getCurrency($user_id,$currency_type){
        $conds = array(
            'user_id' => $user_id,
            'currency_type' => $currency_type,
        );
        $field =  array(
            'amount',
        );
        return \think\Db::table($this->table)->where($conds)->field($field)->select();
    }
}
