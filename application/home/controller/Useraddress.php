<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserAddress.php
 * Date: 2016/11/27
 * Time: 23:48
 */

namespace app\home\controller;

use think\Controller;
use think\Log;
use app\home\model\UserAddress as UserAddressModel;
use think\Validate;
use think\Request;

class UserAddress extends Base
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function add()
    {
        $param = $this->request->param();
        $result = $this->check($param);
        if($result) {
            $address = new UserAddressModel();
            /*
            $address->user_id= $param['user_id'];
            $address->address_name = $param['address_name'];
            $address->consignee = $param['consignee'];
            $address->country = $param['country'];
            $address->province = $param['province'];
            $address->province = $param['city'];
            $address->district = $param['district'];
            $address->address = $param['address'];
            $address->zipcode = $param['zipcode'];
            $address->tel = $param['tel'];
            $address->mobile = $param['mobile'];
            */
            $address->data($param);
            $result = $address->save();
            var_dump($result);
            if ($result) {
                Log::info("Insert UserAddress OK");
                return "ok";
            } else {
                Log::info("Insert UserAddress Failed");
                return "failed";
            }
        }
    }

    public function check($param)
    {
        $rule = [
            'address_name' => 'require|max:25',
            'user_id' => 'require',
            'consignee' => 'require',
            'address' => 'require',
            'mobile' => 'require',
            'province' => 'require',
            'city' => 'require',
            'district' => 'require',
        ];
        $msg = [
            'address_name.require' => '名称必须',
            'address_name.max' => '名称最多不能超过25个字符',
            'user_id.require' => 'userid必须',
            'consignee.require' => 'consignee必须',
            'address.require' => 'address必须',
            'mobile.require' => 'mobile必须',
            'province.require' => 'province必须',
            'city.require' => 'city必须',
            'district.require' => 'district必须',
            'age.number' => '年龄必须是数字',
        ];
        $data = [
            'name' => 'thinkphp',
            'age' => 121,
            'email' => 'thinkphp@qq.com',
        ];
        $validate = new Validate($rule,$msg);
        $result = $validate->check($param);
        if(!$result){
            return $validate->getError();
        }
        return $result;
    }
}

