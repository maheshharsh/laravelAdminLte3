<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    /*
     * Constants for column names.
     */
    const ID = 'id';
    const NAME = 'name';

    /*
     * Constants for permissions's permissions.
     */
    const BROWSE_PERMISSION = 'browse_permission';
    const VIEW_PERMISSION = 'view_permission';
    const CREATE_PERMISSION = 'create_permission';
    const UPDATE_PERMISSION = 'update_permission';
    const DELETE_PERMISSION = 'delete_permission';
}
