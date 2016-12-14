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
    'useraddress/adduseraddress' => 'home/useraddress/addUserAddress',//增加用户地址
    'useraddress/getuseraddress' => 'home/useraddress/getUseraddress',//查询用户有效地址
    'useraddress/removeuseraddress' => 'home/useraddress/removeUseraddress',//删除用户地址
    'useraddress/updateuseraddress' => 'home/useraddress/updateUseraddress',//更新用户地址
    'userfavorite/add' => 'api/Userfavorite/addFavorite',//添加收藏
    'userfavorite/remove' => 'api/Userfavorite/removeFavorite',//取消收藏
    'userfavorite/get' => 'api/Userfavorite/getFavorite',//获取收藏

    'useraccount/adduser' => 'home/useraccount/addUser',//新增用户
];
