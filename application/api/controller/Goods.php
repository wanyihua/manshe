<?php
/**
 * 商品信息
 * User: yuanxuncheng
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\api\model\Goods as GoodsModel;
use app\library\Error;

class Goods extends BaseController {

    private $goodsModel;

    public function __construct() {
        parent::__construct();
        $this->goodsModel = new GoodsModel();
    }

    /**
     * @desc 获取商品
     * @return array
     */
    public function getGoods() {
        $good_id = 111;
        $ret = $this->goodsModel->getGoods($good_id);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }
}
