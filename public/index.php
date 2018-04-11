<?php
error_reporting(E_ALL);

/* @var $response Phalcon\Http\Response */
try {
    require '../bootstrap/bootstrap.php';
    app()->handle()->send();

} catch (\Exception $e) {
    if (app_name() == 'api') {
        $response = new \Phalcon\Http\Response();
        $response->setJsonContent(['error' => $e->getMessage()])->send();
    } else {
        $response = new \Phalcon\Http\Response();
        $response->setContent('SYSTEM ERROR:' . $e->getMessage())->setStatusCode(500, "Internal Error")->send();
    }
}