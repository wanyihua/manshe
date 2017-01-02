<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Circle.php
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\api\model\CircleCategory as CircleCategoryModel;
use app\library\Error;

class Circle extends BaseController {
    
    private $circleCategoryModel;

    public function __construct() {
        parent::__construct();
        $this->circleCategoryModel = new CircleCategoryModel();
    }

    public function getCircleCategory() {
        $ret = $this->circleCategoryModel->getCircleCategory();
        if (false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }
    
}
