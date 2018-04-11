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
class RolePermissions extends \Dowedo\Core\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $profiles_id;

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

    public function initialize()
    {
        $this->belongsTo('role_id', __NAMESPACE__ . '\Roles', 'id', [
            'alias' => 'role'
        ]);
    }
}
