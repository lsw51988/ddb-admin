<?php
define("APP_PATH", __DIR__ . "/../app");
define("APP_ENV", getenv("APP_ENV") == false ? "local" : getenv("APP_ENV"));

require_once __DIR__ . '/../vendor/autoload.php';

$di = new Phalcon\Di\FactoryDefault();

$di->setShared(
    "cache",
    function () {
        $frontCache = new Phalcon\Cache\Frontend\Data(
        //缓存时间一般为2周
            [
                'lifetime' => '1209600'
            ]
        );
        if (PHP_SAPI == "cli" || APP_ENV == "local" || APP_ENV == "qa") {
            //本地或cli环境下用本地文件存储 文件缓存时间会存在问题
            $cache = new Phalcon\Cache\Backend\File(
                $frontCache,
                [
                    "cacheDir" => __DIR__ . "/../storage/cache/",
                ]
            );
        } else {
            //redis缓存
            $cache = new \Phalcon\Cache\Backend\Redis(
                $frontCache,
                [
                    'host' => "localhost",
                    'port' => 6379,
                    "persistent" => false,
                    'lifetime' => '2000'
                ]
            );
        }
        return $cache;
    }
);


$di->setShared(
    "config",
    function () {
        if (di("cache")->get("config")) {
            $config = unserialize(di("cache")->get("config"));
        } else {
            $configDir = APP_PATH . "/Config";
            $configFiles = glob($configDir . '/*.php');
            $config = [];
            if (di("cache")->get("config") == null) {
                foreach ($configFiles as $configFile) {
                    $name = substr(basename($configFile), 0, -4);
                    $configData = require $configFile;
                    $config[strtolower($name)] = $configData["local"];
                }
                di("cache")->save("config", serialize($config));
            }
        }
        return new \Phalcon\Config($config);
    }
);

// modelsManager
$di->setShared(
    'modelsManager',
    function () {
        $modelsManager = new \Phalcon\Mvc\Model\Manager();
        $modelsManager->setEventsManager(di('eventsManager'));
        return $modelsManager;
    }
);

// transactionManager
$di->setShared(
    'transactionManager',
    function () {
        $transactionManager = new \Ddb\Core\Mvc\Model\Transaction\Manager();
        return $transactionManager;
    }
);

// router
$di->setShared(
    "router",
    function () {
        $router = new \Phalcon\Mvc\Router\Annotations(false);
        $router->setEventsManager(di('eventsManager'));
        $router->setDefaultNamespace('\\Ddb\\Controllers');
        $router->setDefaultController('index');
        $router->setDefaultAction('index');
        $router->notFound(array(
            "controller" => "index",
            "action" => "route404"
        ));
        return $router;
    }
);

// dispatcher
$di->setShared(
    "dispatcher",
    function () {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager(di('eventsManager'));
        $dispatcher->setDefaultNamespace('\\Ddb\\Controllers');
        $dispatcher->setDefaultController('index');
        $dispatcher->setDefaultAction('index');
        return $dispatcher;
    }
);

// view
$di->setShared(
    "view",
    function () {
        $config = di('config');
        $view = new \Phalcon\Mvc\View();
        $viewDir = $config->view->path . DIRECTORY_SEPARATOR;
        if (!file_exists($viewDir) || !is_dir($viewDir)) {
            $viewDir = $config->view->path;
        }
        $view->setViewsDir($viewDir);
        $view->registerEngines(
            array(
                ".volt" => 'volt',
                ".phtml" => 'Phalcon\Mvc\View\Engine\Php'
            )
        );

        return $view;
    }
);

// viewCache should not be shared service
$di->set(
    'viewCache',
    function () {
        // Cache data for one day by default
        $frontCache = new \Phalcon\Cache\Frontend\Output(array(
            "lifetime" => di('config')->view->lifetime
        ));

        // Memcached connection settings
        $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
            'cacheDir' => di('config')->view->compiled
        ));

        return $cache;
    }
);

// volt engine
$di->setShared(
    'volt',
    function () {
        $volt = new \Phalcon\Mvc\View\Engine\Volt(di('view'), di());
        $options = di('config')->view->volt->toArray();
        if (di('config')->app->debug) {
            $options["compileAlways"] = true;
        }
        $volt->setOptions($options);

        /* @var $compiler \Phalcon\Mvc\View\Engine\Volt\Compiler */
        $compiler = $volt->getCompiler();
        $compiler->addExtension(new \Ddb\Core\Mvc\View\Engine\Volt\Extension\PhpFunction());

        return $volt;
    }
);

// crypt
$di->setShared(
    'crypt',
    function () {
        $crypt = new \Phalcon\Crypt();
        //设置加密密钥默认使用AES-256-CFB算法
        $crypt->setKey(di('config')->app->cryptKey);
        return $crypt;
    }
);

// 加密工具的设置
$di->setShared(
    "security",
    function () {
        $security = new \Phalcon\Security();
        $security->setWorkFactor(12);
        return $security;
    }
);

// session, 默认使用redis来共享存储
$di->setShared(
    'session',
    function () {
        if (!empty(di('config')->session->cookie_params)) {
            $cookie_params = di('config')->session->cookie_params;
            session_set_cookie_params(
                @$cookie_params->lifetime,
                @$cookie_params->path,
                @$cookie_params->domain,
                @$cookie_params->secure,
                @$cookie_params->httponly
            );
        }

        //if (APP_ENV == 'production') {
        $session = new \Phalcon\Session\Adapter\Redis(di('config')->session->options->toArray());
        /*        } else {
                $session = new \Phalcon\Session\Adapter\Files();
                }*/

        if (!empty(di('config')->session->session_name)) {
            $session->setName(di('config')->session->session_name);
        }

        if (!$session->isStarted()) {
            $session->start();
        }

        return $session;
    }
);

