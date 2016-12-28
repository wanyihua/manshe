<?php
/**
 * Created by PhpStorm.
 * User: iwm
 * Date: 2016/12/27
 * Time: 15:28
 * Timer - ��ʱ������ѡms/s�����ȣ�֧���ۼ�
 * @note: �ڲ�����us��ʱ�����ᵼ���ۼ����
 */
namespace app\library;
class Timer
{
    const PRECISION_MS = 1;
    const PRECISION_S = 2;
    const PRECISION_US = 3;

    private $begTime = 0;
    private $timeUsed = 0;
    private $stopped = true;
    private $precision;

    /**
     * ���캯��
     *
     * @param [in] $start: bool
     *              �Ƿ�������ʼ��ʱ
     * @param [in] $precision: int
     *              ���ؾ��ȣ�֧��ms��s���ȣ�Ĭ��Ϊms
     */
    function __construct($start = false, $precision = self::PRECISION_MS)
    {
        $this->precision = $precision;

        if($start)
        {
            $this->start();
        }
    }


    /**
     * start timer
     *
     * ������ʱ��
     *
     * @return boolean
     * @note ����������ʱ��ִ�б���������ʧ��
     * @see stop()
     */
    function start()
    {
        if(!$this->stopped)
        {
            return false;
        }

        $this->stopped = false;
        $this->begTime = self::getTimeStamp(self::PRECISION_US);
        return true;
    }

    /**
     * stop timer
     *
     * ��ͣ��ʱ��
     *
     * @return boolean/int
     *          false - ʧ��
     *          >= 0  - ���׶μ�ʱ��ʱ�䣬Ϊ��ʱ������
     * @note ������ͣ��ʱ��ִ�б���������ʧ��
     * @see start()
     */
    function stop()
    {
        if($this->stopped)
        {
            return false;
        }

        $this->stopped = true;
        $thisTime = self::getTimeStamp(self::PRECISION_US) - $this->begTime;
        $this->timeUsed += $thisTime;

        switch($this->precision)
        {
            case self::PRECISION_MS:
                return intval($thisTime/1000);

            case self::PRECISION_S:
                return intval($thisTime/1000000);

            default:
                return $thisTime;
        }
    }

    /**
     * reset timer
     *
     * ���ö�ʱ��
     */
    function reset()
    {
        $this->begTime = 0;
        $this->timeUsed = 0;
        $this->stopped = true;
    }

    /**
     * ��ȡ�ۻ�ʱ��
     *
     * @param [in] $precision: int
     *              ���ؾ��ȣ�֧��ms��s���ȣ�Ĭ��Ϊ��ʱ������
     * @return int
     */
    function getTotalTime($precision = null)
    {
        if($precision === null)
        {
            $precision = $this->precision;
        }

        switch($precision)
        {
            case self::PRECISION_MS:
                return intval($this->timeUsed/1000);

            case self::PRECISION_S:
                return intval($this->timeUsed/1000000);

            default:
                return $this->timeUsed;
        }
    }

    /**
     * ��ȡ��ǰʱ���
     *
     * @param [in] $precision: int
     *              ���ؾ��ȣ�֧��us/ms/s��Ĭ��Ϊms
     * @return int
     */
    static function getTimeStamp($precision = self::PRECISION_MS)
    {
        switch($precision)
        {
            case self::PRECISION_MS:
                return intval(microtime(true)*1000);

            case self::PRECISION_S:
                return time();

            case self::PRECISION_US:
                return intval(microtime(true)*1000000);

            default:
                return 0;
        }
    }
}
