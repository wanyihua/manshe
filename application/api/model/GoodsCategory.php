<?php
/**
 * 商品分类
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class GoodsCategory extends Model
{
    //set talbename
    protected $table = 'goods_category';
    //set primary key
    protected $pk = 'cat_id';

    public function getGoodsCategory($cat_id) {
        $conds = array(
            'cat_id' => $cat_id,
        );
        $field= '*';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
}
