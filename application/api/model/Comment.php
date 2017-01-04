<?php
/**
 * 商品评论
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class Comment extends Model
{
    //set talbename
    protected $table = 'comment';
    //set primary key
    protected $pk = 'comment_id';

    public function getComment($comment_id) {
        $conds = array(
            'comment_id' => $comment_id,
        );
        $field= '*';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
}
