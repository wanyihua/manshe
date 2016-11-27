<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Useraddress.php
 * Date: 2016/11/27
 * Time: 23:48
 */

namespace app\home\controller;

use think\Controller;
use think\Log;
use app\home\model\UserAddress as UserAddressModel;

class UserAddress extends Controller
{
    public function add($param)
    {
        //  \think\Validate 验证器
        $rules = [
            'name' => 'require|max:25',
            'age' => 'number|between:1,120',
            ];
        $validate = new Validate($rules);



        var_dump("Insert userAddress Ok.");
        /*
           $address = new UserAddressModel();
           $address->address_name = $param['user_id'];
           $address->address_name = $param['address_name'];
           $address->address_name = $param['consignee'];
           $address->address_name = $param['country'];
           $address->address_name = $param['province'];
           $address->address_name = $param['city'];
           $address->address_name = $param['district'];
           $address->address_name = $param['address'];
           $address->address_name = $param['zipcode'];
           $address->address_name = $param['zipcode'];
           $address->address_name = $param['tel'];
           $address->address_name = $param['mobile'];
           if($address->save())
           {
           Log::info("Insert UserAddress OK");
           return true;
           }
           else
           {
           Log::info("Insert UserAddress Failed");
           return false;
           }
         */
    }
}

