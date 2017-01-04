<?php
/**
 * 商品评论
 * User: yuanxuncheng
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\api\model\Comment as CommentModel;
use app\library\Error;

class Comment extends BaseController {

    private $CommentModel;

    public function __construct() {
        parent::__construct();
        $this->CommentModel = new CommentModel();
    }

    /**
     * @desc 商品评论
     * @return array
     */
    public function getGoods() {
        $comment_id = 111;
        $ret = $this->CommentModel->getComment($comment_id);
        if(false === $ret){
            return $this->getRes(Error::ERR_SYS);
        } else {
            $this->data = $ret;
            return $this->getRes();
        }
    }
}
