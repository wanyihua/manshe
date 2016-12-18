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
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    'address/adduseraddress' => 'home/UserAddress/addUserAddress',//增加用户地址
    'address/getuseraddress' => 'home/UserAddress/getUserAddress',//查询用户有效地址
    'address/removeuseraddress' => 'home/UserAddress/removeUseraddress',//删除用户地址
    'address/updateuseraddress' => 'home/UserAddress/updateUseraddress',//删除用户地址
    'userfavorite/add' => 'api/UserFavorite/addFavorite',//增加收藏帖子
    'userfavorite/remove' => 'api/UserFavorite/removeFavorite',//删除收藏帖子
    'userfavorite/get' => 'api/UserFavorite/getFavorite',//获取收藏帖子列表

    'userfeedback/add'  => 'api/UserFeedback/addFeedback',//增加用户反馈
    'userfeedback/get'  => 'api/UserFeedback/getFeedback',//获取反馈列表


    'home/index' => 'home/Home/index',//首页
    'useraccount/adduser' => 'home/UserAccount/addUser',//新增用户
    'useraccount/getuserhtml' => 'home/UserAccount/getUserHtml',//新增用户


];
