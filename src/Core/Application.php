<?php

namespace Mix\Core;

use Mix\Container\Container;
use Mix\Helpers\FileSystemHelper;

/**
 * App类
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class Application extends BaseObject implements \ApplicationInterface
{

    // 应用调试
    public $appDebug = true;

    // 初始化回调
    public $initialize = [];

    // 基础路径
    public $basePath = '';

    // 配置路径
    public $configPath = 'config';

    // 运行目录路径
    public $runtimePath = 'runtime';

    // 组件配置
    public $components = [];

    // 类库配置
    public $libraries = [];

    /**
     * 容器
     * @var \Mix\Container\Container
     */
    public $container;

    // 初始化事件
    public function onInitialize()
    {
        parent::onInitialize(); // TODO: Change the autogenerated stub
        // 快捷引用
        \Mix::$app = $this;
        // 实例化容器
        $this->container = new Container([
            'config' => $this->components,
        ]);
        // 错误注册
        \Mix\Core\Error::register();
        // 执行初始化回调
        foreach ($this->initialize as $callback) {
            call_user_func($callback);
        }
    }

    // 获取配置
    public function config($name)
    {
        $message   = "Config does not exist: {$name}.";
        $fragments = explode('.', $name);
        // 判断一级配置是否存在
        $first = array_shift($fragments);
        if (!isset($this->$first)) {
            throw new \Mix\Exceptions\ConfigException($message);
        }
        // 判断其他配置是否存在
        $current = $this->$first;
        foreach ($fragments as $key) {
            if (!isset($current[$key])) {
                throw new \Mix\Exceptions\ConfigException($message);
            }
            $current = $current[$key];
        }
        return $current;
    }

    // 获取配置目录路径
    public function getConfigPath()
    {
        if (!FileSystemHelper::isAbsolute($this->configPath)) {
            if ($this->configPath == '') {
                return $this->basePath;
            }
            return $this->basePath . DIRECTORY_SEPARATOR . $this->configPath;
        }
        return $this->configPath;
    }

    // 获取运行目录路径
    public function getRuntimePath()
    {
        if (!FileSystemHelper::isAbsolute($this->runtimePath)) {
            if ($this->runtimePath == '') {
                return $this->basePath;
            }
            return $this->basePath . DIRECTORY_SEPARATOR . $this->runtimePath;
        }
        return $this->runtimePath;
    }

}
