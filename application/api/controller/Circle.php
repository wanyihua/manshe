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
use app\api\model\Circle as CircleModel;
use app\library\Error;

class Circle extends BaseController {
    
    private $circleModel;

    public function __construct() {
        parent::__construct();
        $this->circleModel = new CircleModel();
    }

    public function getCircle() {
        $ret = $this->circleModel->getCircle();
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        }else{
            $this->data = $ret;
            return $this->getRes();
        }
    }
    
}
