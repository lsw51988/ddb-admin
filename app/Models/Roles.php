<?php

namespace Dowedo\Models;

class Roles extends \Dowedo\Core\Mvc\Model
{

    /**
     * ID
     * @var integer
     */
    public $id;

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Define relationships to Users and Permissions
     */
    public function initialize()
    {
        $this->hasMany('id', 'Dowedo\Modules\User\Models\User', 'role_id', [
            'alias' => 'users',
            'foreignKey' => [
                'message' => '因为已经有用户属于此角色,不能删除.'
            ]
        ]);

        $this->hasMany('id', __NAMESPACE__ . '\RolePermissions', 'role_id', [
            'alias' => 'permissions'
        ]);
    }
}