// filesystem
$di->setShared(
    'filesystem',
    function () {
        if (APP_ENV == 'local') {
            return new \League\Flysystem\Adapter\Local(di('config')->filesystem->root);
        }else{
            $ossClient = new \OSS\OssClient(di('config')->filesystem->AccessKeyId, di('config')->filesystem->AccessKeySecret, di('config')->filesystem->Endpoint, false);
            $aliOss = new \Ddb\Core\FS\Adapters\AliOSS(di('config')->filesystem->Bucket,$ossClient);
            return $aliOss;
        }
    }
);

// httpClient
$di->setShared(
    'httpClient',
    function () {
        $client = new \GuzzleHttp\Client();
        return $client;
    }
);

// apiResponse
$di->setShared(
    "apiResponse",
    function () {
        $manager = new \League\Fractal\Manager();
        $manager->setSerializer(new \League\Fractal\Serializer\JsonApiSerializer());
        $response = new \Ddb\Core\Api\Response($manager);
        $response->setPhalconResponse(di('response'));
        return $response;
    }
);

// random
$di->setShared(
    'random',
    function () {
        // require phalcon > 2.0.7
        return new \Phalcon\Security\Random();
    }
);
$di->setShared(
    'queue',
    function () {
        $config = di("config")->get("queue");
        return new \Pheanstalk\Pheanstalk($config->host, $config->port);
    }
);

$di->set('db', function () {
    return new Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => di("config")->database->host,
        "username" => di("config")->database->username,
        "password" => di("config")->database->password,
        "dbname" => di("config")->database->dbname,
        "charset" => di("config")->database->charset
    ));
});

function InitDatabase()
{
    // We only use mysql database here.
    $connections = di('config')->database;
    foreach ($connections as $connectionName => $connectionConfig) {
        // 对于主链接，writeConnection，使用非shared的方式
        $shared = false;
        if ($connectionName != 'db') {
            $shared = true;
        }

        // 创建日志服务
        di()->setShared(
            $connectionName . "Logger",
            app_log($connectionName)
        );

        // 创建数据库服务
        di()->set(
            $connectionName,
            function () use ($connectionName, $connectionConfig) {
                $db = new \Phalcon\Db\Adapter\Pdo\Mysql(di("config")->database);

                // 新创建单独的事件管理器, 注册监听器，用来调试sql
                // TODO: 这里是用单独的事件管理器还是全局的呢?
                //$eventsManager = new \Phalcon\Events\Manager();
                $db->setEventsManager(di('eventsManager'));

                if (di('config')->app->debug && APP_ENV != 'production') {
                    di('eventsManager')->attach(
                        'db',
                        function ($event, $source) use ($db, $connectionName) {
                            // 数据库的监控和日志单独处理，不与应用本身的放一起
                            $logger = di($connectionName . "Logger");
                            if ($source == $db) { // 只记录当前链接的事件
                                $profile = di('profile');
                                if ($event->getType() == 'beforeQuery') {
                                    $profile->startProfile(
                                        $source->getSQLStatement()
                                    );

                                    $sqlVariables = $source->getSQLVariables();
                                    if (count($sqlVariables)) {
                                        $keyArr = [];
                                        $valArr = [];
                                        foreach ($sqlVariables as $k => $v) {
                                            if (':' == $k[0]) {
                                                $keyArr[] = $k;
                                            } else {
                                                $keyArr[] = ':' . $k;
                                            }
                                            if ('string' == gettype($v)) {
                                                $valArr[] = '\'' . $v . '\'';
                                            } else {
                                                $valArr[] = $v;
                                            }
                                        }

                                        $query = $source->getSQLStatement();
                                        for ($i = count($keyArr) - 1; $i >= 0; $i--) {
                                            $query = str_replace($keyArr[$i], $valArr[$i], $query);
                                        }
                                        $logger->log($query, \Phalcon\Logger::DEBUG);
                                    } else {
                                        $logger->log($source->getSQLStatement(), \Phalcon\Logger::DEBUG);
                                    }
                                } else if ($event->getType() == 'afterQuery') {
                                    $profile->stopProfile();
                                    $profile = $profile->getLastProfile();
                                    $totalSeconds = $profile->getTotalElapsedSeconds();
                                    $slow_query_time = 1;
                                    if ($totalSeconds > $slow_query_time) {
                                        $logger->log('Run time is ' . $totalSeconds, \Phalcon\Logger::ERROR);
                                    }
                                }
                            }
                        }
                    );
                }

                return $db;
            },
            $shared
        );
    }
}


function InitRouters($appPath, $prefix)
{
    if (!file_exists($appPath) || !is_dir($appPath)) {
        return null;
    }

    $files = array_diff(scandir($appPath), array('..', '.'));
    foreach ($files as $file) {
        if (\Phalcon\Text::endsWith($file, "Controller.php", false)) {
            $file = str_replace("Controller.php", "", $file);
            di('router')->addResource($prefix . $file);
        } else {
            // Loop sub directory
            $subDir = $appPath . "/" . $file;
            InitRouters($subDir, $prefix . $file . '\\');
        }
    }
}

// Initialize and bootstrap application
InitRouters("../app/Controllers/", "Ddb\\Controllers\\");
//InitDatabase();
