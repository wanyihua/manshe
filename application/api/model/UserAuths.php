<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:40
 */

namespace app\api\model;

use think\Model;
use think\Db;


class UserAuths extends Model
{
    //set talbename
    protected $table = 'user_account';
    //set primary key
    protected $pk = 'id';

    
}