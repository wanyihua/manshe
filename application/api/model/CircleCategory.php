<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: CircleCategory.php
 * Date: 2017/1/2
 * Time: 23:13
 */
namespace app\api\model;

use think\Model;
use think\Db;

use app\library\Flag;

class CircleCategory extends Model
{
    protected $table = 'circle_category';

    protected $pk = 'id';

    /**
     * 获取所有圈子分类
     *
     */
    public function getCircleCategory()
    {
        $conds = array(
            'is_delete' => ['=', Flag::CONST_CIRCLECATEGORY_DELETE_NOT],
        );
        $field = 'creator,create_time,update_time';
        return Db::table($this->table)->where($conds)->field($field,true)->select();
    }

}
