<?php
/**
 * Created by PhpStorm.
 * User: zl
 * Date: 2016/9/5
 * Time: 15:40
 */
namespace Dowedo\Models;

/**
 * Permissions
 * Stores the permissions by profile
 */
class Permissions extends \Dowedo\Core\Mvc\Model
{

    public function initialize()
    {

    }

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $resource;

    /**
     *
     * @var string
     */
    public $action;


}
