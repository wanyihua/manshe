<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Error.php
 * Date: 2016/12/10
 * Time: 19:45
 */
namespace app\library;

class Error{
    const ERR_SUCCESS = 0;

    //系统错误以 1 开始
    const ERR_SYS = -1000;
    const ERR_PARAM = -1001;
    const ERR_VERIFY_CODE = -1002;
    //业务错误以 2 开始
    const ERR_USER_ADDRESS_DUPLICATED = -2001;
    const ERR_USER_ADDRESS_REMOVE = -2002;
    const ERR_USER_ADDRESS_MAX = -2003;
    const ERR_USER_ADDRESS_UPDATE = -2004;
    const ERR_USER_FEEDBACK_ADD = -2005;

    static $arr_err_msg = array(
        self::ERR_SUCCESS => 'success',
        self::ERR_PARAM => '参数错误',
        self::ERR_SYS => '系统错误',
        self::ERR_VERIFY_CODE => '验证码错误',
        self::ERR_USER_ADDRESS_DUPLICATED => '收货地址重复',
        self::ERR_USER_ADDRESS_REMOVE => '此地址已经删除',
        self::ERR_USER_ADDRESS_UPDATE => '更新地址失败',
        self::ERR_USER_ADDRESS_MAX => '每个用户最多可以添加5个收货地址',
        self::ERR_USER_FEEDBACK_ADD => '添加用户反馈失败',
    );
}