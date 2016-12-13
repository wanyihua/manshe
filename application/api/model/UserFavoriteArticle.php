<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Userfavorite.php
 * Date: 2016/12/14
 * Time: 0:13
 */

class userFavoriteArticle extends \think\Model
{
    //set talbename
    protected $table = 'user_favorite';
    //set primary key
    protected $pk = 'id';

    public function addFavoriteArticle($param)
    {
        $this->data($param);
        return $this->allowField(true)->save();
    }

    public function getFavoriteArticle($param)
    {
        $conds = array(
            'user_id' => $param['user_id'],
            'status' => \app\library\Flag::USER_FAVORITE_ACTIVE,
        );
        return \Think\Db::table($this->table)->where($conds)->select();
    }

    public function removeFavoriteArticle($param)
    {
        $conds = array(
            'fav_id' => $param['fav_id'],
        );
        $field = array(
            'status' => \app\library\Flag::USER_FAVORITE_DELETED,
        );
        $this->where($conds)->update($field);

    }
}
