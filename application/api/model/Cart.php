<?php
/**
 * 购物车
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class Cart extends Model
{
    //set talbename
    protected $table = 'cart';
    //set primary key
    protected $pk = 'cart_id';

    public function getCart($cart_id) {
        $conds = array(
            'cart_id' => $cart_id,
        );
        $field= '*';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }

    public function editCart($cart_id) {

    }
}
