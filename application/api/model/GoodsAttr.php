<?php
/**
 * 商品属性
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class GoodsAttr extends Model
{
    //set talbename
    protected $table = 'goods_attr';
    //set primary key
    protected $pk = 'goods_attr_id';

    public function getGoodsAttr($goods_attr_id) {
        $conds = array(
            'goods_attr_id' => $goods_attr_id,
        );
        $field= '*';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
}
