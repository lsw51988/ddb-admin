<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/10/29
 * Time: 21:32
 */

namespace Ddb\Modules;


use Ddb\Models\BikeRefreshes;

class BikeRefresh extends BikeRefreshes
{
    //类型 1-新车 2-二手车 3-丢失车辆
    const TYPE_NEW = 1;
    const TYPE_SECOND = 2;
    const TYPE_LOST = 3 ;
}