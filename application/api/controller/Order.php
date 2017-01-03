<?php
/**
 * 订单
 * User: yuanxuncheng
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\api\model\OrderGoods as OrderGoodsModel;
use app\api\model\OrderInfo as OrderInfoModel;
use app\library\Error;

class Order extends BaseController {

    private $orderGoodsModel;
    private $orderInfoModel;

    public function __construct() {
        parent::__construct();
        $this->orderGoodsModel = new OrderGoodsModel();
        $this->orderInfoModel = new OrderInfoModel();
    }

    /**
     * @desc 创建订单
     * @return array
     * @throws \think\Exception
     */
    public function createOrder() {
        // 添加订单信息
        $ret = $this->orderInfoModel->addOrder();

        // 添加订单商品关联信息
        $ret = $this->orderGoodsModel->addOrderGoods();
        
        if(false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }

    /**
     * @desc 获取订单
     * @return array
     */
    public function getOrder() {
        $order_id = 14834626181644;
        $ret = $this->orderInfoModel->getOrderInfo($order_id);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }
}
