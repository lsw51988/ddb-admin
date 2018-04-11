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
                'message' => '��Ϊ�Ѿ����û����ڴ˽�ɫ,����ɾ��.'
            ]
        ]);

        $this->hasMany('id', __NAMESPACE__ . '\RolePermissions', 'role_id', [
            'alias' => 'permissions'
        ]);
    }
}
