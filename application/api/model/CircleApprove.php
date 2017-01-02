<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: CircleApprove.php
 * Date: 2017/1/2
 * Time: 23:13
 */
namespace app\api\model;

use think\Model;
use think\Db;

class CircleApprove extends Model
{
    protected $table = 'circle_approve';

    protected $pk = 'id';

    /**
     * 申请圈子
     *
     */
    public function addCircleApprove($arrInput)
    {
        
        $arrInput['creator'] = '大黄';

        $this->data($arrInput);
        $this->save();
        return $this->data[$this->pk];
    }

}
