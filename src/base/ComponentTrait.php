<?php

namespace mix\base;

/**
 * 组件基类Trait
 * @author 刘健 <coder.liu@qq.com>
 */
trait ComponentTrait
{

    // 协程模式
    private $_coroutineMode = self::COROUTINE_MODE_NEW;

    // 状态
    private $_status = self::STATUS_READY;

    // 获取状态
    public function getStatus()
    {
        return $this->_status;
    }

    // 设置状态
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    // 获取协程模式
    public function getCoroutineMode()
    {
        return $this->_coroutineMode;
    }

    // 设置协程模式
    public function setCoroutineMode($coroutineMode)
    {
        $this->_coroutineMode = $coroutineMode;
    }

    // 请求前置事件
    public function onRequestBefore()
    {
        $this->setStatus(self::STATUS_RUNNING);
    }

    // 请求后置事件
    public function onRequestAfter()
    {
        $this->setStatus(self::STATUS_READY);
    }

}
