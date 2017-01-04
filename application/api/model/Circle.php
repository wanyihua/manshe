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
     * 申请圈子
     *
     */
    public function addCircle($arrInput)
    {

        $arrInput['creator'] = '大黄';

        $this->data($arrInput);
        $this->save();
        return $this->data[$this->pk];
    }

    /**
     * 审核圈子
     *
     */
    public function approveCircle($arrInput)
    {

        $conds = [
            'id' => ['=', $arrInput['circle_id']]
        ];

        $data = [
            'approve_status' => ['=', $arrInput['status']]
        ];

        return Db::table($this->table)->where($conds)->update($data);
    }

    /**
     * 获取所有圈子
     *
     */
    public function getCircle()
    {
        $conds = array(
            'approve_status' => ['=', Flag::CONST_CIRCLE_APPROVE_PASS],
            'is_delete' => ['=', Flag::CONST_CIRCLE_DELETE_NOT],
        );
        $field = 'creator,create_time,update_time';
        return Db::table($this->table)->where($conds)->field($field,true)->select();
    }

}
