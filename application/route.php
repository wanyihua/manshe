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
    'favoritearticle/add' => 'home/api/addFavoriteArticle',//增加收藏帖子
    'favoritearticle/remove' => 'home/api/removeFavoriteArticle',//删除收藏帖子
    'favoritearticle/get' => 'home/api/getFavoriteArticle',//获取收藏帖子列表
    'favoritegoods/add' => 'home/api/addFavoriteGoods',//增加收藏商品
    'favoritegoods/remove' => 'home/api/removeFavoriteGoods',//删除收藏商品
    'favoritegoods/get' => 'home/api/getFavoriteGoods',//获取收藏商品列表


    'useraccount/adduser' => 'home/useraccount/addUser',//新增用户


];
