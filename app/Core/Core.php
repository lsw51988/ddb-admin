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
if (!function_exists("curl_request")) {
    function curl_request($url, $method = "GET", $param = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
if (!function_exists('service')) {
    /**
     * 利用DI容器注册和管理用户自定义的服务
     * @param $serviceName
     * @param null $parameters
     * @return callable
     */
    function service($serviceName, $parameters = null)
    {
        $serviceName = \Phalcon\Text::lower($serviceName);
        if (strpos($serviceName, "/") === false) {
            return false;
        }

        if (!di()->has($serviceName)) {
            list($module, $service) = explode("/", $serviceName, 2);
            $class = "Ddb\\Service\\" . ucfirst($module) . "\\" . ucfirst($service);
            di()->setShared($serviceName, $class);
        }
        return di($serviceName, $parameters);
    }
}