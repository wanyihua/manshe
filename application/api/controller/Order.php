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
     * @desc 获取商品
     * @return array
     */
    public function getOrder() {
        $order_id = $this->orderInfoModel->getOrderid();
        $this->data = array(
            'order_id' => $order_id,
        );
        return $this->getRes();
        $ret = $this->orderInfoModel->getOrderInfo($order_id);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }
}
