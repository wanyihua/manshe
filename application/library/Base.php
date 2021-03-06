<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Base.php
 * Date: 2016/12/10
 * Time: 17:50
 */

namespace app\library;
use think\Controller;
use app\library\Error;
use think\Cache;
use think\Request;
use think\Log;


class Base extends Controller
{
    protected $errno;//返回值
    protected $data;//返回数据
    protected $errmsg;//返回信息
    protected $redis;
    protected $param;
    
    // 分页参数
    protected $offset;
    protected $limit;

    public function __construct()
    {
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->errno = 0;
        $this->data = array();
        $this->errmsg = '';
        
        $this->offset = 0;
        $this->limit  = 10;
    }


    /**
     * 验证接口权限
     */
    public function checkAuth() {
        $requestid = $this->param['sessionid'];
        $sessionid = Cache::get('userid:'.$this->param['userid']);

        if ($requestid != $sessionid) {
            return false;
        }
        return true;
    }

    /**
     * @param int $errno
     * @param string $errmsg
     * @return array
     */
    protected function getRes($errno = 0, $errmsg = '')
    {
        if (!empty($errno)) {
            $this->errno = $errno;
        }
        $this->errmsg = $errmsg == '' ? Error::$arr_err_msg[$this->errno] : $errmsg;
        $res = array(
            'errno' => $this->errno,
            'errmsg' => $this->errmsg,
            'data' => $this->data,
        );
        //return json_encode($res);
        return $res;
    }

}
