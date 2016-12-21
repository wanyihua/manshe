<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class UserAccount extends Model
{
    //set talbename
    protected $table = 'user_account';
    //set primary key
    protected $pk = 'id';

    public function addUserAccount($param)
    {
        $param['update_time'] = time();
        $this->data($param);
        return $this->save();
    }

}