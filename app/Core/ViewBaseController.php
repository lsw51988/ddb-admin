<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-5-15
 * Time: 上午10:15
 */

namespace Ddb\Core;


class ViewBaseController extends BaseController
{
    const CONTROLLER_NAMESPACE_PREFIX = 'ddb\\controllers\\';
    protected $currentUri = "";
    protected $page = 1;
    protected $limit = 20;

    public function onConstruct()
    {
        parent::onConstruct(); // TODO: Change the autogenerated stub
        $this->currentUri = $this->request->getURI();
        $this->page = $this->request->get("page", "int", 1);
        $this->limit = $this->request->get("limit", "int", 20);
        $this->updateViewDir();
    }

    private function updateViewDir()
    {
        $namespace = $this->dispatcher->getNamespaceName();
        $module = str_replace(strtolower(self::CONTROLLER_NAMESPACE_PREFIX), '', strtolower($namespace));

        $viewDir = $this->view->getViewsDir() . $module;
        $viewDir = str_replace('\\', '/', strtolower($viewDir));
        $this->view->setVar("currentUri", $this->currentUri);
        $this->view->setViewsDir($viewDir);
    }

}