<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Userfavorite.php
 * Date: 2016/12/14
 * Time: 0:13
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\library\Error;

class userFavoriteArticle extends BaseController
{
    protected $param;
    public function __construct()
    {
        parent::__construct();
        $this->param = Request::instance()->param();
    }

    public function addFavoriteArticle()
    {
        if(!isset($this->param['article_id']))
        {
            return $this->getRes(Error::ERR_PARAM);
        }
    }

    public function removeFavoriteArticle()
    {
        if(!isset($this->param['article_id']))
        {
            return $this->getRes(Error::ERR_PARAM);
        }
    }

    public function getFavoriteArticle()
    {
        if(!isset($this->param['user_id']))
        {
            return $this->getRes(Error::ERR_PARAM);
        }
    }
}
