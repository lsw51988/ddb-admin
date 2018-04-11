<?php

namespace Dowedo\Models;

class MemberPermissions extends \Dowedo\Core\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo(
            "member_id",
            "Dowedo\\Modules\\Member\\Models\\Member",
            "id"
        );

        $this->belongsTo(
            "permission_id",
            "Dowedo\\Models\\Permissions",
            "id"
        );

        $this->hasOne(
            "permission_id",
            "Dowedo\\Models\\Permissions",
            "id",
            [
                'alias' => 'permission'
            ]
        );
    }
}
