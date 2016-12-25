<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Flag.php
 * Date: 2016/12/11
 * Time: 15:50
 */
namespace app\library;

class Flag
{
    const ADDRESS_STATUS_ACTIVE = 1;
    const ADDRESS_STATUS_DELETED =0;
    const ADDRESS_MAX = 5;
    const ADDRESS_DEFAUL_ON =1;
    const ADDRESS_DEFAUL_OFF =0;

    const USER_FAVORITE_ACTIVE = 1;
    const USER_FAVORITE_DELETED = 0;

    // 登录类型
    const IDENTIFY_TYPE_PHONE = 1;
    const IDENTIFY_TYPE_WEIXIN = 2;
    const IDENTIFY_TYPE_WEIBO = 3;
    const IDENTIFY_TYPE_EMAIL = 4;

    static $arr_identify_type = array(
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
    );

}