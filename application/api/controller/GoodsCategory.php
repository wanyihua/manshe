<?php
/**
 * 商品分类
 * User: yuanxuncheng
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\api\model\GoodsCategory as GoodsCategoryModel;
use app\library\Error;

class GoodsCategory extends BaseController {

    private $goodsCategoryModel;

    public function __construct() {
        parent::__construct();
        $this->goodsCategoryModel = new GoodsCategoryModel();
    }

    /**
     * @desc 获取商品分类
     * @return array
     */
    public function getCart() {
        $good_id = 111;
        $ret = $this->goodsCategoryModel->getGoodsCategory($good_id);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }
}
