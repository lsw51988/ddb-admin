<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-18
 * Time: 下午9:16
 */

namespace Ddb\Core;


use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    protected $data;
    protected $limit;
    protected $page;

    public function onConstruct()
    {
        $this->data = $this->request->get();
        $this->limit = $this->request->get('limit', "int", 20, true);
        $this->page = $this->request->get('page', "int", 1, true);
    }

    protected function success($data = null, $msg = '')
    {
        return $this->apiResponse->withArray([
            'status' => true,
            'data' => $data,
            'msg' => $msg
        ]);
    }

    protected function error($msg = '', $data = null)
    {
        return $this->apiResponse->withArray([
            'status' => false,
            'data' => $data,
            'msg' => $msg
        ]);
    }
}