<?php
/**
 * 购物车
 * User: yuanxuncheng
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\api\model\Cart as CartModel;
use app\library\Error;

class Cart extends BaseController {

    private $cartModel;

    public function __construct() {
        parent::__construct();
        $this->cartModel = new CartModel();
    }

    /**
     * @desc 获取购物车
     * @return array
     */
    public function getCart() {
        $cart_id = 111;
        $ret = $this->cartModel->getCart($cart_id);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }

    /**
     * @desc 编辑购物车
     * @return array
     */
    public function editCart() {
        $cart_id = 111;
        $ret = $this->cartModel->editCart($cart_id);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }

}
