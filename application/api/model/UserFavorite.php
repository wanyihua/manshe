<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserFavorite.php
 * Date: 2016/12/14
 * Time: 0:13
 */
namespace app\api\model;

use think\Model;
use think\Db;
use app\library\Flag;

class UserFavorite extends Model
{
    //set talbename
    protected $table = 'user_favorite';
    //set primary key
    protected $pk = 'id';

    public function addFavorite($param)
    {
        $param['fav_time'] = time();
        $this->data($param);
        return $this->save();
    }

    public function removeFavorite($param)
    {
        $conds = array(
            'fav_id' => $param['fav_id'],
            'user_id' => $param['user_id'],
        );
        $field = array(
            'status' => Flag::USER_FAVORITE_DELETED,
        );
        return $this->where($conds)->update($field);

    }

    public function getFavorite($user_id,$fav_id)
    {
        $conds = array(
            'user_id' => $user_id,
            'fav_id' => $fav_id,
            'status' => Flag::USER_FAVORITE_ACTIVE,
        );
        $field= 'user_id,fav_type,title,description,fav_time';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
}
