<?php
/**
 * 订单
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Exception;
use think\Log;
use think\Model;
use think\Db;
use app\library\RedisMgr;

class OrderInfo extends Model
{
    //set talbename
    protected $table = 'order_info';
    //set primary key
    protected $pk = 'order_id';

    public function getOrderInfo($order_id) {
        $conds = array(
            'order_id' => $order_id,
        );
        $field= '*';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }

    /**
     * @desc 生成订单ID
     * @return int
     */
    public function getOrderid() {
        $keyPrefix = 'ms:order:';
        $order_id = str_pad(str_replace('.', '', microtime(true)), 14, '0');
        $expireTime = strtotime("+1 day");
        $returnKey = 0;
        $loopIndex = 0;
        while ($returnKey != 1 && $loopIndex++ < 10) { //循环10次获取订单号，保证不重复
            try {
                $order_id = str_pad(str_replace('.', '', microtime(true)), 14, '0');
                $redisKey = $keyPrefix.$order_id;
                $redis = RedisMgr::getInstance([]);
                $returnKey = $redis->inc($redisKey);
                $redis->expireAt($redisKey, $expireTime);
            } catch (Exception $ex) {
                $code = $ex->getCode();
                $msg = $ex->getMessage();
                Log::error(sprintf("CLASS[%s] METHOD[%s] get exception err[%d] msg[%s] file[%s] line[%d] continue re
try",
                    __FILE__, __METHOD__, $code, $msg, $ex->getFile(), $ex->getLine()));
            }
        }
        if ($returnKey == 1) {
            return $order_id;
        } else {
            Log::info('create order_id fail');
            throw new Exception('create order_id fail');
        }
    }
}
