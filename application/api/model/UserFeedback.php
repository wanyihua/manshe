<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserFeedback.php
 * Date: 2016/12/16
 * Time: 0:12
 */
namespace app\api\model;

use think\Model;
use think\Db;

class UserFeedback extends Model
{
    protected $table = 'user_feedback';
    protected $pk = 'id';
    //开启自动写入时间戳，默认识别为整型 int 类型
    //protected $autoWriteTimestamp = 'int';
    //protected $createTime = 'create_time';
    protected $field = array(
        'id',
        'user_id',//用户id
        'content',//用户反馈内容
        'feedback_img',//用户上传照片
        'create_time',//创建时间
    );

    public function addFeedback($param)
    {
        $param['create_time'] = time();
        return $this->allowField(true)->save($param);
    }

    public function getFeedback($user_id)
    {
        $conds = array(
            'user_id' => $user_id,
        );
        return Db::table($this->table)->where($conds)->field($this->field)->select();
    }
}
