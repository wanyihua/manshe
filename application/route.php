<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    /*
    '__pattern__' => [
        'name' => '\w+',
    ],

    '[hello]'     => [
       //':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
*/
    'user/getverifycode' => 'api/User/getVerifyCode',
    'user/register' => 'api/User/register',
    'user/login' => 'api/User/login',
    'user/logout' => 'api/User/logout',
    'user/forgot' => 'api/User/forgot',
    //个人中心
    'address/adduseraddress' => ['api/UserAddress/addUserAddress',['method' => 'post']],//增加用户地址
    'address/getuseraddress' => ['api/UserAddress/getUserAddress',['method' => 'get']],//查询用户有效地址
    'address/removeuseraddress' => ['api/UserAddress/removeUseraddress',['method' => 'post']],//删除用户地址
   'address/updateuseraddress' => ['api/UserAddress/updateUseraddress',['method' => 'post']],//删除用户地址
    'userfavorite/add' => ['api/UserFavorite/addFavorite',['method' => 'get']],//增加收藏帖子
    'userfavorite/remove' => ['api/UserFavorite/removeFavorite',['method' => 'get']],//删除收藏帖子
    'userfavorite/get' => ['api/UserFavorite/getFavorite',['method' => 'get']],//获取收藏帖子列表
    'userfeedback/add'  => ['api/UserFeedback/addFeedback',['method' => 'post']],//增加用户反馈
    'userfeedback/get'  => ['api/UserFeedback/getFeedback',['method' => 'get']],//获取反馈列表
    'coupon/getcouponlist' =>  ['api/UserCoupon/getCouponList', ['method' => 'get']],//获取用户优惠券
    'coupon/addcoupon' =>  ['api/UserCoupon/addCoupon', ['method' => 'get']],//获取用户优惠券
    'currency/getcoin' =>  ['api/UserCurrency/getCoin', ['method' => 'get']],//获取用户漫币
    'currency/getintegral' =>  ['api/UserCurrency/getIntegral', ['method' => 'get']],//获取用户漫币
    'currency/rechargerule' =>  ['api/UserCurrency/getRechargeRule', ['method' => 'get']],//充值漫币送漫豆规则
    'home/index' => 'home/Home/index',//首页
    'admin/add' => 'home/Admin/addAdmin',//新增管理员
    'admin/del' => 'home/Admin/removeAdmin',//删除管理员
    
    'useraccount/adduser' => 'home/UserAccount/addUser',//新增用户
    'useraccount/getuserhtml' => 'home/UserAccount/getUserHtml',//新增用户


    // 社区
    
];
