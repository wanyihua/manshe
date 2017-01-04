<?php
/**
 * 商品
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class Goods extends Model
{
    //set talbename
    protected $table = 'goods';
    //set primary key
    protected $pk = 'goods_id';

    public function getGoods($param) {
        $conds = array(
            'goods_id' => $param['goods_id'],
        );
        $field= '*';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
}
