<?php
/**
 * 订单商品信息
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class OrderGoods extends Model
{
    //set talbename
    protected $table = 'order_goods';
    //set primary key
    protected $pk = 'auto_id';

    public function getGoodsCategory($param) {
        $conds = array(
            'order_id' => $param['order_id'],
        );
        $field= '*';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
}
