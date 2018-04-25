<?php
/**
 * Created by PhpStorm.
 * User: 阿德
 * Date: 2018/4/25
 * Time: 21:05
 */

namespace Ddb\Models;

use \Phalcon\Mvc\Model;

class BaseModel extends Model
{
    //单利模式
    private static $instance = null;

    public static function getInstance()
    {
        $className = get_called_class();
        if (is_null(self::$instance)) {
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public static function getColumnValues($id, $columns)
    {
        $instance = self::getInstance();
        $data = $instance->findFirst([
            "columns" => $columns,
            "conditions" => "id = :id:",
            "bind" => [
                "id" => $id
            ]
        ]);
        if($data!=null){
            $data = $data->toArray();
        }
        return $data;
    }
}