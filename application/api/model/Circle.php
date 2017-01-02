<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Circle.php
 * Date: 2017/1/2
 * Time: 23:13
 */
namespace app\api\model;

use think\Model;
use think\Db;

use app\library\Flag;

class Circle extends Model
{
    protected $table = 'circle';

    protected $pk = 'id';

    /**
     * 获取所有圈子
     *
     */
    public function getCircle()
    {
        $conds = array(
            'is_delete' => ['=', Flag::CONST_CIRCLE_DELETE_NOT],
        );
        $field = 'creator,create_time,update_time';
        return Db::table($this->table)->where($conds)->field($field,true)->select();
    }

}
