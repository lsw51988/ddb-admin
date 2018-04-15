<?php
//error_reporting(E_ALL);
try {
    require '../bootstrap/bootstrap.php';
    $application = new Phalcon\Mvc\Application($di);
    $application->handle()->send();

} catch (\Exception $e) {
    $response = new \Phalcon\Http\Response();
    $response->setContent('SYSTEM ERROR:' . $e->getMessage())->setStatusCode(500, "Internal Error")->send();
}