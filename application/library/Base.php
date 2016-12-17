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
use think\Log;


class Base extends Controller
{
    protected $errno;//返回值
    protected $data;//返回数据
    protected $errmsg;//返回信息
    protected $redis;

    public function __construct()
    {
        parent::__construct();
        $this->redis = RedisMgr::getInstance();
        
        $this->errno = 0;
        $this->data = array();
        $this->errmsg = '';
    }

    /**
     * 初始化操作
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->checkAuth();
    }

    /**
     * 验证接口权限
     */
    public function checkAuth() {
        //$this->redis->set('session', 'test');
        //$sesion = $this->redis->get('session');
        Log::log("chekauth".var_export($this->redis));
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
        return json_encode($res);
    }

}