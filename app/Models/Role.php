<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    /*
     * Constants for column names.
     */
    const ID = 'id';
    const NAME = 'name';
    const GUARD_NAME = 'guard_name';

    /*
     * Constants for role permissions.
     */
    const BROWSE_ROLE = 'browse_role';
    const VIEW_ROLE = 'view_role';
    const CREATE_ROLE = 'create_role';
    const UPDATE_ROLE = 'update_role';
    const DELETE_ROLE = 'delete_role';

    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const USER = 3;

    const USER_ROLE_OPTIONS = [
        self::SUPER_ADMIN => 'super-admin',
        self::ADMIN => 'admin',
        self::USER => 'user',
    ];

    const AUTH_USER_ROLES = [
        'super-admin',
        'admin'
    ];

}
