<?php

if (!function_exists("readFile")) {
    function readFile($file, $serialize = false)
    {
        if (file_exists($file) && $file = include($file)) {
            return $serialize == true ? unserialize($file) : $file;
        }
    }
}

if (!function_exists("di")) {
    function di($name = null, $param = [])
    {
        if (!$di = Phalcon\Di::getDefault()) {
            $di = new Phalcon\Di\FactoryDefault();
        }
        if (is_null($name)) {
            return $di;
        } else {
            return $di->get($name, $param);
        }
    }
}

if (!function_exists("app_log")) {
    /**
     * 返回一个根据日期创建的日志适配器
     *
     * @param string $loggerName
     * @return \Phalcon\Logger\Adapter\File
     */
    function app_log($loggerName = 'ddb')
    {
        $date = date('Y-m-d');
        $app_env = getenv("APP_ENV");
        $path = di('config')->app->log_path . DIRECTORY_SEPARATOR . $date;
        if (!file_exists($path)) {
            mkdir($path);
        }
        return new \Phalcon\Logger\Adapter\File($path . DIRECTORY_SEPARATOR . $loggerName . '.log');
    }
}
