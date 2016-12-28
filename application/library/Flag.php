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
    const SMS_EXPIRE_TIME = 60;
    const ADDRESS_STATUS_ACTIVE = 1; //用户有效地址
    const ADDRESS_STATUS_DELETED =0; //用户删除地址
    const ADDRESS_MAX = 5; //用户最多设置地址
    const ADDRESS_DEFAUL_ON =1; //默认地址
    const ADDRESS_DEFAUL_OFF =0; //非默认地址
    const USER_FAVORITE_ACTIVE = 1; //用户收藏
    const USER_FAVORITE_DELETED = 0; // 用户删除的收藏
    const USER_COUPON_VALID = 1; //用户有效优惠券
    const USER_COUPON_INVALID = 0; //无效优惠券
    const USER_COUPON_USED = 2; //使用过的优惠券
    const CURRENCY_TYPE_COIN = 1; //漫币
    const CURENCY_TYPE_INTEGRAL = 2; //漫豆

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