<?php

require __DIR__ . '/../vendor/autoload.php';

// global configurations
di()->setShared(
    "config",
    function () {
        $cachedConfigFile = __DIR__ . '/app/cache/config.php';
        if (!$config = readCache($cachedConfigFile)) {
            $configDir = __DIR__ . '/../app/config';
            $configFiles = glob($configDir . '/*.php');
            $config = [];
            foreach ($configFiles as $configFile) {
                $name = substr(basename($configFile), 0, -4);
                $config[strtolower($name)] = require $configFile;
            }

            // 生产环境重建缓存
//            if (app_env() == 'production') {
//                writeCache($cachedConfigFile, $config);
//            }
        }

        return new \Phalcon\Config($config);
    }
);

// modelsManager
di()->setShared(
    'modelsManager',
    function () {
        $modelsManager = new \Phalcon\Mvc\Model\Manager();
        $modelsManager->setEventsManager(di('eventsManager'));
        return $modelsManager;
    }
);

// transactionManager
di()->setShared(
    'transactionManager',
    function () {
        $transactionManager = new \Ddb\Core\Mvc\Model\Transaction\Manager();
        return $transactionManager;
    }
);

// router
di()->setShared(
    "router",
    function () {
        if (app_name() == 'cmd') {
            $router = new \Phalcon\Cli\Router();
            return $router;
        } else {
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
    }
);

// output
di()->setShared(
    'output',
    function () {
        return new \Ddb\Core\Console\Output\ConsoleOutput();
    }
);

// dispatcher
di()->setShared(
    "dispatcher",
    function () {
        if (app_name() == 'cmd') {
            $dispatcher = new \Phalcon\Cli\Dispatcher();
            $dispatcher->setEventsManager(di('eventsManager'));
            $dispatcher->setDefaultNamespace("\\Ddb\\Tasks");
            $dispatcher->setDefaultTask("main");
            $dispatcher->setDefaultAction("main");
            return $dispatcher;
        } else {
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager(di('eventsManager'));
            $dispatcher->setDefaultNamespace('\\Ddb\\Controllers');
            $dispatcher->setDefaultController('index');
            $dispatcher->setDefaultAction('index');
            return $dispatcher;
        }
    }
);

// modelsMetaData
di()->setShared(
    'modelsMetadata',
    function () {
        if (di('config')->app->debug) {
            return new \Phalcon\Mvc\Model\MetaData\Memory();
        }
        // 当前默认使用文件缓存，另外还可以支持redis、session、apc等，后期根据性能需要调整即可
        return new \Phalcon\Mvc\Model\MetaData\Files(di('config')->database->modelsMetaData->toArray());
    }
);

// modelsCache
di()->setShared(
    'modelsCache',
    function () {
        if (di('config')->app->debug) {
            $frontCache = new \Phalcon\Cache\Frontend\None();
            return new \Phalcon\Cache\Backend\Memory($frontCache);
        } else {
            //Cache data for one day by default
            $frontCache = new \Phalcon\Cache\Frontend\Data(["lifetime" => 86400 * 30]);
            return new \Phalcon\Cache\Backend\File($frontCache, di('config')->database->models->toArray());
        }
    }
);

// view
di()->setShared(
    "view",
    function () {
        $config = di('config');
        $view = new \Phalcon\Mvc\View();
        $view->setEventsManager(di('eventsManager'));
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
di()->set(
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
di()->setShared(
    'volt',
    function () {
        $volt = new \Phalcon\Mvc\View\Engine\Volt(di('view'), di());
        $volt->setEventsManager(di('eventsManager'));
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
di()->setShared(
    'crypt',
    function () {
        $crypt = new \Phalcon\Crypt();

        //设置加密密钥
        $crypt->setKey(di('config')->app->cryptKey)->setCipher('rijndael-128')->setMode('ofb');
        return $crypt;
    }
);

// 加密工具的设置
di()->setShared(
    "security",
    function () {
        $security = new \Phalcon\Security();
        $security->setWorkFactor(12);
        return $security;
    }
);

// session, 默认使用redis来共享存储
di()->setShared(
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

        // Only use redis in production & testing
        $appEnv = app_env();
//        if ($appEnv == 'production' || $appEnv == 'testing') {
            // $session = new \Phalcon\Session\Adapter\Redis(di('config')->session->options->toArray());
//        } else {
            $session = new \Phalcon\Session\Adapter\Files(di('config')->session->options->toArray());
//        }

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
di()->setShared(
    'filesystem',
    function () {
        $appEnv = app_env();
        if ($appEnv == 'development') {
            return new \League\Flysystem\Adapter\Local(di('config')->filesystem->development->root);
        }
    }
);

// httpClient
di()->setShared(
    'httpClient',
    function () {
        $client = new \GuzzleHttp\Client();
        return $client;
    }
);

// apiResponse
di()->setShared(
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
di()->setShared(
    'random',
    function () {
        // require phalcon > 2.0.7
        return new \Phalcon\Security\Random();
    }
);

// transformerManager
di()->setShared(
    'transformerManager',
    function () {
        $manager = new \League\Fractal\Manager();
        $manager->setSerializer(new \League\Fractal\Serializer\JsonApiSerializer());
        return $manager;
    }
);

di()->setShared('profile', function (){
    return new \Phalcon\Db\Profiler();
});

function InitDatabase()
{
    $appEnv = app_env();

    // We only use mysql database here.
    $connections = di('config')->database->$appEnv;
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
                $db = new \Phalcon\Db\Adapter\Pdo\Mysql($connectionConfig->toArray());

                // 新创建单独的事件管理器, 注册监听器，用来调试sql
                // TODO: 这里是用单独的事件管理器还是全局的呢?
                //$eventsManager = new \Phalcon\Events\Manager();
                $db->setEventsManager(di('eventsManager'));

                if (di('config')->app->debug && app_env() != 'production') {
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
                                        for ($i = count($keyArr)-1; $i>=0; $i--){
                                            $query = str_replace($keyArr[$i], $valArr[$i], $query);
                                        }
                                        $logger->log($query, \Phalcon\Logger::DEBUG);
                                    } else {
                                        $logger->log($source->getSQLStatement(), \Phalcon\Logger::DEBUG);
                                    }
                                }else if($event->getType() == 'afterQuery'){
                                    $profile->stopProfile();
                                    $profile = $profile->getLastProfile();
                                    $totalSeconds = $profile->getTotalElapsedSeconds();
                                    $slow_query_time = 1;
                                    if($totalSeconds > $slow_query_time){
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

function InitListener()
{
    $appName = app_name();
    /** @var Phalcon\Config $listeners */
    if ($listeners = di('config')->get('listener')) {
        if (isset($listeners->global)) {
            foreach ($listeners->global as $event => $listener) {
                if (class_exists($listener)) {
                    //di("appLogger")->info("attach $listener for $event");
                    di('eventsManager')->attach($event, new $listener);
                } else {
                    di("logger")->warning("class $listener for $event not found");
                }
            }
        }

        if ($listeners->get(strtolower($appName))) {
            foreach ($listeners->get(strtolower($appName)) as $event => $listener) {
                if (class_exists($listener)) {
                    //di("appLogger")->info("attach $listener for $event");
                    di('eventsManager')->attach($event, new $listener);
                } else {
                    di("logger")->warning("class $listener for $event not found");
                }
            }
        }
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

/**
 * 初始化应用的个性化配置
 */
function InitApp()
{
    $loader = new \Phalcon\Loader();
}

/**
 * 关闭数据库连接, 给进程管理器使用
 */
function ShutDatabase()
{
    $appEnv = app_env();

    // For database, we only use mysql here.
    $connections = di('config')->database->database->$appEnv;
    foreach ($connections as $connectionName => $connectionConfig) {
        if (di($connectionName)) {
            di($connectionName)->close();
        }
    }
}

// Initialize and bootstrap application
InitRouters(__DIR__ . "/../app/Controllers/", "Ddb\\Controllers\\");
InitListener();
InitDatabase();
InitApp();