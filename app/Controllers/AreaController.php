<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-7-18
 * Time: 下午9:14
 */

namespace Ddb\Controllers;


use Ddb\Core\BaseController;

/**
 * Class AreaController
 * @RoutePrefix("/area")
 */
class AreaController extends BaseController
{
    /**
     * @Get("/provinces")
     */
    public function indexAction()
    {
        $provinces = service('area/query')->getProvinces();
        return $this->success($provinces);
    }

    /**
     * @Get("/province/{province_code:[0-9]+}")
     */
    public function cityAction($province_code)
    {
        $cities = service('area/query')->getCities($province_code);
        return $this->success($cities);
    }

    /**
     * @Get("/city/{city_code:[0-9]+}")
     */
    public function districtAction($city_code)
    {
        $districts = service('area/query')->getDistricts($city_code);
        return $this->success($districts);
    }
}